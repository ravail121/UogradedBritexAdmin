<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeviceToSim extends Model
{
    protected $table = 'device_to_sim';
    protected $fillable = ['device_id', 'sim_id'];
}
