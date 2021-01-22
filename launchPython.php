<?php
require 'vendor/autoload.php';

$locName = $_POST['locName'];

if (!isset($locName))
{
	$locName = $_COOKIE["locName"];
}

$locName = preg_replace("/[^a-zA-Z\-]/", "", $locName);
$locName = strtoupper($locName);
//Connection Details
$client = new MongoDB\Client("mongodb://NET302Admin:NET302@54.87.27.24:27017");
$collections = ($client)->NET302DB->listCollections([
	'filter' => [
		'name' => $locName,
	],
]);

$exists = 0;
foreach ($collections as $collectionData){
	$exists = 1;
}
if ($exists = 1){
	$collection = ($client)->NET302DB->$locName;
	$cursor = $collection->find(
		[
		],
		[
			'limit' => 1,
			'sort' => [
				'_id' => -1,
			]
		]
	);

	foreach ($cursor as $Results){
		$jsonResults = MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($Results));
		$jsonArray = json_decode($jsonResults, true);
	};

	$DateTime = date_create();
	$unixTime = date_timestamp_get($DateTime);
	$timeCreated = $jsonArray['timecreated'];
	if ($timeCreated + 21600 <= $unixTime){
		shell_exec("/var/www/NET302-Project/pythonScripts/bin/python3 /var/www/NET302-Project/pythonScripts/get_request.py $locName");
	}
} else {
	shell_exec("/var/www/NET302-Project/pythonScripts/bin/python3 /var/www/NET302-Project/pythonScripts/get_request.py $locName");
}

setcookie("locName", $locName, time()+2);
header("location:../index.php");
?>
