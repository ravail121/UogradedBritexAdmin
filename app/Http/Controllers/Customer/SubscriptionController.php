<?php

namespace App\Http\Controllers\Customer;


use DataTables;
use App\Model\Subscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Model\SubscriptionBlock;
use App\Model\ReplacementProduct;
use App\Http\Controllers\Controller;

/**
 * Subscription Controller class
 */
class SubscriptionController extends Controller
{

	/**
	 * Color
	 */
	const COLOR = [
        'active'            => '',
        'for-activation'    => '',
        'suspended'         => 'yello',
        'closed'            => 'red',
        'shipping'          => 'blue',
    ];

	/**
	 * @param         $customer_id
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getSubscriptionData($customer_id, Request $request)
    {
        $data = Subscription
                ::with(
                    'customer','ban','banGroup','plans.sims','subscriptionAddon.addons','port','order',
                    'subscriptionCoupon.coupon', 'subscriptionBlock.carrierBlock')
                ->where([['status', $request->isClose == 'true' ? '=' : '!=', 'closed'],['customer_id', '=', $customer_id ]])
                ->whereHas('customer', function ($query) {
                    $query->where('company_id', '=', auth()->user()->company_id );
                })->orderBy('created_at', 'desc')->get();
		$replacementSim = ReplacementProduct::where([
			['company_id', auth()->user()->company_id],
			['product_type', 'sim']
		])->first();
	    $replacementDevice = ReplacementProduct::where([
		    ['company_id', auth()->user()->company_id],
		    ['product_type', 'device']
	    ])->first();
                    
        return DataTables::of($data)
            ->addColumn('phone-no', function(Subscription $detail) {
                return '<span class="timg">
                        <img src='.asset($this->carrierImage($detail->plans["carrier_id"])).' alt="" width="25" height="25"></span>'.$detail->phone_number_formatted;
            })
            ->addColumn('ban', function(Subscription $detail) {
                    return $detail->ban['number'];
            })
            ->addColumn('ban-group-number', function(Subscription $detail) {
                    return isset($detail->banGroup)?$detail->banGroup['number'] : '' ;
            })
            ->addColumn('group_number', function(Subscription $detail) {
                return isset($detail->banGroup)?$detail->banGroup['number'] : '' ;
            })
            ->addColumn('sim-num', function(Subscription $detail) {
                return $detail->sim_card_num;
            })
            ->addColumn('plans', function(Subscription $detail) {
                return $detail->plans['name'];
            })
            ->addColumn('sim', function(Subscription $detail) {
                $simSelectBox = '<select class="custom-select effect-1 subscription_sim_name" name="sim_name" disabled>
                    <option value="" selected="selected"></option>';
                    foreach ($detail->plans->sims as $key => $sim) {
                        if($detail->sim_name == $sim->name){
                            $simSelectBox .= '<option value="'.$sim->name.'" selected="selected" >'.$sim->name.'</option>';
                        }else{
                            $simSelectBox .= '<option value="'.$sim->name.'">'.$sim->name.'</option>';
                        }
                    }
                $simSelectBox .= '</select>';
                return $simSelectBox;
            })
            ->addColumn('slug', function(Subscription $detail) {
                if($detail->plans->carrier){
                    return $detail->plans->carrier->slug;
                }
                return null;
            })
            ->addColumn('add-ons', function(Subscription $detail) {
                if(isset($detail->subscriptionAddon[0])){
                    return '<div class="add-ons">
                                '.$this->getAddonsDetails($detail->subscriptionAddon).'
                            </div>';    
                }
                return 'NA';
            })
            ->addColumn('port-number', function(Subscription $detail) {
                return isset($detail->port)?$detail->port['number_to_port_formatted'] : '';
            })
            ->addColumn('activation-date', function(Subscription $detail) {
                $date = $detail->activation_date ?: '0';
                return '<span data-date ='.$date.'>'.$detail->getActivationDateFormattedAttribute().'</span>';
            })
            ->addColumn('status', function(Subscription $detail) {
                return $this->getSubscriptionStatus($detail);
            })
            ->addColumn('action', function(Subscription $detail) use ($replacementDevice, $replacementSim) {
            return '<div class="actions actionbtn">
                        <button type="button" class="btn btn-dark morebtn edit-subscription-button" id="sub-detail-button" data-subscription_id="'.$detail->id.'" data-customer_id="'.$detail->customer_id.'">More</button>
                        <a href="javascript:void(0);" class="editbtn active edit-subscription-button"><span class="fas fa-pencil-alt"></span></a>
                        ' . ($detail->status !== 'closed' ? '
                        <div class="dropdown active-action-btn">
                            <a class="btn billind-cycles markbtn dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-date='.$detail->customer["billing_end"].'> Actions </a>
					        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> 
						        <a class="dropdown-item active-dropdown-option display-none" href="javascript:void(0);">Suspend</a>
						        <a class="dropdown-item active-dropdown-option close-subscription" href="javascript:void(0);">Close</a>'. ($replacementSim ? '
						        <a class="dropdown-item active-dropdown-option subscription-replace-sim-card" href="javascript:void(0);" data-sim-id="'.$replacementSim->product_id .'" data-subscription-id="'.$detail->id.'">Replace SIM Card</a>' : '') . ($replacementDevice ? '
						        <a class="dropdown-item active-dropdown-option subscription-replace-device" href="javascript:void(0);" data-device-id="'.$replacementDevice->product_id .'" data-subscription-id="'.$detail->id.'">Replace Device</a>' : '') . ($replacementDevice && $replacementSim ? '
						        <a class="dropdown-item active-dropdown-option subscription-replace-sim-device" href="javascript:void(0);" data-sim-id="'.$replacementSim->product_id .'" data-device-id="'.$replacementDevice->product_id .'" data-subscription-id="'.$detail->id.'">Replace SIM + Device</a>' : '') . '
				            </div>
				        </div>
					    <div class="action-confirm-btn display-none">
					        <div id="portbxactions" class="active">
					            <div class="portcheckbox active-datepicker">
					                <div id="datepicker'.$detail->id.'" class="input-group date" data-date-format="dd-mm-yyyy">
									    <input class="active-date form-control" type="text" readonly />
									    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
					            </div>
					            <div class="portclosebtn action-confirm-close-btn confirm-btn-css"> <span class="fas fa-times"></span> </div>
					        </div>
					        <br><br>
					        <a class="btn markbtn confirmaction smbtn130 confirm-active-btn action-confirm-close-btn"> Confirm </a>
					    </div>' : '<div class="dropdown active-action-btn">
                            <a class="btn billind-cycles markbtn dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </a>
					        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> 
						        <a class="dropdown-item active-dropdown-option first-reopen-btn" data-toggle="modal" data-target="#unsuspendConfirmation">Reopen</a>
				            </div>
				        </div>').
	                '</div>';
            })
            ->addColumn('all-data', function(Subscription $detail) {
                return htmlspecialchars(json_encode($detail));
            })
             ->rawColumns(['phone-no', 'add-ons', 'status', 'action', 'coupons', 'activation-date', 'sim'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updateSubcription(Request $request)
    {
        $id = $request->subcription_id;
        $data = $request->validate([
            'subcription_id'    => 'required',
            'phone_number'      => [
	            Rule::unique('subscription', 'phone_number')->ignore($id)->where(function ($query) {
		            return $query->where('status', '!=', 'closed');
	            })
	        ],
        ]);
		if($request->has('label')) {
			$data[ 'label' ] = $request->label;
		}
		if($request->has('ban_id')) {
			$data[ 'ban_id' ] = $request->ban_id;
		}
        if($request->has('ban_group_id')) {
	        $data[ 'ban_group_id' ] = $request->ban_group_id;
        }

		if($request->has('device_os')) {
			$data[ 'device_os' ] = $request->device_os;
		}

		if($request->has('device_imei')) {
			$data[ 'device_imei' ] = $request->device_imei;
		}

		if($request->has('sim_card_num')){
			$data[ 'sim_card_num' ] = $request->sim_card_num;
		}

	    if($request->has('sim_name')){
		    $data[ 'sim_name' ] = $request->sim_name;
	    }

	    if($request->has('tracking_num')){
		    $data[ 'tracking_num' ] = $request->tracking_num;
	    }

		Subscription::find($data['subcription_id'])->update($data);

        $subscriptionBlock = SubscriptionBlock::whereSubscriptionId($data['subcription_id']);
        if($subscriptionBlock){
            $subscriptionBlock->update(['is_on' => '0']);
            $is_on = $request->is_on;
            if($is_on){
                $subscriptionBlock->whereIn('id', $is_on)->update(['is_on' => '1']);
            }
        }
        return $data;
    }

	/**
	 * @param $data
	 *
	 * @return string
	 */
	private function getAddonsDetails($data)
    {
        $addons = $data->pluck('addons')->pluck('name')->toArray();
        return implode(", ",$addons);
    }

	/**
	 * @param $detail
	 *
	 * @return string
	 */
	private function getSubscriptionStatus($detail)
    {
        $addP = $detail->sub_status == "" && $detail->upgrade_downgrade_status == "" ? '' : '</span> <span class="activest2">P</span>';
        $class = isset(self::COLOR[$detail->status]) ? self::COLOR[$detail->status]:'';
		if($detail->status === 'suspended' ){
			$date = '<br>'. $detail->getSuspendedDateFormattedAttribute();
		} elseif($detail->status === 'closed'){
			$date = '<br>'. $detail->getClosedDateFormattedAttribute();
		} else {
			$date = '';
		}
        return '<span class="activest '.$class.'">'.$detail->status.'</span>'. $addP. $date;
    }

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function checkNumber(Request $request)
    {
        if($request->id){
            $count = Subscription::where([
                ['phone_number', $request->phone_number],
                ['status', '!=', 'closed'],
                ['id', '!=', $request->id]
            ])->count();
        }else{
            $count = Subscription::where([
                ['phone_number', $request->number_to_port],
                ['status', '!=', 'closed'],
            ])->count();
        }

        return ($count > 0 ) ? 'false' : 'true';
    }
}
