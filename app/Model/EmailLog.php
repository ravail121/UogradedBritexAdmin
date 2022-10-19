<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailLog
 *
 * @package App\Model
 */
class EmailLog extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'email_log';

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'company_id',
	    'customer_id',
	    'staff_id',
	    'business_verficiation_id',
	    'type',
	    'from',
	    'to',
	    'subject',
	    'body',
	    'notes',
	    'reply_to',
	    'cc',
	    'bcc'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function staff()
    {
        return $this->belongsTo('App\Staff', 'staff_id');
    }

	/**
	 * @return string
	 */
	public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y');
    }
}
