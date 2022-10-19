<?php

namespace App\Http\Controllers;

use App\Staff;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class MasterAdminController
 *
 * @package App\Http\Controllers
 */
class MasterAdminController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		$companies = Company::paginate(15);
		return view('master-admin.index', compact('companies'));
	}

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function changeCompany(Request $request)
	{
		$id = $request->id;
		$staff = Staff::where([
			'level' => Staff::LEVEL['company-admin'],
			'company_id' =>  $id,
		])->first();
		if($staff){
			Auth::login($staff);
			session(['master-staff' => true]);
			return $staff;
		}else{
			return ["error" => "Company Doesn't have any staff"];
		}
	}

	/**
	 * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
	 */
	public function logout()
	{
		$staff = Staff::find(session('master-admin'));
		if($staff){
			Auth::login($staff);
			session()->forget('master-staff');
			return redirect(route('master.admin'))->with('status', 'Switched as Master Admin');
		}
	}
}
