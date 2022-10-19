<?php

namespace App\Http\Controllers;

use App\Model\Ban;
use Illuminate\Http\Request;
use App\Model\CannedResponse;
use App\Model\SubscriptionAddon;
use Illuminate\Database\Eloquent\Collection;
use App\Support\DataProviders\StatesProvider;

/**
 * Class ActionQueueController
 *
 * @package App\Http\Controllers
 */
class ActionQueueController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
    {
        $ban = Ban::whereCompanyId(auth()->user()->company_id)->get();
        $allBan = array_column($ban->toArray(), 'number', 'id');
        $allAtBan = $ban->where('node_id', null);
        $atBan = array_column($allAtBan->toArray(), 'number', 'id');
        $allTmobBan = $ban->where('fan_id', null);
        $tmobBan = array_column($allTmobBan->toArray(), 'number', 'id');
        $states = $this->states();

        $cannedResponseAll = CannedResponse::porting()->where('company_id', '=', auth()->user()->company_id )->get()->toArray();

        $cannedResponse = array_column($cannedResponseAll, 'name', 'id');

        return view('action-queue.index', compact('allBan','cannedResponse', 'states', 'atBan', 'tmobBan', 'ban'));
    }

	/**
	 * @return \App\Support\DataProviders\Collection
	 */
	private function states()
    {
        return StatesProvider::data();
    }
}