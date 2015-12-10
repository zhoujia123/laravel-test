<?php namespace App\Http\Controllers\Webchat;

use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Overtrue\Wechat\Payment\Business;
use Overtrue\Wechat\Payment\Order;
use Overtrue\Wechat\Payment\UnifiedOrder;
use Overtrue\Wechat\Payment;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UserOrder;
use App\OAuth\ResponseModel\BaseResponse;

class WebchatController extends Controller {


	protected $business;
	protected $data;

	public function __construct(Business $business)
	{
		$this->business = $business;
//		var_dump($this->business);
	}

	/**
	 *
	 * 通过跳转获取用户的openid，跳转流程如下：
	 * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
	 * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
	 *
	 * @return 用户的openid
	 */
	public function GetOpenid()
	{
		//通过code获得openid
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
			$url = $this->__CreateOauthUrlForCode($baseUrl);
			Header("Location: $url");
			exit();
		} else {
			//获取code码，以获取openid
			$code = $_GET['code'];
			$openid = $this->getOpenidFromMp($code);
			return $openid;
		}
	}

	/**
	 *
	 * 通过code从工作平台获取openid机器access_token
	 * @param string $code 微信跳转回来带上的code
	 *
	 * @return openid
	 */
	public function GetOpenidFromMp($code,$curl_timeout=30)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
//				&& WxPayConfig::CURL_PROXY_PORT != 0){
//			curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
//			curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
//		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->data = $data;
		$openid = $data['openid'];
		return $openid;
	}


	/**
	 *
	 * 构造获取open和access_toke的url地址
	 * @param string $code，微信跳转带回的code
	 *
	 * @return 请求的url
	 */
	private function __CreateOauthUrlForOpenid($code)
	{
		$urlObj["appid"] = $this->business->appid;
		$urlObj["secret"] = $this->business->appsecret;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}

	/**
	 *
	 * 构造获取code的url连接
	 * @param string $redirectUrl 微信服务器回跳的url，需要url编码
	 *
	 * @return 返回构造好的url
	 */
	private function __CreateOauthUrlForCode($redirectUrl)
	{
		$urlObj["appid"] = $this->business->appid;
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}

	/**
	 *
	 * 拼接签名字符串
	 * @param array $urlObj
	 *
	 * @return 返回已经拼接好的字符串
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}

		$buff = trim($buff, "&");
		return $buff;
	}

	/**
	 * 下单common
	 * @param Request $request
	 */
	private function payerOrder(Request $request,$trade_type = 'NATIVE'){

		//
		/**
		 * 定义订单
		 */
//		$product = Product::find($request->get('product_id'));

		$order = new Order();
		$order->product_id = $request->get('product_id');
		$order->body = $request->get('body');
		$order->detail = $request->get('detail');
		$order->total_fee = $request->get('total_fee');    // 单位为 “分”, 字符串类型



		$order->out_trade_no = md5(uniqid().microtime());

		$order->time_start = date("YmdHis");
		$order->time_expire = date("YmdHis", time() + 36000);
		$order->trade_type= $trade_type;
		if($trade_type === 'JSAPI'){
			$order->openid = $this->GetOpenid();
		}

		$order->notify_url = Config::get('webchat.NOTIFY_URL');


		return $order;
	}

	/**
	 * 保存订单
	 * @param $order
	 * @param $result
	 */
	private function saveOrder($order,$result,Request $request){

		$userOrder = new UserOrder();
		$userOrder->product_id = $order->product_id;
		$userOrder->out_trade_no = $order->out_trade_no;
		$userOrder->time_start = $order->time_start;
		$userOrder->time_expire = $order->time_expire;
		$userOrder->trade_type = $order->trade_type;
		$userOrder->spbill_create_ip = $order->spbill_create_ip;

		$userOrder->attach = $order->attach;
		$userOrder->fee_type = $order->fee_type;
		$userOrder->goods_tag = $order->goods_tag;
		$userOrder->openid = $order->openid;
		/**
		 * 用户ID
		 */
		$userOrder->user_id = 1;

		/**
		 * 返回信息
		 */
		$userOrder->prepay_id = $result['prepay_id'];
		$userOrder->return_code = $result['return_code'];
		$userOrder->return_msg = array_key_exists('return_msg',$result)?$result['return_msg']:'';
		$userOrder->result_code = $result['result_code'];
		$userOrder->err_code = array_key_exists('err_code',$result)?$result['err_code']:'';
		$userOrder->err_code_des = array_key_exists('err_code_des',$result)?$result['err_code_des']:'';

		$userOrder->save();
		return $userOrder;
	}

	/**
	 * Display a listing of the resource.
	 * 网页生成扫码连接
	 * @return Response
	 */
	public function webPayOrder(Request $request)
	{
		$baseResponse = new BaseResponse();

		try{
			/**
			 * 生成订单
			 */
			$order = $this->payerOrder($request);

			$unifiedOrder = new UnifiedOrder($this->business,$order);
			/**
			 * 下单返回交易号
			 */


			$result = $unifiedOrder->getResponse();


			$userOrder = $this->saveOrder($order,$result,$request);

			/**
			 * 返回json信息
			 */
			$baseResponse->setErrcode(0);
			$baseResponse->setErrmsg("SUCCESS");
			$baseResponse->setData([
				'out_trade_no' => $order->out_trade_no,
				'code_url' => urlencode($result['code_url'])
			]);

			return response()->json($baseResponse->toArray());
//		return view('webchat.qrcode')->with('code_url',$result['code_url']);

		}catch (Exception $e){
			$baseResponse->setErrcode($e->getCode());
			$baseResponse->setErrmsg($e->getMessage());
			return response()->json($baseResponse->toArray());
		}



//		return response()->jsonp($request->input('callback'),[
//				'return_code' => 'SUCCESS',
//				'return_msg' => 'OK',
//				'out_trade_no' => $order->out_trade_no,
//				'code_url' => urlencode($result['code_url'])
//		]);
//		return view('webchat.qrcode')->with('code_url',$result['code_url']);
	}


	/**
	 * JS 生成支付订单
	 * @param Request $request
	 * @return array|string|\Symfony\Component\HttpFoundation\Response
	 */
	public function jsPayOrder(Request $request){

		/**
		 * 生成订单
		 */
		$order = $this->payerOrder($request,'JSAPI');

		$unifiedOrder = new UnifiedOrder($this->business,$order);
		/**
		 * 下单返回交易号
		 */
		try{
			$result = $unifiedOrder->getResponse();
		}catch (Exception $e){
			return response()->json([
					'return_code' => 'FAIL',
					'return_msg' => $e->getMessage()
			]);
		}

		$this->saveOrder($order,$result,$request);

		/**
		 * 第 4 步：生成支付配置文件
		 */
		$payment = new Payment($unifiedOrder);

		return $payment->getConfig();
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
