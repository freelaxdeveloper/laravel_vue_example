<?php namespace App\Services\Subscribers\Twitch;

use Carbon\Carbon;

/**
 * Class SubscriberData
 * @package App\Services\Subscribers\Twitch
 */
class SubscriberData
{
  public $subscriber;

  public function __construct($subscriber)
  {
    $this->subscriber = $subscriber;
  }

    /**
     * @return array
     */
  public function getData()
  {
    return [
      '_id'  => $this->subscriber['_id'],
      'bio'  => $this->subscriber['bio'],
      'logo' => $this->subscriber['logo'],
      'name' => $this->subscriber['name'],
      'created_at'   => $this->converDate($this->subscriber['created_at']),
      'updated_at'   => $this->converDate($this->subscriber['updated_at']),
      'service_id'   => service('Twitch'),
      'display_name' => $this->subscriber['display_name'],
    ];
  }

  private function converDate(string $date)
  {
      return Carbon::parse($date)->format('Y-m-d H:i:s');
  }
}
