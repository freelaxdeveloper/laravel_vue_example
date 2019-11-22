<?php namespace App\Services;

/**
 * Class Twitch
 * @package App\Services
 */
class Twitch {
    /**
     * @var mixed
     */
  public $info;

    /**
     * @var string
     */
  protected $client_id;
    /**
     * @var string
     */
  protected $client_secret;
    /**
     * @var string
     */
  protected $redirect_url;
    /**
     * @var mixed
     */
  protected $webhooks_callback;
    /**
     * @var array
     */
  protected $scopes;
    /**
     * @var string
     */
  protected $type;

    /**
     * @var mixed
     */
  protected $response;

  public function __construct()
  {
    $this->setConfig();
  }

    /**
     * @return mixed
     */
  public function response()
  {
    return $this->response;
  }

    /**
     * @param int $twitch_id
     * @return $this
     */
  public function subscribeStream(int $twitch_id)
  {
    $request = [
      'hub.mode' => 'subscribe',
      'hub.topic' => "https://api.twitch.tv/helix/streams?user_id={$twitch_id}",
      'hub.callback' => $this->webhooks_callback,
      'hub.lease_seconds' => 864000,
    ];
    $this->request('webhooks/hub', $request);
    if ($this->info['http_code'] != 202) {
      $errors = json_decode($this->response(), true);
      \Log::channel('twitch-webhook')
        ->info("Не удалось подписаться на стрим: #twitch_id-{$twitch_id}", compact('request', 'errors'));
    }

    return $this;
  }

    /**
     * @param string $method
     * @param array $params
     * @return $this
     */
  public function request(string $method, array $params)
  {
    $url = "https://api.twitch.tv/{$this->type}/{$method}";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      "Client-ID: {$this->client_id}",
    ]);
    $this->response = curl_exec($ch);
    $this->info = curl_getinfo($ch);
    curl_close($ch);
    return $this;
  }

    /**
     * @return void
     */
  protected function setConfig()
  {
    $config = config('twitch-api');
    foreach ($config as $key => $value) {
      if (property_exists($this, $key)) {
        $this->{$key} = $value;
      }
    }
  }

}
