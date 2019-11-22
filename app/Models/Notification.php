<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Animation, AnimationMilestone};
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Notification
 * @package App\Models
 */
class Notification extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'message', 'counter', 'user_id', 'type', 'image', 'animate_id', 'is_show', 'is_test'
    ];
    /**
     * @var array
     */
    protected $with = ['animate'];

    /**
     * @var array
     */
    protected $casts = [
        'is_test' => 'boolean'
    ];

    /**
     * @return HasOne
     */
    public function animate()
    {
        return $this->hasOne(AnimationMilestone::class, 'id', 'animate_id');
    }
}
