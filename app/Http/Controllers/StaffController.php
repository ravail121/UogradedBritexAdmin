<?php

namespace App\Http\Controllers;

use App\Staff;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class StaffController
 *
 * @package App\Http\Controllers
 */
class StaffController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
    {
    	return view('Staff.index');
    }

	/**
	 * @return mixed
	 */
	public function show()
    {
    	$staff = Staff::whereCompanyId(auth()->user()->company_id)->get();
    	return DataTables::of($staff)
            ->addColumn('action', function($staff) {
                return '<div class="actionbtn">
                            <div class="dropdown"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#updateshipping"> Edit </a> </div>
                            <div class="dropdown"> <a class="btn delete-btn" data-id='.$staff->id.'> Delete </a> </div>
                        </div>';
            })
            ->addColumn('all-data', function($staff) {
                return $staff;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function checkEmail(Request $request)
    {
    	if($request->id){
    		$count = Staff::where([['email', $request->email],['id','<>', $request->id]])->count();
    	}else{
    		$count = Staff::whereEmail($request->email)->count();
    	}
    	return ($count > 0 ) ? 'false' : 'true';
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function createUpdateStuff(Request $request)
    {
    	$data =  $this->validateData($request);
        $data['company_id'] = $request->company_id ?: auth()->user()->company_id;
    	if($request->id){
    		$data['id'] = $request->id;
    		if ($request->password) {
    			$data['password'] = Hash::make($request->password);
    		}
    		Staff::find($data['id'])->update($data);
    		return $data;
    	}else{
    		$additionalData = $request->validate([
	            'password' 	=> 'required',
        	]);
        	$data['password'] = Hash::make($additionalData['password']);
        	$data['reset_hash'] = " ";

        	$stuff = Staff::create($data);
        	return $stuff;
    	}
    }

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function validateData(Request $request)
    {
    	$data = $request->validate([
            'fname'	=> 'required',
            'lname' => 'required',
            'level' => 'required',
            'phone' => 'required',
  			'email' => 'required|email',
        ]);
        return $data;
    }

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request)
    {
    	$data = $request->validate([
            'id'	=> 'required',
        ]);

        if($data['id'] != auth()->user()->id ){
            Staff::find($data['id'])->delete();
            return $data;
        }else{
            return response()->json(['message' => 'Logged in Stuff can not be Deleted'], 404);
        }
    }
}