<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $table = 'addon';

    protected $fillable = [
        'name', 'sku', 'carrier_id','description', 'notes', 'amount_recurring', 'soc_code', 'bot_code', 'show', 'taxable', 'image', 'company_id',
    ];


}