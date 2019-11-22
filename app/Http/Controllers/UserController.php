<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use JWTAuth;
use App\User;
use App\Models\{Transaction, Subscribers, PushNotification, Paykeeper, Notification};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use DB;

class UserController extends Controller
{

    /**
     * @SWG\Get(
     *     path="/api/user",
     *     summary="Профиль пользователя",
     *     tags={"Users"},
     *     description="Профиль авторизованного пользователя",
     *     security={
     *         {"passport": {}},
     *     },
     *     @SWG\Response(
     *         response=200,
     *         description="Анкетные данные",
     *         @SWG\Schema(ref="#/definitions/UserProfile"),
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
     * @return JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $this->user()->append('stream_hash_link');

        return $this->success($user);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function milestones(User $user)
    {
        $ank = $this->user();

        if (!checkSubscribe($ank, $user)) {
            return $this->success([
                'badges' => [],
                'animations' => [],
                'music' => [],
            ]);
        }


        $sumDonate = Transaction::whereWhoId($ank->id)->whereUserId($user->id)->sum('amount');
        // return $this->success($sumDonate);

        $milestones = $user->milestones()
            ->whereHas('user', function($q) use ($ank) {
                return $q->whereHas('subscribers', function($q) use ($ank) {
                    return $q->where('_id', '=', $ank->twitch_id)->orWhere('_id', '=', $ank->youtube_id);
                });
            })
            ->where('donate', '<=', $sumDonate)
            ->get();

        $badges = collect([]);
        $animations = collect([]);
        $music = collect([]);
        foreach ($milestones as $milestone) {
            $badges->push($milestone->badges);
            $animations->push($milestone->animations);
            $music->push($milestone->music);
        }
        $badges = $badges->flatten();
        $animations = $animations->flatten();
        $music = $music->flatten();

        return $this->success(compact('badges', 'animations', 'music'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function mycards(Request $request)
    {
        $user = $this->user();

        return $this->success($user->cards);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribers(Request $request)
    {
        $user = $this->user();
        $subscribers = $user->subscribers()->whereHas('service', function ($query) use ($user) {
            return $query->whereName($user->accout_type)->orWhere('name', 'Streamdonations');
        })->get();

        return $this->success($subscribers);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function checkSubscriber(User $user)
    {
        return $this->success(checkSubscribe($this->user(), $user));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function mydonat(User $user)
    {
        $sumDonate = Transaction::whereWhoId($this->user()->id)->whereUserId($user->id)->sum('amount');

        return $this->success(number_format($sumDonate, 0, '.', ''));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function mynotification(User $user)
    {
        $notifications = $this->getNotifications();

        return $this->success($notifications);
    }

    /**
     * @param $notifi_id
     * @return JsonResponse
     */
    public function notificationDelete($notifi_id)
    {
        if (!$notification = PushNotification::whereUserId($this->user()->id)->find($notifi_id)) {
            return $this->fail('Ошибка при удалении');
        }
        $notification->delete();

        $notifications = $this->getNotifications();

        return $this->success($notifications);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function mynotificationAdded(Request $request)
    {
        Validator::make($request->all(), [
            'value' => 'required|integer|min:1',
            'type' => 'required|in:donate,free,paid,premium',
        ])->validate();

        if (PushNotification::whereUserId($this->user()->id)
                ->whereActivate($request->value)
                ->whereType($request->type)
                ->first()
        ) {
            return $this->fail('Уведомление такого типа уже существует');
        }

        $notification = PushNotification::create([
            'activate' => $request->value,
            'type' => $request->type,
            'user_id' => $this->user()->id,
        ]);

        $notifications = $this->getNotifications();

        return $this->success($notifications);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function premiumSubscribed(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'mounth' => 'required|integer|min:1',
        ])->validate();

        $subscribe = checkSubscribe($this->user(), $user, 'premium');

        $date = $subscribe ? Carbon::parse($subscribe) : Carbon::now();
        $date = $date->addMonth($request->mounth)->format('Y-m-d H:i:s');

        DB::beginTransaction();
        try {
            if (!$subscriber = Subscribers::where('_id', $this->user()->twitch_id)->orWhere('_id', $this->user()->youtube_id)->orWhere('_id', $this->user()->id)->first()) {
                $subscriber = Subscribers::create([
                    '_id' => $this->user()->id,
                    'name' => $this->user()->name,
                    'display_name' => $this->user()->name,
                    'bio' => '',
                    'logo' => $this->user()->avatar,
                    'service_id' => service('Streamdonations'),
                ]);
            }
            $token = paykeeper()->request([], '/info/settings/token/')->fetch('token');
            $options = [
                'pay_amount'   => settings('subscribers')->settings['costPremium'] * $request->mounth,
                'clientid'     => $this->user()->name,
                'orderid'      => $subscriber->id,
                'service_name' => 'Подписка',
              ];
              $paykeeper = paykeeper()->setToken($token)->request($options, '/change/invoice/preview/');
              $invoice_id = $paykeeper->fetch('invoice_id');
              $link = $paykeeper->fetchLink();

              Paykeeper::create([
                'id' => $invoice_id,
                'user_id' => $this->user()->id,
                'who_id' => $user->id,
                'orderid' => $subscriber->id,
                'service_name' => 'subscription',
              ]);
              DB::commit();

              return $this->success([
                'message' => 'Выберите способ оплаты',
                'order_id' => $invoice_id,
              ], null);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            DB::rollBack();
            return $this->fail('Ошибка. Попробуйте позже.');
        }

        return $this->fail('Ошибка. Попробуйте позже.');
    }

