<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailTemplate
 *
 * @package App\Model
 */
class EmailTemplate extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'email_template';

	/**
	 * @var string[]
	 */
	protected $fillable = [
        'company_id',
	    'code',
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
	 * @param      $strings
	 * @param      $data
	 * @param null $url
	 *
	 * @return array|mixed|string|string[]
	 */
	public function body($strings, $data, $url = null)
	{
    	$replaceWith = [$data->fname, $data->lname, $data->business_name, $url];
    	$body = str_replace($strings, $replaceWith, $this->body);
    	return $body;
    }

	/**
	 * @param      $strings
	 * @param      $replaceWith
	 * @param null $body
	 *
	 * @return array|string|string[]
	 */
	public function newBody($strings, $replaceWith, $body = null)
	{
        $body = str_replace($strings, $replaceWith, $body ?: $this->body);
        return $body;
    }
}
