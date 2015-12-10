<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 商品表
 * Class Product
 *
 * @package App
 * @property integer $id
 * @property string $body
 * @property string $detail
 * @property integer $total_fee
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserOrder[] $hasManyUserOrders
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereTotalFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereUpdatedAt($value)
 */
class Product extends Model {

	//

    protected $hidden = array('updated_at','created_at');

//    public function hasManyUserOrders()
//    {
//        return $this->hasMany('App\UserOrder', 'product_id', 'id');
//    }
}
