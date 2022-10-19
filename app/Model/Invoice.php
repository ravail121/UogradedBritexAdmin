<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Invoice extends Model
{

	/**
	 * Types of invoices
	 */
	const TYPES = [
		'monthly'   => 1,
		'one-time'  => 2
	];
	/**
	 * Status of invoices
	 */
	const STATUS = [
		'closed_and_unpaid' => 0,
		'pending_payment'   => 1,
		'closed_and_paid'   => 2,
	];

	/**
	 * @var string
	 */
	protected $table = 'invoice';

	/**
	 *
	 * @var string[]
	 */
	protected $fillable = [
		'customer_id',
		'type',
		'status',
		'start_date',
		'end_date',
		'due_date',
		'subtotal',
		'total_due',
		'prev_balance',
		'payment_method',
		'notes',
		'business_name',
		'billing_fname',
		'billing_lname',
		'billing_address_line_1',
		'billing_address_line_2',
		'billing_city',
		'billing_state',
		'billing_zip',
		'shipping_fname',
		'shipping_lname',
		'shipping_address_line_1',
		'shipping_address_line_2',
		'shipping_city',
		'shipping_state',
		'shipping_zip'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function Customer()
	{
		return $this->belongsTo('App\Model\Customer', 'customer_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function invoiceItem()
	{
		return $this->hasMany('App\Model\InvoiceItem', 'invoice_id', 'id');
	}

	/**
	 * @return mixed
	 */
	public function refundInvoiceItem()
	{
		return $this->invoiceItem()->refundItem();
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopePendingPayment($query)
	{
		return $query->whereStatus(self::STATUS['pending_payment']);
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeMonthlyInvoicePending($query)
	{
		return $query->monthly()->pendingPayment();
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeMonthlyInvoiceClosedAndUnpaid($query)
	{
		return $query->monthly()->closedAndUnpaid();
	}

	/**
	 * @return string
	 */
	public function getCreatedDateFormattedAttribute()
	{
		if($this->created_at){
			return Carbon::parse($this->created_at)->format('F d, Y');
		}
		return 'NA';
	}

	/**
	 * @param bool $withDolorSign
	 *
	 * @return mixed|string
	 */
	public function getBillingAmountAttribute($withDolorSign = true)
	{
		if ($withDolorSign) {
			return '$'.number_format($this->subtotal, 2);
		}

		return $this->subtotal;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function order()
	{
		return $this->hasOne('App\Model\Order');
	}

	/**
	 * @return string
	 */
	public function getDueDateFormattedAttribute()
	{
		if($this->due_date){
			return Carbon::parse($this->due_date)->format('M d, Y');
		}
		return 'NA';
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function staff()
	{
		return $this->belongsTo('App\Staff', 'staff_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function usedCredit()
	{
		return $this->belongsToMany('App\Model\Credit', 'credit_to_invoice', 'invoice_id', 'credit_id')->withPivot(['amount', 'description']);
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeOrderInvoice($query)
	{
		return $query->has('order');
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeCustomerInvoice($query)
	{
		return $query->has('customer');
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeRefundInvoice($query)
	{
		return $query->has('refundInvoiceItem');
	}

	/**
	 * @return string
	 */
	public function getTypeDescriptionAttribute()
	{
		$value = $this->type;
		if ($this->type == 2) {
			if ($this->invoiceItem()->where('product_type', 'refund')->count()) {
				return 'Refund';
			}
			return 'One-time invoice';
		}
		return 'Monthly invoice';
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function creditToInvoice()
	{
		return $this->hasMany('App\Model\CreditToInvoice', 'invoice_id', 'id');
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeMonthly($query)
	{
		return $query->where('type', self::TYPES['monthly']);
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeClosedAndUnpaid($query)
	{
		return $query->where('status', self::STATUS['closed_and_unpaid']);
	}

}