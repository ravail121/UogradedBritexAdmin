<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    const CLASSES = [
        1 => 'All Products', 
        2 => 'Specific Product Types',
        3 => 'Specific Products Only',
    ];

    const CLASS_TYPES = [
        'all' => 1,
        'types' => 2,
        'products' => 3
    ];

    const FIXED_PERC_TYPES = [
        1 => 'Fixed',      
        2 => 'Percentage', 
    ];

    const STACKABLE = [
        1 => 'Yes',
        2 => 'No',
    ];

    protected $table = 'coupon';

    protected $fillable = [
        'company_id',
        'active',
        'class',
        'fixed_or_perc',
        'amount',
        'name',
        'code',
        'num_cycles',
        'max_uses',
        'num_uses',
        'stackable',
        'start_date',
        'end_date',
        'multiline_min',
        'multiline_max',
        'multiline_restrict_plans',
    ];

    public function customerCoupon()
    {
        return $this->hasMany('App\Model\CustomerCoupon');
    }

    public function couponProducts()
    {
        return $this->hasMany('App\Model\CouponProduct');
    }

    public function couponProductTypes()
    {
        return $this->hasMany('App\Model\CouponProductType');
    }

    public function multilinePlanTypes()
    {
        return $this->hasMany('App\Model\CouponMultilinePlanType');
    }

    public function subscriptionCoupon()
    {
        return $this->hasMany('App\Model\SubscriptionCoupon');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($coupon) {
            $coupon->couponProducts()->delete();
            $coupon->couponProductTypes()->delete();
        });
    }

}
