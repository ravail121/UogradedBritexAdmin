<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Model\Plan;
use App\Model\Addon;
use App\Model\Subscription;
use App\Model\CarrierBlock;
use App\Model\Coupon;
use Illuminate\Http\Request;
use App\Model\SystemGlobalSetting;

/**
 * Class PlanController
 *
 * @package App\Http\Controllers
 */
class PlanController extends Controller
{

	/**
	 *
	 */
	const TYPE = [
        1 => 'Voice', 
		2 => 'Data',
		3 => 'Wearable',
		4 => 'Membership',
		5 => 'Digits',
		6 => 'Cloud',
		7 => 'IoT',
    ];

	/**
	 *
	 */
	const AREACODE = [
        0 => 'Don’t show option',
        1 => 'Show option for area code but NOT required',
        2 => 'Show option for area code AND required',
    ];

	/**
	 *
	 */
	const REGULATORY_FEE_TYPE = [
        1 => 'Fixed dollar amount',
        2 => 'Percentage of plan cost',
    ];

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
    {
        $type = self::TYPE;
        $areaCode = self::AREACODE;
        $regulatoryFeeType = self::REGULATORY_FEE_TYPE;
        $coupons = Coupon::all()->where('company_id', auth()->user()->company_id)->pluck('name', 'id')->toArray();
        $coupons = $coupons + [null => 'Select a coupon'];
     	return view('Plan.all-plans', compact('type', 'areaCode', 'regulatoryFeeType', 'coupons'));
    }

