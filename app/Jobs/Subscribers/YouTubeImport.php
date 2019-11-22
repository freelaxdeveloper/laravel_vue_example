<?php

namespace App\Jobs\Subscribers;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Services\Subscribers\YouTube\Subscriber as YouTubeSubscriber;
use App\Services\Subscribers\Subscriber;
use App\User;

class YouTubeImport implements ShouldQueue
{

    /**
     * @var int
     */
    public $tries = 3;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * YouTubeImport constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @throws \Google_Exception
     */
    public function handle()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('client_secret.json'));
        $client->addScope(\Google_Service_YouTube::YOUTUBE_READONLY);
        $client->setAccessType('offline');        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth

        $client->setAccessToken(json_encode($this->user->info['youtube']['token']));
        $youtube = new \Google_Service_YouTube($client);
        $subscriptions = $youtube->subscriptions->listSubscriptions('subscriberSnippet,snippet,contentDetails', array('mySubscribers' => true));

        $subscribers = [];

        foreach ($subscriptions->items as $subscriber) {
            if (!$this->user->youtube_id) {
                $this->user->youtube_id = $subscriber->snippet->resourceId->channelId ?? null;
                $this->user->save();
            }
            $YouTubeSubscriber = new YouTubeSubscriber($subscriber);
            $subscriber = new Subscriber($YouTubeSubscriber->getData());

            if ($subscriber->_id) {
                $subscribers[] = $subscriber;
            }
        }

        (new \App\Services\Subscribers\Import($subscribers, $this->user))->startImport();
    }
}
