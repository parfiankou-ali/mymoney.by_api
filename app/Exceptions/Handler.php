<?php

namespace App\Exceptions;

use Anik\Form\ValidationException;
use App\Exceptions\Http\HttpException;
use App\Http\Resources\HttpExceptionResource;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
        $response = new \stdClass();
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        switch (true) {
            case($exception instanceof MethodNotAllowedHttpException):
                $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
                break;
            case($exception instanceof NotFoundHttpException):
                $statusCode = Response::HTTP_NOT_FOUND;
                break;
            case($exception instanceof ValidationException):
                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $response = $exception->getResponse();
                break;
            case($exception instanceof HttpException):
                $statusCode = $exception::getStatusCode();
                $response = $exception->getResponse();
                break;
            default:
                if (env('APP_DEBUG')) {
                    $response = [
                        'message' => $exception->getMessage(),
                        'stack_trace' => $exception->getTraceAsString(),
                    ];
                }
        }

        $exception = new \App\Http\Models\HttpException();
        $exception->response = $response;
        $exception->status_code = $statusCode;

        return response()->json(new HttpExceptionResource($exception), Response::HTTP_BAD_REQUEST)
            ->withHeaders([
                'Access-Control-Allow-Origin'      => '*',
                'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Max-Age'           => '86400',
                'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
            ]);
    }
}
