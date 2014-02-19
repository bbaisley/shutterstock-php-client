<?php
namespace Shutterstock;

class Videos {
    private $api = null;
    
    public $search_defaults = array();

    public function __construct($api_client) {
        $this->api = $api_client;
    }

	public function setSearchDefaults($filters) {
		$this->search_defaults = $filters;
	}
	
	public function clearSearchDefaults() {
		$this->search_defaults = array();
	}
	
	public function get($id) {
		$response = $this->api->get('/images/'.$id.'.json', array('language'=>$this->api->lang_code));
		return $response;
	}
	
