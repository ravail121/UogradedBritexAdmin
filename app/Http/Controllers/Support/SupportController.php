<?php

namespace App\Http\Controllers\Support;

use DataTables;
use App\Model\Support;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SupportController
 *
 * @package App\Http\Controllers\Support
 */
class SupportController extends Controller
{

	/**
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
	public function index()
	{
		$categories = Category::where('company_id', auth()->user()->company_id)->get();
		return view('faq.index', compact('categories'));
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function store(Request $request)
	{
		$data = $request->validate([
			'category_id'           => 'required',
			'question'              => 'required',
			'description'           => 'required',
		]);

		$faq = Support::create($data);

		return $faq;
	}

	/**
	 * @param Category $category
	 *
	 * @return mixed
	 */
	public function show(Category $category)
	{
		$supportData = $category->support;
		return DataTables::of($supportData)
		                 ->addColumn('first', function($supportData) {
			                 return "";
		                 })
		                 ->addColumn('question', function($supportData) {
			                 return str_limit($supportData->question, 70, '...');
		                 })
		                 ->addColumn('id', function($supportData) {
			                 return $supportData->id;
		                 })
		                 ->addColumn('description', function($supportData) {
			                 return str_limit($supportData->description, 70, '...');
		                 })
		                 ->addColumn('action', function($supportData) {

			                 return '<div class="actionbtn"> 
                            <div class="dropdown"><a class="btn markbtn activest smgreen edit-btn" href="#editfaq" data-toggle="modal" data-id='.$supportData->id.' data-target="#editfaq"> Edit </a> </div>
                            <div class="dropdown"> <a class="btn delete-btn dl" data-id ='.$supportData->id.'> Delete </a> </div>
                        </div>';
		                 })
		                 ->addColumn('all-data', function($supportData) {
			                 return $supportData;
		                 })
		                 ->rawColumns(['question', 'description', 'action'])
		                 ->make(true);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function update(Request $request)
	{
		$data = $request->validate([
			'id'                    => 'required',
			'question'              => 'required',
			'description'           => 'required',
		]);

		Support::find($data['id'])->update($data);

		$support = Support::find($data['id']);

		return $support;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function updateCategory(Request $request)
	{
		$data = $request->validate([
			'id'   => 'required',
			'name' => 'required',
		]);

		$category = Category::find($data['id']);

		if($category) {
			$category->update($data);
		}

		return $category;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function createCategory(Request $request)
	{
		$data = $request->validate([
			'name'       => 'required',
		]);

		$data['company_id'] = auth()->user()->company_id;

		$category = Category::create($data);

		return $category;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function destroy(Request $request)
	{
		$data=$request->validate([
			'id'  => 'required',
		]);

		$support = Support::find($data['id']);

		$category = $support->category_id;

		Support::find($data['id'])->delete();

		return $category;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function destroyCategory(Request $request)
	{
		$data = $request->validate([
			'id' => 'required',
		]);

		$category = Category::find($data['id']);

		$category->delete();

		return $category->first();
	}
}
