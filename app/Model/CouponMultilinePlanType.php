<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponMultilinePlanType extends Model
{
    const PLAN_TYPES = [
        1 => 'voice',
        2 => 'data',
        3 => 'wearable',
        4 => 'membership',
        5 => 'digits',
        6 => 'cloud',
        7 => 'Iot',
    ];

    protected $table = 'coupon_multiline_plan_type';
    
    protected $appends = ['name'];

    protected $fillable = [
        'coupon_id',
        'plan_type'
    ];

    public function getNameAttribute()
    {
        return self::PLAN_TYPES[$this->plan_type] ?? null;

    }

    public function coupon()
    {
        return $this->belongsTo('App\Model\Coupon');
    }
}
