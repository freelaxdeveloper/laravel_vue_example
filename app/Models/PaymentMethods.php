<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethods
 * @package App\Models
 */
class PaymentMethods extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'user_id', 'number'];

    /**
     * @var bool
     */
    public $timestamps = false;

}
