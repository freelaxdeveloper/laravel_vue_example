<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\{Transaction, SubscribeUser};
use App\User;
use Validator;
use Carbon\Carbon;

class InsideStreamingController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * @param string $message
     * @param array $items
     * @return JsonResponse
     */
    private function response(string $message, array $items = [])
    {
        $itemString = implode(', ', $items);

        if (empty($itemString)) {
            $itemString = '[тестовое сообщение]';
        }

        $tpl = [
            '{{message}}' => $itemString,
            '{{subscriber}}' => $itemString,
            '{{count}}' => $itemString,
            '{{sum}}' => $itemString,
        ];
        $fullMessage = strtr($message, $tpl);
        $name = str_replace($itemString, '', $fullMessage);

        return $this->success(compact(
            'fullMessage', 'message', 'items', 'name'
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function lastMessage(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'widget_type.message' => 'required|string',
        ])->validate();

        $message = Transaction::whereUserId($user->id)->orderByDesc('id')->first(['message']);

        return $this->response($request->widget_type['message'], [$message->message ?? null]);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function mostExpensive(User $user)
    {
        $maxAmount = Transaction::whereUserId($user->id)->max('amount');

        $message = 'Самое дорогое сообщение: ' . number_format($maxAmount) . 'руб.';


        return $this->success($message);

    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function lastDonater(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'widget_type.message' => 'required|string',
            'type'  => 'nullable|in:free,paid,premium',
            'widget_list_count' => 'nullable|min:1|max:100',
        ])->validate();


        $ank = Transaction::with('paykeeper')->whereHas('paykeeper', function ($query) {
            return $query->whereStatus('paid');
          })->whereUserId($user->id)->orderByDesc('id')->first();

        return $this->response($ank->name ?? '');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function largestDonater(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'widget_list_count' => 'nullable|min:1|max:100',
            'widget_type.message' => 'required|string',
            'options.sort' => 'in:id,sum',
        ])->validate();

        $ankList = Transaction::with('paykeeper')->whereHas('paykeeper', function ($query) {
            return $query->whereStatus('paid');
          })->whereUserId($user->id)->groupBy('name', 'id')
            ->selectRaw('sum(amount) as sum, name, id')
            ->orderByDesc($request->input('options.sort', 'sum'))
            ->take($request->input('widget_list_count', 1))
            ->get()->pluck('name', 'sum');

        $content = explode('||', $request->widget_type['message']);
        $users = [];
        foreach ($ankList as $sum => $name) {
            $tpl = [
                '{{name}}' => $name,
                '{{sum}}' => number_format($sum),
            ];
            $users[] = strtr(trim($content[1]), $tpl);
        }

        if (!count($users) && !$request->is_test) {
            $users = ['DS1', 'DS2', 'DS3'];
        }

        $tpl = [
            '{{users}}' => implode(', ', $users),
        ];
        $content = strtr(trim($content[0]), $tpl);

        return $this->response($content, $users);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function lastSubscriber(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'widget_type.message' => 'required|string',
            'type'  => 'nullable|in:free,paid,premium',
            'widget_list_count' => 'nullable|min:1|max:100',
        ])->validate();

        $subscriber = $user->subscribers()->when($request->type, function ($query) use ($request) {
            return $query->whereNotNull($request->type);
        })->orderByDesc('pivot_subscribers_id')->take($request->input('widget_list_count', 1))->get()->pluck('display_name');


        if (!$subscriber->count() && $request->is_test) {
            $subscriber = collect(['DS1', 'DS2', 'DS3']);
        }

        $suffix = '';
        if ($subscriber->count() && $request->type) {
            switch ($request->type) {
                case 'free':
                    $suffix .= " (бесплатный)";
                    break;
                case 'paid':
                    $suffix .= " (платный)";
                    break;
                case 'premium':
                    $suffix .= " (премиум)";
                    break;
            }
        }

        return $this->response($request->widget_type['message'], $subscriber->toArray(), $suffix);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function numberSubscribers(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'widget_type.message' => 'required|string',
            'period' => 'nullable|in:subDay,subWeek,subMonth,subQuarter,subYear',
            'value'  => 'nullable|integer',
            'type'  => 'nullable|in:free,paid,premium',
        ])->validate();

        $count = SubscribeUser::whereUserId($user->id)
            ->when($request->type, function ($query) use ($request) {
                return $query->whereNotNull($request->type);
            })
            ->when($request->period, function ($query) use ($request) {
                $value = $request->value ?? 1;
                return $query->where('created_at', '>=', Carbon::now()->{$request->period}($value));
            })->count();

        $type = '';
        if ($request->type) {
            switch ($request->type) {
                case 'free':
                    $type = "бесплатных";
                    break;
                case 'paid':
                    $type = "платных";
                    break;
                case 'premium':
                    $type = "премиумных";
                    break;
            }
        }

        $period = '';
        if ($request->period) {
            switch ($request->period) {
                case 'subDay':
                    $period = "день";
                    break;
                case 'subWeek':
                    $period = "неделю";
                    break;
                case 'subMonth':
                    $period = "месяц";
                    break;
                case 'subQuarter':
                    $period = $request->value == 1 ? "квартал" : 'пол года';
                    break;
                case 'subYear':
                    $period = " за год";
                    break;
            }
        }

        $tpl = [
            '{{type}}' => $type,
            '{{period}}' => $period,
        ];
        $content = strtr($request->widget_type['message'], $tpl);


        return $this->response($content, [number_format($count)]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function amountCollected(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'widget_type.message' => 'required|string',
        ])->validate();

        $sumAmount = Transaction::whereUserId($user->id)->sum('amount');
        $sumAmount = number_format($sumAmount) . 'руб.';

        return $this->response($request->widget_type['message'], [$sumAmount]);
    }
}
