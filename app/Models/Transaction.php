<?php

namespace App\Models;

use App\User;

use App\Models\Paykeeper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Transaction
 * @package App\Models
 */
class Transaction extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'who_id', 'amount', 'message', 'name', 'info', 'commission'];

    /**
     * @var array
     */
    protected $appends = ['created_at_humans'];

    /**
     * @var array
     */
    protected $with = ['who', 'user'];

    /**
     * @var array
     */
    protected $casts = [
        'info' => 'array',
    ];

    /**
     * @return |null
     */
    public function getCreatedAtHumansAttribute()
    {
        if ($date = $this->created_at) {
            return $date->diffForHumans();
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function paykeeper()
    {
        return $this->belongsTo(Paykeeper::class, 'id', 'orderid')->whereServiceName('donate');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function who()
    {
        return $this->belongsTo(User::class);
    }

}
