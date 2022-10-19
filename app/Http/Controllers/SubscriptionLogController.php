<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Model\SubscriptionLog;
use Illuminate\Support\Facades\Log;

/**
 * Class SubscriptionLogController
 *
 * @package App\Http\Controllers
 */
class SubscriptionLogController extends Controller
{

	/**
	 * @return mixed
	 */
	public function getAllSubscriptionLogs(Request $request)
	{
		try {
			$subscriptionId = $request->subscription_id;
			$customerId = $request->customer_id;
			$baseQuery =  SubscriptionLog::whereCompanyId(auth()->user()->company_id);
			if($subscriptionId && $customerId){
				$subscriptionLogs = $baseQuery->where('subscription_id', $subscriptionId)
				                                   ->where('customer_id', $customerId)
				                                   ->get();
			} else if($subscriptionId) {
				$subscriptionLogs = $baseQuery->where('subscription_id', $subscriptionId)->get();
			} else if($customerId){
				$subscriptionLogs = $baseQuery->where('customer_id', $customerId)->get();
			} else {
				$subscriptionLogs = $baseQuery->get();
			}
			return DataTables::of( $subscriptionLogs )
							->addColumn( 'id', function ( $subscriptionLog ) {
								return $subscriptionLog->id;
							} )
			                 ->addColumn( 'change_type', function ( $subscriptionLog ) {
				                 return $subscriptionLog->category;
			                 } )
			                 ->addColumn( 'description', function ( $subscriptionLog ) {
				                 return $subscriptionLog->description;
			                 } )
							->addColumn( 'from', function ( $subscriptionLog ) {
								return $subscriptionLog->old_product;
							} )
							->addColumn( 'to', function ( $subscriptionLog ) {
								return $subscriptionLog->new_product;
							} )
							->addColumn( 'date', function ( $subscriptionLog ) {
								return $this->dateFormated($subscriptionLog->created_at);
							} )
			                 ->make( true );
		} catch (\Exception $e ) {
			Log::error( $e->getMessage() );
			return $e->getMessage();
		}
	}

}