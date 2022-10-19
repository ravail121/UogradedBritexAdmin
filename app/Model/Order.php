<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

   	protected $table = 'order';

    protected $appends = [
        'full_address',
        'full_shipping_name',
        'date_processed_formatted'
    ];

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'active_group_id',
		'active_subscription_id',
		'order_num',
		'status',
		'invoice_id',
		'hash',
		'company_id',
		'customer_id',
		'date_processed',
		'shipping_fname',
		'shipping_lname',
		'shipping_address1',
		'shipping_address2',
		'shipping_city',
		'shipping_state_id',
		'shipping_zip'
	];

   	public function bizVerification()
    {
        return $this->hasOne(BusinessVerification::class);
    }

    public function company()
    {
        return $this->hasOne('App\Model\Company', 'id', 'company_id');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Model\Subscription', 'order_id', 'id');
    }

    public function getFullAddressAttribute()
    {
        return $this->shipping_address1 . ' ' . $this->shipping_address2.'<br>'.$this->shipping_city.' '.$this->shipping_state_id.' '.$this->shipping_zip;
    }

    public function getFullShippingNameAttribute()
    {
        return $this->shipping_fname . ' ' . $this->shipping_lname;
    }

    public function getDateProcessedFormattedAttribute()
    {
        if($this->date_processed){
            return Carbon::parse($this->date_processed)->format('F d, Y');   
        }
        return 'NA';
    }
    
    public function customer()
    {
        return $this->hasOne('App\Model\Customer', 'id', 'customer_id');
    }
}