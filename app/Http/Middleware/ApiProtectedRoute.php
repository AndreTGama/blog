<?php

namespace App\Http\Middleware;

use App\Builder\ReturnMessage;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;


class ApiProtectedRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = FacadesJWTAuth::parseToken()->authenticate();

            if(empty($user->email_verified_at))
                throw new \Exception('User is not active, please check your email');

        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return ReturnMessage::message(
                    false,
                    'Token is Invalid',
                    'Token is Invalid',
                    null,
                    null,
                    401
                );
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return ReturnMessage::message(
                    false,
                    'Token is Expired',
                    'Token is Expired',
                    null,
                    null,
                    401
                );
            } else if ($e) {
                return ReturnMessage::message(
                    false,
                    $e->getMessage(),
                    $e->getMessage(),
                    null,
                    null,
                    401
                );
            } else {
                return ReturnMessage::message(
                    false,
                    'Authorization Token not found',
                    'Authorization Token not found',
                    null,
                    null,
                    401
                );
            }
        }
        return $next($request);
    }
}
