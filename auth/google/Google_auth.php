<?php

/**
 * Class Google_auth
 */
class Google_auth implements Provider

{
    protected $client;
    protected $accessToken;

    /**
     * Google_auth constructor.
     * @param array $conf
     * @param mixed $baseUrl
     */
    public function __construct(array $conf, $baseUrl)

    {
        $keys = $conf['keys'];
        $permissions = $conf['permissions'];

        $this->client = new Google_Client();
        $this->client->setClientId($keys['id']);
        $this->client->setClientSecret($keys['secret']);
        $this->client->setRedirectUri($baseUrl);
        $this->client->setScopes($permissions);

    }


    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * @return mixed
     */
    public function setAccessToken()
    {
        if (isset($_GET['code'])) {
            try {
                $this->client->authenticate($_GET['code']);

                $this->accessToken = $this->client->getAccessToken();
                $this->client->setAccessToken($this->accessToken);

                return true;
            } catch (Google_Auth_Exception $e) {
                echo 'Error: Authentication exception: ' . $e;
            } catch (Exception $e) {
                echo 'Error: Uncaught exception: ' . $e;
            }
        }
        return false;

    }

    /**
     * @return mixed
     */
    public function getPayLoad()
    {
        $payload = $this->client->verifyIdToken()->getAttributes()['payload'];
        $plus = new Google_Service_Plus($this->client);  /* THEN PLACE THE $client INTO THE PLUS SERVICE */
        $me = $plus->people->get('me');
        $firstname = $me['name']['givenName'];
        $lastname = $me['name']['familyName'];
        $payload['name'] = $firstname . ' ' . $lastname;

        return $payload;
    }
}