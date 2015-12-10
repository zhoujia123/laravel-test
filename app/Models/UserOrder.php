<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 用户订单
 * Class UserOrder
 *
 * @package App
 * @property integer $id
 * @property string $out_trade_no
 * @property string $spbill_create_ip
 * @property string $time_start
 * @property string $trade_type
 * @property string $prepay_id
 * @property integer $user_id
 * @property string $return_code
 * @property string $return_msg
 * @property string $result_code
 * @property string $err_code
 * @property string $err_code_des
 * @property string $attach
 * @property string $fee_type
 * @property string $time_expire
 * @property string $goods_tag
 * @property string $openid
 * @property string $statu
 * @property integer $product_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Product $belongsToProduct
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereOutTradeNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereSpbillCreateIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereTimeStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereTradeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder wherePrepayId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereReturnCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereReturnMsg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereResultCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereErrCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereErrCodeDes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereAttach($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereFeeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereTimeExpire($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereGoodsTag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereStatu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserOrder whereUpdatedAt($value)
 */
class UserOrder extends Model {

	//
//    protected $fillable = ['product_id'];

    protected $hidden = array('updated_at','created_at');

//    public function belongsToProduct()
//    {
//        return $this->belongsTo('App\Product', 'product_id', 'id');
//    }
}
