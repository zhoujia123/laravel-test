<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;
use App\Qrcode\QRcode;

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/*
 * 申请 access_token 或者刷新 access_token.
 */
Route::get('oauth/access_token', function() {
	return Response::json(Authorizer::issueAccessToken());
});


/**
 * 微信支付
 */
Route::group(['namespace' => 'Webchat','prefix' => 'wx','middleware' => 'oauth'],function(){
//Route::group(['namespace' => 'Webchat','prefix' => 'wx'],function(){

	Route::get('webchat','WebchatController@webPayOrder');
	Route::get('jschat','WebchatController@jsPayOrder');

	Route::resource('product','ProductController');
	Route::get('getOrder','UserOrderController@getOrder');
});

/**
 * 微信通知回调
 */
Route::post('wx/notify','Webchat\NotifyController@notify');

/**
 * 生成二维码
 */
Route::get('wx/qrcode',function(Request $request){
	$url = urldecode($request->input("data"));
	QRcode::png($url);
});


