<?php namespace App\Http\Controllers\Webchat;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\OrderResult;
use Illuminate\Http\Request;
use Overtrue\Wechat\Payment\Notify;
use App\Models\UserOrder;
use Overtrue\Wechat\Payment\QueryOrder;
use Log;

class NotifyController extends Controller {

	protected $notify;
	protected $queryOrder;

	public function __construct(Notify $notify,QueryOrder $queryOrder)
	{
		$this->notify = $notify;
		$this->queryOrder = $queryOrder;
	}


	/**
	 * 注册通知
	 * @return string
	 */
	public function notify(){
		Log::info('微信回调通知开始.....');
		$transaction = $this->notify->verify();

		if (!$transaction) {
			return $this->notify->reply('FAIL', 'verify transaction error');
//			return response($this->notify->reply('FAIL', 'verify transaction error'))->header('Content-Type','application/xml');
		}else {
			Log::debug('返回信息：'.$transaction);
			$resultOrder = $this->queryOrder->getTransaction($transaction->out_trade_no);
			Log::debug('商户的订单信息：'.$resultOrder);
			if($resultOrder){
				$filterResult = array_only($transaction->toArray(), OrderResult::$included);
				//判断订单是否已经入库
				$orderResult = OrderResult::whereTransactionId($transaction->transaction_id)->first();
				Log::debug('查询数据库中的订单'.$orderResult);
				if(!$orderResult){
					$orderResult = new OrderResult();
					foreach ($filterResult as $key => $item) {
						$orderResult->$key = $item;
					}
					$order = UserOrder::where('out_trade_no',$transaction['out_trade_no'])->first();
					$orderResult->user_order_id = $order->id;

					$orderResult->save();
					Log::debug('保存的订单结果：'.$orderResult);
				}
				//TODO 保存结果
				return $this->notify->reply();
			}
//			return response($this->notify->reply())->header('Content-Type','application/xml');
		}

	}
}
