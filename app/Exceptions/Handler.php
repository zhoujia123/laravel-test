<?php namespace App\Exceptions;

use Exception;
use League\OAuth2\Server\Exception\OAuthException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		/**
		 * 处理认证失败异常
		 */
		if($e instanceof OAuthException){
			$data = [
					'error' => $e->errorType,
					'error_description' => $e->getMessage(),
			];

			return new JsonResponse($data, $e->httpStatusCode, $e->getHttpHeaders());
		}
//		if ($e instanceof ModelNotFoundException) {
//			$e = new NotFoundHttpException($e->getMessage(), $e);
//		}
//
//		if (config('app.debug')) {
//			$whoops = new Whoops();
//
//			if ($request->ajax() || str_contains($request->header('Accept'), 'json')) {
//				$whoops->pushHandler(new JsonResponseHandler());
//			} else {
//				$whoops->pushHandler(new PrettyPageHandler());
//			}
//
//			return response($whoops->handleException($e),
//					$e->getStatusCode(),
//					$e->getHeaders()
//			);
//		}

		return parent::render($request, $e);
	}

}
