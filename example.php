<?php

require __DIR__ . '/vendor/autoload.php';

$presto = new Presto\Presto();
$response = new Shutterstock\Response();

$api = new Shutterstock\Api('hackbattle2013','9ed3c46d1b86096a09c33b8b3ff30c2233655178', $presto, $response);

print_r($api->test());

//print_r($api->similar(15484942, array('sort_method'=>'relevance') ));
