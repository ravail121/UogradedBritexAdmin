<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class CustomerStandaloneSim extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'customer_standalone_sim';

	/**
	 * @var string[]
	 */
	protected $fillable = [
    	'customer_id',
    	'sim_id',
    	'order_id',
    	'status',
    	'tracking_num',
    	'sim_num',
        'shipping_date',
	    'order_num',
        'processed',
	    'closed_date',
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
    public function sim()
    {
        return $this->belongsTo('App\Model\Sims', 'sim_id');
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
