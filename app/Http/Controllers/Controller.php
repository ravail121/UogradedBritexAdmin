<?php

namespace App\Http\Controllers;

use App\Support\Utilities\ApiConnect;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\ActionQueue\DateHtml;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, DateHtml, ApiConnect;

    Const PLAN_TYPE = [
        '1' =>  'Voice',
        '2' =>  'Data',
        '3' =>  'Wearable',
        '4' =>  'Membership',
        '5' =>  'Digits',
        '6' =>  'Cloud',
	    '7' =>  'IoT'
    ];
}
