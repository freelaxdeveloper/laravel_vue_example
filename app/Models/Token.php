<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Hash;

/**
 * Class Token
 * @package App\Models
 */
class Token extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['token', 'user_id', 'hash'];
    /**
     * @var array
     */
    protected $hidden = ['token', 'hash'];
    /**
     * @var array
     */
    protected $appends = ['card'];

    /**
     * @return mixed
     */
    public function getCardAttribute()
    {
        return json_decode((new Hash)->decrypt($this->token));
    }
}
