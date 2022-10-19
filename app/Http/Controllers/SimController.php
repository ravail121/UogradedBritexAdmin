<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Model\Sims;
use Illuminate\Http\Request;
use App\Model\SystemGlobalSetting;

/**
 * Class SimController
 *
 * @package App\Http\Controllers
 */
class SimController extends Controller
{
	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		return view('Sim.all-sims');
	}

	/**
	 * @return mixed
	 */
	public function getAllSims()
	{
		$sim = Sims::whereCompanyId(auth()->user()->company_id)->with('carrier')->get();

		return DataTables::of($sim)
		                 ->addColumn('first', function($sim) {
			                 return "";
		                 })
		                 ->addColumn('id', function($sim) {
			                 return $sim->id;
		                 })
		                 ->addColumn('carrier', function($sim) {
			                 return $sim->carrier['name'];
		                 })
		                 ->addColumn('name', function($sim) {
			                 return $sim->name;
		                 })
		                 ->addColumn('stand-alone-price', function($sim) {
			                 return'$ '.number_format($sim->amount_alone, 2);
		                 })
		                 ->addColumn('price-with-plan', function($sim) {
			                 return '$ '.number_format($sim->amount_w_plan, 2);
		                 })
		                 ->addColumn('shipping-fee', function($sim) {
			                 if(!$sim->shipping_fee==""){
				                 return '$ '.number_format($sim->shipping_fee, 2);
			                 }else{
				                 return '$ '.number_format(0, 2);
			                 }
		                 })
		                 ->addColumn('live', function($sim) {
			                 return $sim->show;
		                 })
		                 ->addColumn('sku', function($sim) {
			                 return $sim->sku;
		                 })
		                 ->addColumn('modify', function($sim) {
			                 return '<div class="actionbtn">
                            <div class="dropdown"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#updateshipping"> Edit </a> </div>
                            <div class="dropdown"> <a class="btn delete-btn" data-id ='.$sim->id.' > Delete </a> </div>
                        </div>';
		                 })
		                 ->addColumn('all-data', function($sim) {
			                 return htmlspecialchars(json_encode($sim));
		                 })
		                 ->rawColumns(['modify'])
		                 ->make(true);
	}

	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	public function edit(Request $request)
	{
		$this->validateData($request);
		$data = $request->all();
		$data['id'] = $request->id;

		if(!isset($data['taxable'])){
			$data['taxable'] = 0;
		}

		Sims::find($data['id'])->update($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function uploadImage(Request $request)
	{
		$image = $request->file('image');
		$new_name = rand() . '.' . $image->getClientOriginalExtension();
		$SystemGlobalSetting = SystemGlobalSetting::first();
		$path = $SystemGlobalSetting->upload_path."/uploads/".Auth::user()->company_id."/sim_image/";

		$image->move($path, $new_name);

		$uploadUrl = $SystemGlobalSetting->site_url."/uploads/".Auth::user()->company_id."/sim_image/";

		$data = ['image' => $uploadUrl.'/'.$new_name];

		Sims::find($request->id)->update($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function delete(Request $request)
	{
		$data = $request->validate([
			'id'  => 'required',
		]);
		$sim = Sims::find($data['id']);

		if($sim->simAssociedCount() == 0){
			$sim->delete();
			return $data;
		}else{
			return ['error' => "Sorry this Sim can't be Deleted as it has already been associated with a Order"];
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function create(Request $request)
	{
		$this->validateData($request);
		$data = $request->all();
		$data['company_id'] = auth()->user()->company_id;

		if(!isset($data['taxable'])){
			$data['taxable'] = 0;
		}

		$sim = Sims::create($data);

		return $sim;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function validateData(Request $request)
	{
		$data = $request->validate([
			'name'           => 'required',
			'carrier_id'     => 'required',
			'amount_w_plan'  => 'required',
			'amount_alone'   => 'required',
			'shipping_fee'   => 'required',
			'show'           => 'required',
		]);

		return $data;
	}
}
