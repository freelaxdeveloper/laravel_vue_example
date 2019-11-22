<?php

namespace App\Models;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;

use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Widget
 * @package App\Models
 */
class Widget extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'uri', 'slug', 'options', 'settings', 'user_id',
        'widget_category_id', 'animation', 'active', 'settings2',
    ];
    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $appends = ['link', 'animation_ru'];
    /**
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'settings' => 'array',
        'settings2' => 'array',
        'active' => 'bool',
    ];

    /**
     * @return string
     */
    public function getAnimationRuAttribute()
    {
        switch ($this->attributes['animation'] ?? '') {
            case 'crawl-line': return 'Бегущая строка';
            case 'widget-slider': return 'Слайдер';
            default: return 'Стандарт';
        }
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return UrlGenerator|string
     */
    public function getLinkAttribute()
    {
        return url("api/widget/{$this->slug}");
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $hash = static::slugGenerate();
            while(Widget::whereSlug($hash)->first()) {
                $hash = static::slugGenerate();
            }
            $model->slug = $hash;
        });
    }

    /**
     * @return string
     */
    private static function slugGenerate()
    {
        return md5(microtime()) . str_random(mt_rand(40, 80));
    }
}
