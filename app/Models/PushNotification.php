<?php

namespace App\Models;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Storage;
use Lang;

/**
 * Class PushNotification
 * @package App\Models
 */
class PushNotification extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'type', 'settings', 'activate', 'activate_end', 'active'];
    /**
     * @var array
     */
    protected $appends  = ['amount', 'icon', 'strick', 'link', 'image', 'sound'];
    /**
     * @var array
     */
    protected $casts    = [
        'settings' => 'array',
        'active'   => 'boolean',
    ];

    /**
     * @var static $_token
     */
    public static $_token;

    /**
     * @return array
     */
    public function getAmountAttribute()
    {
        return [
            'min' => $this->attributes['activate'],
            'max' => $this->attributes['activate_end'],
        ];
    }

    /**
     * @return UrlGenerator|string
     */
    public function getImageAttribute()
    {
        if (!$image = $this->settings['image']['src'] ?? null) {
            return '';
        }
        return url(Storage::url($image['src']));
    }

    /**
     * @return UrlGenerator|string
     */
    public function getSoundAttribute()
    {
        if (!$sound = $this->settings['sound'] ?? null) {
            return '';
        }
        return url(Storage::url($sound));
    }

    /**
     * @return string
     */
    public function getIconAttribute()
    {
        if ($this->attributes['type'] == 'free') {
            return 'simple-icon';
        }
        return 'prem-dark';
    }

    /**
     * @return string
     */
    public function getStrickAttribute()
    {
        $strick = $this->attributes['activate'] ?? 0;
        $text = Lang::choice('месяц|месяца|месяцев', $strick);

        return "{$strick} {$text}";
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        if (static::$_token === null && request()->user()) {
            static::$_token = base64_encode(Hash::make(request()->user()->streamlink));
        }
        $token = static::$_token;

        return request()->root() . "/api/push/client/{$this->attributes['user_id']}/{$this->attributes['type']}/{$token}/view";
    }
}
