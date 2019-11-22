<?php

namespace App\Console\Commands;

use App\User;

use TwitchApi;
use Carbon\Carbon;
use Illuminate\Console\Command;

use App\Services\Subscribers\Twitch\{Followers, Subscriber};
use App\Jobs\Subscribers\Import;

class ImportSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportSubscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт подписчиков';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('updated_at', '>', Carbon::now()->subHours(3)->toDateTimeString())->get();
        // \Log::info($users);
        foreach ($users as $user) {
            dispatch(new Import($user, new Followers));
            dispatch(new Import($user, new Subscriber));
            sleep(1);
        }
    }
}
