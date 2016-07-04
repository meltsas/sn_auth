<?php
//use Abraham\TwitterOauth\TwitterOAuth;
// Using library - https://github.com/abraham/twitteroauth

class Twitter_auth implements Provider
{
    protected $client;
    protected $access_token;
    protected $request_token;
    protected $keys;
    protected $oauth_callback;

    /**
     * Twitter_auth constructor.
     */
    public function __construct(array $conf, $baseUrl)
    {
        $keys = $conf['keys'];
        $this->keys = $keys;
//        print_r($keys);
//        die();
        $this->oauth_callback = $baseUrl;
//        $permissions = $conf['permissions'];


        if (!isset($_SESSION['oauth_token'])) {

            $this->client = new Abraham\TwitterOAuth\TwitterOAuth($this->keys['id'],$this->keys['secret']);

            $this->request_token = $this->client->oauth('oauth/request_token', ['oauth_callback' => $this->oauth_callback]);
            if ($this->request_token) {
                $_SESSION['oauth_token'] = $this->request_token['oauth_token'];
                $_SESSION['oauth_token_secret'] = $this->request_token['oauth_token_secret'];
            }

        }

        elseif (isset($_SESSION['oauth_token']) && !isset($_SESSION['access_token'])) {

            $this->request_token['oauth_token'] = $_SESSION['oauth_token'];
            $this->request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

            if (isset($_REQUEST['oauth_token']) && $this->request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
                die('Something wrong with Twitter Auth... $_REQUEST[\'oauth_token\']:' .  $_REQUEST['oauth_token']);
            }

            $this->client = new Abraham\TwitterOAuth\TwitterOAuth(
                $this->keys['id'],
                $this->keys['secret'],
                $this->request_token['oauth_token'],
                $this->request_token['oauth_token_secret']);

        }

        elseif (isset($_SESSION['oauth_token']) && isset($_SESSION['access_token'])) {
            $this->access_token = $_SESSION['access_token'];
            $this->client = new Abraham\TwitterOAuth\TwitterOAuth(
                $this->keys['id'],
                $this->keys['secret'],
                $this->access_token['oauth_token'],
                $this->access_token['oauth_token_secret']);
        }



    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->client->url('oauth/authorize', ['oauth_token' => $this->request_token['oauth_token']]);
    }

    /**
     * @return mixed
     */
    public function setAccessToken()
    {
        if ($_REQUEST['oauth_verifier']) {
            $this->access_token = $this->client->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
            if ($this->access_token) {
                $_SESSION['access_token'] = $this->access_token;
                $this->client = new Abraham\TwitterOAuth\TwitterOAuth(
                    $this->keys['id'],
                    $this->keys['secret'],
                    $this->access_token['oauth_token'],
                    $this->access_token['oauth_token_secret']);
                if ($this->client) return true;
            }
        }
        return false;

    }

    /**
     * @return mixed
     */
    public function getPayLoad()
    {
        return $this->client->get("account/verify_credentials");
    }

}