    /**
     * @param string $service
     * @return JsonResponse
     */
    public function serviceDisconnect(string $service)
    {
        $service = strtolower($service);

        $user = $this->user();

        $info = $user->info;
        unset($info[$service]);

        $user->info = $info;
        $user->save();

        return $this->success(['success' => true, 'user' => $user]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $settings = $request->only([
            'currency', 'time_zone', 'language'
        ]);

        $user = $this->user();
        $user->settings = $settings;
        $user->save();

        return $this->success(['success' => true]);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function userInfo(User $user)
    {
        return $this->success($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function recentoperations(Request $request)
    {
        $operations = Notification::whereIsTest(false)->whereUserId($this->user()->id)->paginate(7);

        return $this->success($operations);
    }

    /**
     * @return string
     */
    public function myStreamLink()
    {
        return base64_encode(Hash::make($this->user()->streamlink));
    }


    /**
     * @SWG\Get(
     *     path="/api/fetchlinks",
     *     summary="Ссылки для отображения в профиле",
     *     tags={"Users"},
     *     description="Список ссылок на страницу доната, подписку, видео...",
     *     security={
     *         {"passport": {}},
     *     },
     *     @SWG\Response(
     *         response=200,
     *         description="Массив ссылок: Донат, Подписка, ",
     *         @SWG\Schema(ref="#/definitions/FetchLinks"),
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
     * @return JsonResponse
     */
    public function fetchlinks(Request $request)
    {
        $links = [];
        $types = ['donate', 'free', 'paid', 'premium'];
        $user = $request->user();
        $token = base64_encode(Hash::make($user->streamlink));
        for ($i = 0; $i < count($types); $i++) {
            $links[$types[$i]] = $request->root() . "/api/push/client/{$user->id}/{$types[$i]}/{$token}/view";
        }

        $list = [
            ['name' => 'Донат', 'type' => 'donate', 'link' => $links['donate']],
            ['name' => 'Подписка', 'type' => 'free', 'link' => $links['free']],
            ['name' => 'Платная подписка', 'type' => 'paid', 'link' => $links['paid']],
            ['name' => 'Премиум подписка', 'type' => 'premium', 'link' => $links['premium']],
            ['name' => 'Форма для доната', 'type' => 'donate_form', 'link' => url("/#/payment/{$user->id}")],
            ['name' => 'Видео', 'type' => 'videoplay', 'link' => url("/{$user->id}/{$token}/youtube")],
        ];

        return $this->success($list);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDonationFormData(Request $request)
    {
        $user = $request->streamer ? User::findOrFail($request->streamer) : $this->user();
        $data = [];
        $data['form_settings'] = $user->settings['donate'];
        $data['streamer_info'] = $user;
        return $this->success($data);
    }

    /**
     * @return mixed
     */
    private function getNotifications()
    {
        return PushNotification::whereUserId($this->user()->id)->get()->groupBy('type');
    }
}
