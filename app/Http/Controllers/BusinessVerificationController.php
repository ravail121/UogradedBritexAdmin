<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Model\SystemGlobalSetting;
use App\Model\BusinessVerification;
use App\Events\BusinessVerificationRejected;
use App\Events\BusinessVerificationApproved;

/**
 * Class BusinessVerificationController
 *
 * @package App\Http\Controllers
 */
class BusinessVerificationController extends Controller
{

	/**
	 * BusinessVerificationController constructor.
	 */
	public function __construct()
    {
        $this->middleware('businessVerification');
    }

	/**
	 * @param Request $request
	 *
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $type = 0;
        if(isset($request->type)){
            $type = $request->type;     
        }
        $authUser = auth()->user();

        $orderIds = $authUser->company->orders()->pluck('id');
        if(in_array($type, ['0','1','-1'])){
            $details = BusinessVerification::whereIn('order_id', $orderIds)->with('businessVerificationDoc')->orderBy('created_at', 'desc')->whereApproved($type)->paginate(15);
        }else{
            $details = BusinessVerification::whereIn('order_id', $orderIds)->with('businessVerificationDoc')->orderBy('created_at', 'desc')->paginate(15);
        }
        $siteUrlLocation = SystemGlobalSetting::first()->site_url;
        $details->type = $type;
        $cannedResponse = $authUser->company->cannedResponse()->whereSection(1)->get();

        return view('biz-verification', compact('details', 'cannedResponse', 'siteUrlLocation'));
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function changeBusinessStatus(Request $request)
    {
        $data = $request->validate([
            'hash'   => 'required',
            'status' => 'required'
        ]);
        $businessVerification = BusinessVerification::hash($data['hash'])->first();
        
        if($businessVerification) {
            $businessVerification->update(['approved' => BusinessVerification::APPROVED[$data['status']]]);
            if($data['status'] == 'approved'){
                event(new BusinessVerificationApproved($businessVerification->hash));
            }
        }
        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
	 */
	public function rejectBusiness(Request $request)
    {
        
    	$msg = 'Something went wrong';
        $subject = $request->subject;
    	$hash = $request->hash;
    	$message = $request->message;
        
    	$businessVerification = BusinessVerification::hash($hash)->first();

        if($businessVerification) {
            if($businessVerification->is_approved) {

                $response = $businessVerification->update(['approved' => -1]);
                event(new BusinessVerificationRejected($businessVerification->hash, $message, $subject));

                if ($response) {
                    $msg = 'Order Rejected Successfully';
                }

            } else {
                $msg = 'Business is already verified';
            }

        } else {
            $msg = 'Invalid User';
        }

        return redirect('biz-verification')->with('status', $msg);
    }

	/**
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|void
	 */
	public function downloadZip($id)
    {
        
        $files = SystemGlobalSetting::first()->upload_path."/uploads/".Auth::user()->company_id."/bus_ver/".$id;

        try {
            \Zipper::make(public_path('data/business-verification-zip/businessVerificationDoc.zip'))->add($files)->close();
        } catch (\Exception $e) {
            return  abort(404);
        }

        return response()->download(public_path('data/business-verification-zip/businessVerificationDoc.zip'))->deleteFileAfterSend(true);  
    }

	/**
	 * @param         $id
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function downloadfile($id, Request $request)
    {
        $src = $request->src;
        
        $files = SystemGlobalSetting::first()->upload_path."/uploads/".Auth::user()->company_id."/bus_ver/".$id."/".$src;

        return response()->download($files);  
    }

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function getImage()
    {
        return view('iframe.image');
    }

	/**
	 * @param $view
	 */
	public function compose($view)
    {
        $count = BusinessVerification::
        whereApproved(0)->with('order')
        ->whereHas('order', function ($query) {
            $query->where('company_id', '=', auth()->user()->company_id );
        })->count();

        $view->with('unapprovedBusinessVerificationCount', $count);

    }

}