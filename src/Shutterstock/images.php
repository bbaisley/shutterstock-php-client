<?php
namespace Shutterstock;

class Images {
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
	
	public function similar($id, $page=1, $sort='popular') {
	    $filters = array('page'=>$page, 'sort'=>$sort);
		$response = $this->api->get('/images/'.$id.'/similar.json', $filters);
		return $response;
	}
	
	public function suggestWords($image_ids) {
		$response = $this->api->get('/images/recommendations/keywords.json', array('image_id'=>implode($image_ids,',')));
		return $response;
	}
	
	public function search($search_term, $filters=null) {
	    if ( is_null($filters) ) {
    	    $filters = array();
	    }
	    $filters['searchterm'] = $search_term;
		static $valid_filters = array(
			'all','search_group','searchterm','category_id','color',
			'photographer_name',
			'commercial_only','editorial_only','enhanced_only','exclude_keywords',
			'model_released','orientation','page_number','page_size',
			'people_age','people_ethnicity','people_gender','people_number',
			'safesearch',
			'sort_method','submitter_id'
			);
		$filters = array_merge($this->search_defaults, $filters);
		if ( !isset($filters['language']) ) {
    		$filters['language'] = $this->api->lang_code;
		}
		$response = $this->api->get('/images/search.json',$filters);
		return $response;
	}


}