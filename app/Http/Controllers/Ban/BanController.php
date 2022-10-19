<?php

namespace App\Http\Controllers\Ban;

use DataTables;
use App\Company;
use App\Model\Ban;
use App\Model\Fan;
use Carbon\Carbon;
use App\Model\Node;
use App\Model\BanGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    public function index()
    {
        return view('ban.index');
    }

    public function show()
    {
        $ban = Ban::whereCompanyId(auth()->user()->company_id)->with('subcription.plans', 'banGroup')->get();
        return DataTables::of($ban)
            ->addColumn('carrier', function($ban) {
                return  '<img src="'.asset($this->carrierImage($ban->carrier_id)).'" alt="NA" width="25" height="25">';
            })
            ->addColumn('created_at', function($ban) {
                return $ban->getCreatedAtFormattedAttribute();
            })
            ->addColumn('voice_subscription', function($ban) {
                return $ban->subcription->where('status', '<>', 'close')->pluck('plans')->where('type', '1')->count();
            })
            ->addColumn('voice_limit', function($ban) {
                if($ban->voice_limit){
                    return $ban->voice_limit;
                }
                return 'NA';
            })
            ->addColumn('voice_avaliable', function($ban) {
                if($ban->voice_limit){
                    return $ban->voice_limit - $ban->subcription->where('status', '<>', 'close')->pluck('plans')->where('type', '1')->count();
                }
                return 'NA';
            })
            ->addColumn('data_subscription', function(Ban $ban) {
                return $ban->subcription->where('status', '<>', 'close')->pluck('plans')->where('type', '<>', '1')->count();
            })
            ->addColumn('total_subscription', function(Ban $ban) {
                return $ban->subcription->where('status', '<>', 'close')->count();
            })
            ->addColumn('all-data', function($ban) {
                return $ban;
            })
            
            ->rawColumns(['carrier'])
            ->make(true);
    }

    public function checkCarrier($companyId)
    {
        return Company::whereId($companyId)->with('carrier')->first();
    }

    public function allNode()
    {
        return Node::whereCompanyId(auth()->user()->company_id)->get();
    }

    public function allFan()
    {
        return Fan::whereCompanyId(auth()->user()->company_id)->get();
    }

    public function insertNode(Request $request)
    {
        $data=$request->validate([
            'number'    => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;

        return Node::create($data);
    }

    public function insertFan(Request $request)
    {
        $data=$request->validate([
            'number'    => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;

        return Fan::create($data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'carrier_id'        => 'required',
            'name'              => 'required',
            'number'            => 'required',
            'billing_start_day' => 'required',
        ]);

        $data['fan_id'] = $request->fan_id;
        $data['node_id'] = $request->node_id;
        $data['voice_limit'] = $request->voice_limit;
        $data['data_limit'] = $request->data_limit;
        $data['total_limit'] = $request->total_limit;
        $data['company_id'] = auth()->user()->company_id;
        // $data['billing_start_day'] = Carbon::parse($data['billing_start_day']);

        $ban = Ban::create($data);

        // if($ban){
        //     session(['status'=> 'Ban Created Sucessfully']);
        // }

        return $ban;
    }

    public function banDetail($ban)
    {
        $ban = Ban::whereId($ban)->with('banGroups')->first();
        $voiceSubcription = $ban->subcription->where('status', '<>', 'close')->pluck('plans')->where('type', '1')->count();

        $voiceAvaliable = $ban->voice_limit - $voiceSubcription;

        $dataSubcription = $ban->subcription->where('status', '<>', 'close')->pluck('plans')->where('type', '<>', '1')->count();

        $fan = $this->allFan()->pluck('number', 'id')->toArray();

        $node = $this->allNode()->pluck('number', 'id')->toArray();

        return view('ban.ban-detail', compact('ban', 'voiceSubcription', 'voiceAvaliable', 'dataSubcription','fan', 'node'));
    }

    public function banGroupDetail(BanGroup $banGroup)
    {
        $ban = Ban::whereCompanyId(auth()->user()->company_id)->pluck('number', 'id')->toArray();

        return view('ban.ban-group-detail', compact('banGroup', 'ban'));
    }

    public function editBan(Request $request)
    {
        $data = $request->all();
        // $data['billing_start_day'] = Carbon::parse($data['billing_start_day']);
        $ban = Ban::find($request->id)->update($data);
        if($ban){
            session(['status'=> 'Ban Edited Sucessfully']);
        }
        return $data;
    }

    public function banGroupsubcription($banGroupId)
    {
        $banGroup = BanGroup::whereId($banGroupId)->with('subcription')->first();

        return DataTables::of($banGroup->subcription)
        ->addColumn('name', function($detail) {
            return '<a href = '.route("customers.detail", $detail->customer["id"]).'>
                                <strong>'.$detail->customer['full_name'].'</strong>';
        })
        ->addColumn('address', function($detail) {
                return $detail->order->full_address;
        })
        ->addColumn('plan-type', function($detail) {
            return '<div class="plan-type">
                        '.self::PLAN_TYPE[$detail->plans->type].'
                    </div>';
        })
        ->addColumn('plan-name', function($detail) {
            return $detail->plans->name;
        })
        ->rawColumns(['plan-type','address', 'name'])
        ->make(true);
    }

    public function createBanGroup(Request $request)
    {
        $data = $request->validate([
            'ban_id'        => 'required',
            'name'          => 'required',
            'number'        => 'required',
            'data_cap'      => 'required',
            'line_limit'    => 'required',
        ]);
        $banGroup = BanGroup::create($data);
        if($banGroup){
            session(['status'=> 'Ban Group Created Sucessfully']);
        }
        return $banGroup;
    }

    public function editBanGroup(Request $request)
    {
        $data = $request->validate([
            'ban_id'        => 'required',
            'id'            => 'required',
            'name'          => 'required',
            'number'        => 'required',
            'data_cap'      => 'required',
            'line_limit'    => 'required',
        ]);
        $banGroup = BanGroup::find($data['id'])->update($data);
        if($banGroup){
            session(['status'=> 'Ban Group Updated Sucessfully']);
        }
        return $data;
    }

    public function banDetailsDatatable($banId)
    {
        $ban = Ban::whereId($banId)->with('banGroups')->first();

        return DataTables::of($ban->banGroups)
        ->addColumn('created_at', function($detail) {
                return $detail->created_at_formatted;
        })
        ->addColumn('line_in_group', function($detail) {
            return  $detail->subcription->where('status', '<>', 'close')->count();
        })
        ->addColumn('null', function($detail) {
            return '0';
        })
        ->rawColumns([])
        ->make(true);
    }

    public function banSubcriptionDatatable($banId)
    {
        $ban = Ban::whereId($banId)->with('subcription')->first();

        return DataTables::of($ban->subcription)
        ->addColumn('name', function($detail) {
            return '<a href = '.route("customers.detail", $detail->customer["id"]).'>
                                <strong>'.$detail->customer['full_name'].'</strong>';
        })
        ->addColumn('address', function($detail) {
            return $detail->order->full_address;
        })
        ->addColumn('plan-type', function($detail) {
            return '<div class="plan-type">
                        '.self::PLAN_TYPE[$detail->plans->type].'
                    </div>';
        })
        ->addColumn('plan-name', function($detail) {
            return $detail->plans->name;
        })->addColumn('addon', function($detail) {
            return 'NA';
        })
        ->rawColumns(['name', 'plan-type', 'address'])
        ->make(true);
    }

}