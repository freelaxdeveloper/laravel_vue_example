<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Animation;

/**
 * Class AnimationMilestone
 * @package App\Models
 */
class AnimationMilestone extends Pivot
{
    /**
     * @var array
     */
    protected $fillable = ['duration'];
    /**
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];
    /**
     * @var array
     */
    protected $with = ['animate'];

    /**
     * @return HasOne
     */
    public function animate()
    {
        return $this->hasOne(Animation::class, 'id', 'animation_id');
    }
}
