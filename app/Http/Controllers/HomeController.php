<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\VK;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Font;
use App\User;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function vkauth()
    {
        echo (new Vk)->oauthLink('VK oauth');
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function test(Request $request)
    {
        $message = '';
        switch ($request->type) {
            case 1:
                $message = 'Пример последнего сообщения';
                break;
            case 2:
                $message = 'Это самое дорогое сообщение';
                break;
            case 3:
                $message = 'Тут самый крупный донатер';
                break;
            case 4:
                $message = 'Последний подписчки';
                break;
            case 5:
                $message = '1025 подписчиков';
                break;
            case 6:
                $message = '1025 подписчиков за';
                break;
            case 7:
                $message = '1,000,000руб.';
                break;

            default:
                # code...
                break;
        }
        if ($request->type == 4 || $request->type == 5 || $request->type == 6) {
            switch ($request->subscriber) {
                case 1:
                    $message .= ' (премиум)';
                    break;
                case 2:
                    $message .= ' (платный)';
                    break;
                case 3:
                    $message .= ' (бесплатный)';
                    break;
                case 4:
                    $message .= ' (любой)';
                    break;

                default:
                    # code...
                    break;
            }
        }
        if ($request->type == 6) {
            switch ($request->period) {
                case 1:
                    $message .= ' (день)';
                    break;
                case 2:
                    $message .= ' (неделя)';
                    break;
                case 3:
                    $message .= ' (месяц)';
                    break;
                case 4:
                    $message .= ' (квартал)';
                    break;
                case 5:
                    $message .= ' (пол года)';
                    break;
                case 6:
                    $message .= ' (год)';
                    break;

                default:
                    # code...
                    break;
            }
        }
        return $this->success($message);
    }

    /**
     * @return JsonResponse
     */
    public function fonts()
    {
        $fonts = Font::get(['name', 'class']);

        return $this->success($fonts);
    }

    /**
     * @return JsonResponse
     */
    public function icons()
    {
        $icons = ['mdi-arrow-all', 'mdi-arrow-bottom-left', 'mdi-arrow-bottom-left-bold-outline', 'mdi-arrow-expand-left', 'mdi-arrow-left', 'mdi-arrow-left-bold', 'mdi-arrow-left-bold-box', 'mdi-arrow-left-bold-box-outline', 'mdi-arrow-left-bold-circle', 'mdi-arrow-left-bold-circle-outline', 'mdi-arrow-left-bold-outline', 'mdi-arrow-left-drop-circle', 'mdi-arrow-left-thick', 'mdi-comment-arrow-left', 'mdi-ray-end-arrow', 'mdi-bullseye-arrow', 'mdi-comment-arrow-right', 'mdi-comment-arrow-right-outline', 'mdi-arrow-right', 'mdi-arrow-right-bold', 'mdi-arrow-right-bold-circle', 'mdi-arrow-right-drop-circle', 'mdi-arrow-right-thick', 'mdi-gnome', 'mdi-golf', 'mdi-cash-usd', 'mdi-currency-usd', 'mdi-currency-usd-off', 'mdi-eye-off-outline'];

        return $this->success($icons);
    }
}
