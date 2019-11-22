<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TwitchApi;

class TwitchController extends Controller
{
    /**
     * @param Request $request
     * @return mixed|string
     */
    public function webhook(Request $request)
    {
        $body = file_get_contents('php://input');
        \Log::info($body);
        try {
            $body = json_decode($body, true);
            $body = $body['data'][0] ?? [];
            $user_name = $body['user_name'] ?? null;
            $thumbnail_url = str_replace(['{width}', '{height}'], 128, $body['thumbnail_url']) ?? null;
            if ($user_name) {
                vk()->sendGroupMessage("{$user_name} начал стрим\nhttps://www.twitch.tv/{$user_name}", $thumbnail_url);
            }
        } catch(\Exception $e) {

        }

        return $request->hub_challenge ?? '';
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function followsList(Request $request)
    {
        $user = $request->user()->info['twitch'];

        $options = [
            'limit' => 100,
        ];

        TwitchApi::setToken($user['token']);
        return $this->success(TwitchApi::followers($user['_id'], $options));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function test(Request $request)
    {
        $user = $request->user()->info['twitch'];

        $options = [
            'limit' => 100,
        ];

        TwitchApi::setToken('e4qws2adb8hi9jamr619wfu1p8zyde');
        return $this->success(TwitchApi::subscribers(138618207, $options));
    }

    /**
     * @param Request $request
     * @param string $channel
     * @return JsonResponse
     */
    public function channelInfoById(Request $request, string $channel)
    {
        return $this->success(TwitchApi::channel($channel));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function getUserStreams(User $user)
    {
        if (!$user->twitch_id) {
            return $this->fail(['message' => 'Twitch не привязан к этом аккаунту']);
        }

        return $this->success(
            TwitchApi::sendRequest('GET',
                'channels/' . $user->twitch_id . '/videos',
                false, [
                    'limit' => 3
                ]
            )
        );
    }
}
