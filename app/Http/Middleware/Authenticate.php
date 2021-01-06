<?php

namespace App\Http\Middleware;

use App\Http\Resources\HttpExceptionResource;

use Closure;

use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Response;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            $exception = new \App\Http\Models\HttpException();
            $exception->status_code = Response::HTTP_UNAUTHORIZED;

            return response()->json(new HttpExceptionResource($exception), Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
