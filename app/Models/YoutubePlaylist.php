<?php

namespace App\Models;

use App\Models\Paykeeper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class YoutubePlaylist
 * @package App\Models
 */
class YoutubePlaylist extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['paykeeper_id', 'video_id', 'user_id'];

    /**
     * @return BelongsTo
     */
    public function paykeeper () {
        return $this->belongsTo(Paykeeper::class);
    }
}
