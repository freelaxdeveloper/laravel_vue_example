<?php namespace App\Services\Subscribers;

use App\Services\Subscribers\Subscriber;
use App\Jobs\Subscribers\Synchronization;
use App\User;
use DB;

/**
 * Class Import
 * @package App\Services\Subscribers
 */
class Import
{
  public $subscribers;
  public $user;
  public $fileds;

    /**
     * Import constructor.
     * @param array $subscribers
     * @param User $user
     */
  public function __construct(Array $subscribers, User $user)
  {
    $this->subscribers = $subscribers;
    $this->user = $user;
    $this->fileds = $this->getFieldsStr();
  }

  public function startImport()
  {
    $values = $users = [];
    foreach ($this->subscribers as $subscriber) {
      $users[] = $subscriber->subscriber;
      $values[] = $this->getValuesStr($subscriber);
    }

    $insertStr = implode(',', $values);

    try {
      DB::insert("INSERT IGNORE INTO `subscribers` ({$this->fileds}) VALUES {$insertStr}");

      dispatch((new Synchronization(
        $this->user,
        $users,
        new \App\Services\Subscribers\YouTube\Followers
      )));
    } catch (\Exception $e) {
      // не получилось добавить подписчиков в бд
      \Log::info($e->getMessage());
    }

    // dd($this->fileds);
  }

    /**
     * @param \App\Services\Subscribers\Subscriber $subscriber
     * @return string
     */
  protected function getValuesStr(Subscriber $subscriber)
  {
    if (!$subscriber->_id) {
      return '';
    }
    $values = array_values($subscriber->subscriber);
    foreach ($values as &$value) {
      $value = \str_replace('\'', "\\'", $value);
      $value = "'{$value}'";
    }

    return '(' . implode(',', $values) . ')';
  }


    /**
     * @return String
     */
  protected function getFieldsStr(): String
  {

    if (!count($this->subscribers)) {
      return '';
    }

    $fileds = array_keys($this->subscribers[0]->subscriber);

    return implode(',', $fileds);
  }

}
