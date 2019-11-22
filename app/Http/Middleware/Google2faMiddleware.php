<?php
namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Google2faMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (!Hash::check($request->header('google2fa'), $user->google2fa_code)) {
            return response()->json(['error' => 'Not authorized Google2fa', 'status' => 'google2fa'], 401);
        }
        return $next($request);
    }
}