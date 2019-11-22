<?php namespace App\Services;

use App\Services\Setting;

/**
 * Class Donate
 * @package App\Services
 */
class Donate
{
    /**
     * @var \App\Services\Setting
     */
  protected $donate;
    /**
     * @var array|bool
     */
  public $settings;

  public function __construct()
  {
    $this->donate = settings('Donate');
    $this->settings = $this->settings();
    $this->settings['minAmount'] = $this->minDonate();
  }

    /**
     * @param float $donate
     * @param bool $is_paid
     * @return array
     */
  public function convert(float $donate, bool $is_paid = true): array
  {
    $amount = $total = $donate = $this->roundAmount($donate);
    $commission = 0;

    // если комиссии нету возвращаем то что пришло
    if (!$this->settings['commission']) {
      return compact('donate', 'amount', 'commission', 'total');
    }

    // если комиссия в процентах, вычитываем в процентах
    if ($this->settings['percent']) {
      $commission = $this->roundAmount($amount / 100 * $this->settings['commission']);
    } else {
      $commission = $this->roundAmount($this->settings['commission']);
    }
    // если сумма денег с комиссии меньше чем указано для минимальной комиссии
    // устанавливаем это минимальное значение
    if ($this->settings['minCommissionAmount'] && $commission < $this->settings['minCommissionAmount']) {
      $commission = $this->settings['minCommissionAmount'];
    }

    // если донатер оплатил комиссию
    if ($is_paid) {
      $amount = $donate; // стример получает то, что донатер изначально ввёл для оплаты
      $total = $donate + $commission; // с донатера будет снято то что он ввёл + комиссия
    } else { // если донатер НЕ оплатил комиссию
      $amount = $donate - $commission; // стример получает то что ввёл донатер с вычетом комиссии
      $total = $donate; // донатер платит столько, сколько и вводил
    }

    return compact('donate', 'amount', 'commission', 'total', 'is_paid');
  }

    /**
     * @return float
     */
  public function minDonate(): float
  {
    $minDonate = $this->settings['minAmount'];
    // если комиссия не в % а фиксированая и, комиссия больше указанной минимальной суммы
    // за минимальную сумму считаем сумму комиссии + минимальная сумма
    if (!$this->settings['percent'] && $minDonate < $this->settings['commission']) {
      $minDonate = $this->settings['commission'] + $this->settings['minAmount'];
    }

    if ($this->settings['minCommissionAmount'] && $minDonate < $this->settings['minCommissionAmount']) {
      $minDonate = $this->settings['minCommissionAmount'] + $this->settings['minAmount'];
    }

    return $minDonate;
  }

    /**
     * @param float $amount
     * @return float
     */
  protected function roundAmount(float $amount): float
  {
    return round($amount, 2, PHP_ROUND_HALF_UP);
  }

    /**
     * @param array $settings
     * @return bool
     */
  public function save(array $settings)
  {
    return $this->donate->save($settings);
  }

    /**
     * @return array
     */
  protected function settings(): array
  {
    $settings = $this->donate->settings ?? [];

    return [
      'percent' => $settings['percent'] ?? true,
      'commission' => $settings['commission'] ?? 0,
      'minCommissionAmount' => $settings['minCommissionAmount'] ?? 30, // указывется сумма в рублях
      'minAmount' => $settings['minAmount'] ?? 1,
    ];
    /**
     * minCommissionAmount - возможность установить минимальную комиссию, актуально если она указана в процентах.
     *  к примеру установлено 10% комиссии, из суммы доната 1000руб. имеем 100руб дохода.
     *  из суммы 10руб. имеем 1руб. Мы можем установить минимальную сумму комиссии 5руб.
     *  теперь при донате в 1000руб, наш доход будет 100руб, при донате в 10руб. доход будет 5руб. а не 1руб.
     */
  }

}
