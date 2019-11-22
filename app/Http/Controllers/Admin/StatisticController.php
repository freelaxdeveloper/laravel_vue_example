<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Models\Transaction;
use Carbon\Carbon;
use JWTAuth;
use DB;

class StatisticController extends Controller
{

    public function fetchDonate()
    {
        $transactions = Transaction::
            // where('created_at', '>=', Carbon::now()->subMonth())
            groupBy('date')
            ->get([
                DB::raw('CONCAT_WS("/", month(created_at), DAY(created_at)) as date'),
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
