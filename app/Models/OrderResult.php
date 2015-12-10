<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 订单结果
 * Class OrderResult
 *
 * @package App
 * @property integer $id
 * @property string $return_code
 * @property string $return_msg
 * @property string $result_code
 * @property string $err_code
 * @property string $err_code_des
 * @property string $openid
 * @property string $is_subscribe
 * @property string $trade_type
 * @property string $bank_type
 * @property integer $total_fee
 * @property string $fee_type
 * @property integer $cash_fee
 * @property string $cash_fee_type
 * @property string $transaction_id
 * @property string $attach
 * @property string $time_end
 * @property integer $user_order_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereReturnCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereReturnMsg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereResultCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereErrCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereErrCodeDes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereIsSubscribe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereTradeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereBankType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereTotalFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereFeeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereCashFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereCashFeeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereTransactionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereAttach($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereTimeEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereUserOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderResult whereUpdatedAt($value)
 */
class OrderResult extends Model {


    public static $included = [
        'return_code','return_msg','result_code',
        'err_code','err_code_des','openid',
        'is_subscribe','trade_type','bank_type',
        'total_fee','fee_type','cash_fee',
        'cash_fee_type','transaction_id','attach',
        'time_end'
    ];


	//

}
