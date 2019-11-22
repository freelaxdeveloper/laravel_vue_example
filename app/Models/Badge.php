<?php

namespace App\Models;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Badge
 * @package App\Models
 */
class Badge extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'size', 'path'];
    /**
     * @var array
     */
    protected $hidden = ['path', 'updated_at', 'created_at'];
    /**
     * @var array
     */
    protected $appends = ['src', 'disabled'];

    /**
     * @return UrlGenerator|string
     */
    public function getSrcAttribute()
    {
        return url(str_replace(public_path(), '', $this->attributes['path']));
    }

    /**
     * @return bool
     */
    public function getDisabledAttribute(): Bool
    {
        return false;
    }
}
