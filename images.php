<?php
namespace Shutterstock;

class Images {
	
	public function image($id, $lang_code=null) {
		if ( is_null($lang_code) ) {
			$lang_code = $this->lang_code;
		}
		$request_url = $this->buildUrl('/images/'.$id.'.json');
		$response = $this->rest_client->get($request_url, array('language'=>$lang_code));
		$this->processResponse($response);
		return $response;
	}
	
	public function similar($id, $filters=array()) {
		$request_url = $this->buildUrl('/images/'.$id.'/similar.json');
		$response = $this->rest_client->get($request_url, $filters);
		$this->processResponse($response);
		return $response;
	}

	public function setSearchDefaults($filters) {
		$this->search_defaults = $filters;
	}
	
	public function clearSearchDefaults() {
		$this->search_defaults = array();
	}
	
	public function search($filters, $media_type="images") {
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
		$request_url = $this->buildUrl('/'.$media_type.'/search.json?'.http_build_query($filters));
		$response = $this->rest_client->get($request_url);
		$this->processResponse($response);
		return $response->data;
	}


}