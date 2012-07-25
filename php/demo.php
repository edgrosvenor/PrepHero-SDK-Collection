<?php
include_once "PrepHeroApi.php";

$api = new PrepHeroApi();

    if (!isset($_GET['code']))
    {
        $auth_url = $api->getAuthUrl();
        header('Location: ' . $auth_url);
        die('Redirect');
    }
    else
    {
        $response = $api->setAccessToken($_GET['code']);
        echo "<pre>";
        var_dump($response);
		echo "</pre>";
		for ($i=0;$i<20;$i++){
			$response = $api->getProfile();
			echo "<pre>";
	        var_dump($response);
			echo "</pre>";
			sleep(1);
		}
        
    }

?>