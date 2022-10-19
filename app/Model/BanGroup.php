<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BanGroup extends Model
{
    protected $table = 'ban_group';

    protected $fillable = [
        'name', 'number', 'ban_id', 'data_cap' , 'line_limit'
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
}
