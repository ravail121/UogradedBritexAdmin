<?php

namespace App\Http\Controllers\ActionQueue;

use DataTables;
use Carbon\Carbon;
use App\Helpers\Log;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Events\ShippingNumber;
use App\Model\SubscriptionLog;
use App\Http\Controllers\Controller;
use App\Model\CustomerStandaloneSim;
use App\Model\CustomerStandaloneDevice;
use App\Events\SubcriptionStatusChanged;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ShippingController
 *
 * @package App\Http\Controllers\ActionQueue
 */
class ShippingController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function markShipped(Request $request)
    {
		try {
			$data = $request->validate( [
				'subscription_id'               => 'sometimes|required',
				'customer_standalone_sim_id'    => 'sometimes|required',
				'customer_standalone_device_id' => 'sometimes|required'
			] );

			$imeiValue = $request->has( 'device_imei' ) ? $request->device_imei : $request->imei;

			$shippingDate = $request->has( 'shipping_date' ) ? Carbon::createFromFormat('Y-m-d', $request->shipping_date) : Carbon::today();

			if ( array_key_exists( "subscription_id", $data ) ) {
				$subscription = Subscription::whereId( $data[ 'subscription_id' ] )->with( 'device', 'sim', 'customer' )->first();

				$subscription->update( [
					'status'        => 'for-activation',
					'tracking_num'  => $request->tracking_num,
					'sim_card_num'  => $request->sim_num,
					'device_imei'   => $imeiValue,
					'shipping_date' => $shippingDate
				] );
				event( new SubcriptionStatusChanged( $data[ 'subscription_id' ] ) );
				event( new ShippingNumber( $request->tracking_num, $subscription ) );

				return $data;
			} else if ( array_key_exists( "customer_standalone_device_id", $data ) ) {
				$customerStandaloneDevice = CustomerStandaloneDevice::whereId( $data[ 'customer_standalone_device_id' ] )->with( 'device', 'customer' )->first();
				if ( $customerStandaloneDevice->subscription_id ) {
					$subscription = Subscription::whereId( $customerStandaloneDevice->subscription_id )->first();
					if ( $subscription ) {
						$deviceImei = $subscription->device_imei;
						$subscription->update( [
							'device_imei'  => $imeiValue
						] );

						SubscriptionLog::create( [
							'subscription_id'   => $subscription->id,
							'company_id'        => auth()->user()->company_id,
							'customer_id'       => $customerStandaloneDevice->customer->id,
							'description'       => 'Replacement Device shipped',
							'category'          => SubscriptionLog::CATEGORY['device-imei-changed'],
							'old_product'       => $deviceImei,
							'new_product'       => $imeiValue
						]);
					}
				}
				$customerStandaloneDevice->update( [
					'status'        => 'complete',
					'tracking_num'  => $request->tracking_num,
					'imei'          => $request->imei,
					'shipping_date' => $shippingDate
				] );
				event( new ShippingNumber( $request->tracking_num, $customerStandaloneDevice ) );

				return $data;
			} else {
				$customerStandaloneSim = CustomerStandaloneSim::whereId( $data[ 'customer_standalone_sim_id' ] )->with( 'sim', 'customer' )->first();
				if ( $customerStandaloneSim->subscription_id ) {
					$subscription = Subscription::whereId( $customerStandaloneSim->subscription_id )->first();
					if ( $subscription ) {
						$simCardNum = $subscription->sim_card_num;
						$subscription->update( [
							'sim_card_num' => $request->sim_num
						] );

						SubscriptionLog::create( [
							'subscription_id'   => $subscription->id,
							'company_id'        => auth()->user()->company_id,
							'customer_id'       => $customerStandaloneSim->customer->id,
							'description'       => 'Replacement SIM shipped',
							'category'          => SubscriptionLog::CATEGORY['sim-num-changed'],
							'old_product'       => $simCardNum,
							'new_product'       => $request->sim_num
						]);
					}
				}
				$customerStandaloneSim->update( [
					'status'        => 'complete',
					'tracking_num'  => $request->tracking_num,
					'sim_num'       => $request->sim_num,
					'shipping_date' => $shippingDate
				] );

				event( new ShippingNumber( $request->tracking_num, $customerStandaloneSim ) );

				return $data;
			}
		} catch (\Exception $e ) {
			Log::info($e->getMessage() . ' on line number: '.$e->getLine() . ' Mark Ship');
			return response()->json( [
				'status'    => 'error',
				'message'   => $e->getMessage()
			], 500);
		}
    }

	/**
	 * @param $date
	 *
	 * @return Subscription[]|\Illuminate\Database\Eloquent\Builder[]|Collection
	 */
	private function getSubscription($date)
    {
        if($date == 0){
            $subscription = Subscription::
                with('customer', 'order', 'device', 'plans','sim','port')->whereStatus('shipping')
                ->whereHas('customer', function ($query) {
                  $query->where('company_id', '=', auth()->user()->company_id );
            })->get();
        }else{
            $subscription = Subscription::
                with('customer', 'order', 'device', 'plans','sim','port')
                ->where([['status', '=', 'shipping'],['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                ->whereHas('customer', function ($query) {
                  $query->where('company_id', '=', auth()->user()->company_id );
            })->get();
        }

            return $subscription;
    }

	/**
	 * @param $date
	 *
	 * @return CustomerStandaloneDevice[]|\Illuminate\Database\Eloquent\Builder[]|Collection
	 */
	private function getCustomerStandaloneDevice($date)
    {
        if($date == 0){
            $customerStandaloneDevice = CustomerStandaloneDevice::
                with('customer', 'order', 'device')
                ->whereStatus('shipping')
                ->whereHas('customer', function ($query) {
                    $query->where('company_id', '=', auth()->user()->company_id );
            })->get();
        }else{
             $customerStandaloneDevice = CustomerStandaloneDevice::
                with('customer', 'order', 'device')
                ->where([['status', '=', 'shipping'],['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                ->whereHas('customer', function ($query) {
                    $query->where('company_id', '=', auth()->user()->company_id );
            })->get();
        }

        return $customerStandaloneDevice;
    }

	/**
	 * @param $date
	 *
	 * @return CustomerStandaloneSim[]|\Illuminate\Database\Eloquent\Builder[]|Collection
	 */
	private function getCustomerStandaloneSim($date)
    {
        if($date == 0){        
            $customerStandaloneSim = CustomerStandaloneSim::
            with('customer', 'order', 'sim')
                ->whereStatus('shipping')
                ->whereHas('customer', function ($query) {
                    $query->where('company_id', '=', auth()->user()->company_id );
            })->get();
        }else{
            $customerStandaloneSim = CustomerStandaloneSim::
            with('customer', 'order', 'sim')
                ->where([['status', '=', 'shipping'],['created_at', '>', Carbon::now()->subDays($date)->endOfDay()]])
                ->whereHas('customer', function ($query) {
                    $query->where('company_id', '=', auth()->user()->company_id );
            })->get();
        }

        return $customerStandaloneSim;
    }

	/**
	 * @param $detail
	 *
	 * @return string
	 */
	private function getProduct($detail)
    {
        $data = '';
        if($detail->device_id){
            $data = '<b>Device: </b>'.$detail->device['name'].'<br>';
        }
        if($detail->plan_id){
             $data = $data.'<b>Plan: </b>'.$detail->plans['name'].'<br>';
        }
        if($detail->sim_id){
             $data = $data.'<b>SIM: </b>'.$detail->sim['name'];
        }
        return $data;
    }


	/**
	 * @param $date
	 *
	 * @return Collection
	 */
	private function getData($date)
    {
        $subscriptions = $this->getSubscription($date);
        $customerStandaloneDevices = $this->getCustomerStandaloneDevice($date);
        $customerStandaloneSims = $this->getCustomerStandaloneSim($date);

        $allData = new Collection;
        foreach ($subscriptions as $subscription){
            $allData->push($subscription);        
        }
        foreach ($customerStandaloneDevices as $customerStandaloneDevice){
            $allData->push($customerStandaloneDevice);        
        }
        foreach ($customerStandaloneSims as $customerStandaloneSim){
            $allData->push($customerStandaloneSim);        
        }
        return $allData;
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getShippingData(Request $request)
    {
        $date = $request->date;
    	$allData = $this->getData($date);

		return DataTables::of($allData)
        ->addColumn('first', function($detail) {
            return $this->dateHtml($this->date($detail->created_at));
        })
        ->addColumn('name', function($detail) {
            return $this->shippingName($detail);
        })  
        ->addColumn('order-number', function($detail) {
            return $detail->order['order_num'];

        })  
        ->addColumn('porting-no', function($detail) {
            if($detail->plan_id){
                if($detail->requested_area_code){
                    return $detail->requested_area_code;      
                }elseif($detail->port){
                    return $detail->port->number_to_port;
                }
            }
            return 'NA';
        })
        ->addColumn('product', function($detail) {
            return $this->getProduct($detail);
        })
        ->addColumn('shipping-address', function($detail) {
            return $detail->order['full_address'];
        })
        ->addColumn('processed', function($detail) {
            if($detail->processed == true){
                return '<input name="processed" id="processed" type="checkbox" value="1" checked >';
            }
            return '<input name="processed" id="processed" type="checkbox" value="0" >';

        })      
        ->addColumn('action', function($detail) {
            return '<div class="actions actionbtn"><div class="dropdown active-action-btn">
                        <a class="btn billind-cycles markbtn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-date = '.$detail->customer["billing_end"].'> Actions </a>
				        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				            <a class="dropdown-item markshippedbtn" href="#updateshipping" data-toggle="modal" data-target="#updateshipping">Shipped</a>' . ($detail->status !== 'closed' ?
				            '<a class="dropdown-item active-dropdown-option" href="#">Close</a>
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
				        <a class="btn markbtn confirmaction smbtn130 confirm-active-btn action-confirm-close-btn"> Confirm </a></div>' : '') .
				    '</div></div>';
        })
        ->addColumn('all-data', function($data) {
            return htmlspecialchars(json_encode($data));
        })
		->addColumn('id', function($detail) {
			return $detail->id;
		})
        ->rawColumns(['first', 'name', 'processed', 'action', 'product', 'shipping-address'])
        ->make(true);
    }


	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function updateProcessed(Request $request)
    {
        $data = $request->all();
        if (array_key_exists("subscription_id",$data))
        {
        Subscription::find($data['subscription_id'])->update(['processed' => $data['processed']]);
        }else if(array_key_exists("customer_standalone_device_id",$data)){
            CustomerStandaloneDevice::find($data['customer_standalone_device_id'])->update(['processed' => $data['processed']]);
        }else{
            CustomerStandaloneSim::find($data['customer_standalone_sim_id'])->update(['processed' => $data['processed']]);
        }
        return $data;
    }
}
