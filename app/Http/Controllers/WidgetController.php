<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\View\View;
use App\Models\{Widget, WidgetCategory};
use Validator;

class WidgetController extends Controller
{
    /***
     * @return JsonResponse
     */
    public function list()
    {
        $widgets = Widget::whereUserId($this->user()->id)->get();

        return $this->success($widgets);
    }

    /**
     * @return JsonResponse
     */
    public function listV2()
    {
        $widgets = WidgetCategory::with(['collapseItem' => function ($query) {
            return $query->whereUserId($this->user()->id);
        }])->whereHas('collapseItem', function ($query) {
            return $query->whereUserId($this->user()->id);
        })->select(['title', 'id', 'slug'])->get();

        return $this->success($widgets);
    }

    /**
     * @param Widget $widget
     * @return Factory|View
     */
    public function widget(Widget $widget)
    {
        $widget->stream_hash_link = $widget->user->stream_hash_link;

        return view('widget', compact('widget'));
    }

    /**
     * @param Request $request
     * @param Widget $widget
     * @return JsonResponse
     */
    public function editWidget(Request $request, Widget $widget)
    {
        Validator::make($request->all(), [
            'name'             => 'required|string',
            'uri'              => 'required|string',
            'options'          => 'nullable|array',
            'options.type'     => 'nullable|in:free,paid,premium',
            'options.value'    => 'nullable|integer|min:1',
            'options.period'   => 'nullable|in:subDay,subWeek,subMonth,subQuarter,subYear',
            'settings'         => 'nullable|array',
            'settings.marquee' => 'nullable|boolean',
            'settings.color'   => 'nullable|array',
            'settings.color.hex8'   => 'nullable|string',
            'settings.size'    => 'nullable|integer',
            'settings.speed'   => 'nullable|integer',
        ])->validate();

        $widget->uri = $request->uri;
        $widget->name = $request->name;
        $widget->options = $request->options;
        $widget->settings = $request->settings;
        $widget->save();

        return $this->list();
    }

    /**
     * @param Widget $widget
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Widget $widget)
    {
        if ($this->user()->id != $widget->user_id) {
            return $this->fail('Доступ запрещён!');
        }

        $widget->delete();
        return $this->success('Виджет успешно удалён');
    }

    /**
     * @param Widget $widget
     * @return JsonResponse
     */
    public function activate(Widget $widget)
    {
        if ($this->user()->id != $widget->user_id) {
            return $this->fail('Доступ запрещён!');
        }

        Widget::whereUserId($this->user()->id)
            ->whereWidgetCategoryId($widget->widget_category_id)
            ->update(['active' => false]);

        $widget->active = true;
        $widget->save();

        return $this->success(['success' => true]);
    }

    /**
     * @param Request $request
     * @param Widget $widget
     * @return JsonResponse
     */
    public function editWidgetV2(Request $request, Widget $widget)
    {
        $count = $request->settings['widget_list_count'];
        $animation = $request->settings['widget_animation']['class_name'];
        $category = WidgetCategory::whereTitle($request->settings['widget_type']['value'])->first();

        $data = [
            'count' => $count,
            'animation' => $animation,
            'widget_category_id' => $category->id,
            'settings2' => $request->settings,
        ];

        $widget->fill($data);
        $widget->save();

        return $this->success(['success' => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addV2(Request $request)
    {
        $count = $request->settings['widget_list_count'];
        $animation = $request->settings['widget_animation']['class_name'];
        $category = WidgetCategory::whereTitle($request->settings['widget_type']['value'])->first();

        $widgetExists = Widget::whereUserId($this->user()->id)->whereWidgetCategoryId($category->id)->count();

        $widget = Widget::create([
            'user_id' => $this->user()->id,
            'widget_category_id' => $category->id,
            'active' => !$widgetExists,
            'count' => $count,
            'uri' => str_random(16),
            'animation' => $animation,
            'settings2' => $request->settings,
        ]);

        return $this->success($widget);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        Validator::make($request->all(), [
            'name'             => 'required|string',
            'uri'              => 'required|string',
            'options'          => 'nullable|array',
            'options.type'     => 'nullable|in:free,paid,premium',
            'options.value'    => 'nullable|integer|min:1',
            'options.period'   => 'nullable|in:subDay,subWeek,subMonth,subQuarter,subYear',
            'settings'         => 'nullable|array',
            'settings.marquee' => 'nullable|boolean',
            'settings.color'   => 'nullable|array',
            'settings.color.hex8'   => 'nullable|string',
            'settings.size'    => 'nullable|integer',
            'settings.speed'   => 'nullable|integer',
        ])->validate();

        $widget = Widget::create([
            'user_id' => $this->user()->id,
            'name' => $request->name,
            'uri' => $request->uri,
            'options' => $request->options,
            'settings' => $request->settings,
        ]);

        return $this->success($widget);
    }
}
