<?php
    require(dirname(__FILE__).'/Client.php');
    require(dirname(__FILE__).'/GrantType/IGrantType.php');
    require(dirname(__FILE__).'/GrantType/AuthorizationCode.php');


define('CLIENT_ID','Shao');
define('CLIENT_SECRET','994738dd31ed445ac27f');
define('REDIRECT_URI', 'http://soleoshao.com/sandbox/oauth2/demo.php');
define('AUTHORIZATION_ENDPOINT', 'https://dev.prephero.com/index.php?module=prephero&type=user&func=v1&method=authorize&return=json');
define('TOKEN_ENDPOINT', 'https://dev.prephero.com/index.php?module=prephero&type=user&func=v1&theme=raw&method=grant&return=json');
const ACCESS_TOKEN_BEARER   = 1;
/*
* not good with php 5.2
    const CLIENT_ID     = 'Shao';
    const CLIENT_SECRET = '994738dd31ed445ac27f';

    const REDIRECT_URI           = 'http://soleoshao.com/sandbox/oauth2/demo.php';
    const AUTHORIZATION_ENDPOINT = 'https://dev.prephero.com/oauth/authorize';
    const TOKEN_ENDPOINT         = 'https://dev.prephero.com/oauth/access_token';
*/
    $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET);
    if (!isset($_GET['code']))
    {
        $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
        header('Location: ' . $auth_url);
        die('Redirect');
    }
    else
    {
        $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
        $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
		echo "<pre>";
		     var_dump($response);
		echo "</pre>";
        $client->setAccessToken($response['result']['access_token']);
        $response = $client->fetch('https://dev.prephero.com/index.php?module=prephero&type=user&func=v1&theme=raw&method=accessresources&return=json');
echo "<pre>";
        var_dump($response, $response['result']);
echo "</pre>";
    }

?>