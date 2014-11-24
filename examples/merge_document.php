<?php
/*
* This example shows how to send data (merge) to one of your documents
*
*/

require_once '../classes/WebMerge.php';

$api_key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$api_secret = 'ABCDEFGH';

$webmerge = new WebMerge($api_key, $api_secret);
$data = array(
    'name' => 'John Smith',
	'email' => 'john@smith.com',
    'address' => '12 The High St, Dundee'
);

$document_id = '12345';
$document_key = 'abcdef';

$pdf_contents = $webmerge->doMerge($document_id, $document_key, $data, array('test' => 0, 'download' => 1)); 

$filename = '/path/to/the/file/test.pdf';
file_put_contents($filename, $pdf_contents);


?>