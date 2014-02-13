<?php

class Response {
    
    public function __construct() {
        
    }
    
    public function process($response) {
		if ( $response->is_success ) {
			if ( strtolower(trim($response->header['Content-Type'])) == 'application/json' ) {
				$response->data = json_decode($response->data, true);
			} else {
				trigger_error($response->data, E_USER_ERROR);
			}
		} else {
			trigger_error($response->error, E_USER_ERROR);
		}
		return $response;
	}

}