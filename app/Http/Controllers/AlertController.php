<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\{PushNotification, Notification};

class AlertController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $alerts = PushNotification::whereUserId($this->user()->id)->orderByDesc('id')->get();

        return $this->success([
            'donate' => $alerts->where('type', 'donate'),
            'subscribe' => $alerts->where('type', '!=', 'donate'),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        list($activate, $activate_end) = $request->range_value;

        if ($request->has('strick') && $request->type != 'donate') {
            $activate = $request->strick;
            $activate_end = $request->strick;
        }

        PushNotification::create([
            'activate' => $activate,
            'activate_end' => $activate_end,
            'type' => $request->type,
            'user_id' => $this->user()->id,
            'settings' => $request->all(),
        ]);

        return $this->success(['success' => true]);
    }

    /**
     * @param Request $request
     * @param string $type
     */
    public function preview(Request $request, string $type)
    {
        Notification::create([
            'image' => $request->image,
            'title' => $request->title,
            'message' => $request->message,
            'counter' => $request->counter,
            'type' => $type,
            'user_id' => $this->user()->id,
        ]);
    }

    public function image(Request $request)
    {
        $path = $request->file('file')->store('alerts', 'public');

        return $this->success($path);
    }

    /**
     * @param Request $request
     * @param int $alert_id
     * @return JsonResponse
     */
    public function update(Request $request, int $alert_id)
    {
        $request->merge([
            'image' => str_replace(\URL::to('/storage'), '', $request->image),
            'sound' => str_replace(\URL::to('/storage'), '', $request->sound),
        ]);

        list($activate, $activate_end) = $request->range_value ?? $request->settings['range_value'];

        if ($request->has('strick') && $request->type != 'donate') {
            $activate = $request->strick;
            $activate_end = $request->strick;
        }

        $data = $request->only([
            'active', 'activate', 'activate_end', 'type'
        ]);

        $data['activate'] = $activate;
        $data['activate_end'] = $activate_end;
        $settings = $request->settings ?? $request->all();
        $data['settings'] = json_encode($settings);

        PushNotification::whereUserId($this->user()->id)->whereId($alert_id)->update($data);

        return $this->success(['success' => true]);
    }

    /**
     * @param int $alert_id
     * @return JsonResponse
     */
    public function destroy(int $alert_id)
    {
        PushNotification::whereUserId($this->user()->id)->whereId($alert_id)->delete();

        return $this->success(['success' => true]);
    }
}
