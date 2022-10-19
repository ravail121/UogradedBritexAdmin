<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderGroup extends Model
{
    protected $table = 'order_group';
    protected $fillable = [
        'order_id', 'device_id', 'sim_id', 'plan_id', 'plan_prorated_amt', 'sim_num', 'sim_type', 'porting_number', 'area_code', 'operating_system', 'imei_number','subscription_id','old_subscription_plan_id','paid','change_subscription',
    ];
}
