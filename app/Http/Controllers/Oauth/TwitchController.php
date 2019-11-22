<?php namespace App\Http\Controllers\Oauth;

use App\Services\Subscribers\Twitch\{Followers, Subscriber};
use App\Jobs\Subscribers\TwitchImport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Subscribers;
use TwitchApi;
use App\User;
use JWTAuth;

use App\Services\Oauth\Twitch;

class TwitchController extends Controller
{
    public function redirect()
    {
        $is_streamer = $this->request->is_streamer ?? 0;
        setcookie('is_streamer', (int) $is_streamer, time() + 900, '/');
        setcookie('redirect', $this->request->redirect, time() + 900, '/');

        return redirect(TwitchApi::getAuthenticationUrl());
    }

    public function rollback(Request $request)
    {
        $service = new Twitch($request);
        $user = $service->createUser();

        if ($user->trashed()) {
            return redirect('/#/login/?locked=error');
        }

        $user->twitch_id = $service->twitch_user['_id'];
        $user->avatar = $service->twitch_user['logo'];
        $user->accout_type = 'twitch';
        $user->profile_mode = !empty($_COOKIE['is_streamer']) && $_COOKIE['is_streamer'] ? 'streamer' : 'user';
        if ($user->profile_mode == 'streamer' && $user->is_vk) {
            (new Twitch)->subscribeStream($user->twitch_id);
        }

        $info = $user->info;
        $info['twitch'] = $service->twitch_user;
        $info['twitch']['token'] = $service->access_token;
        $user->info = $info;

        $user->save();

        // dispatch(new TwitchImport($user, new Followers));
        // dispatch(new TwitchImport($user, new Subscriber));


        $token = JWTAuth::fromUser($user);
        $redirect = $service->redirect;
//	dd([$user, $token]);
	        return redirect(env('FRONT_URL', 'http://localhost:8080') . "/auth/?token={$token}");
        //return clientRedirect("/auth/?token={$token}");
        // rsseturn view('home', compact('user', 'token', 'redirect'));
    }
}