	/**
	 * @return mixed
	 */
	public function getAllPlans()
    {
    	$plan = Plan::whereCompanyId(auth()->user()->company_id)->with('carrier','planDataSocBotCode', 'planCustomType', 'planToAddon', 'planBlock')->get();

    	return DataTables::of($plan)
            ->addColumn('id', function($plan) {
                return $plan->id;
            })
            ->addColumn('carrier', function($plan) {
                return $plan->carrier['name'];
            })
            ->addColumn('name', function($plan) {
                return $plan->name;
            })
            ->addColumn('type', function($plan) {
                return self::TYPE[$plan->type];
            })
            ->addColumn('recurring-price', function($plan) {
                return '$ '.number_format($plan->amount_recurring, 2);
            })
            ->addColumn('activation-fee', function($plan) {
                return '$ '.number_format($plan->amount_onetime, 2);
            })
			->addColumn('live', function($plan) {
                if($plan->show=="1"){
                    return 'YES';
                }
                return 'NO';
            })
            ->addColumn('sku', function($plan) {
                return $plan->sku;
            })
            ->addColumn('modify', function($plan) {
                return '<div class="actionbtn">
                            <div class="dropdown"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#updateshipping"> Edit </a> </div>
                            <div class="dropdown"> <a class="btn delete-btn" data-id ='.$plan->id.' > Delete </a> </div>
                        </div>';
            })
            ->addColumn('all-data', function($plan) {
                return htmlspecialchars(json_encode($plan));
            })
            
            ->rawColumns(['modify'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function edit(Request $request)
    {
        $this->validateData($request);
        
        $data = $request->all();
        $data['id'] = $request->id;
        $data = $this->additionalCheckboxData($data);
        Plan::find($data['id'])->update($data);

        $this->updateAdditionalData($request, Plan::find($data['id']));

        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $SystemGlobalSetting = SystemGlobalSetting::first();
        $path = $SystemGlobalSetting->upload_path."/uploads/".Auth::user()->company_id."/plan_image/";

        $image->move($path, $new_name);

        $uploadUrl = $SystemGlobalSetting->site_url."/uploads/".Auth::user()->company_id."/plan_image/";

        $data = ['image' => $uploadUrl.'/'.$new_name];

        Plan::find($request->id)->update($data);

        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function delete(Request $request)
    {
        $data = $request->validate([
            'id'  => 'required',
        ]);
        $id = $data['id'];

        $count = Subscription::where(function ($query) use($id) {
            $query->where('plan_id',  $id)
            ->orWhere('old_plan_id', $id)
            ->orWhere('new_plan_id', $id);
        })->count();

        if($count == 0 ){
            $plan = Plan::find($data['id']);
            $plan->delete();
            return $data;
        }else{
            return ['error' => "Sorry this Plan can't be Deleted as it has already been associated with a Subscription"];
        }
    }

	/**
	 * @return mixed
	 */
	public function allCarrier()
    {
        return CarrierBlock::get();
    }

	/**
	 * @return mixed
	 */
	public function allPlanToAddon()
    {
       return Addon::whereCompanyId(auth()->user()->company_id)->get();
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function add(Request $request)
    {
        $this->validateData($request);
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;
        $data = $this->additionalCheckboxData($data);
        $plan = Plan::create($data);
        $this->addAdditionalData($request, $plan);

        return $plan;
    }

	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	public function additionalCheckboxData($data)
    {
        if(!isset($data['require_device_info'])){
            $data['require_device_info'] = 0;
        }
        if(!isset($data['taxable'])){
            $data['taxable'] = 0;
        }
        if(!isset($data['subsequent_porting'])){
            $data['subsequent_porting'] = 0;
        }
        if(!isset($data['sim_required'])){
            $data['sim_required'] = 0;
        }
        if(!isset($data['affilate_credit'])){
            $data['affilate_credit'] = 0;
        }
        if(!isset($data['imei_required'])){
            $data['imei_required'] = 0;
        }
        if(!isset($data['signup_porting'])){
            $data['signup_porting'] = 0;
        }
	    if(!isset($data['subsequent_zip'])){
		    $data['subsequent_zip'] = 0;
	    }
	    if(!isset($data['own_sim_card_option'])){
		    $data['own_sim_card_option'] = 0;
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
            'name'                  => 'required',
            'carrier_id'            => 'required',
            'amount_recurring'      => 'required',
            'amount_onetime'        => 'required',
            'show'                  => 'required',
            'area_code'             => 'required',
            'type'                  => 'required',
            'regulatory_fee_amount' => 'required',
        ]);

        return $data;
    }

	/**
	 * @param Request $request
	 * @param         $plan
	 */
	public function addAdditionalData(Request $request, $plan)
    {
        if($request->plan_data_soc_bot_code){
            $planDataSocBotCode = explode(",",$request->plan_data_soc_bot_code);
        }else{
            $planDataSocBotCode = [];
        }

        if($request->plan_to_addons){
            $planToAddon = explode(",",$request->plan_to_addons);
        }else{
            $planToAddon = [];
        }

        if($request->plan_block){
            $planBlock = explode(",",$request->plan_block);
        }else{
            $planBlock = [];
        }

        if($request->custom_plan_name){
            $planCustomType = explode(",",$request->custom_plan_name);
        }else{
            $planCustomType = [];
        }
        foreach ($planDataSocBotCode as $key => $socBotCode) {
            $plan->planDataSocBotCode()->create(['data_soc_bot_code' => $socBotCode]);
        }
        foreach ($planCustomType as $key => $customType) {
            $plan->planCustomType()->create(['name' => $customType, 'company_id' => $plan->company_id]);
        }
        $plan->planToAddon()->sync($planToAddon);
        $plan->planBlock()->sync($planBlock);
    }

	/**
	 * @param Request $request
	 * @param         $plan
	 */
	public function updateAdditionalData(Request $request, $plan)
    {
        if($request->plan_data_soc_bot_code){
            $planDataSocBotCode = explode(",",$request->plan_data_soc_bot_code);
        }else{
            $planDataSocBotCode = [];
        }

        if($request->plan_to_addons){
            $planToAddon = explode(",",$request->plan_to_addons);
        }else{
            $planToAddon = [];
        }

        if($request->plan_block){
            $planBlock = explode(",",$request->plan_block);
        }else{
            $planBlock = [];
        }

        if($request->custom_plan_name){
            $planCustomType = explode(",",$request->custom_plan_name);
        }else{
            $planCustomType = [];
        }
        $plan->planDataSocBotCode()->delete();
        foreach ($planDataSocBotCode as $key => $socBotCode) {
            $plan->planDataSocBotCode()->create(['data_soc_bot_code' => $socBotCode]);
        }
        $plan->planCustomType()->delete();
        foreach ($planCustomType as $key => $customType) {
            $plan->planCustomType()->create(['name' => $customType, 'company_id' => $plan->company_id]);
        }
        $plan->planToAddon()->sync($planToAddon);
        $plan->planBlock()->sync($planBlock);
    }
}