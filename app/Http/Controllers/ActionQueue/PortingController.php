<?php

namespace App\Http\Controllers\ActionQueue;

use DataTables;
use Carbon\Carbon;
use App\Model\Port;
use App\Events\RejectPort;
use Illuminate\Http\Request;
use App\Model\CannedResponse;
use App\Events\PortingComplete;
use App\Http\Controllers\Controller;

/**
 * Class PortingController
 *
 * @package App\Http\Controllers\ActionQueue
 */
class PortingController extends Controller
{

	/**
	 *
	 */
	const STATUS = [
        1 => 'Pending',
        2 => 'Submitted',
        4 => 'Error',
        5 => 'Cancelled'
    ];

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getPortData(Request $request)
    {
        $date = $request->date;
        
        if($date == 0){
    		$data = Port::with('subscription.customer', 'subscription.plans')
                        ->whereIn('status', [Port::STATUS['pending'], Port::STATUS['submitted'], Port::STATUS['error']])
                        ->whereHas('subscription.customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }else{
            $data = Port::with('subscription.customer' , 'subscription.plans')
                        ->whereIn('status', [Port::STATUS['pending'], Port::STATUS['submitted'], Port::STATUS['error']])
                        ->where('date_submitted', '>', Carbon::now()->subDays($date)->endOfDay())
                        ->whereHas('subscription.customer', function ($query) {
                            $query->where('company_id', '=', auth()->user()->company_id );
                        })->get();
        }

        return DataTables::of($data)
            ->addColumn('first', function(Port $detail) {
                return $this->dateHtml($this->date($detail->date_submitted));
            })
            ->addColumn('name', function(Port $detail) {
                return '<div class="tableuserbx">
                            <div class="usrimg data-table-image">
                                <img src='.$this->carrierImage($detail->plans["carrier_id"]).' alt="" width="25" height="25">
                            </div>
                            <div class="usrname data-table-name">
                                <a href = '.route("customers.detail", $detail->subscription['customer']['id']).'>
                                    <strong>'.$detail->subscription['customer']['full_name'].'</strong>
                                </a>
                            </div>
                        </div>';
            })
            ->addColumn('current-phone-no', function(Port $detail) {
                return $detail->subscription['phone_number_formatted'];
            })
            ->addColumn('phone-no-to-port', function(Port $detail) {
                return $detail->number_to_port_formatted;
            })
            ->addColumn('sim-num', function(Port $detail) {
                return $detail->subscription['sim_card_num'];
            })
            ->addColumn('status', function(Port $detail) {
                $select = '<select id ="statusdropdown">';
                foreach (self::STATUS as $key => $status) {
                    if($detail->status == $key){
                        $select .='<option value ='.$key.' selected>'.$status.'</option>';
                    }else{
                        $select .='<option value ='.$key.' >'.$status.'</option>';
                    }
                }
                $select .= '</select><a href="#portpopup" class="eyeviewbtn ml-3" data-toggle="modal" data-target="#portpopup"><span class="fas fa-eye"></span></a>';

                return $select;

            })
            ->addColumn('action', function(Port $detail) {
            	if($detail->status != 4){
                	return '<div class="actionbtn">
                			<div class="port-confirm-btn display-none-imp">
	                     	<div id="portbxactions" class="active">
						        <div class="portcheckbox">
						            <div class="custom-control custom-checkbox">
						                <input type="checkbox" class="custom-control-input" id="customChecknew'.$detail->id.'">
						                <label class="custom-control-label port-mail-msg" for="customChecknew'.$detail->id.'">Do NOT notify the customer</label>
						            </div>
						        </div>
						        <div class="portclosebtn port-confirm-close-btn"> <span class="fas fa-times"></span> </div>
						    </div>
						    <a class="btn markbtn confirmaction smbtn130 confirm-port-btn" > Confirm </a>
						    </div>
						    <div class="combbtnsgroup">
								<a class="btn combbtn1 complete-btn"  title="Complete"> Complete </a>
								<a class="btn combbtn2 port-reject-btn" data-toggle="modal" data-target="#portingerrorpop" title="Reject">Reject</a>
							</div>
						</div>';
            	}
						
            })
            ->addColumn('all-data', function(Port $data) {
                return htmlspecialchars(json_encode($data));
            })
            ->rawColumns(['first', 'name', 'action', 'status'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function setComplete(Request $request)
    {
    	$data = $request->validate([
            'id'  => 'required',
            'phone_number' => 'required'
        ]);
    	$port = Port::find($data['id']);
    	$port->update(['status' => '3']);
        $port->subscription()->update(['phone_number' => $data['phone_number']]);

    	if($request->mail == 'true'){
        	event(new PortingComplete($request->customer_id, $port));
    	}    
        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function rejectPort(Request $request)
    {
    	$data = $request->all();
        $data = $request->validate([
            'id'            => 'required',
            'customer_id'   => 'required',
            'subject'       => 'required',
            'message'       => 'required'
        ]);
		Port::find($data['id'])->update(['status' => '4']);
        event(new RejectPort($data['customer_id'], $data['subject'], $data['message']));

    	return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function getResponsePort(Request $request)
    {
    	$data = $request->all();
    	$data = CannedResponse::find($data['id']);
    	return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updatePort(Request $request)
    {
        $data =  $request->validate([
            'authorized_name'               => 'required|max:20',
            'address_line1'                 => 'required',
            'city'                          => 'required|max:20',
            'zip'                           => 'numeric|required',
            'state'                         => 'required',
            'number_to_port'                => 'numeric|required',
            'company_porting_from'          => 'required',
            'account_number_porting_from'   => 'required',
            'account_pin_porting_from'      => 'required',

        ]);
        $data['id'] = $request->id;
        $data['subscription_id'] = $request->subscription_id;
        $data['ssn_taxid'] = $request->ssn_taxid;
        $data['address_line2'] = $request->address_line2;
        $data['status'] = '1';

        $result = $this->requestConnection('update-port', 'post', $data);
        if($result[0] =='sucessfully Updated'){
            return $data;
        }
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updatePortStatus(Request $request)
    {
        $data = $request->validate([
            'id'        => 'required',
            'status'    => 'required',
        ]);
        Port::find($data['id'])->update(['status' => $data['status']]);
        return $data;
    }

}
