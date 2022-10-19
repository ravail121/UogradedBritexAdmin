<?php

namespace App\Model;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BusinessVerification extends Model
{
    use Notifiable;
    
    const TYPES = [
      'approved' => 0,
    ];

    const APPROVED =[
        'approved' => 1,
        'pending'  => 0,
    ];

	protected $table = 'business_verification'  ;
    
	protected $fillable =[ 'order_id', 'approved' , 'hash' ,'tax_id', 'fname', 'lname', 'email' , 'business_name' ];

    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }

    public function scopeHash($query, $hash)
    {
        return $query->where('hash', $hash);
    }

    public function getFullNameAttribute()
    {
        return $this->fname . ' ' . $this->lname;
    }

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y');
    }

    public function businessVerificationDoc()
    {
        return $this->hasMany(BusinessVerificationDoc::class, 'bus_ver_id');
    }

    public function companyId()
    {
        return $this->hasOne('App\Model\Company', 'id', 'company_id');
    }

    public function getIsApprovedAttribute(){
        return $this->approved == self::TYPES['approved'];
    }

}
