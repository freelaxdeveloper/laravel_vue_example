<?php namespace App\Services\Oauth;

use App\Models\Subscribers;
use App\User;

/**
 * Class App
 * @package App\Services\Oauth
 */
class App
{
    /**
     * @var string|null
     */
    public $redirect;
    /**
     * @var string
     */
    protected $email; // User email
    /**
     * @var mixed
     */
    public $newUser;

    public function __construct()
    {
        $this->redirect = $this->getRedirect();
    }

    /**
     * @return string|null
     */
    private function getRedirect()
    {
        return !empty($_COOKIE['redirect']) ? url('/', [], env('HTTPS_FORCE')) . '/' . $_COOKIE['redirect'] : null;
    }

    /**
     * @return mixed
     */
    public function createUser()
    {
        $data = collect($this->user)->only([
            'bio', 'type', 'display_name', 'logo', 'avatar', 'name', 'service_id'
        ])->toArray();

        if (!isset($data['logo']) && isset($data['avatar'])) {
            $data['logo'] = $data['avatar'];
            unset($data['avatar']);
        }

        Subscribers::updateOrCreate(['_id' => $this->user['twitch_id']], $data);

        return  User::withTrashed()->firstOrCreate(['email' => $this->email], $this->user);
    }
}
