<?php

namespace App\Exceptions;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
        parent::report($e);
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
	    if (($request->isJson() OR $request->ajax()) AND $request->wantsJson()) {
		    $apiController = new ApiController;

		    if ($this->isHttpException($e)) {

				if ($e instanceof NotFoundHttpException) {
					return $apiController->responseNotFound();
				}

			    return $apiController->responseServerError("Un-handled HTTP Exception", $e);
		    }

		    if ($e instanceof HttpResponseException) {
			    $response = $e->getResponse();
			    
			    try {
				    $response = json_decode($response->getContent(), true);
				    if (isset($response['resource'])) {
					    return $apiController->responseValidationError($response);
				    }
			    } catch(Exception $e) { }
			    return $apiController->responseServerError("Un-handled HTTP Response Exception", $e);
		    }

		    return $apiController->responseServerError("Un-handled API Exception", $e);
	    }

	    if ($this->isHttpException($e)) {
		    return $this->renderHttpException($e);
	    }

	    return parent::render($request, $e);
    }
}
