<?php namespace App\Services;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;

/**
 * Class Paykeeper
 * @package App\Services
 */
class Paykeeper
{
    /**
     * @var Repository|mixed
     */
  public $secret_seed;

    /**
     * @var array
     */
  protected $headers = [];
    /**
     * @var Repository|mixed
     */
  protected $user;
    /**
     * @var Repository|mixed
     */
  protected $password;
    /**
     * @var Repository|mixed
     */
  protected $server_paykeeper;
    /**
     * @var string
     */
  protected $token;
    /**
     * @var mixed
     */
  protected $response;

  public function __construct()
  {
    $this->user = config('paykeeper.user');
    $this->password = config('paykeeper.password');
    $this->secret_seed = config('paykeeper.secret_seed');
    $this->server_paykeeper = config('paykeeper.server_paykeeper');

    $this->setHeader('Content-Type: application/x-www-form-urlencoded');
    $this->auth();
  }

    /**
     * @param string $header
     * @return $this
     */
  protected function setHeader(string $header)
  {
    array_push($this->headers, $header);

    return $this;
  }

    /**
     * @param string $token
     * @return $this
     */
  public function setToken(string $token)
  {
    $this->token = $token;

    return $this;
  }

    /**
     * @return $this
     */
  public function auth()
  {
    $base64 = base64_encode("{$this->user}:{$this->password}");
    $this->setHeader("Authorization: Basic {$base64}");

    return $this;
  }

    /**
     * @param int $invoice_id
     * @return $this
     */
  public function status(int $invoice_id)
  {
    return $this->request([], "/info/invoice/byid/?id={$invoice_id}");
  }

    /**
     * @param array $options
     * @param string $uri
     * @return $this
     */
  public function request(array $options, string $uri)
  {
    $method = count($options) ? 'POST' : 'GET';

    if ($this->token) {
      $options = array_merge($options, ['token' => $this->token]);
    }
    # Для сетевых запросов в этом примере используется cURL
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $this->server_paykeeper . $uri);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($options));

    # Инициируем запрос к API
    $response = curl_exec($curl);
    $this->response = json_decode($response, true);

    return $this;
  }

    /**
     * @param string $key
     * @return mixed
     */
  public function fetch(string $key = '')
  {
    return $key ? $this->response[$key] : $this->response;
  }

    /**
     * @param int $invoice_id
     * @return string
     */
  public function link(int $invoice_id): string
  {
    return "http://{$this->server_paykeeper}/bill/{$invoice_id}/";
  }

    /**
     * @return string
     */
  public function fetchLink(): string
  {
    return $this->link($this->fetch('invoice_id'));
  }

}
