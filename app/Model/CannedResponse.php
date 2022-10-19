<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CannedResponse extends Model
{
    protected $table = 'canned_response';

    const SECTION = [
    	'porting' => 2
    ];

    const SECTION_DETAILS = [
        '1' => 'Business Verification Rejection',
        '2' => 'Port Rejection',
        '3' => 'Customer Emails',
    ];

    protected $fillable = [
        'company_id', 'section', 'name', 'subject', 'body'
    ];

    public function scopePorting($query)
    {
    	$query->where('section', self::SECTION['porting']);
    }
}
