<?php

namespace App\Model;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 *
 * @package App\Model
 */
class Subscription extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'subscription';

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'order_id',
        'customer_id',
        'plan_id',
        'phone_number',
        'status',
        'sub_status',
        'upgrade_downgrade_status',
        'upgrade_downgrade_date_submitted',
        'port_in_progress',
        'sim_id',
        'sim_name',
        'sim_card_num',
        'old_plan_id',
        'new_plan_id',
        'downgrade_date',
        'tracking_num',
        'device_id',
        'device_os',
        'device_imei',
        'subsequent_porting',
        'requested_area_code',
        'ban_id',
        'ban_group_id',
        'activation_date',
        'suspended_date',
        'closed_date',
        'shipping_date',
        'processed',
        'restoration_date',
        'scheduled_suspend_date',
        'scheduled_close_date',
        'label',
		'requested_zip'
    ];

	/**
	 * @var string[]
	 */
	protected $appends = [
        'tracking_num_formatted',
        'phone_number_formatted',
        'upgrade_date_formatted',
        'downgrade_date_formatted',
        'created_at_formatted'
    ];

	/**
	 *
	 */
	const SUBSTATUS = [
        'active'            => 'active',
        'suspend-scheduled' => 'suspend-scheduled',
        'close-scheduled'   => 'close-scheduled',
    ];

	/**
	 *
	 */
	const STATUS = [
		'suspended'  => 'suspended',
		'closed'     => 'closed',
		'active'     => 'active',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function ban()
    {
        return $this->belongsTo('App\Model\Ban', 'ban_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function banGroup()
    {
        return $this->belongsTo('App\Model\BanGroup', 'ban_group_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function device()
    {
        return $this->belongsTo('App\Model\Device', 'device_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orderNumber()
    {
        return $this->HasMany('App\Model\Order', 'order_num' , 'order_num')->where('company_id',auth()->user()->company_id);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sim()
    {
        return $this->belongsTo('App\Model\Sims', 'sim_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function plans()
    {
        return $this->belongsTo('App\Model\Plan', 'plan_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function oldPlan()
    {
        return $this->belongsTo('App\Model\Plan', 'old_plan_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function newPlan()
    {
        return $this->belongsTo('App\Model\Plan', 'new_plan_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }

	/**
	 * @return string
	 */
	public function getDowngradeDateFormattedAttribute()
    {
        if($this->downgrade_date){
            return Carbon::parse($this->downgrade_date)->format('F d, Y');   
        }
        return 'NA';
    }

	/**
	 * @return string
	 */
	public function getActivationDateFormattedAttribute()
    {
        if($this->activation_date){
            return Carbon::parse($this->activation_date)->format('F d, Y');   
        }
        return 'NA';
    }

	/**
	 * @return mixed|string
	 */
	public function getTrackingNumFormattedAttribute()
    {
        return $this->tracking_num ?: 'NA';
    }

	/**
	 * @return string
	 */
	public function getUpgradeDateFormattedAttribute()
    {
        if($this->upgrade_downgrade_date_submitted){
            return Carbon::parse($this->upgrade_downgrade_date_submitted)->format('F d, Y'); 
        }
        return 'NA';
    }

	/**
	 * @return string
	 */
	public function getPastDueDateFormattedAttribute()
    {
        if($this->account_past_due_date){
            return Carbon::parse($this->account_past_due_date)->format('F d, Y'); 
        }
        return 'NA';
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function port()
    {
        return $this->hasOne('App\Model\Port');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function addons()
    {
        return $this->hasMany('App\Model\Addon');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscriptionAddon()
    {
        return $this->hasMany('App\Model\SubscriptionAddon', 'subscription_id', 'id');
    }

	/**
	 * @return mixed
	 */
	public function subscriptionAddonNotRemoved()
    {
        return $this->subscriptionAddon()->notRemoved();
    }

	/**
	 * @return mixed
	 */
	public function getNamesOfSubscriptionAddonNotRemovedAttribute()
    {
        return $this->subscriptionAddonNotRemoved->load('addons')->pluck('addons.name');
    }

	/**
	 * @return string
	 */
	public function getSuspendedDateFormattedAttribute()
    {
        if($this->suspended_date){
            return Carbon::parse($this->suspended_date)->format('F d, Y');   
        }
        return 'NA';
    }

	/**
	 * @return string
	 */
	public function getClosedDateFormattedAttribute()
    {
        if($this->closed_date){
            return Carbon::parse($this->closed_date)->format('F d, Y');   
        }
        return 'NA';
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscriptionCoupon()
    {
        return $this->hasMany('App\Model\SubscriptionCoupon', 'subscription_id', 'id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscriptionBlock()
    {
        return $this->hasMany('App\Model\SubscriptionBlock', 'subscription_id');
    }

	/**
	 * @return string|string[]|null
	 */
	public function getPhoneNumberFormattedAttribute()
    {
        if($this->phone_number){
            $length = strlen((string)$this->phone_number) -6;
            return preg_replace("/^1?(\d{3})(\d{3})(\d{".$length."})$/", "$1-$2-$3", $this->phone_number);  
        }
        return 'NA';
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