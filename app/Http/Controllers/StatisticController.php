<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;
use App\Models\Transaction;
use Carbon\Carbon;
use JWTAuth;
use DB;

class StatisticController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function fetchSubscribers ()
    {
        $user = $this->user();

        $subscribers = $user->subscribers()->service($user->accout_type)->select(['display_name'])->get()->toArray() ?? [];
        $subscribers = collect($subscribers);
        $total = $subscribers->count();

        $count_free = $subscribers->where('pivot.free', 1)->count();
        $count_paid = $subscribers->where('pivot.paid', '>=', Carbon::now())->count();
        $count_premium = $subscribers->where('pivot.premium', '>=', Carbon::now())->count();

        $statistic = [
            'all' => $total,
            'mounth' => $user->subscribers()->currentMonth()->count(),
            'chart' => [
                ['label' => 'Простая', 'value' => averageValue($count_free,    $total), 'color' => '#D6D6EA'],
                ['label' => 'Премиум', 'value' => averageValue($count_premium, $total), 'color' => '#8280FF'],
                ['label' => 'Платная', 'value' => averageValue($count_paid,    $total), 'color' => '#636393'],
            ]
        ];

        return $this->success($statistic);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchDonate(Request $request)
    {
        $user = $request->user();
        $currentMonth = $request->mounth ?? date('m');

        $transactions = Transaction::whereUserId($user->id)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            ->get([
                DB::raw('CONCAT_WS(" ", DAY(created_at), MONTHNAME(created_at)) as date'),
                DB::raw('COUNT(*) as "count"'),
                DB::raw('SUM(`amount`) as "sum_donate"'),
                DB::raw('SUM(`commission`) as "sum_commission"'),
            ]
        );
        $labels = $transactions->pluck('date');
		$series = $transactions->pluck('count');
		$sum_donate = $transactions->pluck('sum_donate');
		$sum_commission = $transactions->pluck('sum_commission');
        return $this->success(compact('labels', 'series', 'sum_donate', 'sum_commission'));
    }

}
