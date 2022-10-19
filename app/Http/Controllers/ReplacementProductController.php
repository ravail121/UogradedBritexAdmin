<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Model\Sims;
use App\Model\Device;
use Illuminate\Http\Request;
use App\Model\ReplacementProduct;
use Illuminate\Support\Facades\Log;

/**
 * Class ReplacementProductController
 *
 * @package App\Http\Controllers
 */
class ReplacementProductController extends Controller {

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		$productType = ReplacementProduct::PRODUCT_TYPE;
		$simProducts = Sims::whereCompanyId(auth()->user()->company_id)->pluck('name', 'id')->toArray();
		$deviceProducts = Device::whereCompanyId(auth()->user()->company_id)->pluck('name', 'id')->toArray();

		return view('replacement-product.all-replacement-products', compact('productType', 'simProducts', 'deviceProducts'));
	}

	/**
	 * @return mixed
	 */
	public function getAllReplacementProducts()
	{
		try {
			$replacementProducts = ReplacementProduct::whereCompanyId( auth()->user()->company_id )->get();

			return DataTables::of( $replacementProducts )
			                 ->addColumn( 'id', function ( $replacementProduct ) {
				                 return $replacementProduct->id;
			                 } )
			                 ->addColumn( 'type', function ( $replacementProduct ) {
				                 return ReplacementProduct::PRODUCT_TYPE[$replacementProduct->product_type];
			                 } )
			                 ->addColumn( 'product', function ( $replacementProduct ) {
								 if($replacementProduct->product_type == 'device'){
									 $device = Device::find($replacementProduct->product_id);
									 return $device->name;
								 } else {
									 $sim = Sims::find($replacementProduct->product_id);
									 return $sim->name;
								 }
			                 } )
			                 ->addColumn( 'modify', function ( $replacementProduct ) {
				                 return
					                 '<div class="actionbtn">
	                                    <div class="dropdown"> <a class="btn markbtn activest smgreen edit-btn" href="#edit" data-toggle="modal" data-target="#update-replacement-products-table" data-replacement_product_id=' . $replacementProduct->id . '> Edit </a> </div>
	                                    <div class="dropdown"> <a class="btn delete-btn" data-id =' . $replacementProduct->id . '> Delete </a> </div>
                                    </div>';
			                 } )
			                 ->addColumn( 'all-data', function ( $replacementProduct ) {
				                 return htmlspecialchars( json_encode( $replacementProduct ) );
			                 } )
			                 ->rawColumns( [ 'modify' ] )
			                 ->make( true );
		} catch (\Exception $e ) {
			Log::error( $e->getMessage() );
			return $e->getMessage();
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function add(Request $request)
	{
		try {
			$this->validateData( $request );

			$data                 = $request->all();
			$data[ 'company_id' ] = auth()->user()->company_id;
			$replacementProduct = ReplacementProduct::create( $data );

			return response()->json([
				'status'    => 'success',
				'data'      => $replacementProduct
			]);
		} catch (\Exception $e ) {
			Log::error( $e->getMessage() );
			return response()->json([
				'status'    => 'error',
				'message'   => $e->getMessage()
			]);
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(Request $request)
	{
		try{
			$this->validateData($request);

			$data = $request->all();
			$data['id'] = $request->id;

			$replacementProduct = ReplacementProduct::find($data['id']);

			$replacementProduct->update($data);

			return response()->json([
				'status'    => 'success',
				'data'      => $data
			]);
		} catch (\Exception $e) {
			Log::info($e->getMessage());
			return response()->json([
				'status'    => 'error',
				'message'   => $e->getMessage()
			]);
		}

	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	protected function validateData(Request $request)
	{
		return $request->validate([
			'product_type'           => 'required',
			'product_id'             => 'required'
		]);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteReplacementProduct(Request $request)
	{
		try{
			$replacementProduct = ReplacementProduct::find($request->id);
			$replacementProduct->delete();
			return response()->json([
				'status' => 'success'
			]);
		} catch (\Exception $e) {
			Log::info($e->getMessage());
			return response()->json([
				'status' => 'error',
				'message' => $e->getMessage()
			]);
		}
	}

}