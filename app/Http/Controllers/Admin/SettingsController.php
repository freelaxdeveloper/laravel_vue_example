<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Models\Setting;
use JWTAuth;

class SettingsController extends Controller
{

    public function fetchDonate()
    {
        return $this->success(donate()->settings);
    }

    public function fetchSubscriber()
    {
        return $this->success(settings('subscribers'));
    }

    public function saveSubscriber(Request $request)
    {
        Validator::make($request->all(), [
            'costPremium' => 'required|integer',
        ])->validate();

        $settings = $request->only([
            'costPremium'
        ]);

        if (settings('subscribers')->save($settings)) {
            return $this->success('Настройки сохранены');
        }

        return $this->fail('Ошибка при сохранении настроек');
    }

    public function saveDonate(Request $request)
    {
        Validator::make($request->all(), [
            'commission' => 'required|numeric',
            'minAmount' => 'required|integer',
            'minCommissionAmount' => 'required|integer',
            'percent' => 'required|boolean',
        ])->validate();

        $settings = $request->only([
            'commission', 'minAmount', 'minCommissionAmount', 'percent'
        ]);

        if (donate()->save($settings)) {
            return $this->success('Настройки сохранены');
        }

        return $this->fail('Ошибка при сохранении настроек');
    }

}
