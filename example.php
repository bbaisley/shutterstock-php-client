<?php

require __DIR__ . '/vendor/autoload.php';

/*
set_error_handler( function($e_num, $e_msg, $e_file, $e_line, $e_context) {
    echo 'ERROR '.$e_num;
    echo ' MSG - '.$e_msg;
    echo " FILE: ".$e_file;
    echo ' LINE: '.$e_line;
    echo " CONTEXT: ".print_r($e_context, true);
    echo "\n\n\n";
});

set_exception_handler( function($e) {
    echo 'EXCEPTION ';
    print_r($e);
});

*/

$presto = new Presto\Presto();
$response = new Shutterstock\Response();

//$api = new Shutterstock\Api('hackbattle2013','9ed3c46d1b86096a09c33b8b3ff30c2233655178', $presto, $response);
$api = new Shutterstock\Api('bigstock','f91479918b999e9be6eaa3d437e2e5496fa09a39', $presto, $response);

//echo $api->authUser('bbaisley','br8ktime');
$api->setUser('bbaisley', 'dd6864c9d555baa5dcce25540f1905009fedb8d2');

//print_r($api->lightboxes());
//print_r($api->userInfo());
//print_r($api->categories());


$lightbox_api = new Shutterstock\Lightbox($api, 24490019);
$lightbox_test = new Shutterstock\Lightbox($api, 19968949);
//print_r($lightbox_api->publicUrl());
//print_r($lightbox_api->contents());
//print_r($lightbox_api->contentsExtended());
//print_r($api->createLightbox('ApiClient '.date('Hms')));
//IMAGE IDs: 126709091, 127334102, 126312287, 126312281, 126312260, 126219941, 126053813
//print_r($lightbox_test->add(array(126709091, 127334102) ));

//print_r($api->similar(15484942, array('sort_method'=>'relevance') ));

$images = new Shutterstock\Images($api);
//print_r($images->get(126709091));
//print_r($images->suggestWords(array(126709091, 127334102, 126312287, 126312281)));
print_r($images->search('dog'));
