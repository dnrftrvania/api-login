<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch(Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Token Invalid'
                ]);
            } else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredExceptions){
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Token Expired'
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Authorization token not found'
                ]);
            }
        }
        return $next($request);
    }
}
