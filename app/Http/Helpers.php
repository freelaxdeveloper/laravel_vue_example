<?php
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Services\{Setting, Donate, Paykeeper, VK};
use App\Models\{Subscribers, SubscribeUser, Service, Notification};

/**
 * @return Donate
 */
function donate()
{
    return (new Donate);
}

/**
 * @param string $name
 * @return Setting
 */
function settings(string $name)
{
    return (new Setting($name));
}

/**
 * @param string $pathDir
 * @param array $music
 */
function getMusic(string $pathDir, array &$music)
{
    $files = glob(public_path("{$pathDir}*.mp3"));
    for ($i = 0; $i < count($files); $i++) {
        $music[] = [
            'name' => basename($files[$i]),
            'src' => '/'. $pathDir . basename($files[$i])
        ];
    }
}

/**
 * @param User $user
 * @param $pushSettings
 * @param string $type
 * @return mixed
 */
function fetchSettings(User $user, $pushSettings, string $type)
{
    $settings = settings('PushDonate')->settings;

    $keys = array_keys($settings);
    for ($i = 0; $i < count($keys); $i++) {
        if (!$pushSettings) {
            break;
        }
        if (empty($pushSettings->settings[$keys[$i]])) {
            continue;
        }
        $mySettings = collect($pushSettings->settings[$keys[$i]]);
        $mySettings = $mySettings->filter(function ($value, $key) {
            return $value !== null;
        });
        $mySettings->all();
        $settings[$keys[$i]] = array_merge($settings[$keys[$i]], $mySettings->all());
    }
    $musics = [];
    getMusic("storage/uploads/{$user->id}/music/", $musics);
    getMusic("storage/music/", $musics);
    $settings['music'] = $musics;


    return $settings;
}

/**
 * @param $user
 * @param string $type
 * @return mixed
 */
function pushSettings($user, string $type)
{
    $settings = settings('PushDonate')->settings;

    $keys = array_keys($settings);
    for ($i = 0; $i < count($keys); $i++) {
        if (empty($user->settings['notification'][$type][$keys[$i]])) {
            continue;
        }
        $mySettings = collect($user->settings['notification'][$type][$keys[$i]]);
        $mySettings = $mySettings->filter(function ($value, $key) {
            return $value !== null;
        });
        $mySettings->all();
        $settings[$keys[$i]] = array_merge($settings[$keys[$i]], $mySettings->all());
    }
    $musics = [];
    getMusic("storage/uploads/{$user->id}/music/", $musics);
    getMusic("storage/music/", $musics);
    $settings['music'] = $musics;


    return $settings;
}

/**
 * @param User $user
 * @param Subscribers $subscriber
 * @param array $subscribe
 * @param string $service_name
 */
function subscribe(User $user, Subscribers $subscriber, array $subscribe, string $service_name = 'Twitch')
{
    $subscribeUser = SubscribeUser::updateOrCreate(
        ['subscribers_id' => $subscriber->id, 'service_id' => $subscriber->service_id, 'user_id' => $user->id],
        $subscribe
    );

    if ($subscribeUser->wasRecentlyCreated) {
        $notification = Notification::create([
            'user_id' => $user->id,
            'counter' => '',
            'type' => array_keys($subscribe)[0] ?? 'free',
            'title' => $subscriber->display_name,
            'message' => 'Подписался',
        ]);
    }
}

/**
 * @param string $name
 * @param bool $id_only
 * @return string
 */
function service(string $name, bool $id_only = true): string
{
    $service = Service::firstOrCreate(['name' => $name]);

    return $id_only ? $service->id : $service;
}

/**
 * @param User $user
 * @param User $ank
 * @param string $type
 * @return bool
 */
function checkSubscribe(User $user, User $ank, string $type = 'premium')
{
    if (!$subscribe = $ank->subscribers()->where('_id', $user->twitch_id)->orWhere('_id', $user->youtube_id)->orWhere('_id', $user->id)->first()) {
        return false;
    }

    if (\Carbon\Carbon::now() >= $subscribe->pivot->premium) {
        return false;
    }

    return $subscribe->pivot->{$type};
}

/**
 * @return Paykeeper
 */
function paykeeper()
{
    return (new Paykeeper);
}

/**
 * @return VK
 */
function vk()
{
    return (new VK);
}

/**
 * @param int $count
 * @param int $total
 * @param int $precision
 * @return float|int
 */
function averageValue(int $count, int $total, int $precision = 2)
{
    if (!$count) {
        return 0;
    }
    return round($count / $total * 100, $precision);
}

/**
 * @param string $uri
 * @return RedirectResponse|Redirector
 */
function clientRedirect(string $uri = '/')
{
    return redirect(env('FRONT_URL', "http://localhost:8080{$uri}"));
}
