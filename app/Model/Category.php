<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'faq_category';
    
	protected $fillable =[ 'name', 'company_id' ];

	public function support()
	{
		return $this->hasMany('App\Model\Support');
	}
}
