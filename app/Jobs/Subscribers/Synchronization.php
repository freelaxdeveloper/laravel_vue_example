<?php

namespace App\Jobs\Subscribers;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\{SubscribeUser, Subscribers};
use App\Services\Subscribers\YouTube\Followers as FollowersYouTube;
class Synchronization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Количество попыток задания.
     *
     * @var int
     */
    public $tries = 3;

    protected $user;
    protected $users;
    protected $class;

    /**
     * Synchronization constructor.
     * @param User $user
     * @param array $users
     * @param $class
     */
    public function __construct(User $user, array $users, $class)
    {
        $this->user = $user;
        $this->users = $users;
        $this->class = $class;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = collect($this->users);
        $key = $this->class instanceof FollowersYouTube ? '_id' : 'user._id';

        $subscribers = Subscribers::whereIn('_id', $users->pluck($key))->get();

        foreach ($subscribers as $subscriber) {
            $who = $users->where($key, $subscriber->_id)->first();
            subscribe(
                $this->user,
                $subscriber,
                $this->class->setAttributes($who, $this->user),
                'YouTube'
            );
        }

        // отписываем подписчиков которые уже отписались но еще числятся в нашей базе как подписанные
        if ($this->class->isReset()) {
            SubscribeUser::whereUserId($this->user->id)
                ->whereNotIn('subscribers_id', $subscribers->pluck('id'))
                ->when($this->class->getType() == 'paid', function ($query) {
                    return $query->where('paid', '<=', Carbon::now()->subMonth(1));
                })
                ->update($this->class->setDefaultValue());
        }
    }
}
