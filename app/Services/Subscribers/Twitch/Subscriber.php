<?php namespace App\Services\Subscribers\Twitch;

use Carbon\Carbon;
use App\Models\SubscribeUser;
use App\Interfaces\Subscribers as SubscribersInterface;

class Subscriber implements SubscribersInterface {

  public function getMethod(): string {
    return 'subscribers';
  }

  public function getField(): string {
    return 'subscriptions';
  }

  public function getType(): string {
    return 'paid';
  }

  public function isReset(): bool {
    return true;
  }

  public function setDefaultValue(): array {
    return [
      'paid_counter' => 1
    ];
  }

  public function setAttributes($subscriber, $user): array {
    $currentSubscribe = $user->subscribers()->where('_id', $subscriber['user']['_id'])->first();
    $paid_counter = $currentSubscribe->pivot->paid_counter ?? 1;

    try {
      $old_date = Carbon::parse($currentSubscribe->pivot->paid);
      $diff = Carbon::parse($subscriber['created_at'])->diffInDays($old_date);
      if ($diff) {
        $paid_counter = $diff < (31 + 4) ? ++$paid_counter : 1;
      }
      
    } catch (\Exception $e) {
      \Log::error('Ошибка при обновлении счётчика платых подписок подряд: ' . $e->getMessage() );
    }

    return [
      $this->getType() => $this->getValue($subscriber),
      'paid_counter' => $paid_counter
    ];
  }

  public function getValue($subscriber): ?string {

    try {
      return Carbon::parse($subscriber['created_at'])->format('Y-m-d H:i:s');
    } catch (\Exception $e) {
      return null;
    }
    
  }

}