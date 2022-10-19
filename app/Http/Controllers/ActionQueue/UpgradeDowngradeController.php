<?php

namespace App\Http\Controllers\ActionQueue;

use DataTables;
use Carbon\Carbon;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Model\SubscriptionAddon;
use App\Http\Controllers\Controller;

class UpgradeDowngradeController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
    public function getUpgradeDowngradeData(Request $request)
    {
        $date = $request->date;
        if($date == 0){
            $data = Subscription
                        ::with('customer', 'order', 'plans.carrier','oldPlan','ban', 'banGroup')
                        ->whereIn('upgrade_downgrade_status', ['for-upgrade', 'for-downgrade'])
                        ->whereHas('customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }else{
            $data = Subscription
                    ::with('customer', 'order', 'plans.carrier', 'oldPlan', 'ban', 'banGroup')
                    ->whereIn('upgrade_downgrade_status', ['for-upgrade', 'for-downgrade'])->where([['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                    ->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })->get();
        }

        return DataTables::of($data)
            ->addColumn('first', function(Subscription $detail) {
                return $this->dateHtml($this->date($detail->created_at));
            })
            ->addColumn('all-data', function(Subscription $data) {
                return htmlspecialchars(json_encode($data));
            })
            ->addColumn('name', function(Subscription $detail) {
                return $this->nameHtml($detail);
            })
            ->addColumn('phone-no', function(Subscription $detail) {
                return $detail->phone_number_formatted;
            })
            ->addColumn('upgrade-downgrade', function(Subscription $detail) {
                    if($detail->upgrade_downgrade_status == 'for-upgrade'){
                        return 'Upgrade <span class="mr-1"><img src="theme/img/upgrade.png" alt="" width="8" height="10"></span>';
                    }else{
                        return 'Downgrade <span class="mr-1"><img src="theme/img/downgrade.png" alt="" width="8" height="10"></span>';
                    }
                })
            ->addColumn('due-date', function(Subscription $detail) {
                if($detail->status == 'for-upgrade'){
                        return $detail->getDowngradeDateFormattedAttribute();
                    }else{
                        return $detail->getUpgradeDateFormattedAttribute();
                    }
            })
            ->addColumn('old-plan', function(Subscription $detail) {
                return $detail->oldPlan['name'];
            })
            ->addColumn('new-order', function(Subscription $detail) {
                 return $detail->order['order_num'];
            })
            ->addColumn('new-plan', function(Subscription $detail) {
                 return $detail->plans['name'];
            })
            ->addColumn('action', function(Subscription $detail) {
                return '<div class="actionbtn"> <a class="btn completedbtn smbtn130" href="#updatecomplete" data-toggle="modal" data-target="#updatecomplete"> Complete</a> </div>';
            })
            ->rawColumns(['first', 'name', 'action', 'upgrade-downgrade', 'all-data'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
    public function updateComplete(Request $request)
    {
    	$data = $request->validate([
            'id'  => 'required',
        ]);
        
        Subscription::find($data['id'])->update([
            'upgrade_downgrade_status' => null,
        	'old_plan_id' => null,
        	'downgrade_date' => null,
            'ban_id' => $request->ban_id,
            'ban_group_id' => $request->ban_group_id,
        ]);
        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
    public function getAddonData(Request $request)
    {
        $date = $request->date;
        if($date == 0){
            $data = SubscriptionAddon
                    ::with('subscription.customer','subscription.order', 'subscription.plans','subscription.ban','addons')
                    ->whereIn('status', ['for-adding', 'for-removal'])
                    ->whereHas('subscription.order', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })->get();
        }else{
            $data = SubscriptionAddon
                ::with('subscription.customer','subscription.order', 'subscription.plans','subscription.ban','addons')
                ->where([['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                ->whereIn('status', ['for-adding', 'for-removal'])
                ->whereHas('subscription.order', function ($query) {
                    $query->where('company_id', '=', auth()->user()->company_id );
                })->get();
        }

        return DataTables::of($data)
            ->addColumn('first', function(SubscriptionAddon $detail) {
                return $this->dateHtml($this->date($detail->created_at));
            })
            ->addColumn('all-data', function(SubscriptionAddon $data) {
                return $data;
            })
            ->addColumn('name', function(SubscriptionAddon $detail) {
                return  '<div class="tableuserbx">
                            <div class="usrimg data-table-image">
                                <img src='.asset($this->carrierImage($detail->subscription->plans["carrier_id"])).' alt="" width="25" height="25">
                            </div>
                            <div class="usrname data-table-name">
                                <a href = '.route("customers.detail", $detail->subscription->customer["id"]).'>
                                <strong>'.$detail->subscription->customer['full_name'].'</strong>
                                </a>
                            </div>
                        </div>';
            })
            ->addColumn('phone-no', function(SubscriptionAddon $detail) {
                return $detail->subscription->phone_number_formatted;
            })
            ->addColumn('add-remove', function(SubscriptionAddon $detail) {
                if($detail->status == 'for-adding'){
                    return 'Add <span class="mr-1"><img src="theme/img/upgrade.png" alt="" width="8" height="10"></span>';
                }else{
                    return 'Remove <span class="mr-1"><img src="theme/img/downgrade.png" alt="" width="8" height="10"></span>';
                }
            })
            ->addColumn('due-date', function(SubscriptionAddon $detail) {
                if($detail->status == 'for-adding'){
                        return $detail->getDateSuspendedFormattedAttribute();
                    }else{
                        return $detail->getRemovalDateFormattedAttribute();
                    }
            })
            ->addColumn('order-num', function(SubscriptionAddon $detail) {
                 return $detail->subscription->order['order_num'];
            })
            ->addColumn('add-ons', function(SubscriptionAddon $detail) {
                return $detail->addons['name'];
            })
            ->addColumn('action', function(SubscriptionAddon $detail) {
                return '<div class="actionbtn"> <a class="btn completed-addon-btn smbtn130" href="#updatecompleteaddon" data-toggle="modal" data-target="#updatecompleteaddon"> Complete</a> </div>';
            })
            ->rawColumns(['first', 'name', 'action', 'add-remove', 'all-data', 'add-ons'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
    public function updateAddonComplete(Request $request)
    {
        $data = $request->validate([
            'id'              => 'required',
            'status'          => 'required',
            'subscription_id' => 'required'
        ]);

        if($data['status'] == 'for-adding'){
            SubscriptionAddon::find($data['id'])->update(['status' => 'active']);
        }else{
            SubscriptionAddon::find($data['id'])->update(['status' => 'removed']);
        }
        
        Subscription::find($data['subscription_id'])->update([
            'ban_id' => $request->ban_id,
        ]);

        return $data;
    }
}
