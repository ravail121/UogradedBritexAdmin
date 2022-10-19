<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SystemEmailTemplateDynamicFields extends Model
{
    protected $table = 'system_email_template_dynamic_field';

    protected $appends = ['format_name'];

    protected $fillable = [
        'code', 'name', 'description',
    ];

    public function getFormatNameAttribute()
    {
    	return "[".$this->name."]";
    }

}
