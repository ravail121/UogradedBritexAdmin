<?php

namespace App\Http\Controllers\ActionQueue;

use Validator;
use DataTables;
use App\Model\Ban;
use Carbon\Carbon;
use App\Model\BanGroup;
use App\Model\Subscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\SubcriptionStatusChanged;
use App\Events\SubscriptionRequestedZipRemoved;

/**
 * Class ActivationController
 *
 * @package App\Http\Controllers\ActionQueue
 */
class ActivationController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getActivationData(Request $request)
    {
        $date = $request->date;
        
        if($date == 0){
            $data = Subscription
                    ::with('customer', 'order', 'port', 'plans.carrier', 'ban','banGroup', 'subscriptionAddonNotRemoved')
                    //->where('sim_card_num', '!=', 0)
                    ->whereStatus('for-activation')
                    ->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })
                    ->whereHas('plans', function ($query) {
                        $query->where('type', '<>', '6' );
                    })->get();

        }else{
            $data = Subscription
                    ::with('customer', 'order', 'plans.carrier', 'port' , 'ban', 'banGroup', 'subscriptionAddonNotRemoved')
                    ->where([['status', '=', 'for-activation'],['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                    //->where('sim_card_num', '!=', 0)
                    ->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })
                    ->whereHas('plans', function ($query) {
                        $query->where('type', '<>', '6' );
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
            ->addColumn('porting-no', function(Subscription $detail) {
	            if($detail->requested_zip){
		            return $detail->requested_zip;
	            } elseif($detail->requested_area_code){
                    return $detail->requested_area_code;      
                }else{
                    if($detail->port){
                        return $detail->port->number_to_port;
                    }
                    return 'NA';
                }
            })
            ->addColumn('device_imei', function(Subscription $detail) {
                if($detail->device_imei){
                    return $detail->device_imei;  
                }
            })
            ->addColumn('sim-num', function(Subscription $detail) {
                if($detail->sim_card_num){
                    return $detail->sim_card_num;  
                }
            })
            ->addColumn('tracking-no', function(Subscription $detail) {
                return $detail->tracking_num_formatted;
            })
            ->addColumn('plan-type', function(Subscription $detail) {
                return '<div class="plan-type">
                            '.self::PLAN_TYPE[$detail->plans->type].': '.$detail->plans->name.'
                        </div>';
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
                return '<div class="actions actionbtn"><div class="dropdown active-action-btn">
                        <a class="btn billind-cycles markbtn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-date = '.$detail->customer["billing_end"].'> Actions </a>
				        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item activation-btn" href="#activateline" data-toggle="modal" data-target="#activateline"> Activate </a>'.($detail->requested_zip ? '<a class="dropdown-item remove-requested-zip-button" href="#removeRequestedZip" data-toggle="modal" data-target="#removeRequestedZip" data-subscription-id="'. $detail->id . '"> Remove Requested ZIP </a>' : '') . ($detail->status !== 'closed' ?
		                '<a class="dropdown-item active-dropdown-option" href="javascript:void(0);">Close</a>
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
				        <a class="btn markbtn confirmaction confirm-active-btn smbtn130 action-confirm-close-btn"> Confirm </a>' : '') .
                       '</div></div>';
            })
            ->addColumn('all-data', function(Subscription $data) {
                return htmlspecialchars(json_encode($data));
            })
	        ->addColumn('id', function(Subscription $detail) {
		        return $detail->id;
	        })
            ->rawColumns(['first', 'name', 'action', 'plan-type', 'add-ons', 'image'])
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
	public function setActive(Request $request)
    {
        $data = $request->except(['id', 'carrier_id']);
        $id = $request->input('id');
		$carrier_id = $request->get('carrier_id');
		if($carrier_id != 13){
			$data['phone_number']= preg_replace('/[^\dxX]/', '', $data['phone_number']);

			$validation = Validator::make($data, [
				'phone_number'  => [
					'required',
					Rule::unique('subscription')->ignore($id)->where(function ($query) {
						return $query->where([
							['status', '!=', 'closed']
						]);
					})
				]
			]);

			if ($validation->fails()) {
				return $validation->getmessagebag()->all();
			}
		}

        $data['status'] = 'active';
        $data['activation_date'] = Carbon::today()->toDateString();
        $subscription = Subscription::find($id);
        $subscription->update($data);
        event(new SubcriptionStatusChanged($subscription->id));
        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function getBanGroup(Request $request)
    {
        $data = $request->validate([
            'id'  => 'required',
        ]);

        $banGroup = BanGroup::whereBanId($data['id'])->get()->toArray();
        $allBanGroup = array_column($banGroup, 'number', 'id');
        return $allBanGroup;
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getCloudActivationData(Request $request)
    {
        $date = $request->date;
        
        if($date == 0){
            $data = Subscription
                    ::with('customer', 'order', 'port', 'plans.carrier', 'ban','banGroup','subscriptionAddonNotRemoved')
                    //->where('sim_card_num', '!=', 0)
                    ->whereStatus('for-activation')
                    ->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })
                    ->whereHas('plans', function ($query) {
                        $query->where('type', '=', '6' );
                    })->get();
        }else{
            $data = Subscription
                    ::with('customer', 'order', 'port', 'plans.carrier', 'ban','banGroup','subscriptionAddonNotRemoved')
                    //->where('sim_card_num', '!=', 0)
                    ->where([['status', '=', 'for-activation'],['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                    ->whereHas('customer', function ($query) {
                        $query->where('company_id', '=', auth()->user()->company_id );
                    })
                    ->whereHas('plans', function ($query) {
                        $query->where('type', '=', '6' );
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
            ->addColumn('porting-no', function(Subscription $detail) {
                if($detail->requested_area_code){
                    return $detail->requested_area_code;      
                }else{
                    return $detail->port->number_to_port;
                }
            })
            ->addColumn('sim-num', function(Subscription $detail) {
                if($detail->sim_card_num){
                    return $detail->sim_card_num;  
                }
            })
            ->addColumn('tracking-no', function(Subscription $detail) {
                return $detail->tracking_num_formatted;
            })
            ->addColumn('plan-type', function(Subscription $detail) {
                return '<div class="plan-type">
                            '.self::PLAN_TYPE[$detail->plans->type].': '.$detail->plans->name.'
                        </div>';
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
                            <div class="dropdown"> <a class="btn markbtn activation-btn" href="#activateline" data-toggle="modal" data-target="#activateline"> Activate </a>
                            </div>
                        </div>';
            })
            ->addColumn('all-data', function(Subscription $data) {
                return htmlspecialchars(json_encode($data));

            })
            ->rawColumns(['first', 'name', 'action', 'plan-type', 'add-ons', 'image'])
            ->make(true);
    }


	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function validatePhoneNumber(Request $request)
    {
	    $data = $request->except(['id']);
	    $id = $request->input('id');
	    $data['phone_number']= preg_replace('/[^\dxX]/', '', $data['phone_number']);

	    $validation = Validator::make($data, [
		    'phone_number'  => [
			    'required',
			    Rule::unique('subscription')->ignore($id)->where(function ($query) {
				    return $query->where([
					    ['status', '!=', 'closed']
				    ]);
			    })
		    ]
	    ]);
	    return $validation->passes() ? 'true' : 'false';
    }


	/**
	 * @param Request $request
	 *
	 * @return array|\Illuminate\Http\JsonResponse
	 */
	public function setBulkActive(Request $request)
	{
		try {
			$validation = Validator::make($request->all(), [
				'bulk_csv'  => 'required|file'
			]);
			if ($validation->fails()) {
				return $validation->getmessagebag()->all();
			}
			$csvPath = $request->file('bulk_csv')->getRealPath();
			$csvData = array_map('str_getcsv', file($csvPath));
			if(count($csvData) > 1) {
				/**
				 * @internal https://bit.ly/3sZRYfy
				 */
				array_walk($csvData , function(&$x) use ($csvData) {
					$x = array_combine($csvData[0], $x);
				});
				array_shift($csvData);
				$messages       = [];
				$activationsRows = [];
				$errorCount = 0;
				$activationData = [
					'status'          => 'active',
					'activation_date' => Carbon::today()->toDateString()
				];
				foreach ( $csvData as $value ) {
					$subscription = Subscription::where( 'sim_card_num', $value['sim_number'])
					                            ->whereStatus( 'for-activation' )
					                            ->whereHas( 'customer', function ( $query ) {
						                            $query->where( 'company_id', '=', auth()->user()->company_id );
					                            } )
					                            ->whereHas( 'plans', function ( $query ) {
						                            $query->where( 'type', '<>', '6' );
					                            } )->first();
					if ( ! $subscription ) {
						$errorCount++;
						$messages[] = 'Subscription not found for sim number ' . $value['sim_number'];
						continue;
					}
					$ban = Ban::where( [['number', $value['ban_number']] , ['company_id', auth()->user()->company_id]] )->first();
					if ( ! $ban ) {
						$errorCount++;
						$messages[] = 'Ban not found for ban number ' . $value['ban_number'];
						continue;
					}
					$activationData[ 'phone_number' ] = preg_replace( '/[^\dxX]/', '', $value['phone_number'] );
					if(strlen((string) $activationData[ 'phone_number' ]) !== 10) {
						$errorCount++;
						$messages[] = "Phone number ". $activationData[ 'phone_number' ] . " is not valid";
						continue;
					}
					$activationData[ 'ban_id' ] = $ban->id;
					$phoneNumberExists                = Subscription::where( [
						[ 'phone_number', $activationData[ 'phone_number' ] ],
						[ 'status', '!=', 'closed' ]
					] )->whereHas( 'customer', function ( $query ) {
						$query->where( 'company_id', '=', auth()->user()->company_id );
					} )->whereHas( 'plans', function ( $query ) {
						$query->where( 'type', '<>', '6' );
					} )->exists();
					if ( $phoneNumberExists ) {
						$errorCount++;
						$messages[] = 'Subscription already exists for phone number ' . $activationData[ 'phone_number' ];
						continue;
					}
					$messages[] = 'Subscription activated for sim number ' . $value['sim_number'];
					$activationsRows[$subscription->id] = $activationData;
				}

				if(!$errorCount && count($activationsRows)) {
					DB::transaction(function() use ($activationsRows)
					{
						foreach($activationsRows as $subscriptionId => $activationData) {
							$updateSubscription = Subscription::where('id', $subscriptionId)->update($activationData);
							if( !$updateSubscription )
							{
								throw new \Exception('Failed to activate subscription');
							}
						}
					});
				}

				return response()->json( [
					'status'   => $errorCount > 0 ? 'error' : 'success',
					'messages' => $messages
				] );
			} else {
				return response()->json( [
					'status'   => 'error',
					'message' => 'No data found in csv file'
				] );
			}
		} catch (\Exception $e) {
			Log::info($e->getMessage() . ' on line number: '.$e->getLine() . ' Set Bulk Active');
			return [
				'status'  => 'error',
				'message' => $e->getMessage()
			];
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function removeRequestedZip(Request $request)
	{
		try {
			$subscription = Subscription::where('id', $request->subscription_id)->first();
			$subscription->update(['requested_zip' => null]);
			if($request->send_email){
				event(new SubscriptionRequestedZipRemoved($subscription->id));
			}
			return response()->json([
				'status'  => 'success',
				'data'    => $subscription
			]);
		} catch (\Exception $e) {
			Log::info($e->getMessage() . ' on line number: '.$e->getLine() . ' Remove Requested Zip');
			return response()->json([
				'status'  => 'error',
				'message' => $e->getMessage()
			], 400);
		}
	}
}

