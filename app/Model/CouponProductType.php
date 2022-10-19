<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponProductType extends Model
{
    const TYPES = [
        1 => 'Plan',
        2 => 'Device',
        3 => 'Sim',
        4 => 'Addon'
    ];

    const SUB_TYPES = [
        0 => 'not limited by sub_type',
        1 => 'voice',
        2 => 'data',
        3 => 'wearable',
        4 => 'membership',
        5 => 'digits',
        6 => 'cloud',
        7 => 'iot'
    ];

    protected $table 		= 'coupon_product_type';
    protected $primaryKey	= 'id';

    protected $fillable = [
    	'coupon_id',
    	'amount',
    	'type',
   		'sub_type'
    ];

    public function coupon()
    {
        return $this->belongsTo('App\Model\Coupon');
    }
}