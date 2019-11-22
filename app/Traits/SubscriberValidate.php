<?php namespace App\Traits;

use Validator;

trait SubscriberValidate
{

  public function validate()
  {
    $validator = Validator::make($this->subscriber, [
      '_id' => 'required|string',
      'bio' => 'required|string',
      'display_name' => 'required|string',
      'logo' => 'required|string',
      'name' => 'required|string',
      'service_id' => 'required|string',
    ]);

    return $validator;
  }
}