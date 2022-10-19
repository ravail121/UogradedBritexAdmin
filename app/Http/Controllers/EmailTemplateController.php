<?php

namespace App\Http\Controllers;

use Schema;
use DataTables;
use App\Model\EmailTemplate;
use Illuminate\Http\Request;
use App\Model\CannedResponse;

/**
 * Class EmailTemplateController
 *
 * @package App\Http\Controllers
 */
class EmailTemplateController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		$data = $this->getPlaceHoldersData();
		$customPlaceHolders = $data['customPlaceHolders'];
		$allPlaceHolders = $data['allPlaceHolders'];
		$systemEmailTemplate = EmailTemplate::where('company_id', auth()->user()->company_id )->distinct('code')->pluck('code');

		return view('email-template.index', compact( 'systemEmailTemplate', 'allPlaceHolders', 'customPlaceHolders'));
	}


	/**
	 * @return mixed
	 */
	public function getAllTemplate()
	{
		$emailTemplate = EmailTemplate::where('company_id', '=', auth()->user()->company_id )->get();

		return DataTables::of($emailTemplate)
		                 ->addColumn('id', function($emailTemplate) {
			                 return $emailTemplate->id;
		                 })
		                 ->addColumn('code', function($emailTemplate) {
			                 return $emailTemplate->code;
		                 })
		                 ->addColumn('from', function($emailTemplate) {
			                 return $emailTemplate->from;
		                 })
		                 ->addColumn('to', function($emailTemplate) {
			                 return $emailTemplate->to;
		                 })
		                 ->addColumn('subject', function($emailTemplate) {
			                 return $emailTemplate->subject;
		                 })
		                 ->addColumn('body', function($emailTemplate) {
			                 return substr($emailTemplate->body, 0, 150);
		                 })
		                 ->addColumn('modify', function($emailTemplate) {
			                 return '<div class="actionbtn">
                            <div class="dropdown" style="margin-bottom: 6px;"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#updateshipping"> Edit </a></div>
                            <div class="dropdown"> <a class="btn delete-btn" data-id ='.$emailTemplate->id.' > Delete </a> </div>
                        </div>';
		                 })
		                 ->addColumn('all-data', function($emailTemplate) {
			                 return htmlspecialchars(json_encode($emailTemplate));

		                 })
		                 ->rawColumns(['modify', 'body'])
		                 ->make(true);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function edit(Request $request)
	{
		$data = $this->validateData($request);

		$data['id'] = $request->id;

		$emailTemplate = EmailTemplate::find($data['id']);

		$emailTemplate->update($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function add(Request $request)
	{
		$data = $this->validateData($request);

		$data['company_id'] = auth()->user()->company_id;

		$emailTemplate = EmailTemplate::create($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function validateData(Request $request)
	{
		$data = $request->validate([
			'company_id'      => '',
			'code'            => 'required',
			'from'            => 'required',
			'to'              => 'required',
			'subject'         => 'required',
			'body'            => 'required',
			'notes'           => '',
			'reply_to'        => '',
			'cc'              => '',
			'bcc'             => '',
		]);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function deleteEmailTemplate(Request $request)
	{
		$data = $request->validate([
			'id'  => 'required',
		]);

		EmailTemplate::find($data['id'])->delete();

		return $data;
	}

	/**
	 * CANNED RESPONSE
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function cannedResponse()
	{
		$section = CannedResponse::SECTION_DETAILS;

		$customerTable = Schema::getColumnListing('customer');
		$businessVerificationTable = Schema::getColumnListing('business_verification');

		return view('email-template.canned-response', compact('section', 'customerTable', 'businessVerificationTable'));
	}

	/**
	 * @return mixed
	 */
	public function getCannedResponseData()
	{
		$cannedResponse = CannedResponse::where('company_id', auth()->user()->company_id )->get();

		return DataTables::of($cannedResponse)
		                 ->addColumn('body', function($cannedResponse) {
			                 return substr($cannedResponse->body, 0, 150);
		                 })
		                 ->addColumn('section', function($cannedResponse) {
			                 return CannedResponse::SECTION_DETAILS[$cannedResponse->section];
		                 })
		                 ->addColumn('modify', function($cannedResponse) {
			                 return '<div class="actionbtn">
                            <div class="dropdown" style="margin-bottom: 6px;"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#updateshipping"> Edit </a></div>
                            <div class="dropdown"> <a class="btn delete-btn" data-id ='.$cannedResponse->id.' > Delete </a> </div>
                        </div>';
		                 })
		                 ->addColumn('all-data', function($cannedResponse) {
			                 return htmlspecialchars(json_encode($cannedResponse));

		                 })
		                 ->rawColumns(['modify', 'body'])
		                 ->make(true);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function deleteCanndedResponse(Request $request)
	{
		$data = $request->validate([
			'id'  => 'required',
		]);

		CannedResponse::find($data['id'])->delete();

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function editCannedResponse(Request $request)
	{
		$data = $this->validateCannedData($request);
		$data['id'] = $request->id;
		$emailTemplate = CannedResponse::find($data['id']);

		$emailTemplate->update($data);
		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function addCannedData(Request $request)
	{
		$data = $this->validateCannedData($request);
		$data['company_id'] = auth()->user()->company_id;
		$emailTemplate = CannedResponse::create($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function validateCannedData(Request $request)
	{
		$data = $request->validate([
			'section'         => 'required',
			'name'            => 'required',
			'subject'         => 'required',
			'body'            => 'required',
		]);

		return $data;
	}

	/**
	 * @return array
	 */
	public function getPlaceHoldersData()
	{
		$customPlaceHolders = collect([
			'account-pastdue'               => '[balance_due], [active_subscriptions_list]',
			'for-activation'                => '[addon__name]',
			'activation-complete'           => '[addon__name]',
			'closed'                        => '[addon__name]',
			'suspended'                     => '[addon__name]',
			'refund'                        => '[refund_amount]',
			'auto-pay-reminder'             => '[total_amount_due]',
			'auto-pay-fail'                 => '[total_amount_due], [description]',
			'auto-pay-success'              => '[total_amount_due]',
			'shipping-tracking'             => '[product_name] ,[tracking_num]',
			'subscription-change'           => '[subscriptions_changed]',
			'biz-verification-rejected'      => '[additional_message]',
		]);

		$allPlaceHolders = collect([
			(object) [
				'code' => (object)[
					'biz-verification-approved',
					'biz-verification-rejected',
					'biz-verification-submitted'
				],
				'table' => 'biz-verification',
				'name' => (object) Schema::getColumnListing('business_verification'),
			],
			(object) [
				'code' => (object)[
					'auto-pay-success',
					'auto-pay-reminder',
					'auto-pay-fail',
					'auto-pay-enabled',
					'auto-pay-disabled',
					'port-complete',
					'one-time-invoice',
					'monthly-invoice',
					'refund',
					'subscription-activated',
					'for-activation',
					'port-pending',
					'custom-invoice',
					'account-pastdue',
					'closed',
					'subscription-change',
					'shipping-tracking',
					'account-unsuspended',
					'reset-password',
					'activation-complete',
					'payment-failed',
					'custom-charge',
					'suspended',
					'scheduled close',
					'scheduled suspend',
					'credit-card-expiration',
					'instant-invoice',
					'requested-zip-removal'
				],
				'table' => 'customer',
				'name' => (object) Schema::getColumnListing('customer'),
			],
			(object) [
				'code' => (object)[
					'one-time-invoice',
					'monthly-invoice',
					'refund',
					'subscription-activated',
					'custom-invoice',
					'closed',
					'auto-pay-success',
					'auto-pay-reminder',
					'custom-charge',
					'instant-invoice'
				],
				'table' => 'invoice',
				'name' => (object) Schema::getColumnListing('invoice'),
			],
			(object) [
				'code' => (object)[
					'for-activation',
					'subscription-change',
					'activation-complete',
					'port-complete',
					'port-pending',
					'subscription-activated',
					'closed',
					'suspended',
					'scheduled close',
					'scheduled suspend',
					'for-restoration',
					'requested-zip-removal'
				],
				'table' => 'subscription',
				'name' => (object) Schema::getColumnListing('subscription'),
			],
			(object) [
				'code' => (object)[
					'one-time-invoice',
					'monthly-invoice',
					'instant-invoice'
				],
				'table' => 'order',
				'name' => (object) Schema::getColumnListing('order'),
			],
			(object) [
				'code' => (object)[
					'port-pending',
					'port-complete'
				],
				'table' => 'port',
				'name' => (object) Schema::getColumnListing('port'),
			],
			(object) [
				'code' => (object)['credit-card-expiration'],
				'table' => 'customer_credit_card',
				'name' => (object) Schema::getColumnListing('customer_credit_card'),
			],
		]);

		return [
			'customPlaceHolders'    => $customPlaceHolders,
			'allPlaceHolders'       => $allPlaceHolders
		];
	}
}
