<?php
namespace Shutterstock;

class Api {
	
	const VERSION = '2.0.0';
	
	public $protocol = 'http://';
	
	public $base_url = 'api.shutterstock.com';
	
	public $lang_code = 'en';
	
	public $rest_client = null;

	protected $api_username = null;
	
	protected $api_key = null;
	
	public $username = null;
	public $auth_token = null;
		
	public $response = null;
	
	private $cache = array();
	
	private static $categories = null;
	
	public function __construct($api_username, $api_key, $rest_client, $response) {
		$this->api_username = $api_username;
		$this->api_key = $api_key;
		$this->rest_client = $rest_client;
		$this->rest_client->setAuth($api_username, $api_key);
		$this->response = $response;
	}
	
	public function clearCache() {
    	$this->cache = array();
    	self::$categories = null;
	}
	
	public function setLanguage($lang_code) {
		$this->language = $lang_code;
	}
	
	public function buildUrl($path) {
		return $this->protocol.$this->base_url.$path;
	}
	
	public function authUser($username, $password) {
		$this->clearCache();
		$auth_token = $this->getAuthToken($username, $password);
		if ( is_null($auth_token) ) {
			return $auth_token;
		} else {
			$this->username = $username;
			$this->setAuthToken($auth_token);
			return $auth_token;
		}
	}
	public function setUser($username, $auth_token) {
		$this->username = $username;
		$this->setAuthToken($auth_token);
		$this->clearCache();
	}
	
	public function getAuthToken($username, $password) {
		$request_url = $this->buildUrl('/auth/customer.json');
		$request_params = array('username'=>$username, 'password'=>$password);
		$response = $this->rest_client->post($request_url, $request_params);
		$auth_token = null;
		$response = $this->response->process($response);
		$auth_token = $response->data['auth_token'];
		return $auth_token;
	}
	
	public function setAuthToken($auth_token) {
		$this->auth_token = $auth_token;
	}
		
	public function userInfo() {
		if ( $this->checkUserConfig() ) {
			$request_url = $this->buildUrl('/customers/'.$this->username.'.json');
			$response = $this->rest_client->get($request_url, array('auth_token'=>$this->auth_token));
			try {
			    $response = $this->response->process($response);
    			
			} catch(Exception $e) {
    			$response = null;
    			echo $e->message;
			}
			return $response;
		} else {
			return false;
		}
	}
	
	public function checkUserConfig() {
		if ( is_null($this->username) || is_null($this->auth_token) ) {
			trigger_error('No user and/or no auth token set.', E_USER_WARNING);
			return false;
		}
		return true;
	}

    public function get($url_path, $params=null) {
		$request_url = $this->buildUrl($url_path);
		$response = $this->rest_client->get($request_url, $params);
		$response = $this->response->process($response);
		return $response;
    }
	
	public function resources() {
		$request_url = $this->buildUrl('/resources.json');
		$response = $this->rest_client->get($request_url);
		return $this->response->process($response);;
	}
	
	public function test() {
		$response = $this->get('/test/echo.json?test=connect');
		if ( $response->data['test']=='connect' ) {
			return true;
		} else {
			return false;
		}
	}

	public function categories() {
	    if ( is_null(self::$categories) ) {
            $response = $this->get('/categories.json');
            if ( $response->meta['is_success'] && $response->meta['http_code']==200 ) {
                // Cache category list
                self::$categories = $response;
            } else {
                return $response;
            }
	    }
	    return self::$categories;
	}
	
	public function subscriptions() {
	    return $this->get('/customers/'.$this->username.'/subscriptions.json', array('auth_token'=>$this->auth_token));
	}
	
	public function lightboxes($extended=false) {
	    $params = array('auth_token'=>$this->auth_token);
	    if ($extended) {
    	    $url_path = '/extended.json';
	    } else {
    	    $url_path = '.json';
    	    $params['exclude_images'] = 1;
    	    $params['hero_image_only'] = 1;
	    }
    	return $this->get('/customers/'.$this->username.'/lightboxes'.$url_path, $params);
	}
	
	public function createLightbox($name) {
	    $url = $this->buildUrl('/customers/'.$this->username.'/lightboxes.json');
    	$response = $this->rest_client->post($url, array('auth_token'=>$this->auth_token, 'lightbox_name'=>$name));
        $response = $this->response->process($response);
        return $response;
	}
}

