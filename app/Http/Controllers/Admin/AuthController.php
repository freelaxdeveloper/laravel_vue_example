<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\Admin;
use JWTAuth;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     \Config::set('auth.providers.users.model', \App\Admin::class);
    // }

    public function login2faQR()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->google2fa_code) {
            return $this->success(['image' => null, 'secretKey' => null]);
        }
        $google2fa = app('pragmarx.google2fa');
        if (!$user->google2fa_secret) {
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }
        $QR_Image = $google2fa->getQRCodeInline(
            'Admin StreamDonations',
            $user->email,
            $user->google2fa_secret
        );
        return $this->success(['image' => $QR_Image, 'secretKey' => $user->google2fa_secret]);
    }

    public function login2fa(Request $request)
    {
        Validator::make($request->all(), [
            'secret' => 'required',
        ])->validate();

        $google2fa = app('pragmarx.google2fa');
        $secret = $request->secret;
        $user = JWTAuth::parseToken()->authenticate();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);

        if ($valid) {
            $secret = sha1(md5($secret) . env('JWT_SECRET'));
            $user->google2fa_code = bcrypt($secret);
            $user->save();
            return $this->success(['message' => 'Success', 'secret' => $secret]);
        }
        return $this->fail('Ошибка при вводе ключа');
    }

    public function authenticate(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            // 'recaptcha' => 'required|captcha',
        ])->validate();

        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Доступ запрещен'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        return response()->json(compact('token'));
    }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:admins',
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }

    //     $user = Admin::create([
    //         'name' => $request->get('name'),
    //         'email' => $request->get('email'),
    //         'password' => Hash::make($request->get('password')),
    //     ]);
    //     $token = JWTAuth::fromUser($user);

    //     return response()->json(compact('user','token'),201);
    // }

    public function getAuthenticatedUser()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        return response()->json(compact('user'));
    }
}
