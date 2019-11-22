<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Font
 * @package App\Models
 */
class Font extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'class', 'path'];

    /**
     * @var array
     */
    protected $appends = ['value'];

    /**
     * @return mixed
     */
    public function getValueAttribute()
    {
        return $this->attributes['name'];
    }
}
