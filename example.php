<?php

require __DIR__ . '/vendor/autoload.php';

// Create instance of REST client
$presto = new Presto\Presto();

// Create instance to handle responses
// Pass false (don't extract response data) parameter to have 
// it return full response headers and debugging information
$response = new Shutterstock\Response(false);

// Create instance of Shutterstock API client
$api = new Shutterstock\Api('<api username>','<api key>', $presto, $response);


//
// End points not requiring user login //
//

// Test connection
print_r($api->test());

// Get categories list
$categories = $api->categories();

// Create instance to access Image end points
$images = new Shutterstock\Images($api);

$search_result = $images->search('dog');
$similar_images = $images->similar(15484942, array('sort_method'=>'relevance') );
$image_info = $images->get(126709091);
$suggest_words = $images->suggestWords(array(126709091, 127334102, 126312287, 126312281));



//
// Login as a Shutterstock user //
//

// Should only authUser once per session
// auth token should be extracted and retained
$auth_info = $api->authUser('<username>','<password>');

// Instead of authing again, set user with auth token
//$api->setUser('<username>','<auth token>');

// Auth token is automatically used when needed on API requests

$user_info = $api->userInfo();
$subscriptions = $api->subscriptions();
// Get download URL for downloading and image
//$download_info = $images->purchase('<subscription_id>', '<image id>', 'small');

// Get list of lightboxes for user
$lightboxes = $api->lightboxes();

// Create Lightbox instance to interact with a lightbox
$lightbox_api = new Shutterstock\Lightbox($api, '<lightbox ID>');

$lb_contents = $lightbox_api->contents();
$lb_contents_ext = $lightbox_api->contentsExtended();

