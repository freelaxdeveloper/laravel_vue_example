<?php namespace App\Services\Oauth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use TwitchApi;

class Twitch extends App
{
    public $user;
    public $twitch_user;
    public $access_token;

    protected $response;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->response = $this->getResponse();
        $this->user = $this->getUser();
    }

    /**
     * @return bool
     */
    private function getResponse()
    {
        $response = TwitchApi::getAccessObject($this->request->code);
        if (is_object($response) && $response->status != 200) {
            dd($response->message);
            \Log::channel('twitch-webhook')
                ->info("Ошибка авторизации", $response->message);
            return false;
        }
        $this->access_token = $response['access_token'];
        TwitchApi::setToken($this->access_token);

        return $response;
    }

    /**
     * @return array|bool
     */
    private function getUser()
    {
        $user = TwitchApi::authUser();
        if (is_object($user) && $user->status != 200) {
            \Log::channel('twitch-webhook')
                ->info("Ошибка авторизации", $user->message);
            return false;
        }
        $this->twitch_user = $user;

        $data = [
            'name' => $user['name'],
            'display_name' => $user['display_name'],
            'twitch_id' => $user['_id'],
            'password' => Hash::make(str_random(128)),
            'api_token' => str_random(128),
            'avatar' => $user['logo'],
            'info' => ['twitch' => $user],
            'service_id' => service('Twitch'),
        ];
        $this->email = $user['email'];

        return $data;
    }
}
