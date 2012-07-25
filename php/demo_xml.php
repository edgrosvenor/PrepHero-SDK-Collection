<?php
    require(dirname(__FILE__).'/Client.php');
    require(dirname(__FILE__).'/GrantType/IGrantType.php');
    require(dirname(__FILE__).'/GrantType/AuthorizationCode.php');


define('CLIENT_ID','prephero_xml_test');
define('CLIENT_SECRET','ab412718c6e8f0f78633');
define('REDIRECT_URI', 'http://soleoshao.com/sandbox/oauth2/demo_xml.php');
define('AUTHORIZATION_ENDPOINT', 'https://dev.prephero.com/index.php?module=prephero&type=user&func=v1&method=authorize&return=xml');
define('TOKEN_ENDPOINT', 'https://dev.prephero.com/index.php?module=prephero&type=user&func=v1&theme=raw&method=grant&return=xml');
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
	/*	<prephero>	
	<access_token>a1b41668c44cde81f1a4204e72e96ce466adb67e</access_token>
		  <expires_in>3600</expires_in>
		  <token_type>bearer</token_type>
		  <scope>		  
	<refresh_token>1f43f18f52571fa53ba75c6b7c1ee11f0ef30ac5</refresh_token>
		</scope></prephero>*/
		$xml = simplexml_load_string($response['result']);
		echo "<pre>";
		     var_dump($xml);
		echo "</pre>";
        $client->setAccessToken($xml->access_token);
        $response = $client->fetch('https://dev.prephero.com/index.php?module=prephero&type=user&func=v1&theme=raw&method=accessresources&return=xml');
echo "<pre>";
        var_dump($response, $response['result']);
echo "</pre>";
    }

?>