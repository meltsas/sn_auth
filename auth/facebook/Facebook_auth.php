<?php


/**
 * Class Fb_auth
 */
class Facebook_auth implements Provider
{
    /**
     * @var \Facebook\Facebook
     */
    protected $fb;
    protected $accessToken;
    protected $permissions;
    protected $baseUrl;

    /**
     * Fb_auth constructor.
     * @param array $conf
     * @param $baseUrl mixed
     */
    public function __construct(array $conf, $baseUrl)
    {
        $keys=$conf['keys'];
        $permissions=$conf['permissions'];
        $this->fb = new Facebook\Facebook([
            'app_id' => $keys['id'],
            'app_secret' => $keys['secret'],
            'default_graph_version' => $keys['version']
        ]);
        $this->permissions = $permissions;
        $this->baseUrl = $baseUrl;
    }


    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->fb->getRedirectLoginHelper()->getLoginUrl($this->baseUrl, $this->permissions);
    }

    /**
     * @return mixed
     */
    public function setAccessToken()
    {
        try {
            $helper = $this->fb->getRedirectLoginHelper();
            $this->accessToken = $helper->getAccessToken();
            $this->fb->setDefaultAccessToken($this->accessToken);

        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'setAccessTokern(): Graph returned an error: ' . $e->getMessage();
            exit;

        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'setAccessTokern(): Facebook SDK returned an error: ' . $e->getMessage();
            exit;

        }
        if ($this->accessToken) return true;
        else return false;

    }

    /**
     * @return array
     */
    public function getPayLoad() : array
    {
            try {
                $response = $this->fb->get('/me?fields=name,email,picture,gender,link');
                $userNode = $response->getGraphUser()->asArray();

            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'getPayLoad(): Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'getPayLoad(): Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            return $userNode;
    }
}