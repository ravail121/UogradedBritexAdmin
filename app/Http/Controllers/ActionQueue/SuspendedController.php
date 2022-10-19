<?php

namespace App\Http\Controllers\ActionQueue;

use DataTables;
use Carbon\Carbon;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\SubcriptionStatusChanged;
use App\Events\SubscriptionForReactivation;

/**
 * Class SuspendedController
 *
 * @package App\Http\Controllers\ActionQueue
 */
class SuspendedController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getSuspendedAData(Request $request)
    {
        $date = $request->date;
        if($date == 0){
            $data = Subscription
                    ::with('customer', 'order', 'plans','subscriptionAddon.addons')
                    ->where([
                            ['status', '=', 'suspended']
                        ])->where(function ($query) {
                        $query->whereNull('sub_status')
                              ->orWhere('sub_status', '');
                    })->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })->get();
        }else{
            $data = Subscription
                    ::with('customer', 'order', 'plans','subscriptionAddon.addons')
                    ->where([
                            ['status', '=', 'suspended'],
                            ['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]
                        ])->where(function ($query) {
                        $query->whereNull('sub_status')
                              ->orWhere('sub_status', '');
                    })
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
            ->addColumn('suspended-date', function(Subscription $detail) {
                return $detail->getSuspendedDateFormattedAttribute();
            })
            ->addColumn('status', function(Subscription $detail) {
                return '<span class="activest">Suspended</span>';
            })
            ->addColumn('action', function(Subscription $detail) {
                return '<div class="actionbtn">
							<div class="dropdown suspended-action-btn">
								<a class="btn markbtn billind-cycles dropdown-toggle suspended-mark-btn" href="#" data-date = '.$detail->customer["billing_end"].' role="button" id="dropdownMenuLink128" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions </a>
								<div class="dropdown-menu suspended-dropdown" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item suspended-unsuspend-btn" href="#" data-row="'.$detail->customer['account_suspended'].'">Unsuspend</a> 
									<a class="dropdown-item suspended-close-btn" href="#">Close</a>
								</div>
							</div>
							<div class="suspended-confirm-btn  display-none">
							    <div id="portbxactions" class="active">
							        <div class="portcheckbox active-datepicker">
							            <div id="datepicker'.$detail->id.'" class="input-group date" data-date-format="dd-mm-yyyy">
											    <input class="suspended-date form-control" type="text" readonly />
											    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											</div>
							        </div>
							        <div class="portclosebtn suspended-confirm-close-btn confirm-btn-css"> <span class="fas fa-times"></span> </div>
							    </div><br><br>
							    <a class="btn markbtn confirmaction smbtn130 confirm-suspended-btn"> Confirm </a>
							</div>
						</div>';
            })
            ->addColumn('id', function(Subscription $detail) {
                return $detail->id;
            })
            ->rawColumns(['first', 'image', 'name', 'action', 'add-ons', 'status'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function updateAccountSuspended(Request $request)
    {
        $data = $request->all();

        Subscription::find($data['id'])->update([
        	'status'        => 'active',
	        'sub_status'    => 'account-past-due',
	        'suspended_date' => null
        ]);
        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function updateUnsuspend(Request $request)
    {
        $data = $request->all();

        Subscription::find($data['id'])->update([
        	'status'            => 'active',
	        'sub_status'        => 'for-restoration',
	        'suspended_date'    => null
        ]);

	    event( new SubscriptionForReactivation($data['id']) );
        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function updateSuspendedClose(Request $request)
    {
        $data = $request->all();

        $formatedDate = Carbon::createFromFormat('m/d/Y', $data['date']);

        if($formatedDate->gte(Carbon::now())){
            Subscription::find($data['id'])->update([
            	'sub_status'            => 'close-scheduled',
	            'scheduled_close_date'  => $formatedDate
            ]);
            event(new SubcriptionStatusChanged($data['id'], true));
        }else{
            Subscription::find($data['id'])->update([
            	'status'                => 'closed',
	            'sub_status'            => 'confirm-closing',
	            'closed_date'           => $formatedDate
            ]);
            event(new SubcriptionStatusChanged($data['id']));
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
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getSuspendedBData(Request $request)
    {
        $date = $request->date;
        if($date == 0){
        	$data = Subscription
                        ::with('customer', 'order', 'plans','subscriptionAddon.addons')
                        ->where([
    						    ['status', '=', 'suspended'],
    						    ['sub_status', '=', 'confirm-suspend'],
    						])
                        ->whereHas('customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }
        else{
            $data = Subscription
                        ::with('customer', 'order', 'plans','subscriptionAddon.addons')
                        ->where([
                                ['status', '=', 'suspended'],
                                ['sub_status', '=', 'confirm-suspend'],
                                ['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]
                            ])
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
            	if($detail->subscriptionAddon){
                	return '<div class="add-ons">
                                '.$this->getAddonsDetails($detail->subscriptionAddon).'
                            </div>';	
            	}
            })
            ->addColumn('suspended-date', function(Subscription $detail) {
                return $detail->getSuspendedDateFormattedAttribute();
            })
            ->addColumn('status', function(Subscription $detail) {
                return '<span class="activest">Suspended</span>';
            })
            ->addColumn('action', function(Subscription $detail) {
                return '<div class="actionbtn">
                        	<div class="dropdown"> <a class="btn markbtn suspendedB-confirm-btn"> Confirm </a> </div>
                        </div>';
            })
            ->addColumn('id', function(Subscription $detail) {
                return $detail->id;
            })
            ->rawColumns(['first', 'image', 'name', 'add-ons', 'status', 'action'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function updateSuspendedB(Request $request)
    {
        $data = $request->all();
        Subscription::find($data['id'])->update(['sub_status' => null]);
        return $data;
    }
}
