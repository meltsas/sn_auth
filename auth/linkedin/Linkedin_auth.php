<?php

// Using library : https://github.com/ashwinks/PHP-LinkedIn-SDK

use LinkedIn\LinkedIn;

class Linkedin_auth implements Provider
{

    /**
     * @var LinkedIn $client
     */
    protected $client;
    protected $accessToken;
    /**
     * @var array $permissions
     */
    protected $permissions;

    /**
     * Linkedin_auth constructor.
     */
    public function __construct(array $conf, $baseUrl)
    {
        $keys = $conf['keys'];
        $this->permissions = $conf['permissions'];

        $this->client = new LinkedIn(
            [
                'api_key' => $keys['id'],
                'api_secret' => $keys['secret'],
                'callback_url' => $baseUrl
            ]
        );

//        if ($this->client) print_r('LinkedIn $client :' . print_r($this->client));
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
//        return $this->client->getLoginUrl([
//            LinkedIn::SCOPE_BASIC_PROFILE,
//            LinkedIn::SCOPE_EMAIL_ADDRESS]);
        return $this->client->getLoginUrl($this->permissions);
    }

    /**
     * @return mixed
     */
    public function setAccessToken()
    {
        if (isset($_REQUEST['code'])) $this->accessToken = $this->client->getAccessToken($_REQUEST['code']);
        if ($this->accessToken) return true;
        else return false;
    }

    /**
     * @return mixed
     */
    public function getPayLoad()
    {
        $payload = $this->client->get('/people/~:(first-name,last-name,positions,email-address,specialties,public-profile-url)');
        return $payload;
    }

}