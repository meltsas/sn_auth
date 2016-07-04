<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AUTH</title>
</head>
<body>
<a href="logout.php">Sign Out</a>

<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once 'config/config.php';


if (key_exists('provider', $_GET) && key_exists($_GET['provider'], CONFIG['providers'])) {
    $provider = $_GET['provider'];
} else {
    if (isset($_SESSION['provider'])) $provider = $_SESSION['provider'];
    else die('Something wrong - no provider found!');
}


require_once 'includes/Provider.php';
require_once 'includes/Social_network.php';

require_once $provider . '/vendor/autoload.php';
require_once $provider . '/' . ucfirst($provider) . '_auth.php';


//require_once 'Provider.php'; //interface
//require_once $provider . '/' . ucfirst($provider) . '_auth.php';
$provider_class = ucfirst($provider) . '_auth';

if (!isset($_SESSION['provider'])) {
    $sn_class = new $provider_class(CONFIG['providers'][$provider], CONFIG['base_url']);
    $sn = Social_network::getProvider($sn_class);

    $url = $sn->getRedirectUrl();

//    if ($provider==='linkedin') die('getRedirectUrl(): '.$url);

    $_SESSION['provider'] = $provider;
    header('Location: ' . $url);
    die();
}

?>

<h2>RESULTS</h2>
<br/><br/>

<?php

if (isset($_SESSION['provider'])) {
    if ($_SESSION['provider'] === $provider) {
        $sn = Social_network::getProvider(new $provider_class(CONFIG['providers'][$provider], CONFIG['base_url']));

        $token = $sn->setAccessToken();
        if ($token) {
            // You can use to DB to store information from payload (e.g email, name.. etc)
            $_SESSION['payload'] = $sn->getPayLoad();
            header('Location: ../index.php');
            die();

        }
        else {
            $_SESSION['payload'] = ['result'=>'fail']; // IF AUTHENTICATION FAILS IN SOME REASON
            header('Location: ../index.php');
            die();
        }
    }
}

else {

}


?>

</body>
</html>


