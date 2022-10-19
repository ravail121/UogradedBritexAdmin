<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PendingCharge extends Model
{
    protected $table = 'pending_charge';
    
    protected $fillable = ['customer_id', 'subscription_id', 'invoice_id', 'type', 'amount', 'description'];
}
