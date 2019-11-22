<?php namespace App\Http\Controllers\Oauth;

use Hash;
use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use App\Jobs\Subscribers\YouTubeImport;
class YouTubeController extends Controller
{
    public function redirect(Request $request)
    {
        $is_streamer = $this->request->is_streamer ?? 0;
        setcookie('is_streamer', (int) $is_streamer, time() + 900, '/');
        setcookie('redirect', $this->request->redirect, time() + 900, '/');

        $client = new \Google_Client();
        $client->setAuthConfig(config('youtube'));
        $client->addScope(\Google_Service_YouTube::YOUTUBE_READONLY);

        $client->addScope('https://www.googleapis.com/auth/userinfo.profile');
        $client->addScope('https://www.googleapis.com/auth/userinfo.email');
        $client->setRedirectUri(config('youtube.redirect'));
        $client->setAccessType('offline');        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth

        if ($request->code) {
            $response = $this->rollback($client, $request);
            list('user' => $user, 'token' => $token, 'redirect' => $redirect) = $response;

            if ($redirect) {
                return clientRedirect('/settings/account');
                // return redirect($redirect);
            }
            
            return clientRedirect("/auth/?token={$token}");
            // return view('home', compact('user', 'token', 'redirect'));
        }

        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;
    }

    public function rollback(\Google_Client $client, Request $request)
    {
        $client->authenticate($request->code);
        $access_token = $client->getAccessToken();

        $userService = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $access_token['access_token']);
        $userService = \json_decode($userService);

        $client->setAccessToken($access_token);

        $user = User::withTrashed()->firstOrCreate(['email' => $userService->email], [
            'name' => $userService->name,
            'password' => Hash::make(str_random(128)),
            'api_token' => str_random(128),
            'avatar' => $userService->picture,
            'info' => ['youtube' => $userService],
        ]);

        if ($user->trashed()) {
            return redirect('/#/login/?locked=error');
        }

        $user->avatar = $userService->picture;
        $user->accout_type = 'youtube';
        $user->profile_mode = !empty($_COOKIE['is_streamer']) && $_COOKIE['is_streamer'] ? 'streamer' : 'user';

        $info = $user->info;
        $info['youtube'] = $userService;
        $info['youtube']->token = $access_token;
        $user->info = $info;

        $user->save();

        dispatch(new YouTubeImport($user));
// dd(5);
        $token = JWTAuth::fromUser($user);
        $redirect = !empty($_COOKIE['redirect']) ? url('/', [], true) . '/' . $_COOKIE['redirect'] : null;
        // $redirect = !empty($_COOKIE['redirect']) ? env('FRONT_URL', 'http://localhost:8080') . $_COOKIE['redirect'] : null;

        return compact('user', 'token', 'redirect');
    }
}
