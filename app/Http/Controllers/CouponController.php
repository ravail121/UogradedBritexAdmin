<?php

namespace App\Http\Controllers;

use DataTables;
use App\Model\Sims;
use App\Model\Plan;
use App\Model\Addon;
use App\Model\Device;
use App\Model\Coupon;
use App\Model\CouponProduct;
use Illuminate\Http\Request;
use App\Model\CouponProductType;
use App\Model\CouponMultilinePlanType;
use App\Model\Subscription;
use App\Model\SubscriptionCoupon;

/**
 * Class CouponController
 *
 * @package App\Http\Controllers
 */
class CouponController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		$class = Coupon::CLASSES;
		$fixedPercentage = Coupon::FIXED_PERC_TYPES;
		$stackable = Coupon::STACKABLE;
		$productType = CouponProduct::PRODUCT_TYPES;
		$couponProductType = CouponProductType::TYPES;
		$subType = CouponProductType::SUB_TYPES;
		return view('coupon.index', compact('class', 'fixedPercentage', 'stackable', 'productType', 'subType', 'couponProductType', 'multiline'));
	}

	/**
	 * @return mixed
	 */
	public function getAllCoupons()
	{
		$coupon = Coupon::whereCompanyId(auth()->user()->company_id)->with('couponProducts', 'couponProductTypes', 'multilinePlanTypes')->get();
		return DataTables::of($coupon)
		                 ->addColumn('id', function($coupon) {
			                 return $coupon->id;
		                 })
		                 ->addColumn('status', function($coupon) {
			                 return $coupon->active;
		                 })
		                 ->addColumn('name', function($coupon) {
			                 return $coupon->name;
		                 })
		                 ->addColumn('cycles', function($coupon) {
			                 return $coupon->num_cycles;
		                 })
		                 ->addColumn('class', function($coupon) {
			                 return $coupon->class;
		                 })
		                 ->addColumn('amount', function($coupon) {
			                 if($coupon->fixed_or_perc == 2) {
				                 return $coupon->amount.'%';
			                 }else {
				                 return '$ '.number_format($coupon->amount, 2);
			                 }
		                 })
		                 ->addColumn('start-date', function($coupon) {
			                 return $coupon->start_date;
		                 })
		                 ->addColumn('end-date', function($coupon) {
			                 return $coupon->end_date;
		                 })
		                 ->addColumn('modify', function($coupon) {
			                 return '<div class="actionbtn">
                            <div class="dropdown"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#updateshipping"> Edit </a> </div>
                            <div class="dropdown"> <a class="btn delete-btn" data-id ='.$coupon->id.' > Delete </a> </div>
                        </div>';
		                 })
		                 ->addColumn('all-data', function($coupon) {
			                 return htmlspecialchars(json_encode($coupon));
		                 })

		                 ->rawColumns(['modify'])
		                 ->make(true);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function add(Request $request)
	{
		$data = $this->validateData($request);
		$input = $request->only(['addon_id', 'sim_id', 'device_id', 'product_id']);
		foreach ($input as  $value) {
			if($value != null) {
				$data['product_id'] = $value;
			}
		}
		if($request->has('multiline_restrict_plans') && $data['multiline_restrict_plans']) {
			$data['plan_type'] = $data['multiline_restrict_plans'];
			$data['multiline_restrict_plans'] = true;
		}
		$data['company_id'] = auth()->user()->company_id;
		$coupon     = Coupon::create($data);
		$additional = $this->addAdditionalData($data, $coupon);
		return $coupon;
	}

	/**
	 * @return mixed
	 */
	public function allAddonToAddon()
	{
		return Addon::whereCompanyId(auth()->user()->company_id)->get();
	}

	/**
	 * @return mixed
	 */
	public function allPlanToAddon()
	{
		return Plan::whereCompanyId(auth()->user()->company_id)->get();
	}

	/**
	 * @return mixed
	 */
	public function allDeviceToAddon()
	{
		return Device::whereCompanyId(auth()->user()->company_id)->get();
	}

	/**
	 * @return mixed
	 */
	public function allSimToAddon()
	{
		return Sims::whereCompanyId(auth()->user()->company_id)->get();
	}

	/**
	 * @return array
	 */
	public function allCouponMultilinePlanType()
	{
		$data = [];

		$couponMultilinePlanType =  CouponMultilinePlanType::PLAN_TYPES;
		foreach ($couponMultilinePlanType as $key => $value) {
			array_push($data, ['name' => $value, 'id' => $key]);
		}

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function edit(Request $request)
	{
		$data = $this->validateData($request, $request->id);
		$input = $request->only(['addon_id', 'sim_id', 'device_id', 'product_id']);
		foreach ($input as  $value) {
			if($value != null) {
				$data['product_id'] = $value;
			}
		}
		if($data['multiline_restrict_plans']) {
			$data['plan_type'] = $data['multiline_restrict_plans'];
			$data['multiline_restrict_plans'] = true;
		}

		$data['id'] = $request->id;
		$coupon = Coupon::find($data['id']);
		$coupon->update($data);

		$this->updateAdditionalData($data, $coupon);

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
		$coupon = Coupon::find($data['id']);
		if ($coupon->customerCoupon->count()) {
			$count = $coupon->customerCoupon->count();
			$customers = $count > 1 ? ' customers.' : ' customer.';
			return ['error' => 'This coupon is used by '.$count.$customers ];
		} elseif ($coupon->subscriptionCoupon->count()) {
			$count = $coupon->subscriptionCoupon->count();
			$customers = $count > 1 ? ' customers.' : ' customer.';
			return ['error' => 'This coupon is used by '.$count.$customers ];
		} else {
			$coupon->delete();
		}
		// Coupon::find($data['id'])->delete();

		return $data;
	}

	/**
	 * @param $data
	 * @param $coupon
	 */
	public function addAdditionalData($data, $coupon)
	{
		if($data['type'] != '' && $data['sub_type'] != '') {
			$coupon->couponProductTypes()->create($data);
		}

		if($data['product_type'] !='' && $data['product_id'] != '') {
			$productId = explode(",", $data['product_id']);
			foreach($productId as $value) {
				$data['product_id'] = $value;
				$coupon->couponProducts()->create($data);
			}
		}

		if(isset($data['plan_type']) && $data['plan_type']) {
			$multiline = explode(",",$data['plan_type']);
			foreach ($multiline as $value) {
				$data['plan_type'] = $value;
				$coupon->multilinePlanTypes()->create($data);
			}
		}
	}

	/**
	 * @param $data
	 * @param $coupon
	 */
	public function updateAdditionalData($data, $coupon)
	{
		if($data['type'] != '' && $data['sub_type'] != '') {
			$this->updateProductType($data, $coupon);
		} else if($data['product_type'] != '' && isset($data['product_id']) && $data['product_id'] != '') {
			$this->updateCouponProducts($data, $coupon);
		}
		if(array_key_exists('plan_type', $data)) {
			$this->updateMultilinePlanTypes($data, $coupon);
		}
	}

	/**
	 * @param $data
	 * @param $coupon
	 */
	public function updateProductType($data, $coupon) {
		$productType['type']     = $data['type'];
		$productType['sub_type'] = $data['sub_type'];
		$productType['amount']   = $data['amount'];
		$coupon->couponProductTypes()->update($productType);
	}

	/**
	 * @param $data
	 * @param $coupon
	 */
	public function updateCouponProducts($data, $coupon) {
		$productIds = explode(",", $data['product_id']);
		$coupon->couponProducts()->delete();
		foreach($productIds as $productId) {
			$couponProduct['product_type'] = $data['product_type'];
			$couponProduct['product_id']   = $productId;
			$couponProduct['amount']       = $data['amount'];
			$coupon->couponProducts()->create($couponProduct);
		}
	}

	/**
	 * @param $data
	 * @param $coupon
	 */
	public function updateMultilinePlanTypes($data, $coupon) {
		$multiline = explode(",",$data['plan_type']);
		$coupon->multilinePlanTypes()->delete();
		foreach ($multiline as $value) {
			$data['plan_type'] = $value;
			$coupon->multilinePlanTypes()->create($data);
		}
	}

	/**
	 * @param Request $request
	 * @param int     $id
	 *
	 * @return mixed
	 */
	public function validateData(Request $request, $id =0)
	{
		$data=$request->validate([
			'active'                   => '',
			'class'                    => 'required',
			'type'                     => 'nullable',
			'sub_type'                 => 'nullable',
			'product_type'             => 'nullable',
			'fixed_or_perc'            => 'required',
			'amount'                   => 'required',
			'name'                     => 'required',
			'code'                     => 'required|unique:coupon,code,'.$id,
			'num_cycles'               => 'required',
			'max_uses'                 => 'required',
			'num_uses'                 => 'required',
			'stackable'                => 'required',
			// 'start_date'               => 'date',
			// 'end_date'                 => 'date',
			'multiline_max'            => 'nullable',
			'multiline_min'            => 'nullable',
			'multiline_restrict_plans' => 'nullable',
			'plan_type'                => 'nullable',
		]);

		if(!array_key_exists('active', $data)) {
			$data['active'] = 0;
		}

		return $data;
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function checkCoupon(Request $request)
	{
		$count = Coupon::where([['code', $request->code],['id', '!=', $request->id],['company_id', auth()->user()->company_id]])->count();
		return ($count > 0 ) ? 'false' : 'true';
	}

	/**
	 * @param Request $request
	 *
	 * @return array|null[]
	 */
	public function getCoupons(Request $request)
	{
		$subscription = Subscription::find($request->subscription_id);
		if(is_null($subscription)) {
			return [
				'subscription_coupons' => null,
				'customer_coupons' => null
			];
		}
		$customer = $subscription->customer;
		$customerCoupons = $customer->customerCoupons;
		$customerCoupons = $this->getCouponCodes($customerCoupons, $subscription);
		$subscriptionCoupons = $this->getCouponCodes($subscription->subscriptionCoupon, $subscription);
		return [
			'subscription_coupons' => $subscriptionCoupons,
			'customer_coupons' => $customerCoupons
		];
	}

	/**
	 * @param $coupons
	 * @param $subscription
	 *
	 * @return array|null
	 */
	protected function getCouponCodes($coupons, $subscription)
	{
		$data = [];
		foreach ($coupons as $c) {
			$couponData = $c->coupon;
			if ($couponData) {
				if ($couponData->multiline_restrict_plans) {
					$types = $couponData->multilinePlanTypes->pluck('plan_type')->toArray();
					if (in_array($subscription->plans->type, $types)) {
						$data[] = [
							'code' => $couponData->code,
							'cycles_remaining' => $c->cycles_remaining,
							'id' => $c->id
						];
					}
				} else {
					$data[] = [
						'code' => $couponData->code,
						'cycles_remaining' => $c->cycles_remaining,
						'id' => $c->id
					];
				}
			}
		}
		return count($data) ? $data : null;
	}

	/**
	 * @param Request $request
	 *
	 * @return \App\Support\Utilities\Collection
	 */
	public function applyCoupon(Request $request)
	{
		return $this->requestConnection('coupon/add-coupon', 'post', [
			'code'              => $request->code,
			'customer_id'       => $request->customer_id,
			'subscription_id'   => $request->subscription_id
		]);
	}

	/**
	 * @param Request $request
	 */
	public function deleteCoupon(Request $request)
	{
		$type = $request->type;
		$couponId = $request->coupon_id;
		if ($type == 1) {
			SubscriptionCoupon::find($couponId)->delete();
		}
	}
}
