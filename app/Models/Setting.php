<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App\Models
 */
class Setting extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['settings'];

    /**
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
    ];
}
