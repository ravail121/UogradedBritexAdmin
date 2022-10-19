<?php

namespace App\Http\Controllers\ActionQueue;

use DataTables;
use Carbon\Carbon;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PastDueController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
    public function getPastDue(Request $request)
    {
        $date = $request->date;
        
        if($date == 0){
        	$data = Subscription
                        ::with('customer', 'order', 'plans','subscriptionAddon.addons')
                        ->where([['status', '=', 'active'],
    						    ['sub_status', '=', 'account-past-due'],])
                        ->whereHas('customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }else{
            $data = Subscription
                        ::with('customer', 'order', 'plans','subscriptionAddon.addons')
                        ->where([['status', '=', 'active'],
                                ['sub_status', '=', 'account-past-due'],['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                        ->whereHas('customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }

        return DataTables::of($data)
            ->addColumn('first', function(Subscription $detail) {
                return $this->dateHtml($this->date($detail->created_at));
            })
            ->addColumn('name', function(Subscription $detail) {
                return $this->nameHtml($detail);
            })
            ->addColumn('order-number', function(Subscription $detail) {
                return $detail->order['order_num'];
            })
            ->addColumn('phone-no', function(Subscription $detail) {
                return $detail->phone_number_formatted;
            })
            ->addColumn('sim-num', function(Subscription $detail) {
                return $detail->sim_card_num;
            })
            ->addColumn('plan', function(Subscription $detail) {
                return $detail->plans['name'];
            })
            ->addColumn('add-ons', function(Subscription $detail) {
            	if(isset($detail->subscriptionAddon['0'])){
                    return '<div class="add-ons">
                                '.$this->getAddonsDetails($detail->subscriptionAddon).'
                            </div>';    
                }else{
                    return '<div class="add-ons">
                                NA
                            </div>';
                }
            })
            ->addColumn('suspension-date', function(Subscription $detail) {
                return $detail->getPastDueDateFormattedAttribute();
            })
            ->addColumn('status', function(Subscription $detail) {
                return '<span class="activest">Active</span>';
            })
            ->addColumn('action', function(Subscription $detail) {
                return '<div class="actionbtn">
						    <div class="dropdown active-action-btn"> <a class="btn billind-cycles markbtn dropdown-toggle" data-date = '.$detail->customer["billing_end"].' href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions</a>
						        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> <a class="dropdown-item active-dropdown-option" href="#">Suspend</a><a class="dropdown-item active-dropdown-option" href="#">Close</a>
						        </div>
						    </div>
						    <div class="action-confirm-btn display-none">
						        <div id="portbxactions" class="active">
						            <div class="portcheckbox active-datepicker">
						                <div id="past-due-'.$detail->id.'" class="input-group date" data-date-format="dd-mm-yyyy">
											    <input class="active-date form-control" type="text" readonly />
											    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											</div>
						            </div>
						            <div class="portclosebtn action-confirm-close-btn confirm-btn-css"> <span class="fas fa-times"></span> </div>
						        </div>
                                <br><br>
						        <a class="btn markbtn confirmaction smbtn130 confirm-active-btn action-confirm-close-btn final-past-due-btn"> Confirm </a>
						    </div>
						</div>';
            })
            ->addColumn('id', function(Subscription $detail) {
                return $detail->id;
            })
            ->rawColumns(['first', 'image', 'name', 'action', 'status', 'add-ons'])
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
}
