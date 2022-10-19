<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlanDataSocBotCode extends Model
{
    protected $table = 'plan_data_soc_bot_code';

    protected $fillable = [
        'plan_id',
        'data_soc_bot_code',
    ];
}
