<?php

namespace App\Http\Controllers\Customer;

use Auth;
use DataTables;
use App\Company;
use Carbon\Carbon;
use App\Model\Order;
use App\Model\Credit;
use App\Model\Invoice;
use App\Model\Customer;
use App\Model\PaymentLog;
use App\Model\InvoiceItem;
use App\Model\PendingCharge;
use Illuminate\Http\Request;
use App\Model\CustomerCreditCard;
use App\Events\CustomInvoiceAdded;
use App\Events\InstantInvoiceAdded;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\CardController;

/**
 * Class BillingController
 *
 * @package App\Http\Controllers\Customer
 */
class BillingController extends Controller
{

	/**
	 *
	 */
	const CREDIT_TYPE = [
		'payment'        => 1,
		'manual-credit'  => 2,
		'closed invoice' => 3,
	];

	/**
	 *
	 */
	const PAYMENT_LOG_STATUS = [
		0 => 'FAIL',
		1 => 'Success',
	];

	/**
	 *
	 */
	const STATUS = [
		'fail'    => 0,
		'success' => 1,
	];

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return array
	 */
	public function updateAutoPay($customerId, Request $request)
	{
		$data = $request->all();
		Customer::find($customerId)->update($data);

		return $data;
	}

	/**
	 * @param $customerId
	 *
	 * @return mixed
	 */
	public function getBillingHistoryData($customerId)
	{
		$invoice = $this->getInvoiceData($customerId);
		$credits = $this->getCreditData($customerId);

		$invoice = $invoice->merge($credits);
		$invoice = $invoice->sortBy('id')->sortBy('created_at'); //To generate balance column
		$balance = 0;
		$prev_amount = 0;
		foreach ($invoice as $inv) {
			if (isset($inv->subtotal)) {
				$amount = 0 - $inv->getBillingAmountAttribute(false);
			} else {
				$amount = $inv->getBillingAmountAttribute(false);
			}
			//$balance = $prev_amount + $amount;
			$balance = sprintf("%.2f",$amount+$prev_amount);
			//echo "id:".$inv->id.",date:".$inv->created_at.",prev:".$prev_amount.", current:".$amount.", balance:".$balance."\n";
			$inv->balance = ($balance < 0) ? '-$'.-$balance : '$'.$balance;
			$inv->amount = $amount;
			$prev_amount = $balance;
		}


		$invoice = $invoice->reverse();
		//$invoice = $invoice->sortByDesc('id')->sortByDesc('created_at'); //to show latest transaction at first
		return DataTables::of($invoice)
		                 ->addColumn('agent', function ($invoice) {
			                 $agent = "System";
			                 $staff_id = $invoice['staff'];
			                 if($staff_id == null){
				                 $agent = 'User';
			                 }else{
				                 $agent = $invoice['staff']->getFullNameAttribute();
			                 }
			                 return $agent;
		                 })
		                 ->addColumn('date', function ($invoice) {
			                 return '<span data-date ='.$invoice->created_at.'>'.$invoice->getCreatedDateFormattedAttribute().'</span>';
		                 })
		                 ->addColumn('type', function ($invoice) {
			                 return $this->getType($invoice);
		                 })
		                 ->addColumn('amount', function ($invoice) {
			                 if (isset($invoice->subtotal)) {
				                 return "-".$invoice->getBillingAmountAttribute();
			                 } else {
				                 return $invoice->getBillingAmountAttribute();
			                 }
		                 })
		                 ->addColumn('payment-type', function ($invoice) {
			                 return $invoice->getTypeDescriptionAttribute();
		                 })
		                 ->addColumn('detail', function () {
			                 return '<a href ="javascript:void(0);" type="button" class="btn btn-dark downloadbtnblue credit-info">View Details</a>';
		                 })
		                 ->addColumn('note', function ($invoice) {
			                 $note = 'NA';
			                 if ($invoice->description) {
				                 $note = $invoice->description;
			                 }
			                 return $note;
		                 })
		                 ->rawColumns(['detail', 'type', 'date'])
		                 ->make(true);
	}

