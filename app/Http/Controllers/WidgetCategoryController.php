<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\{WidgetCategory, Widget};
use Illuminate\Http\Request;

class WidgetCategoryController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $widget_categories = WidgetCategory::select(['title AS value', 'message', 'slug'])->get();

        return $this->success($widget_categories);
    }

    /**
     * @param WidgetCategory $widgetCategory
     * @return Factory|JsonResponse|View
     */
    public function show(WidgetCategory $widgetCategory)
    {
        if ( !$widget = Widget::whereActive(1)->whereWidgetCategoryId($widgetCategory->id)->first() ) {
            return response()->json(['error' => 'Нету активных виджетов']);
        }
        $widget->stream_hash_link = $widget->user->stream_hash_link;

        return view('widget', compact('widget', 'widgetCategory'));
    }
}
