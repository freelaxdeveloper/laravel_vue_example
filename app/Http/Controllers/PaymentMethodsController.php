<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PaymentMethods;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class PaymentMethodsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $validator = Validator::make($this->request->all(), [
            'code' => 'required|string',
            'number' => 'required|string',
        ])->validate();

        $paymentMethod = PaymentMethods::create([
            'code' => $request->code,
            'number' => $request->number,
            'user_id' => $this->user()->id
        ]);

        return $this->success($paymentMethod);
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        return $this->success(
            PaymentMethods::where('user_id', $this->user()->id)->get()
        );
    }

    /**
     * @param PaymentMethods $paymentMethod
     * @return JsonResponse
     */
    public function remove(PaymentMethods $paymentMethod)
    {
        try {
            $paymentMethod->delete();
            return $this->success('Платежный метод успешно удалён');
        } catch (\Exception $e) {
            report($e);
        }


        return $this->fail('Не удалось удалить');
    }

    /**
     * @param int $paymentId
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $paymentId, Request $request)
    {
        if ($request->toggle) {
            PaymentMethods::where([
                ['user_id', $this->user()->id],
                ['id', '!=', $paymentId]
            ])->update(['active' => false]);

            $active = PaymentMethods::find($paymentId);
            $active->active = true;
            $active->save();
        } else {
            PaymentMethods::whereUserId($this->user()->id)->whereId($paymentId)->update($request->only(['number', 'code']));
        }

        return $this->success(PaymentMethods::whereUserId($this->user()->id));
    }
}
