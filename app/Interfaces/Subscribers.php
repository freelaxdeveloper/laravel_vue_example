<?php namespace App\Interfaces;

interface Subscribers {

  /**
   * Вызываемый метод twitch api
   */
  public function getMethod();

  /**
   * ключ поля в response твича с пользователями
   */
  public function getField();

  /**
   * тип подписки (free, paid, premium)
   */
  public function getType();

  /**
   * нужно ли обнулять значение поля value
   */
  public function isReset();

  /**
   * 
   */
  public function setDefaultValue();

  /**
   * какие атрибуты, на какие значения нужно обновить в базе
   */
  public function setAttributes($subscriber, $user);

  /**
   * значение которое будет зписываться в таблицу subscribers_user
   * для типа free: 0, 1
   * paid: 1000, 2000m, 3000
   * premium: дата в формате - 2018-11-10 22:05:16
   */
  public function getValue($subscriber);
  
}