<?php

return [
  'user' => env('PAYKEEPER_USER', 'demo'),
  'password' => env('PAYKEEPER_PASSWORD', 'demo'),
  'server_paykeeper' => env('PAYKEEPER_SERVER', 'demo.paykeeper.ru'),
  'secret_seed' => env('PAYKEEPER_SEED', 'verysecretseed'),
];