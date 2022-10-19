<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Model\Sims;
use App\Model\Order;
use App\Helpers\Log;
use App\Model\Device;
use App\Model\Invoice;
use App\Model\Customer;
use App\Model\OrderGroup;
use App\Model\InvoiceItem;
use Illuminate\Http\Request;
use App\Model\SubscriptionLog;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Model\CustomerStandaloneSim;
use App\Model\CustomerStandaloneDevice;

class OrderController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function orderReplacementProduct(Request $request)
	{
		try{
			$customer = Customer::find($request->get('customer_id'));
			$customerCompanyId = $customer->company_id;
			$validation = Validator::make(
				$request->all(),
				[
					'device_id'            => [
						'numeric',
						Rule::exists('device', 'id')->where(function ($query) use ($customerCompanyId) {
							return $query->where('company_id', $customerCompanyId);
						})
					],
					'sim_id'               =>  [
						'numeric',
						Rule::exists('sim', 'id')->where(function ($query) use ($customerCompanyId) {
							return $query->where('company_id', $customerCompanyId);
						})
					],
					'subscription_id'      => [
						'numeric',
						'required',
						Rule::exists('subscription', 'id')->where(function ($query) use ($customerCompanyId) {
							return $query->where('company_id', $customerCompanyId);
						})
					],
					'customer_id'           => [
						'required',
						'numeric',
						Rule::exists('customer', 'id')->where(function ($query) use ($customerCompanyId) {
							return $query->where('company_id', $customerCompanyId);
						})
					],
					'internal_notes'        => 'required'
				]
			);
			if ( $validation->fails() ) {
				$errors = $validation->errors();
				$validationErrorResponse = [
					'status' => 'error',
					'data'   => $errors->messages()
				];
				return response()->json($validationErrorResponse, 422);
			}
			$data = $request->all();

			DB::transaction(function () use ($request, $data, $customer) {

				$orderCount = Order::where([['status', 1], ['company_id', $customer->company_id]])->max('order_num');

				$order = Order::create( [
					'hash'              => sha1( time() . rand() ),
					'company_id'        => $customer->company_id,
					'customer_id'       => $data[ 'customer_id' ],
					'shipping_fname'    => $customer->billing_fname,
					'shipping_lname'    => $customer->billing_lname,
					'shipping_address1' => $customer->billing_address1,
					'shipping_address2' => $customer->billing_address2,
					'shipping_city'     => $customer->billing_city,
					'shipping_state_id' => $customer->billing_state_id,
					'shipping_zip'      => $customer->billing_zip,
					'order_num'         => $orderCount + 1
				] );


				$orderGroups = $this->insertOrderGroups( $data, $order );

				if($order) {
					$this->createInvoice($request, $order, $orderGroups);
				}

				$this->insertSubscriptionLog( $data, $customer->company_id );
			});

			return response()->json(['success' => true, 'message' => 'Order created successfully.']);
		} catch (\Exception $e) {
			Log::info($e->getMessage() . ' on line number: '.$e->getLine() . ' Create replacement order');
			return response()->json( [
				'status'    => 'error',
				'message'   => $e->getMessage()
			], 500);
		}
	}

	/**
	 * @param $data
	 * @param $order
	 *
	 * @return array
	 */
	private function insertOrderGroups($data, $order)
	{
		$orderGroups = [];
		$baseParams = [
			'order_id'          => $order->id,
			'subscription_id'   => $data['subscription_id']
		];
		if(isset($data['device_id'])){
			$baseParams['device_id'] = $data['device_id'];
			$baseParams['sim_id'] = null;
			$orderGroups[] = OrderGroup::create($baseParams);
		}

		if(isset($data['sim_id'])){
			$simId = $data['sim_id'];
			if($simId == 0){
				$simId = null;
			}
			$baseParams['sim_id'] = $simId;
			$baseParams['device_id'] = null;
			$orderGroups[] = OrderGroup::create($baseParams);
		}
		return $orderGroups;
	}

	/**
	 * @param $data
	 * @param $companyId
	 *
	 * @return mixed
	 */
	private function insertSubscriptionLog($data, $companyId)
	{
		$baseSubscriptionLog = [
			'subscription_id'   => $data['subscription_id'],
			'company_id'        => $companyId,
			'customer_id'       => $data['customer_id'],
			'description'       => $data['internal_notes']
		];
		if(isset($data['device_id']) && $data['device_id']){
			$baseSubscriptionLog['product_id'] = $data['device_id'];
			$baseSubscriptionLog['category'] = SubscriptionLog::CATEGORY['replacement-device-ordered'];
			SubscriptionLog::create($baseSubscriptionLog);
		}
		if(isset($data['sim_id']) && $data['sim_id']){
			$baseSubscriptionLog['product_id'] = $data['sim_id'];
			$baseSubscriptionLog['category'] = SubscriptionLog::CATEGORY['replacement-sim-ordered'];
			SubscriptionLog::create($baseSubscriptionLog);
		}
	}

	/**
	 * @param Request  $request
	 * @param          $order
	 * @param          $orderItems
	 */
	private function createInvoice(Request $request, $order, $orderItems)
	{
		$customer = Customer::find($request->get('customer_id'));
		$order = Order::whereHash($order->hash)->first();

		$invoiceStartDate = $this->getInvoiceDates($customer);
		$invoiceEndDate = $this->getInvoiceDates($customer, 'end_date');
		$invoiceDueDate = $this->getInvoiceDates($customer, 'due_date', true);

		$invoice = Invoice::create([
			'customer_id'             => $customer->id,
			'end_date'                => $invoiceEndDate,
			'start_date'              => $invoiceStartDate,
			'due_date'                => $invoiceDueDate,
			'type'                    => 2,
			'status'                  => 2,
			'subtotal'                => 0,
			'total_due'               => 0,
			'prev_balance'            => 0,
			'payment_method'          => 1,
			'notes'                   => 'Replacement order | '.$request->get('internal_notes'),
			'business_name'           => $customer->company_name,
			'billing_fname'           => $customer->billing_fname ?: $customer->fname,
			'billing_lname'           => $customer->billing_lname ?: $customer->lname,
			'billing_address_line_1'  => $customer->billing_address1,
			'billing_address_line_2'  => $customer->billing_address2,
			'billing_city'            => $customer->billing_city,
			'billing_state'           => $customer->billing_state_id,
			'billing_zip'             => $customer->billing_zip,
			'shipping_fname'          => $order->shipping_fname ?: $customer->fname,
			'shipping_lname'          => $order->shipping_lname ?: $customer->lname,
			'shipping_address_line_1' => $order->shipping_address1,
			'shipping_address_line_2' => $order->shipping_address2,
			'shipping_city'           => $order->shipping_city,
			'shipping_state'          => $order->shipping_state_id,
			'shipping_zip'            => $order->shipping_zip
		]);

		$order->update([
			'invoice_id'    => $invoice->id,
			'status'        => '1'
		]);

		$this->invoiceItem($orderItems, $invoice);

	}

	/**
	 * @param $orderItems
	 * @param $invoice
	 * @param $planActivation
	 */
	protected function invoiceItem($orderItems, $invoice) {
		foreach($orderItems as $orderItem) {
			if($orderItem->device_id) {
				CustomerStandaloneDevice::create([
					'customer_id'       => $invoice->customer_id,
					'order_id'          => $invoice->order->id,
					'order_num'         => $invoice->order->order_num,
					'subscription_id'   => $orderItem->subscription_id,
					'status'            => 'shipping',
					'processed'         => 0,
					'device_id'         => $orderItem->device_id,
					'imei'              => 'null'
				]);
				$device           = Device::find($orderItem->device_id);
				$deviceInvoiceItemArray = [
					/**
					 * @internal Setting subscription id 0 so that the invoice item
					 * can be displayed in the invoice
					 */
					'subscription_id'   => 0,
					'product_type'      => 'device',
					'invoice_id'        => $invoice->id,
					'start_date'        => $invoice->start_date,
					'product_id'        => $orderItem->device_id,
					'type'              => 3,
					'amount'            => 0,
					'taxable'           => $device->taxable,
					'description'       => 'Replacement Device'
				];
				InvoiceItem::create($deviceInvoiceItemArray);
			}

			if($orderItem->sim_id) {
				CustomerStandaloneSim::create([
					'customer_id'       => $invoice->customer_id,
					'order_id'          => $invoice->order->id,
					'order_num'         => $invoice->order->order_num,
					'subscription_id'   => $orderItem->subscription_id,
					'status'            => 'shipping',
					'processed'         => 0,
					'sim_id'            => $orderItem->sim_id,
					'sim_num'           => 'null'
				]);
				$sim           = Sims::find($orderItem->sim_id);
				$simInvoiceItemArray = [
					/**
					 * @internal Setting subscription id 0 so that the invoice item
					 * can be displayed in the invoice
					 */
					'subscription_id'   => 0,
					'product_type'      => 'sim',
					'invoice_id'        => $invoice->id,
					'start_date'        => $invoice->start_date,
					'product_id'        => $orderItem->sim_id,
					'type'              => 3,
					'amount'            => 0,
					'taxable'           => $sim->taxable,
					'description'       => 'Replacement SIM'
				];
				InvoiceItem::create($simInvoiceItemArray);
			}
		}
	}

	/**
	 * @param $customer
	 * @param $output
	 * @param $isOneTime
	 *
	 * @return Carbon|string
	 */
	protected function getInvoiceDates($customer, $output='start_date', $isOneTime=false)
	{
		$carbon = new Carbon();
		$dueDate = $carbon->toDateString();
		if(!($customer->billing_start || $customer->billing_end)) {
			$startDate = $endDate = $dueDate;
		} else {
			$startDate = $customer->billing_start;
			$endDate = $customer->billing_end;
			if(!$isOneTime){
				$dueDate = Carbon::parse($endDate)->subDays(1);
			}
		}
		if($output === 'end_date'){
			return $endDate;
		} elseif($output === 'due_date') {
			return $dueDate;
		} else {
			return $startDate;
		}
	}
}