<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Sims extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'sim';

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'name',
		'sku',
		'carrier_id',
		'description',
		'notes',
		'amount_alone',
		'amount_w_plan',
		'shipping_fee',
		'show',
		'taxable',
		'image',
		'code',
		'company_id',
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
	public function customerStandAloneSim()
    {
        return $this->hasMany('App\Model\CustomerStandaloneSim','sim_id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subscription()
    {
        return $this->hasMany('App\Model\Subscription','sim_id');
    }

	/**
	 * @return int
	 */
	public function simAssociedCount()
    {
        $count = $this->customerStandAloneSim()->count();
        $count += $this->subscription()->count();

        return $count;
    }

	/**
	 * Remove replacement product associated with this sim
	 * @return void
	 */
	public static function boot() {
		parent::boot();

		static::deleting(function($sim) {
			$replacementProduct = ReplacementProduct::where('product_id', $sim->id)->where('product_type', 'sim')->first();
			if($replacementProduct) {
				$replacementProduct->delete();
			}
		});
	}
}
