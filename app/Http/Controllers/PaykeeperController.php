<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Validator;
use App\Models\{Paykeeper, Notification};
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
class PaykeeperController extends Controller
{

    public function test()
    {
        $token = paykeeper()->auth()->request([], '/info/settings/token/')->fetch('token');

        $options = [
            "pay_amount" => 42.50,
            "clientid" => "Иванов Иван Иванович",
            "orderid" => "Заказ № 10",
            "client_email" => "test@example.com",
            "service_name" => "Услуга",
            "client_phone" => "8 (910) 123-45-67"
        ];

        $paykeeper = paykeeper()->setToken($token)->request($options, '/change/invoice/preview/');
        $invoice_id = $paykeeper->fetch('invoice_id');

        dd($paykeeper->fetchLink());
    }

    /**
     * для теста
     */
    public function status()
    {
        $invoice_id = '20190106014554404';

        $status = paykeeper()->auth()->status($invoice_id)->fetch('status');

        dd($status);
    }

    public function fethPayment(int $paykeeper_id)
    {
        if (!$paykeeper = Paykeeper::whereStatus('created')->find($paykeeper_id)) {
            return $this->fail('Платеж не найден');
        }
        return $this->success($paykeeper);
    }

    public function paykeeperAlert(Request $request)
    {
        // https://docs.paykeeper.ru/metody-integratsii/priyom-post-opoveshhenij/

        $validator = Validator::make($request->all(), [
            'id'              => 'required|integer', # Уникальный номер платежа
            'sum'             => 'required|numeric', # Сумма платежа
            'clientid'        => 'string',  # Фамилия Имя Отчество
            'orderid'         => 'required|integer', # Номер заказа
            'key'             => 'required|string',  # Цифровая подпись запроса, строка из символов a-f и 0-9
            'ps_id'           => 'required|integer', # Идентификатор платежной системы
            'service_name'    => 'string',  # Наименование услуги
            'client_email'    => 'nullable|string',  # Адрес электронной почты
            'batch_date'      => 'string',  # Дата списания авторизованного платежа
            'client_phone'    => 'nullable|string',  # Телефон
            'fop_receipt_key' => 'string',  # Код страницы чека 54-ФЗ
            'bank_id'         => 'integer', # Идентификатор привязки карты
            'card_number'     => 'string',  # Маскированный номер карты
            'card_holder'     => 'string',  # Держатель карты
            'card_expiry'     => 'string',  # Срок действия карты
        ]);

        if ($validator->fails()) {
            \Log::info($validator->errors());
            return 'Error validator!';
            // dd($validator->errors());
        }
        $paykeeper = Paykeeper::whereOrderid($request->orderid)->orderByDesc('id')->first();

        $signature = md5 ($request->id.number_format($request->sum, 2, ".", "").$request->clientid.$request->orderid.paykeeper()->secret_seed);

        if ($request->key != $signature) {
            \Log::info("paykeeperAlert: {$signature}");
            return 'Error! Hash mismatch';
        }

        $paykeeper->status = 'paid';
        $paykeeper->save();

        if ($paykeeper->service_name == 'subscription') {
            $user = User::find($paykeeper->user_id);

            $ank = User::find($paykeeper->who_id);

            $subscribe = checkSubscribe($user, $ank, 'premium');

            $date = $subscribe ? Carbon::parse($subscribe) : Carbon::now();
            $mounth = floor($request->sum / settings('subscribers')->settings['costPremium']);
            $date = $date->addMonth($mounth)->format('Y-m-d H:i:s');
            subscribe($ank, $paykeeper->order, [
                'premium' => $date
            ]);
        }

        // TODO: создать нотификейшин

        $hash = md5($request->id . paykeeper()->secret_seed);
        \Log::info("OK {$hash}");
        return "OK {$hash}";
    }
}
