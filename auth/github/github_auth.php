<?php

// Using library - https://github.com/thephpleague/oauth2-github

class github_auth implements Provider
{
    /**
     * @var \League\OAuth2\Client\Provider\Github
     */
    protected $client;
    protected $accessToken;
    protected $permissions;

    /**
     * github_auth constructor.
     * @param array $conf
     * @param mixed $baseUrl
     */
    public function __construct(array $conf, $baseUrl)
    {
        $keys = $conf['keys'];
        $this->permissions = $conf['permissions']; //scope

        $this->client = new League\OAuth2\Client\Provider\Github([
            'clientId' => $keys['id'],
            'clientSecret' => $keys['secret'],
            'redirectUri' => $baseUrl,
        ]);

    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        $options = [
            'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
            'scope' => $this->permissions
        ];
        $_SESSION['oauth2state'] = $this->client->getState();
        return $this->client->getAuthorizationUrl($options);
    }

    /**
     * @return mixed
     */
    public function setAccessToken()
    {
        // Try to get an access token (using the authorization code grant)
        if (isset($_GET['code'])) {
            $this->accessToken = $this->client->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            return $this->accessToken;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getPayLoad()
    {
        return $this->client->getResourceOwner($this->accessToken)->toArray();
    }

}