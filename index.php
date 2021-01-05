<?php
// Include Composer's Autoloader
require 'vendor/autoload.php';

$location= '';
$location= $_POST[ 'location' ];
if (!isset($location))
{
	$location = $_COOKIE["locName"];
}
$userIP=$_SERVER['REMOTE_ADDR'];;
$userLocData = json_decode(file_get_contents("http://ipinfo.io/{$userIP}/json"));
$coords = $userLocData->loc;
$coords_explode=explode(",",$coords);
$lat = $coords_explode[0];
$lon = $coords_explode[1];
if (isset($location))
{	
	//Connection Details
	$client = new MongoDB\Client("mongodb://NET302Admin:NET302@54.87.27.24:27017");
	$collection = ($client)->NET302DB->$location;
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
}
else {
	$location=$userLocData->city;
	setcookie("locName", $location, time()+2);
	header("location:../launchPython.php");
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Required Metadata -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Import Materialize Framework -->
		<link rel="stylesheet" href="css/materialize.min.css">
		<!-- Import Google Icons -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<!-- Import Custom Styles -->
		<link rel="stylesheet" href="css/styles.css">

	</head>
	<body>
		<nav>
			<div class="nav-wrapper" id="main-nav-bar">
				<logo href="#" class="brand-logo">WEATHER</logo>
					<searchbar>
						<form action='../launchPython.php' method='POST'>
							<input placeholder="Enter a town, city or UK postcode" name="locName" id="locName" type="textbox" maxlength="120" size="70">
    							<button class="material-icons" id="submitCity" type="submit">search</button>
						</form>
					</searchbar>
				</ul>
			</div>
		</nav>

		<div>
			<?php 	
				//var_dump($jsonArray);
				echo $jsonArray['daily'][0]['weather'][0]['main'];
				#echo $jsonResults;
 			?>
		</div>

<footer class="page-footer" id="footer">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<p class="grey-text text-lighten-4">"Weather App Lmao &trade;"</p>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			© 2020 William Tyler (NET302_Project)
		</div>
	</div>
</footer>

		<!--        JAVA SCRIPT        -->
		<!-- Import Frameworks -->
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/materialize.min.js"></script>
		<!-- Import Common Code -->
		<!-- <script type="text/javascript" src="js/functions.js"></script> -->
		<!-- <script type="text/javascript" src="js/global.js"></script> -->
		<!-- Page Specific Script -->
		<script type="text/javascript">
		</script>

	</body>
</html>
