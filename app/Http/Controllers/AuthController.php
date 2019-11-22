<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\JsonResponse;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
  public function register(Request $request)
  {
    Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
    ])->validate();

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'api_token' => str_random(128),
    ]);

    return $this->success(['message' => 'Register success', 'user' => $user]);
  }

    /**
     * @param Request $request
     * @return JsonResponse
     */
  public function login(Request $request)
  {
    Validator::make($request->all(), [
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:6',
    ])->validate();

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      $user = User::whereEmail($credentials['email'])->first();
      return $this->success(['message' => 'Авторизация успешна', 'api_token' => $user->api_token, 'user_data' => $user]);
    }

    return $this->fail(['message' => 'Ошибка авторизации']);
  }
}
