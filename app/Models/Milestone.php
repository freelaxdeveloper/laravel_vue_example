<?php

namespace App\Models;

use App\User;

use App\Models\{
    Badge, Animation, BadgeMilestone, AnimationMilestone, MusicMilestone
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Milestone
 * @package App\Models
 */
class Milestone extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['donate', 'user_id'];
    /**
     * @var array
     */
    protected $with = ['badges', 'animations', 'music'];

    /**
     * @param $donaterId
     * @param $streamerId
     * @return mixed
     */
    public static function getClosestMilestone($donaterId, $streamerId)
    {
        $donater = User::find($donaterId);
        $streamer = User::find($streamerId);
        $myDonate = number_format(
            Transaction::whereWhoId($donater->id)->whereUserId($streamer->id)->sum('amount'),
            2,
            '.',
            ''
        );
        return self::where(
            [
                ['user_id', $streamer->id],
                ['donate', '>=', $myDonate]
            ]
        )->orderBy('donate', 'desc');
    }

    /**
     * @return BelongsToMany
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class)->using(BadgeMilestone::class);
    }

    /**
     * @return BelongsToMany
     */
    public function animations()
    {
        return $this->belongsToMany(Animation::class)
            ->using(AnimationMilestone::class)
            ->withPivot('id', 'duration');
    }

    /**
     * @return HasMany
     */
    public function music()
    {
        return $this->hasMany(MusicMilestone::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
