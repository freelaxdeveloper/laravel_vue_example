<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use App\Models\Setting;
use Validator;
use Illuminate\Filesystem\Filesystem;
class SettingsController extends Controller
{
    /**
     * @param $settings
     * @param $default
     */
    private function mergeSettings($settings, &$default)
    {
        foreach (array_keys($default) as $value) {
            if (isset($settings[$value])) {
                foreach ($default[$value] as $key => $test) {
                    if (is_array($test)) {
                        $default[$value][$key] = array_merge($test, $settings[$value][$key]);
                    } else {
                        $default[$value] = array_merge($default[$value], $settings[$value]);
                    }
                }
            }
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/mainsettings",
     *     summary="Список настроек",
     *     tags={"Settings"},
     *     @SWG\Response(
     *         response=200,
     *         description="Успешная операция",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/MainSettings")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Настройки не найдены",
     *     )
     * )
     */

    /**
     * @return JsonResponse
     */
    public function mainSettings()
    {
        $settings = Setting::pluck('settings', 'name');
        $settings_default = config('settings_default');

        $this->mergeSettings($settings, $settings_default);

        return $this->success($settings_default);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function videoUpload(Request $request)
    {
        $validator = Validator::make($_FILES, [
            'filepond' => 'required|array',
            'filepond.tmp_name' => 'required|string',
            'filepond.name' => 'required|string',
        ])->validate();
        $user = $request->user();
        $file = $_FILES['filepond'];

        $path = "/storage/uploads/{$user->id}/formdonatevideo";
        $dir = public_path($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $system = new Filesystem;
        $system->cleanDirectory($dir);

        $fileinfo = pathinfo($file['name']);
        $filename = 'formbg_' . time() . '.' .  $fileinfo['extension'];
        copy($file['tmp_name'], "{$dir}/{$filename}");

        $settings = $user->settings;
        $settings['donate']['main']['bgVideo'] = "{$path}/{$filename}";
        $settings['donate']['main']['bg'] = 'video';
        $user->settings = $settings;
        $user->save();

        return $this->success(['src' => "{$path}/{$filename}", 'name' => $filename]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function imageUpload(Request $request)
    {
        $validator = Validator::make($_FILES, [
            'file' => 'required|array',
            'file.tmp_name' => 'required|string',
            'file.name' => 'required|string',
        ])->validate();
        $user = $request->user();
        $file = $_FILES['file'];

        $path = "/storage/uploads/{$user->id}/formdonate";
        $dir = public_path($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $system = new Filesystem;
        $system->cleanDirectory($dir);

        $fileinfo = pathinfo($file['name']);
        $filename = 'formbg_' . time() . '.' .  $fileinfo['extension'];
        copy($file['tmp_name'], "{$dir}/{$filename}");

        return $this->success(['src' => "{$path}/{$filename}", 'name' => $filename]);
    }

    /**
     * @SWG\Put(
     *     path="/api/donate/settings/{user}",
     *     summary="Сброс настроек",
     *     tags={"Settings"},
     *     description="Сброс настроек",
     *     security={
     *         {"passport": {}},
     *     },
     *     @SWG\Parameter(
     *         name="user",
     *         in="path",
     *         description="User id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/MainSettings"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User is not found",
     *     )
     * )
     */

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function donateSettingsReset(Request $request, User $user) {

        if ($request->user()->id != $user->id) {
            return $this->fail('Доступ запрещён');
        }

        $destinationPath = public_path("/storage/uploads/{$user->id}/");
        $file = new Filesystem;
        $file->cleanDirectory($destinationPath);

        $settings = $user->settings;
        $settings['donate'] = [];
        $user->settings = $settings;
        $user->save();

        $settings = settings('DonateForm')->settings;

        return $this->success(['message' =>'Настройки сброшены', 'settings' => $settings]);

    }

    /***
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function donateSettingsSave(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'settings' => 'required|array',
            'settings.*' => 'required|array',
            'settings.main.bg' => 'required|in:image,color,default',
            'settings.main.bgColor' => 'nullable|string',
        ])->validate();

        if ($request->user()->id != $user->id) {
            return $this->fail('Доступ запрещён');
        }

        $settings = $user->settings;
        $settings['donate'] = $request->settings;
        $user->settings = $settings;
        $user->save();

        return $this->success('Настройки сохранены');
    }

    /**
     * @return JsonResponse
     */
    public function donateSettings()
    {
        $user = $this->user();
        $settings = settings('DonateForm')->settings;
        $keys = array_keys($settings);
        for ($i = 0; $i < count($keys); $i++) {
            if (empty($user->settings['donate'][$keys[$i]])) {
                continue;
            }
            $mySettings = collect($user->settings['donate'][$keys[$i]]);
            $mySettings = $mySettings->filter(function ($value, $key) {
                return $value !== null;
            });
            $mySettings->all();
            $settings[$keys[$i]] = array_merge($settings[$keys[$i]], $mySettings->all());
        }
        $settings['main']['bgImage'] = $user->bg_image;

        return $this->success($settings);
    }
}
