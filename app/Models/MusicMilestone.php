<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MusicMilestone
 * @package App\Models
 */
class MusicMilestone extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['src', 'milestone_id'];
    /**
     * @var array
     */
    protected $appends = ['name'];

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return basename($this->src);
    }
}
