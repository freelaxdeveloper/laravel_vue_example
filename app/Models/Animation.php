<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Animation
 * @package App\Models
 */
class Animation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['animate'];
    /**
     * @var array
     */
    protected $appends = ['duration', 'test'];

    /**
     * @return int
     */
    public function getDurationAttribute()
    {
        return 1000;
    }

    /**
     * @return array
     */
    public function getTestAttribute()
    {
        return ['duration' => 1000, 'id' => $this->id, 'animate' => $this->animate];
    }
}
