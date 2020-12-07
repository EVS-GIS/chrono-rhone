<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
      if ($exception instanceof ModelNotFoundException) {
        return response()->json([
          'status'=>'error','message'=>''.$exception->getMessage().''], 404);
      } else if ($exception instanceof UnauthorizedHttpException) {
        $preException = $exception->getPrevious();
        if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['status'=>'error','message'=>'Token expired'],401);
        } else if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['status'=>'error','message'=>'Token invalid'],401);
        } else if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
             return response()->json(['status'=>'error','message'=>'Token blacklisted'],401);
        }
        if ($exception->getMessage() === 'Token not provided') {
          return response()->json(['status'=>'error','message'=>'Token not provided'],401);
        }
      } else if ($exception instanceof \ErrorException) {
        return response()->json(['status'=>'error','message'=>''.$exception->getMessage().''],500);
      } 
      return parent::render($request, $exception);
    }
}
