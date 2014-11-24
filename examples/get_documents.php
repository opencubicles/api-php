<?php
/*
* This example shows how to grab all of the documents in your WebMerge account
*
*/

require_once '../classes/WebMerge.php';

$api_key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$api_secret = 'ABCDEFGH';

$webmerge = new WebMerge($api_key, $api_secret);
$documents = $webmerge->getDocuments();

print '<ul>';
foreach($documents as $document) {
	print '<li>' . $document['name'] . '</li>';	
}
print '</ul>';
?>