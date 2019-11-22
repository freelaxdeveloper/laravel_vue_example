<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Validator;
use App\Services\Hash;
use App\Services\Setting;
use Illuminate\Http\Request;
use App\Models\{Transaction, Notification, Token, Badge, Paykeeper, YoutubePlaylist};
use JWTAuth;
use DB;

class TransactionController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
  public function donateInfo(Request $request)
  {
    Validator::make($request->all(), [
      'amount' => 'required|numeric',
    ])->validate();

    $donate = donate()->convert($request->amount, false);
    $settings = donate()->settings;

    return $this->success(compact('donate', 'settings'));
  }

    /**
     * @param Request $request
     * @return JsonResponse
     */
  public function donate(Request $request)
  {
    Validator::make($request->all(), [
      'amount' => 'required|numeric',
      'user_id' => 'required|exists:users,id',
      'badge_id' => 'nullable|numeric|exists:badges,id',
      'animate_id' => 'nullable|numeric|exists:animation_milestone,id',
      'ank.login' => 'required',
      'ank.message' => 'required',
      'youtubeVideoID' => 'nullable|alpha_dash'
    ])->validate();

    if ($user = $this->user()) {
      if ($request->ank['login'] != 'Аноним') {
        $user->login = $request->ank['login'];
        $user->save();
      }
    }

    $commission = $request->commission ? true : false;
    $donate = donate()->convert($request->amount, $commission);
    $settings = donate()->settings;
    $info = compact('donate', 'settings');

    $request->amount = $donate['amount'];

    DB::beginTransaction();

    try {
      $transaction = Transaction::create([
        'user_id' => $request->user_id,
        'who_id' => $user->id ?? null,
        'amount' => $request->amount,
        'info' => $info,
        'commission' => $donate['commission'],
        'message' => $request->ank['message'],
        'name' => $request->ank['login'],
      ]);
      $token = paykeeper()->request([], '/info/settings/token/')->fetch('token');
      $options = [
        "pay_amount" => $request->amount + $donate['commission'],
        "clientid" => $request->ank['login'],
        "orderid" => $transaction->id,
        "service_name" => 'Донат',
      ];
      $paykeeper = paykeeper()->setToken($token)->request($options, '/change/invoice/preview/');
      $invoice_id = $paykeeper->fetch('invoice_id');
      $link = $paykeeper->fetchLink();

      $paykeeper = Paykeeper::create([
        'id' => $invoice_id,
        'orderid' => $transaction->id,
        'who_id' => $request->user_id,
        'service_name' => 'donate',
      ]);

      if ($request->youtubeVideoID) {
        YoutubePlaylist::create([
          'paykeeper_id' => $paykeeper->id,
          'video_id' => $request->youtubeVideoID,
          'user_id' => $request->user_id,
        ]);
      }
      DB::commit();
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
      DB::rollBack();
      return $this->fail('Ошибка. Попробуйте позже.');
    }

    $badge = Badge::find($request->badge_id);

    $path = "storage/google";
    $dir = public_path($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }

    // $message = urlencode($request->ank['message']);
    // copy("https://translate.google.com.vn/translate_tts?ie=UTF-8&q={$message}&tl=ru&client=tw-ob", $dir . "/{$notification['id']}.mp3");

    return $this->success([
      'message' => 'Выберите способ оплаты',
      'order_id' => $invoice_id,
    ]);
  }

    /**
     * @param Request $request
     * @return JsonResponse
     */
  public function transactionsStatistic (Request $request)
  {
    $user = $request->user();
    $currentMonth = date('m');

    $statistic = [
        'count' => $user->transactions()->count(),
        'sum' => $user->transactions()->sum('amount'),
        'current_mounth' => [
            'count' => $user->transactions()->whereRaw('MONTH(created_at) = ?',[$currentMonth])->count(),
            'sum' => $user->transactions()->whereRaw('MONTH(created_at) = ?',[$currentMonth])->sum('amount'),
        ]
    ];

    return $this->success($statistic);
  }

    /**
     * @param Request $request
     * @return JsonResponse
     */
  public function transactions(Request $request)
  {
    Validator::make($request->all(), [
      'sortBy' => 'in:id,name,amount,created_at,platform',
      'rowsPerPage' => 'integer',
      'descending' => 'in:true,false',
      'dateFrom' => 'nullable|date',
      'dateTo' => 'nullable|date',
    ])->validate();
    $user = $request->user();

    $request->rowsPerPage = -1 == $request->rowsPerPage ? $user->transactions()->count() : $request->rowsPerPage;

    $request->descending = $request->descending == 'false' ? 'ASC' : 'DESC';

    $transactions = $user->transactions()
      ->with('paykeeper')
      ->whereHas('paykeeper', function ($query) {
        return $query->whereStatus('paid');
      })
      ->when($request->sortBy, function ($query) use ($request) {
        if ('name' == $request->sortBy) {
          return $query->with(['who' => function ($query) use ($request) {
            return $query->orderBy($request->sortBy, $request->descending);
          }]);
        }
        return $query->orderBy($request->sortBy, $request->descending);
      }, function ($query) {
        return $query->orderBy('id', 'asc');
      })
      ->when($request->dateFrom, function ($query) use ($request) {
        return $query->where('created_at', '>=', $request->dateFrom);
      })
      ->when($request->dateTo, function ($query) use ($request) {
        return $query->where('created_at', '<=', $request->dateTo);
      });
    //   ->paginate($request->rowsPerPage);

    if ($request->has('all')) {
        $transactions = $transactions->get();
    } else {
        $transactions = $transactions->paginate($request->rowsPerPage);
    }

    return $this->success($transactions);
  }
}
