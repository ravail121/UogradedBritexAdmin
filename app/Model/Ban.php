<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $table = 'ban';

    protected $fillable = [
        'name', 'number', 'carrier_id', 'billing_start_day', 'fan_id', 'node_id', 'voice_limit', 'data_limit', 'total_limit', 'company_id',
    ];

    public function getCreatedAtFormattedAttribute()
    {
        if($this->created_at){
            return Carbon::parse($this->created_at)->format('F d, Y'); 
        }
        return 'NA';
    }

    public function subcription()
    {
    	return $this->hasMany('App\Model\Subscription');
    }

    public function banGroups()
    {
        return $this->hasMany('App\Model\BanGroup' , 'ban_id');
    }

    public function banGroup()
    {
        return $this->hasOne('App\Model\BanGroup');
    }

    public function getBillingStartDayFormattedAttribute()
    {
        if($this->billing_start_day){
            return Carbon::parse($this->billing_start_day)->format('m/d/Y');
        }
        return 'NA';
    }
}
