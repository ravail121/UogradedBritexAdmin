<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use Notifiable;
    
    protected $table = 'customer';

    protected $appends = [
    	'full_name'
    ];

    protected $fillable = [
        'hash',  
        'company_id',
        'business_verification_id',
        'business_verified',
        'fname',
        'lname',
        'password',
        'phone',
        'alternate_phone',
        'pin',
        'email',
        'company_name',
        'subscription_start_date',
        'billing_start',
        'billing_end',
        'primary_payment_method',
        'primary_payment_card',
        'account_suspended',
        'billing_address1',
        'billing_address2', 
        'billing_city',
        'billing_state_id',
        'billing_zip',
        'shipping_fname',
        'shipping_lname',
        'shipping_address1',
        'shipping_address2',
        'shipping_city',
        'shipping_state_id',
        'shipping_zip',
        'auto_pay',
        'billing_fname',
        'billing_lname'
    ];

    public function getFullNameAttribute()
    {
        return $this->fname . ' ' . $this->lname;
    }

    public function getAmountDueAttribute()
    {
        $amountDue = $this->nonCreditInvoice() - $this->credit->sum('amount');
        return number_format((float)$amountDue, 2, '.', '');
    }

    public function getCreditsCountAttribute()
    {
        return abs($this->amount_due);
    }

    public function invoice()
    {
        return $this->hasMany('App\Model\Invoice', 'customer_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function pendingPaymentInvoices()
    {
        return $this->invoice()->pendingPayment();
    }

    public function credit()
    {
        return $this->hasMany('App\Model\Credit', 'customer_id');
    }

    public function customerNote()
    {
        return $this->hasMany('App\Model\CustomerNote', 'customer_id')->orderBy('id', 'desc');
    }

    public function getBillingEndFormattedAttribute()
    {
        if($this->billing_end){
            return Carbon::parse($this->billing_end)->format('M d, Y');   
        }
        return 'NA';
    }

    public function getPhoneNumberFormattedAttribute()
    {
        if($this->phone){
            $length = strlen((string)$this->phone) -6;
            return preg_replace("/^1?(\d{3})(\d{3})(\d{".$length."})$/", "$1-$2-$3", $this->phone);  
        }
        return 'NA';
    }

    public function emailLog()
    {
        return $this->hasMany('App\Model\EmailLog', 'customer_id');
    }

    public function creditsNotAppliedCompletely()
    {
        return $this->credit()->notAppliedCompletely();
    }

    public function nonCreditInvoice()
    {
        $orderAmount = $this->invoice()->customerInvoice()->sum('subtotal');
        $refundAmount = $this->invoice()->refundInvoice()->sum('subtotal');
        $refundAmount = 0;
        return $orderAmount + $refundAmount;
    }

    public function customerCoupons()
    {
        return $this->hasMany('App\Model\CustomerCoupon');
    }

    public function unpaidMounthlyInvoice()
    {
        return $this->invoice()->monthlyInvoicePending();
    }

    public function unpaidAndClosedMounthlyInvoice()
    {
        return $this->invoice()->monthlyInvoiceClosedAndUnpaid();
    }

}

