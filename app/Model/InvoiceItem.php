<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
	protected $table = 'invoice_item';

    protected $fillable = [ 'invoice_id', 'subscription_id', 'product_type', 'product_id', 'type', 'start_date', 'description', 'amount', 'taxable'];

    public function scopeRefundItem($query)
    {
        return $query->whereType('10');
    }
}
