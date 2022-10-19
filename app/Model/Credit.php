<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $table = 'credit';

    protected $fillable = [
        'customer_id',
        'amount',
        'applied_to_invoice',
        'type',
        'date',
        'payment_method',
        'description',
        'account_level',
        'subscription_id',
        'staff_id',
        'order_id',
    ];

    public function Customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }

    public function getCreatedDateFormattedAttribute()
    {
        if ($this->created_at) {
            return Carbon::parse($this->created_at)->format('F d, Y');
        }

        return 'NA';
    }

    public function getTypeDescriptionAttribute()
    {
        $value = $this->type;
		if($value == 1 && $this->staff_id == 5) {
			return 'Auto Payment';
		}elseif ($value == 1) {
            return 'Payment';
        }
        elseif ($value == 2) {
            return 'Manual Credit';
        }
        return 'Closed Invoice';
    }

    public function getBillingAmountAttribute($withDolorSign = true)
    {
        if ($withDolorSign) {
            return '$'.number_format($this->amount, 2);
        }

        return $this->amount;
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff', 'staff_id');
    }

    public function usedCredit()
    {
        return $this->belongsToMany('App\Model\Invoice', 'credit_to_invoice', 'credit_id', 'invoice_id')->withPivot(['amount', 'description']);
    }

    public function scopeNotAppliedCompletely($query)
    {
        return $query->where('applied_to_invoice', 0);
    }

    public function usedOnInvoices()
    {
        return $this->hasMany('App\Model\CreditToInvoice', 'credit_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Model\Invoice', 'invoice_id' ,'id');
    }

}