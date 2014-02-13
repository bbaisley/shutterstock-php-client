<?php
namespace Shutterstock;

class Lightboxes {
	
	public function getUserLightboxes() {
		if ( $this->checkUserConfig() ) {
			$request_url = $this->buildUrl('/customer/'.$this->username.'/lightboxes.json');
			$response = $this->rest_client->get($request_url, array('auth_token'=>$this->user_auth_token));
			$this->processResponse($response);
		} else {
			return false;
		}
	}


}