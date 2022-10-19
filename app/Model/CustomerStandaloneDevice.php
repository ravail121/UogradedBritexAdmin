<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class CustomerStandaloneDevice extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'customer_standalone_device';

	/**
	 * @var string[]
	 */
	protected $fillable = [
    	'customer_id',
    	'device_id',
    	'order_id',
    	'status',
    	'tracking_num',
    	'imei',
        'shipping_date',
	    'order_num',
        'processed',
	    'subscription_id'
    ];

	/**
	 * @var string[]
	 */
	protected $appends = [
        'created_at_formatted'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function device()
    {
        return $this->belongsTo('App\Model\Device', 'device_id');
    }

	/**
	 * @return string
	 */
	public function getCreatedAtFormattedAttribute()
    {
        if($this->created_at){
            return Carbon::parse($this->created_at)->format('F d, Y');   
        }
        return 'NA';
    }
}
