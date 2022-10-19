<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $table = 'node';

    protected $fillable = ['number', 'company_id'];
}
