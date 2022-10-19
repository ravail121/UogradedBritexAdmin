<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeviceImage extends Model
{
	protected $table = 'device_image';

	protected $fillable = [
        'device_id', 'source'
    ];
}
