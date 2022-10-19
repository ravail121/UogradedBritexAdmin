<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use Carbon\Carbon;
use App\Model\Addon;
use Illuminate\Http\Request;
use App\Model\SubscriptionAddon;
use App\Model\SystemGlobalSetting;

/**
 * Class AddonController
 *
 * @package App\Http\Controllers
 */
class AddonController extends Controller
{
	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		return view('Addon.all-addons');
	}

	/**
	 * @return mixed
	 */
	public function getAllAddons()
	{
		$addon = Addon::whereCompanyId(auth()->user()->company_id)->get();

		return DataTables::of($addon)
		                 ->addColumn('first', function($addon) {
			                 return "";
		                 })
		                 ->addColumn('id', function($addon) {
			                 return $addon->id;
		                 })
		                 ->addColumn('name', function($addon) {
			                 return $addon->name;
		                 })
		                 ->addColumn('recurring-price', function($addon) {
			                 return '$ '.number_format($addon->amount_recurring, 2);
		                 })
		                 ->addColumn('sku', function($addon) {
			                 return $addon->sku;
		                 })
		                 ->addColumn('soc-code', function($addon) {
			                 return $addon->soc_code;
		                 })
		                 ->addColumn('modify', function($addon) {
			                 return '<div class="actionbtn">
                            <div class="dropdown"> 
                            <a class="edit-btn btn activest smgreen " href="#edit" data-toggle="modal" data-target="#updateshipping"> Edit </a>
                             <a class="btn delete-btn" data-id ='.$addon->id.' > Delete </a> </div>
                        </div>';
		                 })
		                 ->addColumn('all-data', function($addon) {
			                 return htmlspecialchars(json_encode($addon));
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

		$data= $request->all();
		$data['id'] = $request->id;
		if(!isset($data['taxable'])){
			$data['taxable'] = 0;
		}
		Addon::find($data['id'])->update($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function delete(Request $request)
	{
		$data=$request->validate([
			'id'  => 'required',
		]);
		$count = SubscriptionAddon::where('addon_id', $data['id'])->count();

		if($count == 0){
			Addon::find($data['id'])->delete();
			return $data;
		}else{
			return ['error' => "Sorry this Addon can't be Deleted as it has already been associated with a Subscription"];
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

		$data= $request->all();
		$data['company_id'] = auth()->user()->company_id;
		if(!isset($data['taxable'])){
			$data['taxable'] = 0;
		}

		$addon = Addon::create($data);

		return $addon;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function validateData(Request $request)
	{
		$data = $request->validate([
			'name'                  => 'required',
			'description'           => 'required',
			'taxable'               => 'sometimes|required',
			'amount_recurring'      => 'required',
			'show'                  => 'required'
		]);
		return $data;
	}
}
