<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @package App
 */
class Company extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'company';

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'support_phone_number',
	    'logo',
	    'primary_contact_name',
	    'primary_contact_phone_number',
	    'primary_contact_email_address',
	    'address_line_1',
	    'address_line_2',
	    'city',
	    'state',
	    'zip',
		'usaepay_live',
	    'usaepay_api_key',
	    'usaepay_username',
	    'usaepay_password',
	    'readycloud_api_key',
	    'readycloud_username',
	    'readycloud_password',
	    'tbc_username',
	    'tbc_password',
	    'apex_username',
	    'apex_password',
	    'premier_username',
	    'premier_password',
	    'opus_username',
	    'opus_password',
	    'reseller_status',
	    'name',
	    'url',
	    'carrier_id',
	    'regulatory_label',
	    'default_voice_reg_fee',
	    'default_data_reg_fee',
	    'support_email',
	    'suspend_grace_period',
	    'smtp_driver',
	    'smtp_host',
	    'smtp_port',
	    'smtp_username',
	    'smtp_password',
	    'email_header',
	    'email_footer',
	    'api_key',
	    'selling_devices',
	    'selling_plans',
	    'selling_addons',
	    'selling_sim_standalone',
	    'business_verification',
	    'ultra_username',
	    'ultra_password',
		'enable_bulk_order',
		'invoice_background_text_color',
		'invoice_normal_text_color',
		'invoice_account_summary_primary_color',
		'invoice_account_summary_secondary_color',
		'invoice_solid_line_color',
		'shipping_easy_api_key',
		'shipping_easy_api_secret',
		'shipping_easy_store_api_key',
		'ultra_api_key',
		'ultra_api_secret'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function staff()
    {
    	return $this->hasMany('App\Staff');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function cannedResponse()
    {
    	return $this->hasMany('App\Model\CannedResponse');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function ban()
    {
        return $this->hasMany('App\Model\Ban');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function carrier()
    {
        return $this->belongsToMany('App\Model\Carrier','company_to_carrier','company_id','carrier_id');
    }

	/**
	 * @return string
	 */
	public function getCreatedAtFormattedAttribute()
    {
        if($this->created_at){
            return Carbon::parse($this->created_at)->format('F d, Y');   
        }
        return 'NA';
    }

	/**
	 * @return string|string[]|null
	 */
	public function getSupportPhoneNumberFormattedAttribute()
    {
        if($this->support_phone_number){
            $length = strlen((string)$this->support_phone_number) -6;
            return preg_replace("/^1?(\d{3})(\d{3})(\d{".$length."})$/", "$1-$2-$3", $this->support_phone_number);  
        }
        return 'NA';
    }
}
