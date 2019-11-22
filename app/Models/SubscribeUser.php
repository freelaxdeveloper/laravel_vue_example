<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * Class SubscribeUser
 * @package App\Models
 */
class SubscribeUser extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'subscribers_user';

    /**
     * @var array
     */
    protected $fillable = ['free', 'paid', 'paid_counter', 'premium', 'service_id', 'user_id', 'subscribers_id'];

    /**
     * @return int
     */
    public function getFreeAttribute() {
        return (int) $this->attributes['free'];
    }

    /**
     * @return int
     */
    public function getPaidAttribute() {
        return (int) $this->attributes['paid'];
    }
}
