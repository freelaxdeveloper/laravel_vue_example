<?php namespace App\Services\Subscribers\YouTube;

class Subscriber
{
  public $subscriber;

  public function __construct(\Google_Service_YouTube_Subscription $subscriber)
  {
    $this->subscriber = $subscriber->subscriberSnippet;
  }

  public function getData()
  {
    return [
      '_id' => $this->subscriber->channelId,
      'bio' => $this->subscriber->description,
      'display_name' => $this->subscriber->title,
      'logo' => $this->subscriber->thumbnails->medium->url,
      'name' => $this->subscriber->title,
      'service_id' => service('youtube'),
    ];
  }
}