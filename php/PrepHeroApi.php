<?php
    /**
      *  Author          : Xinjiang Shao <Xinjiang.Shao@exactsports.com>
      *  Date            : July 2012
      *  Description     : This file provide a wrapper class for clients to 
      *                    use OAuth2 authentication and acsess secret resources 
      *                    in PrepHero.com
      **/
      
require(dirname(__FILE__).'/Client.php');
require(dirname(__FILE__).'/GrantType/IGrantType.php');
require(dirname(__FILE__).'/GrantType/AuthorizationCode.php');
require(dirname(__FILE__).'/GrantType/RefreshToken.php');
const CLIENT_ID                 = 'Shao';
const CLIENT_SECRET             = '994738dd31ed445ac27f';
const REDIRECT_URI              = 'http://soleoshao.com/sandbox/oauth2/demo.php';

const ACCESS_TOKEN_BEARER       = 1;


class PrepHeroApi{
    
                                                   
    protected $base_url                  = "https://dev.prephero.com/index.php?module=prephero&type=user&func=v1";
    
    protected $client_id;
    protected $client_secret;
    protected $redirect_url;
    protected $authorization_endpoint;
    protected $token_endpoint;
    
    protected $client;
    private   $code;
    private   $returntype;
    private   $access_token;
    /**
     * @param string $returntype JSON or XML, by default JSON
     */
    function __construct($returntype = 'json'){
        
        $this->client_id                = CLIENT_ID;
        $this->client_secret            = CLIENT_SECRET;
        $this->redirect_uri             = REDIRECT_URI;
        
        $this->authorization_endpoint   = $this->base_url.'&method=authorize&return='. $returntype;
        $this->token_endpoint           = $this->base_url.'&theme=raw&method=grant&return='. $returntype;
        $this->returntype               = $returntype;
        $this->client = new OAuth2\Client($this->client_id, $this->client_secret);
        
    }
    
    /**
     * @return string url for authentication. choose allow or deny 
     */
    public function getAuthUrl(){
        $auth_url = $this->client->getAuthenticationUrl($this->authorization_endpoint, $this->redirect_uri);
        return $auth_url;
    }
    /**
     * @param string $code retrieve from $_GET['code'] on redirect_uri
     * @return array ['result']        for xml or json response. In result, we have information of access_token,expires_in,token_type, scope, refresh_token
     *               ['code']          for http status
     *               ['content_type']  for http type eg. application/json or application/xml
     */
    public function setAccessToken($code){
        $params = array('code' => $code, 'redirect_uri' => $this->redirect_uri);
        $response = $this->client->getAccessToken($this->token_endpoint, 'authorization_code', $params);
        if(!isset($response['result']['error'])){
            $this->access_token = $response['result']['access_token'];
            $_COOKIE['prephero_refresh_token'] =  $response['result']['refresh_token'];
        }
        return $response;
    }
    
    public function getAccessTokenByRefreshToken(){
        // get another token
        $params = array('refresh_token' => $_COOKIE['prephero_refresh_token']);
 
        $response = $this->client->getAccessToken($this->token_endpoint, 'refresh_token', $params);

        $this->access_token = $response['refresh_token'];
    }
    
    public function fetch($method, $secretresource = null){
		$this->client->setAccessToken($this->access_token);
        $response = $this->client->fetch($this->base_url.'&theme=raw&method='.$method.'&return='.$this->returntype);
		
        if(isset($response['result']['error']) && strcmp ( trim($response['result']['error']), trim('invalid_grant') ) == 0){
           
			$params = array('refresh_token' => $_COOKIE['prephero_refresh_token']);
			
	        $response = $this->client->getAccessToken($this->token_endpoint, 'refresh_token', $params);
			
	        $this->access_token = $response['result']['access_token'];
			$this->client->setAccessToken($this->access_token);
            $response = $this->client->fetch($this->base_url.'&theme=raw&method='.$method.'&return='.$this->returntype);
			return $response;
						
        }
        return $response;
    }
    
    public function getProfile(){
        return self::fetch('accessresources', null);
    }

	public function revokeAccess(){
		return self::fetch('revokeaccess', null);
	}
    
    
}          