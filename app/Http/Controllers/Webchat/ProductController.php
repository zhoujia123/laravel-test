<?php namespace App\Http\Controllers\Webchat;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use Debugbar;
use App\OAuth\ResponseModel\BaseResponse;
use Illuminate\Support\Facades\Response;
use League\Flysystem\Exception;

/**
 * 提供给外围系统使用（商品信息）
 * Class ProductController
 * @package App\Http\Controllers\Webchat
 */
class ProductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		Debugbar::info(Product::all());
		$response = new BaseResponse();
		try{
			$products = Product::all();
			$response->setErrcode(0);
			$response->setErrmsg('SUCCESS');
			$response->setData($products->toArray());
		}catch (\Exception $e){
			$response->setErrcode($e->getCode());
			$response->setErrmsg($e->getMessage());
		}
		return new JsonResponse($response->toArray());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		return Product::find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
