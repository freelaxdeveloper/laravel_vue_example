<?php namespace App\Services;

/**
 * Class Hash
 * @package App\Services
 */
class Hash
{
    /**
     * @var false|string
     */
  protected $secret_key;
    /**
     * @var string
     */
  protected $secret_iv;
    /**
     * @var string
     */
  protected $encrypt_method = 'AES-256-CBC';

  public function __construct()
  {
    $this->secret_key = $this->getKeyContent();
    $this->secret_iv = bin2hex(env('JWT_SECRET'));
  }

    /**
     * @param String $string
     * @return String
     */
  public function decrypt(String $string): String
  {
    return openssl_decrypt(base64_decode($string), $this->encrypt_method, $this->key(), 0, $this->iv());
  }

    /**
     * @param String $string
     * @return String
     */
  public function encrypt(String $string): String
  {
    $output = openssl_encrypt($string, $this->encrypt_method, $this->key(), 0, $this->iv());

    return base64_encode($output);
  }

    /**
     * @return false|string
     */
  protected function key()
  {
    return $this->secret_key;
  }

    /**
     * @return false|string
     */
  protected function iv()
  {
    return substr(hash('sha256', $this->secret_iv), 0, 16);
  }

    /**
     * @return false|string
     */
  protected function getKeyContent()
  {
    $key_path = storage_path('keys/private.key');

    return file_get_contents($key_path);
  }
}
