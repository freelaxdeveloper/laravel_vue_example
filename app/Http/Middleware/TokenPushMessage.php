<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class TokenPushMessage
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
  public function handle(Request $request, Closure $next)
  {
    $user = $request->route('user');
    $token = base64_decode($request->route('token'));

    if (!Hash::check($user->streamlink, $token)) {
      return response()->json(['errors' => ['Access denied']], 403);
    }

    return $next($request);
  }
}
