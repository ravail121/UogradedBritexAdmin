<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlanCustomType extends Model
{
    protected $table = 'plan_custom_type';

    protected $fillable = [
        'company_id', 'plan_id' , 'name'
    ];
}
