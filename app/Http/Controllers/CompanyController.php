<?php

namespace App\Http\Controllers;

use App\Company;
use App\Model\Carrier;
use App\Model\EmailTemplate;
use App\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\SystemGlobalSetting;
use App\Support\DataProviders\StatesProvider;

/**
 * Class CompanyController
 *
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
    {
    	$carriers = Carrier::all();
        $states = $this->states();
    	return view('company.index', compact('carriers', 'states'));
    }


	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
	 */
	public function create(Request $request)
    {
    	$data = $request->validate([
            'name'                          => 'required',
            'url'                           => 'required',
            'staff_first_name'               => 'required',
            'staff_last_name'               => 'required',
            'staff_phone'                   => 'required',
            'staff_email'                   => 'required|email',
            'staff_password'                => 'required|confirmed',
            'staff_password_confirmation'    => 'required',
   //          'regulatory_label'              =>  'required',
   //          'default_voice_reg_fee'         =>  'required',
   //          'default_data_reg_fee'          =>  'sometimes|required',
   //          'support_phone_number'          =>  'required',
             'support_email'                 =>  'required',
   //          'suspend_grace_period'          =>  'required',
   //          'smtp_driver'                   =>  'required',
   //          'smtp_host' => 						'required',
			// 'smtp_port' => 						'required',
			// 'smtp_username' => 					'required',
			// 'smtp_password' => 					'required',
			// 'email_header' => 					'required',
			// 'email_footer' => 					'required',
			// 'primary_contact_name' => 			'required',
			// 'primary_contact_phone_number' => 	'required',
			// 'primary_contact_email_address' => 	'required',
			// 'address_line_1' => 				'required',
			// 'address_line_2' => 				'required',
			// 'city' => 							'required',
			// 'state' => 							'required',
			// 'zip' => 							'required',
			// 'readycloud_api_key' => 			'required',
			// 'reseller_status' => 				'required',
			// 'selling_devices'              	 => 'sometimes|required',
			// 'selling_plans'              	 => 'sometimes|required',
			// 'selling_addons'            	 => 'sometimes|required',
			// 'selling_sim_standalone'         => 'sometimes|required',
			// 'business_verification'          => 'sometimes|required',

        ]);
		// $data['readycloud_username'] = $request->readycloud_username;
		// $data['readycloud_password'] = $request->readycloud_password;
		// $data['tbc_username']        = $request->tbc_username;
		// $data['tbc_password']        = $request->tbc_password;
		// $data['apex_username']       = $request->apex_username;
		// $data['premier_username']    = $request->premier_username;
		// $data['premier_password']    = $request->premier_password;
		// $data['opus_usernames']      = $request->opus_usernames;
		// $data['opus_password']       = $request->opus_password;
        $data = $request->all();
        unset($data['carrier_id']);
        if(! $request->regulatory_label){
            unset($data['regulatory_label']);
        }
        if(! $request->suspend_grace_period){
            unset($data['suspend_grace_period']);
        }
		$data['api_key']  = Str::random(10);
		$data['enable_bulk_order']  = $data['enable_bulk_order'] ?? 0;
	    $data['usaepay_live']  = $data['usaepay_live'] ?? 0;

        $company = Company::create($data);
        $carrierId = null;
        foreach ($request->carrier_id as $key => $carrierDetail) {
           $carrierId[$key] = json_decode($carrierDetail)->id;
        }
        $company->carrier()->sync($carrierId);

        if($company){
	        $staffData = [
		        'fname'         => $data['staff_first_name'],
		        'lname'         => $data['staff_last_name'],
		        'level'         => $data['staff_level'],
		        'phone'         => $data['staff_phone'],
		        'email'         => $data['staff_email'],
		        'password'      => Hash::make($data['staff_password']),
		        'reset_hash'    => ' ',
		        'company_id'    => $company->id
	        ];
	        Staff::create($staffData);
        	$msg = 'Company Added Sucessfully';
            if($request->logo){
                $logo = $this->uploadImage($request, $company);
                if ($logo != 1) {
                    $msg = 'Company Added Sucessfully but Logo not uploaded';
                }
            }
	        session(['all-company' => Company::all()]);
	        /**
	         * When a new company is created, auto generate the email triggers for that account.
	         */
            $emailTemplates = EmailTemplate::where('company_id', 1)->get();
	        $emailTemplateCreateData = [
		        'company_id'    => $company->id,
		        'from'          => $company->support_email,
		        'cc'            => null,
		        'bcc'           => null
	        ];
            foreach($emailTemplates as $emailTemplate) {
	            $emailTemplateCreateData['code'] = $emailTemplate->code;
	            $emailTemplateCreateData['to'] = $emailTemplate->to;
	            $emailTemplateCreateData['subject'] = $emailTemplate->subject;
	            $emailTemplateCreateData['body'] = $emailTemplate->body;
	            $emailTemplateCreateData['notes'] = $emailTemplate->notes;
	            $emailTemplateCreateData['reply_to'] = $emailTemplate->reply_to;
	            EmailTemplate::create($emailTemplateCreateData);
            }
        }else{
        	$msg = 'Sorry Something went Wrong';
        }
        return redirect(route('master.admin'))->with('status', $msg);
    }

	/**
	 * @return Carrier[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function allCarrier()
    {
    	return Carrier::all();
    }

	/**
	 * @param Request $request
	 * @param         $company
	 *
	 * @return mixed
	 */
	public function uploadImage(Request $request, $company)
    {
        $image = $request->file('logo');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $SystemGlobalSetting = SystemGlobalSetting::first();
        $path = $SystemGlobalSetting->upload_path."/uploads/".$company->id."/logo/";

        $image->move($path, $new_name);

        $uploadUrl = $SystemGlobalSetting->site_url."/uploads/".$company->id."/logo/";

        $logo = Company::find($company->id)->update(['logo' => $uploadUrl.$new_name]);

        return $logo;
    }

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function checkUsaepayKey(Request $request)
    {
        $count = Company::where([['usaepay_api_key', $request->usaepay_api_key]])->count();
        
        return ($count > 0 ) ? 'false' : 'true';
    }

	/**
	 * @param $companyId
	 *
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function edit($companyId)
    {
        $company = Company::whereId($companyId)->with('carrier')->first();
        $carriers = Carrier::all();
        $states = $this->states();
        return view('company.edit', compact('carriers', 'states', 'company'));
    }

	/**
	 * @param Request $request
	 * @param Company $company
	 *
	 * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
	 */
	public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name'   =>  'required',
            'url'    =>  'required',

        ]);
        $data = $request->all();
        $data = $this->setAdditionalData($data, $request);

        $company->update($data);
        $carrierId = null;
        foreach ($request->carrier_id as $key => $carrierDetail) {
           $carrierId[$key] = json_decode($carrierDetail)->id;
        }
        $company->carrier()->sync($carrierId);
        if($company){
            $msg = 'Company Edited Successfully';
            if($request->logo){
                $logo = $this->uploadImage($request, $company);
                if ($logo != 1) {
                    $msg = 'Company Added Successfully but Logo not uploaded';
                }
            }
        }else{
            $msg = 'Sorry Something went Wrong';
        }
        return redirect(route('master.admin'))->with('status', $msg);
    }

	/**
	 * @return \App\Support\DataProviders\Collection
	 */
	private function states()
    {
        return StatesProvider::data();
    }

	/**
	 * @param $data
	 * @param $request
	 *
	 * @return mixed
	 */
	public function setAdditionalData($data, $request)
    {
        unset($data['carrier_id']);
        if(! $request->regulatory_label){
            unset($data['regulatory_label']);
        }
        if(! $request->suspend_grace_period){
            unset($data['suspend_grace_period']);
        }
        if(! isset($data['selling_devices'])){
            $data['selling_devices'] = 0;
        }
        if(! isset($data['selling_plans'])){
            $data['selling_plans'] = 0;
        }
        if(! isset($data['selling_addons'])){
            $data['selling_addons'] = 0;
        }
        if(! isset($data['selling_sim_standalone'])){
            $data['selling_sim_standalone'] = 0;
        }
        if(! isset($data['business_verification'])){
            $data['business_verification'] = 0;
        }
	    if(! isset($data['usaepay_live'])){
		    $data['usaepay_live'] = 0;
	    }
        return $data;
    }
}