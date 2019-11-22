<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubscribeUser;
use App\Models\Service;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Subscribers
 * @package App\Models
 */
class Subscribers extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $with = ['service'];
    /**
     * @var array
     */
    protected $fillable = ['_id', 'bio', 'display_name', 'logo', 'name', 'service_id', 'type'];

    /**
     * @param $query
     * @param string $service
     * @return mixed
     */
    public function scopeService($query, string $service)
    {
        return $query->whereHas('service', function ($query) use ($service) {
            return $query->whereName($service)->orWhere('name', 'Streamdonations');
        });
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCurrentMonth($query)
    {
        return $query->whereRaw('MONTH(subscribers_user.created_at) = ?', [date('m')]);
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->using(SubscribeUser::class)->withPivot([
            'free',
            'paid',
            'premium',
        ]);
    }

    /**
     * @return BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
