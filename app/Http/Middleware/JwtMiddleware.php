<?php

namespace App\Http\Middleware;

use Closure;
Use Exception;
Use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
				return response()->json(['status' => 'Token is Invalid']);
			}else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
				return response()->json(['status' => 'Token is Expired']);
			}else{
				return response()->json(['status' => 'Authorization Token not found']);
			}
        }
        Return $next($request);
    }
}
