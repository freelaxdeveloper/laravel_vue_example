<?php namespace App\Console;

trait Helper {

    /**
     * @param $validator
     * @return bool
     */
  public function showErrors($validator): Bool
  {
    if (!$validator->fails()) {
      return false;
    }

    $errors = $validator->errors()->all();
    foreach ($errors as $error) {
      $this->error($error);
    }

    return true;
  }
}
