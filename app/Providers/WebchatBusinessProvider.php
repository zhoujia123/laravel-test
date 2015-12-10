<?php namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Overtrue\Wechat\Payment\Business;
use Overtrue\Wechat\Payment\Notify;
use Overtrue\Wechat\Payment\QueryOrder;

class WebchatBusinessProvider extends ServiceProvider {


	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		/**
		 * 这次商户，和 回调通知
		 */
		$this->app->singleton('Overtrue\Wechat\Payment\Business',function($app){
			return new Business($app['config']['webchat.APPID'],$app['config']['webchat.APPSECRET']
					,$app['config']['webchat.MCHID'],$app['config']['webchat.KEY']);
		});

		$this->app->singleton(Notify::class,function($app){
			return new Notify($app['config']['webchat.APPID'],$app['config']['webchat.APPSECRET']
					,$app['config']['webchat.MCHID'],$app['config']['webchat.KEY']);
		});

		$this->app->singleton(QueryOrder::class,function($app){
			return new QueryOrder($app['config']['webchat.APPID'],$app['config']['webchat.APPSECRET']
					,$app['config']['webchat.MCHID'],$app['config']['webchat.KEY']);
		});
	}

}
