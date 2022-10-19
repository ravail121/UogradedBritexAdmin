<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PaymentRefundLog extends Model
{
	protected $table = 'payment_refund_log';

	protected $fillable = [
        'payment_log_id',
        'transaction_num',
        'error',
        'amount',
        'status',
    ];

    protected $appends = [
    	'amount_formatted',
    	'status_formatted',
        'created_at_formatted',
        'transaction_no_formatted',
    ];

    const STATUS_FORMATED = [
        0 	=>	'FAIL',
        1 	=>	'SUCCESS',
    ];

    public function getAmountFormattedAttribute()
    {
        return number_format($this->amount, 2);
    }

    public function getCreatedAtFormattedAttribute()
    {
        if($this->created_at){
            return Carbon::parse($this->created_at)->format('F d, Y');   
        }
        return 'NA';
    }


    public function getTransactionNoFormattedAttribute()
    {
        if($this->transaction_num){
        	 return $this->transaction_num;
        }
        return 'NA';
    }

    public function getStatusFormattedAttribute()
    {
        return self::STATUS_FORMATED[$this->status];
    }
}
