<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{
    protected $table = 'customer_note';

    protected $fillable = [
    	'customer_id',
    	'staff_id',
    	'date',
    	'text',
    ];

    public function staff()
    {
    	return $this->belongsTo('App\Staff', 'staff_id');
    }

    public function getFullNameAttribute()
    {
        return $this->fname . ' ' . $this->lname;
    }

    public function getCreatedDateFormattedAttribute()
    {
        if($this->created_at){
            return Carbon::parse($this->created_at)->format('F d, Y');   
        }
        return 'NA';
    }
}
