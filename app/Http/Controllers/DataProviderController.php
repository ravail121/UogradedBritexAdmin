<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\Tag;

/**
 * Class DataProviderController
 *
 * @package App\Http\Controllers
 */
class DataProviderController extends Controller
{

	/**
	 * @param $view
	 */
	public function compose($view)
	{
		$show = [
			0 => 'Not visible on website at all',
			1 => 'Visible on website & orderable',
			2 => 'Visible on website and NOT orderable, instead show “Coming soon”'
		];
		$company = Auth::user()->company;
		$carrier = array_replace([
			null    => 'Please Select Carrier',
			'0'     => 'No carrier / unlocked'
		], $company->carrier()->get()->pluck('name', 'id')->toArray());
		$view->with('carrier', $carrier);
		$view->with('tag', Tag::whereCompanyId($company->id)->pluck('name', 'id'));
		$view->with('show', $show);

	}
}