	/**
	 * @param $customerId
	 *
	 * @return mixed
	 */
	public function getInvoiceData($customerId)
	{
		return Invoice::whereCustomerId($customerId)
		              ->with('order', 'refundInvoiceItem', 'staff', 'usedCredit')
		              ->where(function ($query) {
			              $query->where(function ($subQuery) {
				              $subQuery->has('order');
			              })
			                    ->orWhere(function ($subQuery) {
				                    $subQuery->has('refundInvoiceItem');
			                    })->orWhere(function ($subQuery) {
					              $subQuery->has('customer');
				              });;
		              }
		              )->get();
	}

	/**
	 * @param $customerId
	 *
	 * @return mixed
	 */
	public function getCreditData($customerId)
	{
		return Credit::whereCustomerId($customerId)->with('staff', 'usedCredit', 'invoice')->get();
	}

	/**
	 * @param $invoice
	 *
	 * @return string
	 */
	private function getType($invoice)
	{
		if (isset($invoice->subtotal)) {
			if ($invoice->order) {
				return 'Invoice
                <a href = '.config('internal.__BRITEX_API_BASE_URL').'/invoice/download/'.auth()->user()->company_id.'?order_hash='.$invoice->order["hash"].' type="button" class="btn btn-dark downloadbtnblue"><span class="fas fa-cloud-download-alt"></span>Download PDF
                </a>';
			} elseif (isset($invoice->refundInvoiceItem[0])) {
				return 'Refund
                <a href = '.config('internal.__BRITEX_API_BASE_URL').'/invoice/download/'.auth()->user()->company_id.'?invoice_hash='.bin2hex('invoice='.$invoice->id).' type="button" class="btn btn-dark downloadbtnblue"><span class="fas fa-cloud-download-alt"></span>Download PDF
                </a>';
			}
			elseif($invoice->getTypeDescriptionAttribute() == 'One-time invoice') {
				return 'Invoice
                 <a href = '.config('internal.__BRITEX_API_BASE_URL').'/invoice/download/'.auth()->user()->company_id.'?invoice_hash='.bin2hex('invoice='.$invoice->id).' type="button" class="btn btn-dark downloadbtnblue"><span class="fas fa-cloud-download-alt"></span>Download PDF
                    </a>';
			}
		}
		elseif ($invoice->invoice && $invoice->getTypeDescriptionAttribute() != 'Payment' ) {
			return 'Credit
        <a href = '.config('internal.__BRITEX_API_BASE_URL').'/invoice/download/'.auth()->user()->company_id.'?invoice_hash='.bin2hex('invoice='.$invoice->invoice->id).' type="button" class="btn btn-dark downloadbtnblue"><span class="fas fa-cloud-download-alt"></span>Download PDF
                    </a>';
		}

		return 'Credit';
	}

