<?php
namespace Shutterstock;

class Response {
    public $content_type = null;
    
    public function __construct($content_type='application/json') {
        $this->content_type = $content_type;
    }
    
    public function process($response) {
		if ( $response->is_success ) {
			if ( strtolower(trim($response->header['Content-Type'])) == $this->content_type || is_null($this->content_type) ) {
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