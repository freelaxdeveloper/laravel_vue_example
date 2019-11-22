<?php namespace App\Services\Subscribers\Twitch;

use App\Interfaces\Subscribers;

class Followers implements Subscribers {

  public function getMethod(): string {
    return 'followers';
  }

  public function getField(): string {
    return 'follows';
  }

  public function getType(): string {
    return 'free';
  }

  public function isReset(): bool {
    return true;
  }

  public function setDefaultValue(): array {
    return [
      $this->getType() => null
    ];
  }

  public function setAttributes($subscriber, $user): array {
    return [
      $this->getType() => $this->getValue($subscriber)
    ];
  }

  public function getValue($subscriber): string {
    return '1';
  }

}