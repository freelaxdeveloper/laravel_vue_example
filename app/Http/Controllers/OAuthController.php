<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Jobs\Subscribers\YouTubeImport;
use App\User;
use Illuminate\Routing\Redirector;
use Socialite;
use JWTAuth;
use Hash;

class OAuthController extends Controller
{
    /**
     * @param string $service
     * @return RedirectResponse
     */
    public function redirectToProvider(string $service)
    {
        if (!in_array($service, ['google', 'vkontakte'])) {
            return redirect()->route('home');
        }
        $is_streamer = $this->request->is_streamer ?? 0;
        setcookie('is_streamer', (int) $is_streamer, time() + 900, '/');
        setcookie('redirect', $this->request->redirect, time() + 900, '/');


        return Socialite::driver($service)->redirect();
    }

    /**
     * @param string $service
     * @return RedirectResponse|Redirector
     */
    public function handleProviderCallback(string $service)
    {
        $redirect = !empty($_COOKIE['redirect']) ? url('/', [], true) . '/' . $_COOKIE['redirect'] : null;
        try {
            $userService = Socialite::driver($service)->user();
        } catch (\Exception $e) {
            return redirect(route('error', ['message' => 'Ошибка при авторизации. Повторите попытку.']));
        }

        $userService->email = $userService->email ?? $userService->accessTokenResponseBody['email'] ?? null;
        if (!$userService->email) {
            return redirect(route('error', ['message' => 'Не удалось получить E-mail']));
        }

        $user = User::withTrashed()->firstOrCreate(['email' => $userService->email], [
            'name' => $userService->name,
            'password' => Hash::make(str_random(128)),
            'api_token' => str_random(128),
            'avatar' => $userService->avatar,
            'info' => [$service => $userService],
        ]);

        if ($user->trashed()) {
            return redirect('/#/login/?locked=error');
        }

        $user->avatar = $userService->avatar;
        $user->accout_type = $service;
        $user->profile_mode = !empty($_COOKIE['is_streamer']) && $_COOKIE['is_streamer'] ? 'streamer' : 'user';

        $info = $user->info;
        $info[$service] = $userService;
        $info[$service]['token'] = $userService->token;
        $user->info = $info;

        $user->save();

        $token = JWTAuth::fromUser($user);

        return clientRedirect("/auth/?token={$token}");
    }
}
