<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('out_trade_no',32)->unique();
			$table->string('spbill_create_ip',16);
			$table->string('time_start',14);
			$table->string('trade_type',16);  //交易类型

			$table->string('prepay_id',64);   //预支付交易会话标识
			$table->integer('user_id');       //用户ID

			/**
			 * 返回状态
			 */
			$table->string('return_code',16); //返回状态
			$table->string('return_msg',128)->nullable(); //返回信息

			$table->string('result_code',16);   //业务结果
			$table->string('err_code',32)->nullable();      //错误代码
			$table->string('err_code_des',128)->nullable(); //错误代码描述

//			$table->string('body',32);
//			$table->string('detail',8192)->nullable();
			$table->string('attach',127)->nullable();
			$table->string('fee_type',16)->nullable();
//			$table->integer('total_fee');
			$table->string('time_expire',14)->nullable();
			$table->string('goods_tag',32)->nullable();
			$table->string('openid',128)->nullable();
			/**
			 * 订单状态
			 * create 创建，cancel 取消，success 成功，fail 失败
			 */
			$table->enum('statu',['create','cancel','success','fail'])->default('create');

			$table->String('product_id');  //产品ID
//			$table->index('product_id');
//			$table->foreign('product_id')
//				   ->references('id')->on('products');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::table('user_orders', function (Blueprint $table) {
//			$table->dropForeign('user_orders_product_id_foreign');
//		});

		Schema::drop('user_orders');
	}

}
