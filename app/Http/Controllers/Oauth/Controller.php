<?php namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller as ParentController;
use Log;

class Controller extends ParentController
{
    protected function log(string $message, array $options = [])
    {
      $user_data = [
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user-agent' => $_SERVER['HTTP_USER_AGENT'],
      ];

      $options = array_merge($options, $user_data);

      Log::channel('failed-auth')->error($message, $options);
    }

}
