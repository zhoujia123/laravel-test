<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_results', function(Blueprint $table)
		{
			$table->increments('id');


			/**
			 * 返回状态
			 */
			$table->string('return_code',16); //返回状态
			$table->string('return_msg',128)->nullable(); //返回信息

			$table->string('result_code',16);   //业务结果
			$table->string('err_code',32)->nullable();      //错误代码
			$table->string('err_code_des',128)->nullable(); //错误代码描述

			$table->string('openid',128);

			$table->string('is_subscribe',1)->nullable();  //是否关注公众号
			$table->string('trade_type',16);  			//交易类型
			$table->string('bank_type',16);  			//付款银行
			$table->integer('total_fee');  				//总金额
			$table->string('fee_type',8)->nullable();  	//货币类型
			$table->integer('cash_fee');  				//现金支付额度
			$table->string('cash_fee_type',16)->nullable();  //现金支付货币类型

			$table->string('transaction_id',32);  		//微信支付订单号
			$table->string('attach',128)->nullable();   //商家数据包
			$table->string('time_end',14);        		//微信支付完成时间


			$table->unsignedInteger('user_order_id');
			$table->foreign('user_order_id')
				  ->references('id')->on('user_orders');

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
		Schema::table('order_results', function (Blueprint $table) {
			$table->dropForeign('order_results_user_order_id_foreign');
		});

		Schema::drop('order_results');
	}

}
