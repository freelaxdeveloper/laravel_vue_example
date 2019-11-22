<?php namespace App\Services\Subscribers;

use Log;
class Subscriber
{
  use \App\Traits\SubscriberValidate;

  public $subscriber;

  public $_id;
  public $bio;
  public $name;
  public $logo;
  public $service_id;
  public $display_name;

    /**
     * Subscriber constructor.
     * @param array $subscriber
     */
  public function __construct(Array $subscriber)
  {
    $this->subscriber = $subscriber;

    if ($this->validate()->fails()) {
      return Log::channel('failed-subscriber')
              ->error(
                json_encode($this->subscriber),
                $this->validate()->errors()->all()
            );
    }

    $this->_id = $subscriber['_id'];
    $this->bio = $subscriber['bio'];
    $this->name = $subscriber['name'];
    $this->logo = $subscriber['logo'];
    $this->service_id = $subscriber['service_id'];
    $this->display_name = $subscriber['display_name'];
  }
}
