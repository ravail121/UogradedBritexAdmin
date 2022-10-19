<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BanData extends Model
{
    protected $table = 'ban_data';

    protected $fillable = [
        'id', 'ban_number', 'phone_number', 'tbc_status', 'db_status', 'date_identified'
    ];
}
