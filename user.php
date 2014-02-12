<?php
namespace Shutterstock;

class ShutterstockUser {
	
	protected $api = null;
	
	protected $username = null;
	protected $auth_token = null;

	public function __construct($api_client) {
		$this->api = $api_client;
	}
	
	public function auth($username, $password) {
		$request_url = $this->api->buildUrl('/auth/customer.json');
		$request_params = array('username'=>$username, 'password'=>$password);
		// Try to authenticate user
		$response = $this->api->rest_client->post($request_url, $request_params);
		// Process response
		$auth_token = null;
		$this->api->processResponse($response);
		$this->auth_token = $response->data['auth_token'];
		$this->username = $username;
	}
	
	public function getInfo() {
		
	}
	
	public function create() {
		
	}
	
	public function lightboxes() {
		
	}
	
	public function lightboxCreate() {
		
	}
	
	public function lightboxDelete() {
		
	}
	
	public function lightboxAddImage() {
		
	}
	
	public function lightboxDeleteImage() {
		
	}
	
	public function setPurchaseId($id) {
		
	}
	
	public function subscriptions() {
		
	}
	
	public function purchase() {
		
	}
	
	public function download() {
		
	}
	
	public function downloadHistory() {
		
	}
	
}