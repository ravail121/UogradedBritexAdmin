<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubscriptionBlock extends Model
{
	protected $table = 'subscription_block';
	protected $fillable = [ 'is_on'];

	public function carrierBlock()
    {
        return $this->belongsTo('App\Model\CarrierBlock', 'carrier_block_id');
    }
}
