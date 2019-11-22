<?php namespace App\Services;

/**
 * Class VK
 * @package App\Services
 */
class VK {
  protected $APP_ID;
  protected $TOKEN;
  protected $PROXY_IP;
  protected $PROXY_PORT;
  protected $SCOPE;
  protected $MY_GROUP_ID;

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
     * @param string $title
     * @return string
     */
  public function oauthLink(string $title): string
  {
    return "<a href='https://oauth.vk.com/authorize?client_id={$this->APP_ID}&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope={$this->SCOPE}&response_type=token&v=5.37'>{$title}</a>";
  }

    /**
     * @param string $message
     * @param string $attachment
     * @return $this
     */
  public function sendGroupMessage(string $message, string $attachment = '')
  {
    $params = array_merge(['owner_id' => $this->MY_GROUP_ID, 'attachment' => $attachment], compact('message'));

    return $this->request('wall.post', $params);
  }

    /**
     * @param string $method
     * @param array $params
     * @return $this
     */
  public function request(string $method, array $params)
  {
    $params = array_merge($params, [
      'access_token' => $this->TOKEN,
      'v' => '5.37',
    ]);

    $url = "https://api.vk.com/method/{$method}";
    $proxy = $this->PROXY_IP && $this->PROXY_IP ? "{$this->PROXY_IP}:{$this->PROXY_PORT}" : null;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    if ($proxy) {
      curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $this->response = json_decode(curl_exec($ch));
    curl_close($ch);
    return $this;
  }

  protected function setConfig()
  {
    $config = config('vk');
    foreach ($config as $key => $value) {
      if (property_exists($this, $key)) {
        $this->{$key} = $value;
      }
    }
  }

}
