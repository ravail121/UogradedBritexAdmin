<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SubscriptionAddon extends Model
{
	protected $table ='subscription_addon';
	protected $fillable = [ 'subscription_id', 'addon_id', 'status', 'removal_date'];

    public function addons()
     {
        return $this->belongsTo('App\Model\Addon', 'addon_id');
     }

    public function subscription()
    {
        return $this->belongsTo('App\Model\Subscription', 'subscription_id');
    }

    public function scopeNotRemoved($query)
    {
        return $query->whereNotIn('status', ['removed']);
    }

    public function getDateSuspendedFormattedAttribute()
    {
        if($this->date_submitted){
            return Carbon::parse($this->date_submitted)->format('F d, Y');   
        }
        return 'NA';
    }

    public function getRemovalDateFormattedAttribute()
    {
        if($this->removal_date){
            return Carbon::parse($this->removal_date)->format('F d, Y');   
        }
        return 'NA';
    }
}
