<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\AuthenticationException;

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
        $exceptionClassName = class_basename($exception);
        $ref = new \ReflectionClass($this);
        $methods = $ref->getMethods(\ReflectionMethod::IS_PROTECTED);
        foreach ($methods as $method) {
            $parameters = $method->getParameters();
            if (isset($parameters[1]) && studly_case($method->getParameters()[1]->getName()) == $exceptionClassName) {
                return call_user_func_array([$this, $method->getName()], [$request, $exception]);
            }
        }

        return parent::render($request, $exception);
    }
	
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $authenticationException
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $authenticationException)
    {
        if ($request->expectsJson()) {
            return response()->json(
                [
                    'error'         => 'Unauthenticated.',
                    'error_message' => 'Unauthenticated.',
                    'redirect_url'  => \RouteUrls::site_login(),
                ], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param TokenMismatchException $tokenMismatchException
     * @return \Illuminate\Http\Response
     */
    protected function tokenMismatched($request, TokenMismatchException $tokenMismatchException)
    {
        if($request->ajax()) {
            return response()->json(
                [
                    'error_message' => 'Token Mismatched.',
                    'redirect_url'  => redirect()->back()->getTargetUrl(),
                ], 500);
        }
        return redirect()->back();
    }
}
