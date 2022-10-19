<?php

namespace App\Http\Controllers;

use App\Model\Subscription;
use DataTables;
use Carbon\Carbon;
use App\Model\Invoice;
use App\Model\CronLog;
use App\Model\Customer;
use App\Model\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class ToolsController
 *
 * @package App\Http\Controllers
 */
class ToolsController extends Controller
{
	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		return view('tools.due_check');
	}

	/**
	 * @param $customerInvoice
	 *
	 * @return mixed
	 */
	public function getPaymentAndCreditAmount($customerInvoice)
	{
		return $customerInvoice->creditToInvoice->sum('amount');
	}

	/**
	 * @param $amount
	 *
	 * @return false|string[]
	 */
	public function getAmountFormated($amount){
		return explode(".", (string)self::toTwoDecimals($amount));
	}

	/**
	 * @param $amount
	 *
	 * @return string
	 */
	protected static function toTwoDecimals($amount)
	{
		return number_format((float)$amount, 2, '.', '');
	}

	/**
	 * @param $customer
	 *
	 * @return mixed
	 */
	public function getTotalDueDate($customer)
	{
		$invoice = Invoice::where([['customer_id', $customer->id],['status', '1']])->first();
		if($invoice){
			$dueDate = $invoice->due_date_formatted;
		}else{
			$dueDate = $customer->billing_end_date_formatted;
		}
		return $dueDate;

	}

	/**
	 * @param $customer
	 *
	 * @return array
	 */
	protected function invoiceDetail($customer)
	{
		$array = [
			'billing_start' => $customer->billing_start_date_formatted,
			'billing_end'   => $customer->billing_end_date_formatted,
		];

		$date = Carbon::today()->subDays(31)->endOfDay();
		$customerInvoice = Invoice::where([
			'customer_id'   => $customer->id,
			'type'          => 1 //monthly
		])->where('start_date', '>', $date)->get()->last();

		if($array['billing_start'] =='NA' || $array['billing_end'] =='NA' || ! $customerInvoice){
			return array_merge([
				'charges'  => ['0','00'],
				'past_due' => ['0','00'],
				'payment'  => ['0','00'],
				'total'    => ['0','00'],
				'due_date' => 'NA'
			], $array);
		}

		$charges = $customerInvoice->subtotal;

		$payment = $this->getPaymentAndCreditAmount($customerInvoice);

		$pastDue = 0;
		if($customerInvoice->status == 0){ //closed&upaid
			$pastDue = $customerInvoice->total_due;
		}
		// $total = ($charges - $payment) + $pastDue;
		$total =  $customerInvoice->total_due;

		if($total < 0){
			$total = 0;
		}

		$charges = $this->getAmountFormated($charges);
		$payment = $this->getAmountFormated($payment);
		$pastDue = $this->getAmountFormated($pastDue);
		$total   = $this->getAmountFormated($total);
		$dueDate = $this->getTotalDueDate($customer);


		return array_merge([
			'charges'  => $charges,
			'past_due' => $pastDue,
			'payment'  => $payment,
			'total'    => $total,
			'due_date' => $dueDate
		], $array);
	}

	/**
	 * @param $customer
	 *
	 * @return int
	 */
	protected function autoPayDue($customer){
		$due = 0;
		$date = Carbon::today()->addDays(1);
		if($customer["account_suspended"] == 1){

		}else{
			$api_key = $customer["company"]["api_key"];
			// var_dump($customer);
			if(isset($customer['unpaid_mounthly_invoice'][0]) || isset($customer['unpaid_and_closed_mounthly_invoice'][0]) ){

				if(isset($customer['unpaid_mounthly_invoice'][0])){
					$customer['mounthlyInvoice'] = $customer['unpaid_mounthly_invoice'][0];
				}else{
					$customer['mounthlyInvoice'] = $customer['unpaid_and_closed_mounthly_invoice'][0];
				}
				$due = $customer['mounthlyInvoice']['total_due'];
			}
		}
		return $due;

	}

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function dueCheck()
	{
		$customers = array();

		$_customers = Customer::with(
			'unpaidAndClosedMounthlyInvoice',
			'unpaidMounthlyInvoice',
			'company')
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('id', 'DESC')->get();
		foreach ($_customers as $customer) {
			$invoice = $this->invoiceDetail($customer);
			$autopay_due = $this->autoPayDue($customer->toArray());
			$cust = array(
				'id' => $customer->id,
				'name' => $customer->fname . " " . $customer->lname,
				'portal_due' => $invoice['total'][0].".".$invoice['total'][1],
				'admin_due' => $customer->credits_count,
				'autopay_due' => $autopay_due
			);
			$customers[] = $cust;
		}

		return view('tools.due_check', compact('customers') );
	}

	public function report()
	{
		$arr = array();

		$invoices = Invoice::all();

            foreach($invoices as $invoice){

                $sumtotal=InvoiceItem::where('invoice_id',$invoice->id)->where('type','!=', 6)->where('type','!=', 10)->sum('amount');
                $sum=InvoiceItem::where('invoice_id',$invoice->id)->where('type', 6)->sum('amount');
                $invoice->sumtotal=$sumtotal;
                $invoice->sumcoupon=$sum;

                if(($invoice->sumtotal - $invoice->sumcoupon) !=  $invoice['subtotal']){
                   array_push($arr,$invoice);
                }

            }

		return view('tools.report', compact('invoices') );
	}


	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function getCronLogsIndex()
	{
		return view('tools.cron-logs');
	}

	public function getCronLogs(Request $request) {

		/**
		 * @see https://bit.ly/3Hr6d2o
		 */
		try {
			$columns = [
				0 => 'name',
				1 => 'status',
				2 => 'payload',
				3 => 'response',
				4 => 'ran_at'
			];


			$totalData = CronLog::count();

			$totalFiltered = $totalData;

			$limit = $request->input( 'length' );
			$start = $request->input( 'start' );
			$order = $columns[ $request->input( 'order.0.column' ) ];
			$dir   = $request->input( 'order.0.dir' );

			if ( empty( $request->input( 'search.value' ) ) ) {
				$cronLogs = CronLog::offset( $start )
				                   ->limit( $limit )
				                   ->orderBy( $order, $dir )
				                   ->get();
			} else {
				$search = $request->input( 'search.value' );

				$cronLogs      = CronLog::where( [
					[ 'name', 'LIKE', "%{$search}%" ],
					[ 'status', 'LIKE', "%{$search}%" ]
				] )
				                        ->offset( $start )
				                        ->limit( $limit )
				                        ->orderBy( $order, $dir )
				                        ->get();
				$totalFiltered = CronLog::where( [
					[ 'name', 'LIKE', "%{$search}%" ],
					[ 'status', 'LIKE', "%{$search}%" ]
				] )->count();
			}

			$data = [];
			if ( ! empty( $cronLogs ) ) {
				foreach ( $cronLogs as $cronLog ) {
					$nestedData               = [];
					$nestedData[ 'name' ]     = $cronLog->name;
					$nestedData[ 'status' ]   = $cronLog->status;
					$nestedData[ 'payload' ]  = $cronLog->payload;
					$nestedData[ 'response' ] = $cronLog->response;
					$nestedData[ 'ran_at' ]   = $cronLog->ran_at;
					$nestedData[ 'id' ]       = $cronLog->id;
					$data[]                   = $nestedData;
				}
			}

			$json_data = [
				"draw"            => intval( $request->input( 'draw' ) ),
				"recordsTotal"    => intval( $totalData ),
				"recordsFiltered" => intval( $totalFiltered ),
				"data"            => $data
			];

			if ( $request->has( 'download' ) && $request->get( 'download' ) ) {
				/**
				 * @see https://bit.ly/2X3epC6
				 */
				$fileHandle = fopen( 'php://output', 'w' );
				ob_start();

				$header   = [
					'Name',
					'Status',
					'Payload',
					'Response'
				];

				fputcsv( $fileHandle, $header );

				fputcsv( $fileHandle, $data );

				fclose( $fileHandle );

				$csvObject = ob_get_contents();

				ob_get_clean();

				$fileName = 'cron-logs-' . date( 'Ymd' ) . '-' . date( 'His' ) . '.csv';

				return \Response::make( $csvObject, 200, [
					'Content-Type'              => 'application/octet-stream',
					'Content-Description'       => 'File Transfer',
					'Content-Disposition'       => 'attachment; filename="' . $fileName . '";',
					'Pragma'                    => 'private',
					'Expires'                   => 0,
					'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
					'Content-Transfer-Encoding' => 'binary'
				] );
			}

			return response( $json_data );
		} catch ( \Exception $e ) {
			Log::info($e->getMessage() . ' on line number: '.$e->getLine() . ' Get Cron Logs');
			return [
				'status'  => 'error',
				'message' => $e->getMessage()
			];
		}

	}
}
