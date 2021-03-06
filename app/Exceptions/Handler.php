<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Query\InvalidBuilderDelimiterException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (! $request->wantsJson()) {
            return parent::render($request, $exception);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()
                ->json(['error' => 'The requested resource does not exist.'], 404);
        }

        if ($exception instanceof AuthenticationException) {
            return response()
                ->json(['error' => 'The provided API token is invalid.'], 401);
        }

        if ($exception instanceof MethodNotAllowedException) {
            return response()
                ->json(['error' => 'The method is not allowed for this uri.'], 405);
        }

        if ($exception instanceof InvalidBuilderDelimiterException) {
            return response()
                ->json(['error' => 'The query string has an invalid delimiter.'], 422);
        }

        return parent::render($request, $exception);
    }
}
