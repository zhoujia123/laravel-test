<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use LucaDegasperi\OAuth2Server\Middleware\OAuthExceptionHandlerMiddleware;
use LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware;
use LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware;
use LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware;
use LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		/**
		 * Oauth
		 */
		OAuthExceptionHandlerMiddleware::class,
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'csrf' => 'App\Http\Middleware\VerifyCsrfToken',
		/**
		 * Oauth
		 */
		'oauth' => OAuthMiddleware::class,
		'oauth-user' => OAuthUserOwnerMiddleware::class,
		'oauth-client' => OAuthClientOwnerMiddleware::class,
		'check-authorization-params' => CheckAuthCodeRequestMiddleware::class
	];

}
