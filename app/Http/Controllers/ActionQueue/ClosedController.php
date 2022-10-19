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
class ClosedController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getCloseAData(Request $request)
    {
        $date = $request->date;
        if($date == 0){
        	$data = Subscription
                        ::with('customer', 'order', 'plans')
                        ->where([
    						    ['status', '=', 'closed'],
    						    ['sub_status', '=', 'confirm-closing'],
    						])
                        ->whereHas('customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }else{
            $data = Subscription
                        ::with('customer', 'order', 'plans')
                        ->where([
                                ['status', '=', 'closed'],
                                ['sub_status', '=', 'confirm-closing'],['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]
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
            ->addColumn('close-date', function(Subscription $detail) {
                return $detail->getClosedDateFormattedAttribute();
            })
            ->addColumn('action', function(Subscription $detail) {
                return '<div class="actions actionbtn">
					<div class="dropdown active-action-btn">
	                    <a class="btn markbtn dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<a class="dropdown-item btn close-confirm-btn"> Confirm </a>
							<a class="dropdown-item btn active-dropdown-option first-reopen-btn" data-toggle="modal" data-target="#unsuspendConfirmation"> Reopen </a>
						</div>
					</div>
				</div>';
            })
            ->addColumn('id', function(Subscription $detail) {
                return $detail->id;
            })
            ->rawColumns(['first', 'image', 'name', 'action', 'add-ons'])
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
	 * @return array
	 */
	public function updateClosed(Request $request)
    {
        $data = $request->all();

        Subscription::find($data['id'])->update([
			'sub_status'    => null
        ]);
        return $data;
    }


	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getCloseBData(Request $request)
    {
        $date = $request->date;
        if($date == 0){
        	$data = Subscription
                        ::with('customer', 'order', 'plans')
                        ->where('status', 'closed')
                        ->where(function($q) {
                              $q->where('sub_status', '')
                                ->orWhere('sub_status', null);
                          })
                        ->whereHas('customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }else{

            $data = Subscription
                        ::with('customer', 'order', 'plans')
                        ->where([
                                ['status', '=', 'closed'],
                                ['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]
                            ])
                        ->where(function($q) {
                              $q->where('sub_status', '')
                                ->orWhere('sub_status', null);
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
            ->addColumn('close-date', function(Subscription $detail) {
                return $detail->getClosedDateFormattedAttribute();
            })
            ->addColumn('action', function(Subscription $detail) {
                return '<div class="actionbtn">
                         	<div class="dropdown">
                         	<a class="btn markbtn first-reopen-btn" href="javascript:void(0);" data-toggle="modal" data-target="#unsuspendConfirmation">
	                         	Reopen 
	                        </a> </div>
                        </div>';
            })
	        ->addColumn('id', function(Subscription $detail) {
		        return $detail->id;
	        })
            ->rawColumns(['first', 'image', 'name', 'add-ons', 'action'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function reopenClosedSubscription(Request $request)
	{
		try {
			$subscription = Subscription::find($request->id);

			$phoneNumberExists                = Subscription::where( [
				[ 'phone_number', $subscription->phone_number],
				[ 'status', '!=', 'closed' ]
			] )->whereHas( 'customer', function ( $query ) {
				$query->where( 'company_id', '=', auth()->user()->company_id );
			} )->whereHas( 'plans', function ( $query ) {
				$query->where( 'type', '<>', '6' );
			} )->exists();

			if($phoneNumberExists){
				return response()->json(['status' => 'error', 'message' => 'Phone number already exists']);
			}

			Subscription::find($request->get('id'))->update([
				'sub_status'            => null,
				'status'                => 'active',
				'closed_date'           => null,
				'suspended_date'        => null
			]);

			return response()->json(['status' => 'success', 'message' => 'Subscription reopened successfully']);
		} catch(\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}
}