	/**
	 * @param $customerId
	 *
	 * @return mixed
	 */
	public function getPaymentLogData($customerId)
	{
		$paymentLog = PaymentLog::whereCustomerId($customerId)->with('paymentRefundLog')->get();

		return DataTables::of($paymentLog)
		                 ->addColumn('date', function ($paymentLog) {
			                 return '<span data-date ='.$paymentLog->created_at.'>'.$paymentLog->getCreatedDateFormattedAttribute().'</span>';
		                 })
		                 ->addColumn('transaction_num', function ($paymentLog) {
			                 return $paymentLog->transaction_num;
		                 })
		                 ->addColumn('refno', function ($paymentLog) {
			                 return $paymentLog->processor_customer_num;
		                 })
		                 ->addColumn('last4', function ($paymentLog) {
			                 return $paymentLog->last4;
		                 })
		                 ->addColumn('total', function ($paymentLog) {
			                 return '$'.$paymentLog->amount;
		                 })
		                 ->addColumn('error', function ($paymentLog) {
			                 return $paymentLog->error;
		                 })
		                 ->addColumn('refund', function ($paymentLog) {
			                 if ($paymentLog->status == 1) {
				                 $amount = $paymentLog->amount - $paymentLog->paymentRefundLog->where('status',
						                 self::STATUS['success'])->sum('amount');

				                 return '<div class="actionbtn">
                        <div class="refund-confirm-btn display-none">
                            <div id="portbxactions" class="active">
                                <div class="portcheckbox">
                                    <div class="custom-control custom-checkbox">
                                    <form id = "payment-log-form">
                                        <input type="hidden" name="refnum" value="'.$paymentLog->transaction_num.'">
                                        <input type ="text" name="amount" id="refund-amount" amount="'.$amount.'" value="'.$amount.'" ></input>
                                        <label><input type="checkbox" class="margin-right-10" name="credit" value = 1>Give Credit</label>
                                    </form>
                                    </div>
                                </div>
                                <div class="portclosebtn refund-confirm-close-btn"> <span class="fas fa-times"></span> </div>
                            </div>
                            <a class="btn markbtn confirmaction smbtn130 confirm-refund-btn" >Refund</a>
                        </div>
                        <div class="refund-action">
                            <button type="button" class="btn btn-dark purplebtn refund-btn">Refund Form</button>
                        </div>
                    </div>';
			                 }
		                 })
		                 ->addColumn('status', function ($paymentLog) {
			                 if ($paymentLog->status == 0) {
				                 return '<span class="activest red">'.self::PAYMENT_LOG_STATUS[$paymentLog->status].'</span>';
			                 }

			                 return '<span class="activest">'.self::PAYMENT_LOG_STATUS[$paymentLog->status].'</span>';
		                 })
		                 ->addColumn('refund_issue', function ($paymentLog) {
			                 return 'NA';
		                 })
		                 ->addColumn('details', function ($paymentLog) {
			                 return '<div class="actions">
                        <button type="button" class="btn btn-dark morebtn">More</button>
                    </div>';
		                 })
		                 ->rawColumns(['status', 'refund', 'details', 'date'])
		                 ->make(true);
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return \Illuminate\Support\Collection|string
	 */
	public function addCard($customerId, Request $request)
	{
		$data     = $this->validateData($request);
		$response = $this->validateMonth($data);
		if (isset($response)) {
			return $response;
		}
		$data                = $this->addAdditionalData($data);
		$data['customer_id'] = $customerId;
		$cards               = $this->requestConnection('add-card', 'post', $data);
		if (isset($cards['card'])) {
			if ($request->default) {
				$primary['customer_credit_card_id'] = $cards['card']['card']['id'];
				$primary['id']                      = $customerId;
				$primaryCards                       = $this->requestConnection('primary-card', 'post', $primary);
			}
		}

		return $cards;
	}

	/**
	 * @param $request
	 *
	 * @return mixed
	 */
	protected function validateData($request)
	{
		$data                     = $request->validate([
			'payment_card_no'     => 'required|max:19',
			'expires_mmyy'        => 'required',
			'payment_cvc'         => 'required|max:4',
			'payment_card_holder' => 'required',
			'billing_address1'    => 'required',
			'billing_city'        => 'required',
			'billing_state_id'    => 'required',
			'billing_zip'         => 'required',
		]);
		$data['billing_address2'] = $request->billing_address2;

		return $data;
	}

	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	private function addAdditionalData($data)
	{
		$apiKey                = Company::find(auth()->user()->company_id)->api_key;
		$data['api_key']       = $apiKey;
		$data['billing_fname'] = "Test";
		$data['billing_lname'] = "Test";

		return $data;
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	private function validateMonth($data)
	{
		$now   = Carbon::now();
		$month = $now->month;
		$year  = $now->format('y');
		$date  = explode("/", $data['expires_mmyy']);
		if ($year == $date['1'] && $date['0'] < $month) {
			return "New Card Can't be added due to Invalid Expiration Month";
		}
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return \Illuminate\Support\Collection|string
	 */
	public function manualPayment($customerId, Request $request)
	{
		$data = $request->validate([
			'amount'            => 'required',
			'description'       => 'sometimes',
			'credit_card_id'    => 'required',
			'payment_type'      => 'required'
		]);
		$card = CustomerCreditCard::where([
			['id', '=', $data['credit_card_id']],
			['customer_id', '=', $customerId],
		])->first();
		if ($card) {
			$data['customer_id']   = $customerId;
			$data['without_order'] = true;
			$data['staff_id']      = Auth::id();
			if ($data['payment_type'] == 'Custom Charge') {
				$data['subscription_id'] = null;
			} else {
				if ($data['payment_type'] == 'Manual Payment') {
					$data['subscription_id'] = $request->subscription_id;
				}
			}
			$responses = $this->requestConnection('charge-card', 'post', $data);

			return $responses;
		}
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function manualCredit($customerId, Request $request)
	{
		$data                        = $request->validate([
			'amount'      => 'required',
			'description' => 'required',
		]);
		$data['customer_id']         = $customerId;
		$data['staff_id']            = Auth::id();
		$data['date']                = Carbon::now();
		$data ['applied_to_invoice'] = '0';
		$data ['type']               = self::CREDIT_TYPE['manual-credit'];

		$credit    = Credit::create($data);
		$responses = $this->requestConnection('pay-unpaied-invoice', 'post', ['creditId' => $credit->id]);

		return $credit;
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function customInvoice($customerId, Request $request)
	{
		try {
			$data    = $request->validate( [
				'amount'          => 'required',
				'description'     => 'required',
				'type'            => 'required',
				'subscription_id' => 'required_if:type,4'
			] );
			$invoice = Invoice::where( [ [ 'customer_id', '=', $customerId ], [ 'status', '=', '1' ] ] )->first();

			if ( $invoice ) {
				$data[ 'product_type' ]    = " ";
				$data[ 'product_id' ]      = '0';
				$data[ 'product_type' ]    = 'custom-invoice';
				$data[ 'subscription_id' ] = $request->subscription_id;
				$data[ 'taxable' ]         = '0';
				$data[ 'start_date' ]      = Carbon::now();
				if ( $request->invoice_type === 'create' ) {
					$invoice = $this->createInstantInvoice( $customerId, $invoice );
					if ( isset( $output[ 'error' ] ) ) {
						throw new \Exception( $output[ 'error' ] );
					}
				}
				$data[ 'invoice_id' ] = $invoice->id;

				if ( $request->invoice_type === 'create' ) {
					event( new InstantInvoiceAdded(
						[
							'invoice_id' => $invoice->id,
							'amount'      => $data[ 'amount' ],
						]
					) );
				} else {
					event( new CustomInvoiceAdded(
						[
							'invoice_id' => $data[ 'invoice_id' ],
							'amount'     => $data[ 'amount' ],
						]
					) );
				}

				$invoiceItem = InvoiceItem::create( $data );
				if ( $invoiceItem ) {
					$invoice->subtotal  = $data[ 'amount' ] + $invoice->subtotal;
					$invoice->total_due = $data[ 'amount' ] + $invoice->total_due;
					$invoice->save();

					return $invoiceItem;
				}
			} else {
				$data[ 'subscription_id' ] = $request->subscription_id ?: 0;
				$data[ 'customer_id' ]     = $customerId;
				if ( $request->invoice_type === 'create' ) {
					$output = $this->createInstantInvoice( $customerId );
					if ( isset( $output[ 'error' ] ) ) {
						throw new \Exception( $output[ 'error' ] );
					}
					$output->subtotal  = $data[ 'amount' ];
					$output->total_due = $data[ 'amount' ];
					$output->save();
					$data[ 'product_type' ]    = " ";
					$data[ 'product_id' ]      = '0';
					$data[ 'product_type' ]    = 'custom-invoice';
					$data[ 'subscription_id' ] = $request->subscription_id ?: 0;
					$data[ 'taxable' ]         = '0';
					$data[ 'start_date' ]      = Carbon::now();
					$data[ 'invoice_id' ]      = $output->id;
					$output                    = InvoiceItem::create( $data );
					event( new InstantInvoiceAdded(
						[
							'customer_id' => $customerId,
							'amount'      => $data[ 'amount' ],
						]
					) );
				} else {
					$data[ 'invoice_id' ] = '0';
					$output               = PendingCharge::create( $data );
					event( new CustomInvoiceAdded(
						[
							'customer_id' => $customerId,
							'amount'      => $data[ 'amount' ],
						]
					) );
				}

				return $output;
			}
		} catch ( \Exception $e ) {
			return [ 'error' => $e->getMessage() ];
		}
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updateCustomerShippingInfo($customerId, Request $request)
	{
		$data                     = $request->validate([
			'shipping_fname'    => 'required',
			'shipping_lname'    => 'required',
			'shipping_address1' => 'required',
			'shipping_city'     => 'required',
			'shipping_state_id' => 'required',
			'shipping_zip'      => 'required',
		]);
		$data['shipping_address2'] = $request->shipping_address2;

		Customer::find($customerId)->update($data);

		return $data;
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updateCustomerBillingInfo($customerId, Request $request)
	{
		$data                     = $request->validate([
			'billing_fname'    => 'required',
			'billing_lname'    => 'required',
			'billing_address1' => 'required',
			'billing_city'     => 'required',
			'billing_state_id' => 'required',
			'billing_zip'      => 'required',
		]);
		$data['billing_address2'] = $request->billing_address2;

		Customer::find($customerId)->update($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return array|string[]
	 */
	public function processRefund(Request $request)
	{
		$data             = $request->validate([
			'refnum' => 'required',
			'amount' => 'required|numeric',
		]);
		$data['staff_id'] = Auth::id();
		if ($request->credit) {
			$data['credit'] = '1';
		} else {
			$data['credit'] = '0';
		}

		$response = $this->requestConnection('process-refund', 'post', $data);

		if ($response['message'] === 'success') {
			return ['success' => 'Refund Processed Successfully'];
		} else {
			return ['error' => $response['message']];
		}
	}

	/**
	 * @param      $customerId
	 * @param null $invoice
	 *
	 * @return mixed
	 */
	protected function createInstantInvoice($customerId, $invoice=null)
	{
		$customer = Customer::find($customerId);
		if(!$customer->billing_address1 ||
		   !$customer->billing_city ||
		   !$customer->billing_state_id ||
		   !$customer->billing_zip) {
			return [
				'error' => "Please update the customer's billing information."
			];
		}
		$carbon = new Carbon();
		$invoiceDate = $carbon->toDateString();
		$invoice = Invoice::create([
			'customer_id'             => $customer->id,
			'type'                    => 2,
			'status'                  => 1,
			'subtotal'                => '0',
			'total_due'               => '0',
			'prev_balance'            => '0',
			'payment_method'          => '1',
			'notes'                   => '',
			'end_date'                => $invoiceDate,
			'start_date'              => $invoiceDate,
			'due_date'                => $invoiceDate,
			'business_name'           => $customer->company_name,
			'billing_fname'           => $customer->billing_fname ?: $customer->fname,
			'billing_lname'           => $customer->billing_lname ?: $customer->lname,
			'billing_address_line_1'  => $customer->billing_address1,
			'billing_address_line_2'  => $customer->billing_address2,
			'billing_city'            => $customer->billing_city,
			'billing_state'           => $customer->billing_state_id,
			'billing_zip'             => $customer->billing_zip,
			'shipping_fname'          => $customer->fname,
			'shipping_lname'          => $customer->lname,
			'shipping_address_line_1' => $invoice->shipping_address_line_1 ?? $customer->billing_address1,
			'shipping_address_line_2' => $invoice->shipping_address_line_2 ?? $customer->billing_address2,
			'shipping_city'           => $invoice->shipping_city ?? $customer->billing_city,
			'shipping_state'          => $invoice->shipping_state ?? $customer->billing_state_id,
			'shipping_zip'            => $invoice->shipping_zip ?? $customer->billing_zip
		]);

		Order::create([
			'hash'              => sha1(time().rand()),
			'customer_id'       => $customer->id,
			'company_id'        => $customer->company_id,
			'status'            => 1,
			'invoice_id'        => $invoice->id,
			'order_num'         => 1,
			'date_processed'    => Carbon::today()
		]);
		return $invoice;
	}
}
