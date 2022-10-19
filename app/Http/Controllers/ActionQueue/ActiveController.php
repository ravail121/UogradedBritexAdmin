<?php

namespace App\Http\Controllers\ActionQueue;


use Validator;
use DataTables;
use Carbon\Carbon;
use App\Model\Invoice;
use App\Model\InvoiceItem;
use App\Model\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\SubcriptionStatusChanged;

/**
 * Active Controller
 */
class ActiveController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
    public function getActiveData(Request $request)
    {
	    /**
	     * @see https://bit.ly/3Hr6d2o
	     */
		try {
			$subStatus = $request->get( 'sub_status' );
			$columns   = [
				0  => 'first',
				1  => 'name',
				2  => 'phone_number',
				3  => 'ban',
				4  => 'plans',
				5  => 'add-ons',
				6  => 'sim_card_num',
				7  => 'activation_date',
				8  => 'date',
				9  => 'action',
				10 => 'id'
			];
			$mainQuery = $subStatus ? Subscription
				::with( 'customer', 'plans', 'ban' )
				->whereStatus( 'active' )
				->where( 'sub_status', Subscription::SUBSTATUS[ $subStatus ] ) : Subscription
				::with( 'customer', 'plans', 'ban' )
				->whereStatus( 'active' );


			$totalData = $mainQuery
				->whereHas( 'customer', function ( $query ) {
					$query->where( 'company_id', '=', auth()->user()->company_id );
				} )->count();

			$totalFiltered = $totalData;

			$limit = $request->input( 'length' );
			$start = $request->input( 'start' );
			$order = $columns[ $request->input( 'order.0.column' ) ];
			$dir   = $request->input( 'order.0.dir' );

			if ( empty( $request->input( 'search.value' ) ) ) {
				$subscriptions = $mainQuery->whereHas( 'customer', function ( $query ) {
					$query->where( 'company_id', '=', auth()->user()->company_id );
				} )->offset( $start )
				                           ->limit( $limit )
				                           ->orderBy( $order, $dir )
				                           ->get();
			} else {
				/**
				 * @internal Replace '-' with ''
				 */
				$search = str_replace('-', '', $request->input( 'search.value'));

				$subscriptions = $mainQuery->whereHas( 'customer', function ( $query ) use ( $search ) {
					$query->where( 'company_id', '=', auth()->user()->company_id )
			            ->where( function ( $query ) use ( $search ) {
							$query->where( 'fname', 'LIKE', "%{$search}%" )
							      ->orWhere( 'lname', 'LIKE', "%{$search}%" );
						});
					})->orWhere(function ( $query ) use ( $search ) {
						$query->where( 'company_id', '=', auth()->user()->company_id )
						->where( function($query) use ($search) {
							$query->where( 'phone_number', 'LIKE', "%{$search}%" )
							      ->orWhere( 'sim_card_num', 'LIKE', "%{$search}%" );
						});
					})->offset( $start )
					->limit( $limit )
					->orderBy( $order, $dir )
					->get();

				$totalFiltered = $mainQuery
					->whereHas( 'customer', function ( $query ) use ( $search ) {
						$query->where( 'company_id', '=', auth()->user()->company_id )
							->where( function ( $query ) use ( $search ) {
								$query->where( 'fname', 'LIKE', "%{$search}%" )
								      ->orWhere( 'lname', 'LIKE', "%{$search}%" );
						});
			        })->orWhere( function ( $query ) use ( $search ) {
						$query->where( 'company_id', '=', auth()->user()->company_id )
					        ->where( function ( $query ) use ( $search ) {
						        $query->where( 'phone_number', 'LIKE', "%{$search}%" )
						            ->orWhere( 'sim_card_num', 'LIKE', "%{$search}%" );
					        });
					})->count();
			}

			$data = [];
			if ( ! empty( $subscriptions ) ) {
				foreach ( $subscriptions as $subscription ) {

					$nestedData[ 'first' ]           = '';
					$nestedData[ 'name' ]            = $this->nameHtml( $subscription );
					$nestedData[ 'phone_number' ]    = $subscription->getPhoneNumberFormattedAttribute();
					$nestedData[ 'ban' ]             = $subscription->ban[ 'number' ];
					$nestedData[ 'plans' ]           = $subscription->plans[ 'name' ];
					$nestedData[ 'add-ons' ]         = isset( $subscription->subscriptionAddonNotRemoved[ '0' ] ) ? '<div class="add-ons">' . $this->getAddonsDetails( $subscription->subscriptionAddonNotRemoved ) . '</div>' : '<div class="add-ons">' . $this->getAddonsDetails( $subscription->subscriptionAddonNotRemoved ) . '</div>';
					$nestedData[ 'sim_card_num' ]    = $subscription->sim_card_num;
					$nestedData[ 'activation_date' ] = '<span data-date =' . $subscription->activation_date . '>' . $subscription->getActivationDateFormattedAttribute() . '</span>';
					$nestedData[ 'date' ]            = $subscription->sub_status == 'suspend-scheduled' ? '<span data-date =' . $subscription->scheduled_suspend_date . '>' . $this->dateFormated( $subscription->scheduled_suspend_date ) . '</span>' : '<span data-date =' . $subscription->scheduled_closed_date . '>' . $this->dateFormated( $subscription->scheduled_close_date ) . '</span>';
					$nestedData[ 'action' ]          = '<div class="actionbtn">
			                                       						    <div class="dropdown active-action-btn">
			                                                                   <a class="btn billind-cycles markbtn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-date = ' . $subscription->customer[ "billing_end" ] . '> Actions </a>
			                                       						        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> <a class="dropdown-item active-dropdown-option display-none" href="#">Suspend</a><a class="dropdown-item active-dropdown-option" href="#">Close</a>
			                                       						        </div>
			                                       						    </div>
			                                       						    <div class="action-confirm-btn display-none">
			                                       						        <div id="portbxactions" class="active">
			                                       						            <div class="portcheckbox active-datepicker">
			                                       						                <div id="datepicker' . $subscription->id . '" class="input-group date" data-date-format="dd-mm-yyyy">
			                                       											    <input class="active-date form-control" type="text" readonly />
			                                       											    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                       											</div>
			                                       						            </div>
			                                       						            <div class="portclosebtn action-confirm-close-btn confirm-btn-css"> <span class="fas fa-times"></span> </div>
			                                       						        </div><br><br>
			                                       						        <a class="btn markbtn confirmaction smbtn130 confirm-active-btn action-confirm-close-btn"> Confirm </a>
			                                       						    </div>
			                                       						</div>';
					$nestedData[ 'id' ]              = $subscription->id;
					$data[]                          = $nestedData;

				}
			}

			$json_data = [
				"draw"            => intval( $request->input( 'draw' ) ),
				"recordsTotal"    => intval( $totalData ),
				"recordsFiltered" => intval( $totalFiltered ),
				"data"            => $data
			];

			return response( $json_data );
		} catch (\Exception $e) {
			Log::info($e->getMessage() . ' on line number: '.$e->getLine() . ' Get Active Datatables');
			return [
				'status'  => 'error',
				'message' => $e->getMessage()
			];
		}

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
    public function markActive(Request $request)
    {
    	$data = $request->all();
        $formatedDate = Carbon::createFromFormat('m/d/Y', $data['date']);
        $subscription = Subscription::find($data['id']);
    	if($data['type'] != "close"){

            $data['hide'] = 1;
	    	if($formatedDate->gte(Carbon::now())){
	    		$subscription->update(['sub_status' => 'suspend-scheduled', 'scheduled_suspend_date' => $formatedDate]);
                event(new SubcriptionStatusChanged($data['id'], true));
	    	}else{
	    		$subscription->update(['status' => 'suspended','sub_status' => 'confirm-suspend', 'suspended_date' => $formatedDate]);
                event(new SubcriptionStatusChanged($data['id']));
	    	}
	    }else{
	    	if($formatedDate->gte(Carbon::now())){
                if($subscription->sub_status == 'account-past-due'){
                    $data['hide'] = 1;
                }
	    		$subscription->update(['sub_status' => 'close-scheduled', 'scheduled_close_date' => $formatedDate]);
                event(new SubcriptionStatusChanged($data['id'], true));
	    	}else{
                $data['hide'] = 1;
	    		$subscription->update(['status' => 'closed','sub_status' => 'confirm-closing', 'closed_date' => $formatedDate]);
			    /**
			     * Remove charge of the subscription from the invoice table and remove row from the invoice_item table
			     */
				$invoice = Invoice::where([['customer_id', $subscription->customer_id], ['status', 1]])->first();

				if($invoice){
				    $invoiceItemsAmount = $invoice->invoiceItem()->where('subscription_id', $subscription->id)->sum('amount');

				    $subTotal               = $invoice->subtotal - $invoiceItemsAmount;
				    $totalDue               = $invoice->total_due - $invoiceItemsAmount;
				    $invoice->update(
					    [
						    'subtotal'  => $subTotal,
						    'total_due' => $totalDue
					    ]
				    );
					InvoiceItem::where([['invoice_id', $invoice->id], ['subscription_id', $subscription->id]])->delete();

			    }
                event(new SubcriptionStatusChanged($data['id']));

	    	}
	    }
	    return $data;
    }


	/**
	 * @param Request $request
	 *
	 * @return array|\Illuminate\Http\JsonResponse
	 */
	public function changeBulkNumbers(Request $request)
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
				$numberChangeRows = [];
				$errorCount = 0;
				foreach ( $csvData as $value ) {
					$numberChangeData = [];
					$subscription = Subscription::where( 'phone_number', $value['old_number'])
					                            ->whereStatus( 'active' )
					                            ->whereHas( 'customer', function ( $query ) {
						                            $query->where( 'company_id', '=', auth()->user()->company_id );
					                            } )
					                            ->whereHas( 'plans', function ( $query ) {
						                            $query->where( 'type', '<>', '6' );
					                            } )->first();
					if ( ! $subscription ) {
						$errorCount++;
						$messages[] = 'Subscription not found for phone number ' . $value['old_number'];
						continue;
					}
					$numberChangeData[ 'phone_number' ] = preg_replace( '/[^\dxX]/', '', $value['new_number'] );
					if(strlen((string) $numberChangeData[ 'phone_number' ]) !== 10) {
						$errorCount++;
						$messages[] = "Phone number ". $numberChangeData[ 'phone_number' ] . " is not valid";
						continue;
					}
					$phoneNumberExists                = Subscription::where( [
						[ 'phone_number', $numberChangeData[ 'phone_number' ] ],
						[ 'status', '!=', 'closed' ]
					] )->whereHas( 'customer', function ( $query ) {
						$query->where( 'company_id', '=', auth()->user()->company_id );
					} )->whereHas( 'plans', function ( $query ) {
						$query->where( 'type', '<>', '6' );
					} )->exists();
					if ( $phoneNumberExists ) {
						$errorCount++;
						$messages[] = 'Subscription already exists for phone number ' . $numberChangeData[ 'phone_number' ];
						continue;
					}
					$messages[] = 'Phone Number updated to ' . $value['new_number'];
					$numberChangeRows[$subscription->id] = $numberChangeData;
				}

				if(!$errorCount && count($numberChangeRows)) {
					DB::transaction(function() use ($numberChangeRows)
					{
						foreach($numberChangeRows as $subscriptionId => $numberChangeData) {
							$updateSubscription = Subscription::where('id', $subscriptionId)->update($numberChangeData);
							if( !$updateSubscription )
							{
								throw new \Exception('Failed to update numbers');
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
}