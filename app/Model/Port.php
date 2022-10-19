<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Port
 *
 * @package App\Model
 */
class Port extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'port';

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'subscription_id',
        'status', 
        'notes',
        'number_to_port',
        'company_porting_from',
        'account_number_porting_from',
        'authorized_name',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'zip',
        'ssn_taxid',
        'account_pin_porting_from',
    ];

	/**
	 *
	 */
	const STATUS = [
        'pending'       => '1',
        'submitted'     => '2',
        'complete'      => '3',
        'error'         => '4',
        'cancelled'     => '5'
    ];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function subscription()
    {
        return $this->belongsTo('App\Model\Subscription', 'subscription_id');
    }

	/**
	 * @return string|string[]|null
	 */
	public function getNumberToPortFormattedAttribute()
    {
        if($this->number_to_port){
            $length = strlen((string)$this->number_to_port) -6;
            return preg_replace("/^1?(\d{3})(\d{3})(\d{".$length."})$/", "$1-$2-$3", $this->number_to_port);  
        }
        return 'NA';
    }
}
