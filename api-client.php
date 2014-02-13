<?php
namespace Shutterstock;

include('../presto/presto.php');
$presto = new \Presto\Presto();

$api = new ShutterstockApiClient('hackbattle2013','9ed3c46d1b86096a09c33b8b3ff30c2233655178',$presto);

print_r($api->similar(15484942, array('sort_method'=>'relevance') ));


class ShutterstockApiClient {
	
	const VERSION = '2.0.0';
	
	public $protocol = 'http://';
	
	public $base_url = 'api.shutterstock.com';
	
	public $lang_code = 'en';
	
	protected $rest_client = null;

	protected $api_username = null;
	
	protected $api_key = null;
	
	protected $username = null;
	protected $user_auth_token = null;
	
	protected $search_defaults = array();
	
	public $response = null;
	
	public function __construct($api_username, $api_key, $rest_client) {
		$this->api_username = $api_username;
		$this->api_key = $api_key;
		$this->rest_client = $rest_client;
		$this->rest_client->setAuth($api_username, $api_key);
	}
	
	public function setLanguage($lang_code) {
		$this->language = $lang_code;
	}
	
	public function buildUrl($path) {
		return $this->protocol.$this->base_url.$path;
	}
	
	public function getResources() {
		$request_url = $this->buildUrl('/resources.json');
		$response = $this->rest_client->get($request_url);
		$this->processResponse($response);
		print_r($response);
	}
	
	public function test() {
		$request_url = $this->buildUrl('/test/echo.json?test=connect');
		$response = $this->rest_client->get($request_url);
		$this->processResponse($response);
		if ( $response->data['test']=='connect' ) {
			return true;
		} else {
			return false;
		}
	}

	public function categories() {
		$request_url = $this->buildUrl('/categories.json');
		$response = $this->rest_client->get($request_url);
		$this->processResponse($response);
		return $response->data;
	}
	
	public function setUser($username, $password) {
		$auth_token = $this->getUserAuthToken($username, $password);
		if ( is_null($auth_token) ) {
			return $auth_token;
		} else {
			$this->username = $username;
			$this->setUserAuthToken($auth_token);
			return $auth_token;
		}
	}
	
	public function getUser() {
		if ( $this->checkUserConfig() ) {
			$request_url = $this->buildUrl('/customer/'.$this->username.'.json');
			$response = $this->rest_client->get($request_url, array('auth_token'=>$this->user_auth_token));
			$this->processResponse($response);
		} else {
			return false;
		}
	}
	
	public function setUserAuthToken($auth_token) {
		$this->user_auth_token = $auth_token;
	}
	
	public function checkUserConfig() {
		if ( is_null($this->username) || is_null($this->user_auth_token) ) {
			trigger_error('No user or user auth token set.', E_USER_WARNING);
			return false;
		}
	}
	
	public function getUserAuthToken($username, $password) {
		$request_url = $this->buildUrl('/auth/customer.json');
		$request_params = array('username'=>$username, 'password'=>$password);
		$response = $this->rest_client->post($request_url, $request_params);
		$auth_token = null;
		$this->processResponse($response);
		$auth_token = $response->data['auth_token'];
		return $auth_token;
	}
		
	public function processResponse($response) {
		if ( $response->is_success ) {
			if ( strtolower(trim($response->header['Content-Type'])) == 'application/json' ) {
				$response->data = json_decode($response->data, true);
			} else {
				trigger_error($response->data, E_USER_ERROR);
			}
		} else {
			trigger_error($response->error, E_USER_ERROR);
		}
	}
}