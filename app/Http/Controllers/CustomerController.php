<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Company;
use App\Model\Ban;
use Carbon\Carbon;
use App\Model\Sims;
use App\Model\Customer;
use App\Model\CustomerLog;
use App\Model\EmailLog;
use App\Model\DeviceGroup;
use App\Model\Subscription;
use App\Model\CannedResponse;
use App\Model\CustomerNote;
use Illuminate\Http\Request;
use App\Events\ComposeEmail;
use App\Support\DataProviders\StatesProvider;

/**
 * Class CustomerController
 *
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		return view('customers.show');
	}

	/**
	 * @param Customer $customer
	 *
	 * @return mixed
	 */
	public function getAllLog(Customer $customer)
	{
		$customerLog = CustomerLog::where('customer_id', $customer->id)->get();
		return DataTables::of($customerLog)
		                 ->addColumn('created_at', function($customerLog) {
			                 return $customerLog->created_at;
		                 })
		                 ->rawColumns(['id', 'content', 'updated_at'])
		                 ->make(true);
	}

	/**
	 * @param Customer $customer
	 *
	 * @return mixed
	 */
	public function getAllEmailLog(Customer $customer)
	{
		$emailLog = EmailLog::where('customer_id', $customer->id)->with('staff')->get();
		return DataTables::of($emailLog)
		                 ->addColumn('agent', function($emailLog) {
			                 $staff = $emailLog->staff;
			                 $full_name = '';
			                 if($staff and isset($staff['full_name'])){
				                 $full_name = $staff['full_name'];
			                 }
			                 return '<div class="tableuserbx">
                            <div class="usrname"><strong>'.$full_name.'</strong></div>
                        </div>';
		                 })
		                 ->addColumn('subject', function($emailLog) {
			                 return $emailLog->subject;
		                 })
		                 ->addColumn('to', function($emailLog) {
			                 return '<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="54353a3a3527393d203c143339353d387a373b39">'.$emailLog->to.'</a>';
		                 })
		                 ->addColumn('created_at', function($emailLog) {
			                 return '<span data-date ='.$emailLog->created_at.'>'.$emailLog->created_at_formatted.'</span>';
		                 })
		                 ->addColumn('body', function($emailLog) {
			                 return str_limit($emailLog->body, 30);
		                 })
		                 ->addColumn('modify', function($emailLog) {
			                 return '<a class="btn btn-dark purplebtn more-btn" data-toggle="collapse" href="#morebutton" role="button" aria-expanded="false" aria-controls="collapseExample">Show More</a>';
		                 })
		                 ->addColumn('all-data', function($emailLog) {
			                 return htmlspecialchars(json_encode($emailLog));
		                 })
		                 ->rawColumns(['modify', 'agent', 'to', 'body', 'created_at'])
		                 ->make(true);
	}

	/**
	 * @param $customerId
	 *
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|void
	 */
	public function show($customerId)
	{
		$customer = Customer::where('id', $customerId)->with('company')->first();
		$user = Auth::user();
		if($customer == null ||  $customer->company_id != $user->company_id){
			return redirect('/action-queue')->with('status', "Customer Doesn't belongs to your Company");
		}
		$states = array_merge([''=>'--- Please Select ---'],  $this->states()->toArray());

		$cannedResponse = CannedResponse::where(['company_id' => $user->company_id, 'section' => '3'])->get();
		$transactionType = $this->transactionType();
		$subcription = $this->getCustomerSubscription($customer->id);
		$customerCards = $this->getCustomerCards($customer->hash);
		$deviceOs = DeviceGroup::whereCompanyId($user->company_id)->pluck('name', 'name')->toArray();
		$sim = Sims::whereCompanyId($user->company_id)->pluck('name', 'name')->toArray();
		$ban = Ban::whereCompanyId($user->company_id)->get();
		$allBan = $ban->pluck('number', 'id');
		$atBan = $ban->where('node_id', null)->pluck('number', 'id');
		$tmobBan =  $ban->where('fan_id', null)->pluck('number', 'id');
		$customer->load('pendingPaymentInvoices', 'customerNote.staff');


		return view('customers.show', compact('user', 'customer', 'states', 'transactionType', 'customerCards', 'subcription', 'allBan', 'atBan', 'tmobBan', 'deviceOs', 'sim', 'cannedResponse'));
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return string
	 */
	public function checkEmail($customerId, Request $request)
	{
		$count = Customer::where([['email', '=', $request->email],['id', '!=', $customerId]])->count();
		return ($count > 0 ) ? 'false' : 'true';
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updateCustomer(Request $request)
	{
		$id = $request->id;
		$data =  $request->validate([
			'fname'			=> 'required',
			'lname'			=> 'required',
			'email'			=> 'required|unique:customer,email,'.$id,
			'phone'			=> 'required',
			'pin'			=> 'required',
		]);

		$data['company_name'] = $request->company_name;
		if($request->alternate_phone){
			$data['alternate_phone'] = preg_replace('/[^\dxX]/', '', $request->alternate_phone);
		}else{
			$data['alternate_phone'] = null;
		}
		$phone = $data['phone'];
		$data['phone']= preg_replace('/[^\dxX]/', '', $data['phone']);

		$customer = Customer::find($id);
		$customer->update($data);

		$data['phone'] = $phone;

		return $data;
	}

	/**
	 * @param         $customerId
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function addNote($customerId ,Request $request)
	{
		$data =  $request->validate([
			'text'  => 'required',
		]);

		$data['customer_id'] = $customerId;
		$data['staff_id'] = Auth::id();
		$data['date'] = Carbon::now()->toDateTimeString();

		CustomerNote::create($data);

		$data['date'] = Carbon::parse($data['date'])->format('F d, Y');

		return $data;

	}

	/**
	 * @return \App\Support\DataProviders\Collection
	 */
	private function states()
	{
		return StatesProvider::data();
	}

	/**
	 * @return string[]
	 */
	private function transactionType()
	{
		return[
			'Manual Payment' => 'Manual Payment',
			'Custom Charge'  => 'Custom Charge',
			'Manual Credit'  => 'Manual Credit',
			'Custom Invoice' => 'Custom Invoice',
		];
	}

	/**
	 * @param $hash
	 *
	 * @return \App\Support\Utilities\Collection
	 */
	private function getCustomerCards($hash)
	{
		$apiKey = Company::find(auth()->user()->company_id)->api_key;
		return $this->requestConnection('customer-cards', 'get', [
			'hash'    =>  $hash
		]);
	}

	/**
	 * @param $id
	 *
	 * @return array
	 */
	private function getCustomerSubscription($id)
	{
		$subcription = Subscription::where([['customer_id', '=', $id],['status', 'active'],['phone_number', '!=', null]])->get()->toArray();

		return array_column($subcription, 'phone_number', 'id');
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function addEmailLog(Request $request)
	{
		$data = $this->validateData($request);

		if(!$request->has('reply_to')) {
			$data['reply_to'] = null;
		}

		if($request->has('compose')) {
			event(new ComposeEmail($data));
		}

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
			'company_id'               => '',
			'customer_id'              => 'required',
			'staff_id'                 => 'required',
			'business_verficiation_id' => '',
			'type'                     => '',
			'from'                     => 'required',
			'to'                       => 'required',
			'subject'                  => 'required',
			'body'                     => 'required',
			'notes'                    => '',
			'reply_to'                 => '',
			'cc'                       => '',
			'bcc'                      => '',
		]);

		return $data;
	}

	/**
	 * @return string
	 */
	public function billingName()
	{
		$customers = Customer::all();

		foreach ($customers as $key => $customer) {
			$data = [
				'billing_fname'  =>  $customer->fname,
				'billing_lname'  =>  $customer->lname
			];
			Customer::find($customer->id)->update($data);
		}
		return 'sucesssful';
	}
}