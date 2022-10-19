<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fan extends Model
{
    protected $table = 'fan';

    protected $fillable = ['number', 'company_id'];
}
