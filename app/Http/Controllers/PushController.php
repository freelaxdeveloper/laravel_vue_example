<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\{Transaction, Notification, PushNotification};
use Illuminate\Http\Request;
use Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PushController extends Controller
{

    /**
     * @param User $user
     * @param string $token
     * @return JsonResponse
     */
    public function uploadmusic(User $user, string $token) {
        $validator = Validator::make($_FILES, [
            'filepond' => 'required|array',
            'filepond.tmp_name' => 'required|string',
            'filepond.name' => 'required|string',
        ])->validate();
        $file = $_FILES['filepond'];

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, ['audio/mpeg', 'application/octet-stream'])) {
            return $this->fail(['Только музыка', $mime]);
        }

        $path = "storage/uploads/{$user->id}/music";
        $dir = public_path($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = str_slug(basename($file['name'], '.mp3')) . '.mp3';
        copy($file['tmp_name'], "{$dir}/{$filename}");

        return $this->success(['src' => "/{$path}/{$filename}", 'name' => $filename]);
    }

    /**
     * @param User $user
     * @param int $push_id
     * @param string $token
     * @return JsonResponse
     */
    public function uploadvideo(User $user, int $push_id, string $token)
    {

        if (!$notification = PushNotification::whereUserId($user->id)->find($push_id)) {
            return $this->fail('Ошибка при выборе уведомления');
        }

        $validator = Validator::make($_FILES, [
            'filepond' => 'required|array',
            'filepond.tmp_name' => 'required|string',
            'filepond.name' => 'required|string',
        ])->validate();
        $file = $_FILES['filepond'];

        $path = "storage/uploads/{$user->id}/video";
        $dir = public_path($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fileinfo = pathinfo($file['name']);
        $filename = str_slug($fileinfo['filename']) . '.' .  $fileinfo['extension'];
        copy($file['tmp_name'], "{$dir}/{$filename}");

        $settings = $notification->settings;
        $settings['video'] = [
            'src'  =>  "/{$path}/{$filename}",
            'name' => $filename,
        ];
        $notification->settings = $settings;
        $notification->save();

        return $this->success([
            'src' => $settings['video']['src'],
            'name' => $settings['video']['name']
        ]);

    }

    /**
     * @param User $user
     * @param int $push_id
     * @param string $token
     * @return JsonResponse
     */
    public function uploadimage(User $user, int $push_id, string $token) {

        if (!$notification = PushNotification::whereUserId($user->id)->find($push_id)) {
            return $this->fail('Ошибка при выборе уведомления');
        }

        $validator = Validator::make($_FILES, [
            'filepond' => 'required|array',
            'filepond.tmp_name' => 'required|string',
            'filepond.name' => 'required|string',
        ])->validate();
        $file = $_FILES['filepond'];
        $type = explode('/', $file['type'])[0];

        $path = "storage/uploads/{$user->id}/{$type}";
        $dir = public_path($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fileinfo = pathinfo($file['name']);
        $filename = str_slug($fileinfo['filename']) . '.' .  $fileinfo['extension'];
        copy($file['tmp_name'], "{$dir}/{$filename}");

        $settings = $notification->settings;
        $settings['attachment'] = [
            'src'  =>  "/{$path}/{$filename}",
            'name' => $filename,
            'type' => $type,
        ];
        $notification->settings = $settings;
        $notification->save();

        return $this->success($settings['attachment']);
    }

    /**
     * @param User $user
     * @param string $type
     * @param string $token
     * @return StreamedResponse
     */
    public function server(User $user, string $type, string $token)
    {
        Notification::whereIsShow('0')
            ->whereType($type)
            ->whereUserId($user->id)
            ->update(['is_show' => '1']);

        $response = new StreamedResponse(function() use ($user, $type) {
            while(true) {
                $notifications = PushNotification::whereUserId($user->id)->get();
                if ( $notification = Notification::where([
                        ['type', $type],
                        ['is_show', '=', '0'],
                        ['user_id', '=', $user->id]
                    ])->first() ) {
                    $notification->is_show = '1';
                    $notification->save();

                    $pushSettings = $notifications->where('type', '=', $type)
                                        ->where('activate', '<=', (int) $notification->counter)
                                        ->where('activate_end', '>=', (int) $notification->counter)
                                        ->sortByDesc('activate')
                                        ->first();

                    $settings = fetchSettings($user, $pushSettings, $type);
                    $settings['pushSettings'] = $pushSettings;

                        // echo "data: " . json_encode([]) . "\n\n";
                    echo 'data: ' . json_encode(compact('notification', 'settings')) . "\n\n";
                } else {
                    echo "data: " . json_encode(compact('settings')) . "\n\n";
                }
                ob_flush();
                flush();
                sleep(6);
            }
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        return $response;
   }

    /**
     * @param User $user
     * @param int $push_id
     * @param string $token
     * @return Factory|View
     */
    public function client(User $user, int $push_id, string $token)
    {
        $serverLink = "/api/push/server/{$user->id}/{$token}";
        $settingsLink = "/api/push/settings/{$user->id}/{$token}";

        return view('push', compact('serverLink', 'settingsLink', 'token', 'user', 'push_id'));
    }

    /**
     * @param User $user
     * @param string $type
     * @param string $token
     * @return Factory|View
     */
    public function clientView(User $user, string $type, string $token)
    {
        $serverLink = "/api/push/server/{$user->id}/{$token}";
        $settingsLink = "/api/push/settings/{$user->id}/{$token}";

        return view('push', compact('serverLink', 'settingsLink', 'token', 'user', 'type'));
    }

    /**
     * @param User $user
     * @param int $push_id
     * @param string $token
     * @return JsonResponse
     */
    public function reset(User $user, int $push_id, string $token)
    {
        if (!$notification = PushNotification::whereUserId($user->id)->find($push_id)) {
            return $this->fail('Ошибка при выборе уведомления');
        }

        $default = settings('PushDonate')->settings;

        $notification->settings = [];

        return $this->success($default);

    }

    /**
     * @param User $user
     * @param int $push_id
     * @param string $token
     * @return JsonResponse
     */
    public function fetch(User $user, int $push_id, string $token)
    {
        if (!$notification = PushNotification::whereUserId($user->id)->find($push_id)) {
            return $this->fail('Ошибка при выборе уведомления');
        }

        $settings = settings('PushDonate')->settings;

        $keys = array_keys($settings);
        for ($i = 0; $i < count($keys); $i++) {
            if (empty($notification->settings[$keys[$i]])) {
                continue;
            }
            $mySettings = collect($notification->settings[$keys[$i]]);
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


        return $this->success($settings);
    }

    /**
     * @param User $user
     * @param int $push_id
     * @return JsonResponse
     */
    public function testNotification(User $user, int $push_id)
    {
        if (!$push = PushNotification::whereUserId($user->id)->find($push_id)) {
            return $this->fail('Ошибка при выборе уведомления');
        }
        $notification = Notification::create([
            'user_id' => $user->id,
            'counter' => $push->activate . ' ' . ($push->type == 'donate' ? 'руб.' : 'мес.'),
            'type' => $push->type,
            'title' => $user->login ?? 'Аноним',
            'message' => 'Тестовое уведомление',
        ]);

        return $this->success($notification);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param int $push_id
     * @param string $token
     * @return JsonResponse
     */
    public function save(Request $request, User $user, int $push_id, string $token)
    {
        if (!$notification = PushNotification::whereUserId($user->id)->find($push_id)) {
            return $this->fail('Ошибка при выборе уведомления');
        }
        $validator = Validator::make($request->all(), [
            'settings' => 'required|array',
            'settings.*' => 'required|array',

            'settings.main.minVoice' => 'nullable|integer',
            'settings.main.minDonate' => 'nullable|integer',
            'settings.main.duration' => 'required|integer|min:10',
            'settings.main.sound' => 'required|array',
            'settings.main.sound.src' => 'nullable|string',
            'settings.main.sound.volume' => 'required|integer|min:1|max:9',

            'settings.image.color' => 'nullable|string',
            'settings.image.tile' => 'required|boolean',
            'settings.image.size' => 'integer',
            'settings.image.src' => 'required|string',

            'settings.name.color' => 'nullable|string',
            'settings.name.size' => 'required|integer',
            'settings.name.font' => 'nullable|exists:fonts,class',

            'settings.amount.color' => 'nullable|string',
            'settings.amount.size' => 'required|integer',
            'settings.amount.font' => 'nullable|exists:fonts,class',

            'settings.message.color' => 'nullable|string',
            'settings.message.size' => 'required|integer',
            'settings.message.font' => 'nullable|exists:fonts,class',
        ])->validate();

        $notification->settings = $request->settings;
        $notification->save();

        return $this->success($request->settings);
    }
}
