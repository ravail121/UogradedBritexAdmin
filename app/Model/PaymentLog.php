<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

const STATUS = [
    'fail'      => 0,
    'success'   => 1,
];

class PaymentLog extends Model
{
	protected $table = 'payment_log';

    protected $fillable = [
        'customer_id', 
        'order_id', 
        'invoice_id', 
        'transaction_num', 
        'processor_customer_num', 
        'status',
        'error',
        'exp',
        'last4',
        'card_type',
        'amount',
        'card_token',
    ]; 

	public function paymentRefundLog()
    {
    	return $this->hasMany('App\Model\PaymentRefundLog', 'payment_log_id')->orderBy('id', 'desc');
    }

    public function getCreatedDateFormattedAttribute()
    {
        if($this->created_at){
            return Carbon::parse($this->created_at)->format('F d, Y');   
        }
        return 'NA';
    }
}
