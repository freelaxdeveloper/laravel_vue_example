<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\{Admin, User};
use App\Models\Transaction;

class DashboardController extends Controller
{

    public function index()
    {
        $count = [
            'users' => [
                'count' => User::count()
            ],
            'transactions' => [
                'count' => Transaction::count(),
                'amount_sum' => Transaction::sum('amount'),
            ],
        ];
        return $this->success(['count' => $count]);
    }

}
