<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Device extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'device';

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'name',
		'sku',
		'tag_id',
		'type',
		'carrier_id',
		'description',
		'description_detail',
		'notes',
		'amount',
		'amount_w_plan',
		'shipping_fee',
		'os',
		'show',
		'sort',
		'taxable',
		'primary_image',
		'associate_with_plan',
		'company_id',
		'weight'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function carrier()
    {
    	return $this->belongsTo('App\Model\Carrier', 'carrier_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function addtionalCarrier()
    {
	    return $this->belongsToMany('App\Model\Carrier','device_to_carrier','device_id','carrier_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function deviceToPlan()
    {
        return $this->belongsToMany('App\Model\Plan','device_to_plan','device_id','plan_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function deviceToSim()
    {
        return $this->belongsToMany('App\Model\Sims','device_to_sim','device_id','sim_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function deviceToGroup()
    {
        return $this->belongsToMany('App\Model\DeviceGroup','device_to_group','device_id','device_group_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function deviceImage()
    {
        return $this->hasMany('App\Model\DeviceImage','device_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function customerStandAloneDevice()
    {
        return $this->hasMany('App\Model\CustomerStandaloneDevice','device_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscription()
    {
        return $this->hasMany('App\Model\Subscription','device_id');
    }

	/**
	 * @return int
	 */
	public function deviceAssocied()
    {
        $count = $this->customerStandAloneDevice()->count();
        $count += $this->subscription()->count();

        return $count;
    }

	/**
	 * Remove replacement product associated with this device
	 * @return void
	 */
	public static function boot() {
		parent::boot();

		static::deleting(function($device) {
			$replacementProduct = ReplacementProduct::where('product_id', $device->id)->where('product_type', 'device')->first();
			if($replacementProduct) {
				$replacementProduct->delete();
			}
		});
	}

}