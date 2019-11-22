<?php

namespace App\Models;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;

use App\Models\Widget;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class WidgetCategory
 * @package App\Models
 */
class WidgetCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'message', 'slug'];
    /**
     * @var array
     */
    protected $appends = ['active', 'link', 'method'];

    /**
     * @return bool
     */
    public function getActiveAttribute()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getMethodAttribute()
    {
        switch ($this->attributes['title'] ?? $this->attributes['value'] ?? '') {
            case 'Последнее сообщение': return 'lastmessage';
            case 'Самый крупный донатер': return 'largestdonater';
            case 'Последний донатер': return 'lastdonater';
            case 'Последний подписчик': return 'lastsubscriber';
            case 'Количество подписчиков за период': return 'lastsubscriber';
            case 'Сбор средств': return 'amountcollected';
        }
    }

    /**
     * @return UrlGenerator|string
     */
    public function getLinkAttribute()
    {
        return route('widget.view', $this);

        return url($this->attributes['slug']);
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return HasMany
     */
    public function collapseItem()
    {
        return $this->hasMany(Widget::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $hash = static::slugGenerate();
            while(WidgetCategory::whereSlug($hash)->first()) {
                $hash = static::slugGenerate();
            }
            $model->slug = $hash;
        });
    }

    /**
     * @return string
     */
    public static function slugGenerate()
    {
        return md5(microtime()) . str_random(mt_rand(40, 80));
    }
}
