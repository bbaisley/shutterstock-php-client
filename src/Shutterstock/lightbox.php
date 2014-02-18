<?php
namespace Shutterstock;

class Lightbox {
    
    public $use_cache = true;
    
    private $api = null;
    
    private $id = null;
    
    private $contents = null;
    private $contents_ext = null;
    
    public function __construct($api_client, $id) {
        $this->api = $api_client;
        $this->id = $id;
    }
    
    public function clearCache() {
        $this->contents = null;
    }
    
    public function publicUrl() {
        $response = $this->api->get('/lightboxes/'.$this->id.'/public_url.json', array('auth_token'=>$this->api->auth_token) );
        return $response;
    }
    
    public function contents() {
        // Check for cached contents
        if ( !$this->use_cache || is_null($this->contents) ) {
            $response = $this->api->get('/lightboxes/'.$this->id.'.json', array('auth_token'=>$this->api->auth_token) );
            $this->contents = $response;
        }
        return $this->contents;
    }
    
    public function contentsExtended() {
        // Check for cached contents
        if ( !$this->use_cache || is_null($this->contents_ext) ) {
            $response = $this->api->get('/lightboxes/'.$this->id.'/extended.json', array('auth_token'=>$this->api->auth_token) );
            $this->contents_ext = $response;
        }
        return $this->contents_ext;
    }
    
    public function add($image_ids) {
	    $url = $this->api->buildUrl('/lightboxes/'.$this->id.'/images/');
	    if ( !is_array($image_ids) ) {
    	    $image_ids = array($image_ids);
	    }
	    $responses = array();
	    foreach($image_ids as $id) {
    	    $response = $this->api->rest_client->put($url.$id.'.json?auth_token='.$this->api->auth_token, array());
            $response = $this->api->response->process($response);
    	    $responses[$id] = $response;
	    }
	    if ( count($responses)==1 ) {
    	    return $response;
	    } else {
            return $responses;
	    }
    }
    
    public function delete($image_ids) {
	    $url = $this->api->buildUrl('/lightboxes/'.$this->id.'/images/');
	    if ( !is_array($image_ids) ) {
    	    $image_ids = array($image_ids);
	    }
	    $responses = array();
	    foreach($image_ids as $id) {
    	    $response = $this->api->rest_client->delete($url.$id.'.json?auth_token='.$this->api->auth_token, array());
            $response = $this->api->response->process($response);
    	    $responses[$id] = $response;
	    }
	    if ( count($responses)==1 ) {
    	    return $response;
	    } else {
            return $responses;
	    }
    }
}

