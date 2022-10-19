<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CreditToInvoice extends Pivot
{
    protected $table = 'credit_to_invoice';
    
    protected $fillable = [
        'credit_id',
        'invoice_id',
        'amount',
        'description'
    ];
}
