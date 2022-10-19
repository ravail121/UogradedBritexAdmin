<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Plan
 *
 * @package App\Model
 */
class Plan extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'plan';

	/**
	 * @var int[]
	 */
	protected $attributes = [
        'associate_with_device' => 0,
    ];

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'name',
	    'sku',
	    'carrier_id',
	    'description',
	    'notes',
	    'signup_porting',
	    'imei_required',
	    'require_device_info',
	    'show',
	    'taxable',
	    'image',
	    'subsequent_porting',
	    'data_limit',
	    'amount_recurring',
	    'amount_onetime',
	    'tag_id',
	    'area_code',
	    'rate_plan_soc',
	    'rate_plan_bot_code',
	    'regulatory_fee_type',
	    'type',
	    'sim_required',
	    'affilate_credit',
	    'primary_image',
	    'data_soc',
	    'regulatory_fee_amount',
	    'associate_with_device',
	    'company_id',
	    'auto_add_coupon_id',
		'subsequent_zip',
		'own_sim_card_option'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function carrier()
    {
    	return $this->belongsTo('App\Model\Carrier', 'carrier_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function planDataSocBotCode()
    {
    	return $this->hasMany('App\Model\PlanDataSocBotCode', 'plan_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function planCustomType()
    {
    	return $this->hasMany('App\Model\PlanCustomType', 'plan_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sims()
    {
        return $this->hasMany('App\Model\Sims', 'carrier_id', 'carrier_id')->where('company_id', auth()->user()->company_id);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function planToAddon()
    {
        return $this->belongsToMany('App\Model\Addon','plan_to_addon','plan_id','addon_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function planBlock()
    {
        return $this->belongsToMany('App\Model\CarrierBlock','plan_block','plan_id','carrier_block_id');
    }
}
