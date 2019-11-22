<?php

namespace App\Jobs\Subscribers;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Services\Subscribers\Twitch\SubscriberData;
use App\Services\Subscribers\Subscriber;
use TwitchApi;
use App\User;

class TwitchImport implements ShouldQueue
{

    /**
     * Количество попыток задания.
     *
     * @var int
     */
    public $tries = 3;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $class;

    /**
     * TwitchImport constructor.
     * @param User $user
     * @param $subscribeClass
     * @throws \Exception
     */
    public function __construct(User $user, $subscribeClass)
    {
        $this->checkDependence($subscribeClass);

        $this->user = $user;
        $this->class = $subscribeClass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $options = [
            'limit' => 100,
        ];

        TwitchApi::setToken($this->user->info['twitch']['token']);
        $followers = TwitchApi::{$this->class->getMethod()}($this->user->twitch_id, $options);

        // при ошибке выходим из ф-ции
        if (!empty($followers->error)) {
           return;
        }

        $subscribers = [];
        foreach ($followers[$this->class->getField()] as $follower) {
            $subscriberData = new SubscriberData($follower['user']);
            $subscriber = new Subscriber($subscriberData->getData());

            if ($subscriber->_id) {
                $subscribers[] = $subscriber;
            }
        }

        (new \App\Services\Subscribers\Import($subscribers, $this->user))->startImport();
    }

    private function checkDependence($class)
    {
        $interface = 'App\\Interfaces\\Subscribers';
        $interfaces = array_values(class_implements($class));
        if (!in_array($interface, $interfaces)) {
            $className = get_class($class);
            throw new \Exception("{$className} должен реализовывть интерфейс {$interface}");
        }
    }
}
