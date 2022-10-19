<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CronLog extends Model {

	protected $fillable = [
		'name',
		'status',
		'payload',
		'response'
	];

	/**
	 * @return string
	 */
	public function getRanAtDateFormattedAttribute()
	{
		if($this->ran_at){
			return Carbon::parse($this->ran_at)->format('Y-m-d h:i:s');
		}
		return 'NA';
	}
}