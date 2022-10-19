<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\Subscription;
use Illuminate\Http\Request;

/**
 * Class SearchController
 *
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{

	/**
	 * @param Request $request
	 *
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index(Request $request)
    {
    	if($request->has('phone')) {
    		if($request->phone != null) {
	    		$searchPhone = $request->phone;
	    		$subscription = Subscription::where('phone_number', 'LIKE', '%' .$searchPhone. '%')->with('customer')->whereHas('customer', function ($query) {
                    $query->where('company_id', '=', auth()->user()->company_id );
                })->get();
	    		if(count($subscription)) {

	    			return view('Search-data.index', compact('subscription'));
	    		}

	    		return view('Search-data.index');
	    	}
    	} elseif($request->has('name')) {
    		if($request->name != null) {
	    		$serchName = $request->name;
	    		$customers = Customer::whereRaw('CONCAT(fname, " ", lname) LIKE ? ', '%' .$serchName. '%')->whereCompanyId(auth()->user()->company_id)->get();
	    		if(count($customers)) {

	    			return view('Search-data.index', compact('customers'));
	    		}

	    		return view('Search-data.index');
	    	}
    	} elseif($request->has('sim')) {
		    if($request->sim != null) {
			    $searchSim = $request->sim;
			    $subscription = Subscription::where('sim_card_num', 'LIKE', '%' .$searchSim. '%')->with('customer')->whereHas('customer', function ($query) {
				    $query->where('company_id', '=', auth()->user()->company_id );
			    })->get();
			    if(count($subscription)) {
				    return view('Search-data.index', compact('subscription'));
			    }

			    return view('Search-data.index');
		    }
	    } elseif($request->has('company')) {
		    if($request->company != null) {
			    $searchWithCompany = $request->company;
			    $customers = Customer::whereRaw('company_name LIKE ? ', '%' . $searchWithCompany. '%')->whereCompanyId(auth()->user()->company_id)->get();
			    if(count($customers)) {
				    return view('Search-data.index', compact('customers'));
			    }
			    return view('Search-data.index');
		    }
	    }
    }
}