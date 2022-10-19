<?php

namespace App\Http\Controllers\Report;

use Auth;
use App\Model\Order;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use App\Model\CannedResponse;
use App\Model\SystemGlobalSetting;
use App\Model\BanData;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class TBCReportController extends Controller
{
    public function index(Request $request)
    {
        $details = BanData::where('tbc_status','Active')->where('db_status', '!=', 'active')->orderBy('id', 'desc')->paginate(100);
        $details2 = BanData::where('tbc_status','!=','Active')->where('db_status', 'active')->orderBy('id', 'desc')->paginate(100);
        return view('report/tbc',  compact('details', 'details2'));
    }

}