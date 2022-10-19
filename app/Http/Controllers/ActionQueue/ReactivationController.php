<?php

namespace App\Http\Controllers\ActionQueue;

use DataTables;
use Carbon\Carbon;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 *
 */
class ReactivationController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getReactivationData(Request $request)
    {
        $date = $request->date;

        if($date == 0){
            $data = Subscription
                    ::with('customer', 'plans')
                    ->whereSubStatus('for-restoration')
                    ->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })->get();
        }else{
            $data = Subscription
                    ::with('customer', 'plans')
                    ->where([['sub_status', '=', 'for-restoration'],['restoration_date', '>', Carbon::now()->subDays($date)->endOfDay()]])
                    ->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })->get();
        }

        return DataTables::of($data)
            ->addColumn('first', function(Subscription $detail) {
                return $this->dateHtml($this->date($detail->restoration_date));
            })
            ->addColumn('name', function(Subscription $detail) {
                return $this->nameHtml($detail);
            })
            ->addColumn('phone-no', function(Subscription $detail) {
                return $detail->getPhoneNumberFormattedAttribute();
            })
            ->addColumn('sim-num', function(Subscription $detail) {
                return $detail->sim_card_num;
            })
            ->addColumn('plan', function(Subscription $detail) {
                return $detail->plans['name'];
            })
            ->addColumn('add-ons', function(Subscription $detail) {
            	if(isset($detail->subscriptionAddonNotRemoved['0'])){
                    return '<div class="add-ons">
                                '.$this->getAddonsDetails($detail->subscriptionAddonNotRemoved).'
                            </div>';    
                }else{
                    return '<div class="add-ons">
                                NA
                            </div>';
                }
            })
            ->addColumn('action', function(Subscription $detail) {
                return '<div class="actionbtn">
                         	<div class="dropdown">
                         	<a class="btn markbtn activest smgreen reactivation-completebtn" href="#markcomplete" data-toggle="modal" data-target="#markcomplete">
	                         	Complete 
	                        </a> </div>
                        </div>';
						
            })
            ->addColumn('all-data', function(Subscription $data) {
                return htmlspecialchars(json_encode($data));

            })
            ->rawColumns(['first', 'name', 'action', 'add-ons'])
            ->make(true);
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
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updateReactivation(Request $request)
    {
        $data = $request->validate([
            'id'  => 'required',
        ]);
        
        Subscription::find($data['id'])->update(['sub_status' => '',
            'restoration_date' => null,
        ]);
        return $data;
    }
}
