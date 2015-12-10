<?php namespace App\Http\Controllers\Webchat;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UserOrder;
use Illuminate\Http\Request;

/**
 * 获取用户订单
 * Class UserOrderController
 * @package App\Http\Controllers\Webchat
 */
class UserOrderController extends Controller {


	/**
	 * 根据out_trade_no 获取订单
	 * @param Request $request
	 * @return mixed
	 */
	public function getOrder(Request $request){

		return UserOrder::where('out_trade_no',$request->input('out_trade_no'))->get();
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
