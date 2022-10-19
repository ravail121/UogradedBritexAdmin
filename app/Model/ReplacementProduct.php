<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReplacementProduct extends Model
{
	/**
	 *
	 */
	const PRODUCT_TYPE = [
		'device'  => 'Device',
		'sim'     => 'Sim'
	];
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'product_id',
		'product_type',
		'company_id'
	];

}