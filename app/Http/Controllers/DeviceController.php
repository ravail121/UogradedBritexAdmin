<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Model\Sims;
use App\Model\Plan;
use App\Model\Device;
use App\Model\Carrier;
use App\Model\DeviceImage;
use App\Model\DeviceGroup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\SystemGlobalSetting;
use App\Model\DeviceToSim;

/**
 * Class DeviceController
 *
 * @package App\Http\Controllers
 */
class DeviceController extends Controller
{

	/**
	 *
	 */
	const TYPE = [
		0 => 'Custom',
		1 => 'Voice',
		2 => 'Data',
		3 => 'Wearable',
		4 => 'Membership',
		5 => 'Digits',
		6 => 'Cloud',
		7 => 'IoT',
		8 => 'Accessory',
	];

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		$type = self::TYPE;
		$deviceGroupName = DeviceGroup::whereCompanyId(auth()->user()->company_id)->pluck('name', 'id')->toArray();

		return view('Device.all-devices', compact('type', 'deviceGroupName'));
	}

	/**
	 * @return mixed
	 */
	public function getAllDevices()
	{
		$device = Device::whereCompanyId(auth()->user()->company_id)->with('carrier', 'addtionalCarrier','deviceToPlan', 'deviceToSim', 'deviceToGroup', 'deviceImage')->get();

		return DataTables::of($device)
		                 ->addColumn('id', function($device) {
			                 return $device->id;
		                 })
		                 ->addColumn('carrier', function($device) {
			                 return $device->carrier['name'];
		                 })
		                 ->addColumn('name', function($device) {
			                 return $device->name;
		                 })
		                 ->addColumn('type', function($device) {
			                 return self::TYPE[$device->type];
		                 })
		                 ->addColumn('stand-alone-price', function($device) {
			                 return '$ '.number_format($device->amount, 2);
		                 })
		                 ->addColumn('price-with-plan', function($device) {
			                 return '$ '.number_format($device->amount_w_plan, 2);
		                 })
		                 ->addColumn('shipping-fee', function($device) {
			                 if(!$device->shipping_fee==""){
				                 return '$ '.number_format($device->shipping_fee, 2);
			                 }else{
				                 return '$ '.number_format(0, 2);
			                 }
		                 })
		                 ->addColumn('live', function($device) {
			                 if($device->show=="1"){
				                 return 'YES';
			                 }
			                 return 'NO';
		                 })
		                 ->addColumn('os', function($device) {
			                 return $device->os;
		                 })
		                 ->addColumn('sku', function($device) {
			                 return $device->sku;
		                 })
		                 ->addColumn('modify', function($device) {
			                 $deviceToSim = $device->deviceToSim->count() ? $device->deviceToSim->first()->id : 0;
			                 return '<div class="actionbtn">
                            <div class="dropdown"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#updateshipping" data-sim_id='.$deviceToSim.'> Edit </a> </div>
                            <div class="dropdown"> <a class="btn delete-btn" data-id ='.$device->id.' > Delete </a> </div>
                        </div>';
		                 })
		                 ->addColumn('all-data', function($device) {
			                 return htmlspecialchars(json_encode($device));
		                 })
		                 ->addColumn('device-image', function($device) {
			                 return $device->deviceImage->pluck('source');
			                 // array_column($device->deviceImage->toArray(), 'source');
		                 })
		                 ->rawColumns(['modify'])
		                 ->make(true);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function deleteImage(Request $request)
	{
		$data = $request->validate([
			'id'  => 'required',
		]);

		DeviceImage::find($data['id'])->delete();

		return $data;
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
		$device = Device::find($data['id']);

		$device->update($data);

		$this->addAdditionalData($request, $device);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function add(Request $request)
	{
		$this->validateData($request);

		$data = $request->all();
		$data['company_id'] = auth()->user()->company_id;
		if(!isset($data['taxable'])){
			$data['taxable'] = 0;
		}
		$device = Device::create($data);

		$this->addAdditionalData($request, $device);

		return $device;
	}

	/**
	 * @param Request $request
	 * @param         $device
	 */
	public function addAdditionalData(Request $request, $device)
	{
		if($request->additional_carrier){
			$additionalCarrier = explode(",",$request->additional_carrier);
		}else{
			$additionalCarrier = [];
		}

		if($request->device_to_plan){
			$deviceToPlan = explode(",",$request->device_to_plan);
		}else{
			$deviceToPlan = [];
		}

		if($request->device_to_sim){
			// $deviceToSim = explode(",",$request->device_to_sim);
			$deviceToSim = $request->device_to_sim;
		} else{
			DeviceToSim::where('device_id', $device->id)->delete();
			// $deviceToSim = [];
		}

		if($request->device_to_group){
			$deviceToGroup = explode(",",$request->device_to_group);
		}else{
			$deviceToGroup = [];
		}

		$device->addtionalCarrier()->sync($additionalCarrier);
		$device->deviceToPlan()->sync($deviceToPlan);
		isset($deviceToSim) ? $device->deviceToSim()->sync($deviceToSim) : null;
		$device->deviceToGroup()->sync($deviceToGroup);
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
			'type'           => 'required',
			'carrier_id'     => 'required',
			'amount_w_plan'  => 'required|numeric',
			'amount'         => 'required|numeric',
			'shipping_fee'   => 'required|numeric',
			'show'           => 'required',
			'weight'         => 'nullable|numeric',
		]);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function uploadImage(Request $request)
	{
		$image = $request->file('primary_image');
		$imageData = $this->imageUpload($image);

		$data = ['primary_image' => $imageData['upload_url'].'/'.$imageData['new_name']];

		Device::find($request->id)->update($data);

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return string[]
	 */
	public function deleteDevice(Request $request)
	{
		$data = $request->validate([
			'id'  => 'required',
		]);
		$device = Device::find($data['id']);
		if($device->deviceAssocied() == 0){
			$device->delete();
			return $data;
		}else{
			return ['error' => "Sorry this Device can't be Deleted as it has already been associated with a Order"];
		}
	}

	/**
	 * @return Carrier[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function allAdditionalCarrier()
	{
		return Carrier::all();
	}

	/**
	 * @return mixed
	 */
	public function allDeviceToPlan()
	{
		return Plan::whereCompanyId(auth()->user()->company_id)->get();
	}

	/**
	 * @return mixed
	 */
	public function allDeviceToSim()
	{
		return Sims::whereCompanyId(auth()->user()->company_id)->get();
	}

	/**
	 * @param Request $request
	 */
	public function uploadProductImage(Request $request)
	{
		$newDeviceId = $request->newDeviceId;
		$filename = $request->file('file');
		foreach ($filename as $n => $file) {
			$imageData = $this->imageUpload($file);

			DeviceImage::create(['device_id' => $newDeviceId, 'source' => $imageData['upload_url'].'/'.$imageData['new_name']]);
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return false|string
	 */
	public function descriptionDetailImage(Request $request)
	{
		$image = $request->file('upload');

		$imageData = $this->imageUpload($image);

		$data = [
			'url' => $imageData['upload_url'].'/'.$imageData['new_name'],
			"uploaded" => 1,
			"fileName" => $imageData['new_name'],
		];

		return json_encode($data);
	}


	/**
	 * @param $file
	 *
	 * @return string[]
	 */
	private function imageUpload($file)
	{
		$new_name = Str::random(32) . '.' . $file->getClientOriginalExtension();
		$SystemGlobalSetting = SystemGlobalSetting::first();
		$path = $SystemGlobalSetting->upload_path."/uploads/".Auth::user()->company_id."/device_image/";
		$file->move($path, $new_name);
		$uploadUrl = $SystemGlobalSetting->site_url."/uploads/".Auth::user()->company_id."/device_image/";

		return [
			'upload_url' => $uploadUrl,
			'new_name'   => $new_name
		];
	}
}