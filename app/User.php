<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\{
    Transaction,
    Token,
    Subscribers,
    SubscribeUser,
    Badge,
    MilestoneBadge,
    Milestone
};

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'info', 'avatar', 'is_vk', 'youtube_id', 'twitch_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'info'
    ];

    protected $appends = [
        'status', 'type', 'social_youtube', 'social_twitch', 'social_vkontakte', 'currency', 'time_zone', 'language'
    ];

    protected $casts = [
        'info' => 'Array',
        'settings' => 'Array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // protected $with = ['transactions'];

    public function setSettingsAttribute(Array $settings)
    {
        $settings_old = $this->settings ?? [];
        $settings = array_merge($settings_old, $settings);

        $this->attributes['settings'] = json_encode($settings);
    }

    public function getStatusAttribute()
    {
        if ($this->deleted_at) return 'deleted';

        if ($this->blocked_at) return 'draft';

        return 'published';
    }

    public function getCurrencyAttribute()
    {
        return $this->settings['currency'] ?? 'RUS';
    }

    public function getTimeZoneAttribute()
    {
        return $this->settings['time_zone'] ?? '(UTC+3:00) Европа/Москва';
    }

    public function getLanguageAttribute()
    {
        return $this->settings['language'] ?? 'Русский';
    }

    public function getSocialTwitchAttribute()
    {
        return $this->isSocial('twitch');
    }

    public function getSocialGoogleAttribute()
    {
        return $this->isSocial('google');
    }

    public function getSocialYouTubeAttribute()
    {
        return $this->isSocial('youtube');
    }

    public function getSocialVkontakteAttribute()
    {
        return $this->isSocial('vkontakte');
    }

    protected function isSocial(string $social): Bool {
        return in_array($social, array_keys($this->info));
    }

    public function getBgImageAttribute()
    {
        // return '';
        $bgImagePath = "/storage/uploads/{$this->id}/formdonate/";
        $files = glob(public_path($bgImagePath) . '*');
        if (empty($files[0])) {
            return '';
        }
        $bgImage = $bgImagePath . basename($files[0]);
        \Log::info($files);
        return $bgImage;
    }

    public function updateStatus($status)
    {
        switch ($status) {
            case 'draft':
                $this->blocked_at = \Carbon\Carbon::now();
                $this->restore();
            break;
            case 'published':
                $this->blocked_at = null;
                $this->restore();
            break;
            case 'deleted':
                $this->delete();
            break;
        }
        return $this->save();
    }

    public function getTypeAttribute()
    {
        return collect($this->info)->keys();
        return 'twitch';
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getStreamlinkAttribute()
    {
        return md5(env('SECRET_STREAM_LINK') . sha1($this->id) . $this->email) . env('SECRET_STREAM_LINK');
    }

    public function getStreamHashLinkAttribute()
    {
        return base64_encode(Hash::make($this->streamlink));
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscribers::class)->withPivot([
            'free',
            'paid',
            'paid_counter',
            'premium',
        ]);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function cards()
    {
        return $this->hasMany(Token::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
