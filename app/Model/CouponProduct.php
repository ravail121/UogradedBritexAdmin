<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    const PRODUCT_TYPES = [
        1 => 'plan',   
        2 => 'device', 
        3 => 'sim',    
        4 => 'addon'  
    ];

    protected $table = 'coupon_product';
    
    protected $appends = ['product'];

    protected $fillable = [
        'coupon_id',
        'amount',
        'product_id',
        'product_type'
    ];


    public function coupon()
    {
        return $this->belongsTo('App\Model\Coupon');
    }

    public function getProductAttribute()
    {
        $product = "\App\Model\\" . ucfirst(self::PRODUCT_TYPES[$this->product_type]);

        if($product == "\App\Model\Sim") {
            $product = "\App\Model\Sims";
        }

		$productDetail = $product::find($this->product_id);
        return $productDetail->name ?? '';
    }
}
