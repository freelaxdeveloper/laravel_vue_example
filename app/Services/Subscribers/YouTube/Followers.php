<?php namespace App\Services\Subscribers\YouTube;

use App\Interfaces\Subscribers;

class Followers implements Subscribers {

  public function getMethod(): string {
    return '';
  }

  public function getField(): string {
    return '';
  }

  public function getType(): string {
    return 'free';
  }

  public function isReset(): bool {
    return false;
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