<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof DuplicateException) {
            return response()->view('errors.already_attendance', ['exception' => $e]);
        }

        if ($e instanceof UserNotFoundException) {
            return response()->view('errors.user_not_found', ['exception' => $e]);
        }

        if ($e instanceof TokenException) {
            return response()->view('errors.token_not_found', ['exception' => $e]);
        }

        if ($this->isHttpException($e)) {
            /** @var \Symfony\Component\HttpKernel\Exception\HttpException $e */
            if ($e->getStatusCode() == 404) {
                return response()->view('errors.404', ['exception' => $e, 'message' => trans('front/message.errors.404')], $e->getStatusCode());
            }
        }

        return parent::render($request, $e);
    }
}
