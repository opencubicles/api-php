<?php
/*
* This example shows how to create a new document in your WebMerge account
*
*/

require_once '../classes/WebMerge.php';

$api_key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$api_secret = 'ABCDEFGH';

$webmerge = new WebMerge($api_key, $api_secret);

$doc = array();
$doc['name'] = 'Test Document';
$doc['type'] = 'pdf';
$doc['output'] = 'pdf';
$doc['file_contents'] = base64_encode( file_get_contents('/path/to/the/file.pdf') );

$document = $webmerge->createDocument($doc);

print_r($document);
?>