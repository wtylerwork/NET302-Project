<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
// Include Composer's Autoloader
require 'vendor/autoload.php';

$location= '';
$location= $_POST[ 'location' ];
if (!isset($location))
{
	$location = $_COOKIE["locName"];
}
$userIP=$_SERVER['REMOTE_ADDR'];
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
$location= strtoupper($location);
############ FUNCTIONS ############

function ordinalSuffix($number) {
	$suffix = array('th','st','nd','rd','th','th','th','th','th','th');
    	if ((($number % 100) >= 11) && (($number%100) <= 13))
        	return $number. 'th';
    	else
        	return $number. $suffix[$number % 10];
}

function day($dayCounter) {
	$dateNum = ltrim(date("d", strtotime("+$dayCounter day")), '0');
	return date("l", strtotime("+$dayCounter day")) . " " . ordinalSuffix($dateNum);
}
?>
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
		
		<nav>
                        <div class="nav-wrapper" id="main-nav-bar">
                                <logo href="#" class="brand-logo">WEATHER</logo>
                                        <searchbar>
                                                <form action='../launchPython.php' method='POST'>
                                                        <input placeholder="Enter a town or city" name="locName" id="locName" type="textbox" maxlength="120" size="70" required>
                                                        <button class="material-icons" id="submitCity" type="submit">search</button>
                                                </form>
                                        </searchbar>
                        </div>
                </nav>

	</head>
	<body>
		<div>
			<dt id="currentLocation"><?php echo $location ?></dt>
			<div class="row">
				<div class="tabUpper">						
					<div class="tab">
						<button class="tablinks active" onclick="openTab(event, 'day1')"><?php echo day(0);?></button>
						<button class="tablinks" onclick="openTab(event, 'day2')"><?php echo day(1);?></button>
						<button class="tablinks" onclick="openTab(event, 'day3')"><?php echo day(2);?></button>
						<button class="tablinks" onclick="openTab(event, 'day4')"><?php echo day(3);?></button>
						<button class="tablinks" onclick="openTab(event, 'day5')"><?php echo day(4);?></button>
						<button class="tablinks" onclick="openTab(event, 'day6')"><?php echo day(5);?></button>
						<button class="tablinks" onclick="openTab(event, 'day7')"><?php echo day(6);?></button>
						<button class="tablinks" onclick="openTab(event, 'day8')"><?php echo day(7);?></button>
					</div>
				</div>
				<div id="day1" class="tabcontent">
					<img id="day1Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][0]['weather'][0]['icon'];?>@2x.png">
					<dt id="day1Main">Weather: <?php echo ucfirst($jsonArray['daily'][0]['weather'][0]['main']); ?></dt>
					<dt id="day1Desc">Description: <?php echo ucfirst($jsonArray['daily'][0]['weather'][0]['description']); ?></dt>
					<dt id="day1Temp">Temperature: <?php echo(round($jsonArray['daily'][0]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
					<dt id="day1Humidity">Humidity: <?php echo $jsonArray['daily'][0]['humidity'];?>%</dt>
					<dt id="day1WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][0]['wind_speed']));?>MpH</dt>
				</div>
				<div id="day2" class="tabcontent">
					<img id="day2Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][1]['weather'][0]['icon'];?>@2x.png">
                                        <dt id="day2Main">Weather: <?php echo ucfirst($jsonArray['daily'][1]['weather'][0]['main']); ?></dt>
                                        <dt id="day2Desc">Description: <?php echo ucfirst($jsonArray['daily'][1]['weather'][0]['description']); ?></dt>
                                        <dt id="day2Temp">Temperature: <?php echo(round($jsonArray['daily'][1]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
                                        <dt id="day2Humidity">Humidity: <?php echo $jsonArray['daily'][1]['humidity'];?>%</dt>
                                        <dt id="day2WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][1]['wind_speed']));?>MpH</dt>
				</div>
				<div id="day3" class="tabcontent">
					<img id="day3Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][2]['weather'][0]['icon'];?>@2x.png">
                                        <dt id="day3Main">Weather: <?php echo ucfirst($jsonArray['daily'][2]['weather'][0]['main']); ?></dt>
                                        <dt id="day3Desc">Description: <?php echo ucfirst($jsonArray['daily'][2]['weather'][0]['description']); ?></dt>
                                        <dt id="day3Temp">Temperature: <?php echo(round($jsonArray['daily'][2]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
                                        <dt id="day3Humidity">Humidity: <?php echo $jsonArray['daily'][2]['humidity'];?>%</dt>
                                        <dt id="day3WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][2]['wind_speed']));?>MpH</dt>

				</div>
				<div id="day4" class="tabcontent">
				<img id="day4Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][3]['weather'][0]['icon'];?>@2x.png">
                                        <dt id="day4Main">Weather: <?php echo ucfirst($jsonArray['daily'][3]['weather'][0]['main']); ?></dt>
                                        <dt id="day4Desc">Description: <?php echo ucfirst($jsonArray['daily'][3]['weather'][0]['description']); ?></dt>
                                        <dt id="day4Temp">Temperature: <?php echo(round($jsonArray['daily'][3]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
                                        <dt id="day4Humidity">Humidity: <?php echo $jsonArray['daily'][3]['humidity'];?>%</dt>
                                        <dt id="day4WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][3]['wind_speed']));?>MpH</dt>

				</div>
				<div id="day5" class="tabcontent">
				<img id="day5Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][4]['weather'][0]['icon'];?>@2x.png">
                                        <dt id="day5Main">Weather: <?php echo ucfirst($jsonArray['daily'][4]['weather'][0]['main']); ?></dt>
                                        <dt id="day5Desc">Description: <?php echo ucfirst($jsonArray['daily'][4]['weather'][0]['description']); ?></dt>
                                        <dt id="day5Temp">Temperature: <?php echo(round($jsonArray['daily'][4]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
                                        <dt id="day5Humidity">Humidity: <?php echo $jsonArray['daily'][4]['humidity'];?>%</dt>
                                        <dt id="day5WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][4]['wind_speed']));?>MpH</dt>

				</div>
				<div id="day6" class="tabcontent">
				<img id="day6Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][5]['weather'][0]['icon'];?>@2x.png">
                                        <dt id="day6Main">Weather: <?php echo ucfirst($jsonArray['daily'][5]['weather'][0]['main']); ?></dt>
                                        <dt id="day6Desc">Description: <?php echo ucfirst($jsonArray['daily'][5]['weather'][0]['description']); ?></dt>
                                        <dt id="day6Temp">Temperature: <?php echo(round($jsonArray['daily'][5]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
                                        <dt id="day6Humidity">Humidity: <?php echo $jsonArray['daily'][5]['humidity'];?>%</dt>
                                        <dt id="day6WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][5]['wind_speed']));?>MpH</dt>

				</div>
				<div id="day7" class="tabcontent">
				<img id="day7Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][6]['weather'][0]['icon'];?>@2x.png">
                                        <dt id="day7Main">Weather: <?php echo ucfirst($jsonArray['daily'][6]['weather'][0]['main']); ?></dt>
                                        <dt id="day7Desc">Description: <?php echo ucfirst($jsonArray['daily'][6]['weather'][0]['description']); ?></dt>
                                        <dt id="day7Temp">Temperature: <?php echo(round($jsonArray['daily'][6]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
                                        <dt id="day7Humidity">Humidity: <?php echo $jsonArray['daily'][6]['humidity'];?>%</dt>
                                        <dt id="day7WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][6]['wind_speed']));?>MpH</dt>

				</div>
				<div id="day8" class="tabcontent">
				<img id="day8Icon" src="http://openweathermap.org/img/wn/<?php echo $jsonArray['daily'][7]['weather'][0]['icon'];?>@2x.png">
                                        <dt id="day8Main">Weather: <?php echo ucfirst($jsonArray['daily'][7]['weather'][0]['main']); ?></dt>
                                        <dt id="day8Desc">Description: <?php echo ucfirst($jsonArray['daily'][7]['weather'][0]['description']); ?></dt>
                                        <dt id="day8Temp">Temperature: <?php echo(round($jsonArray['daily'][7]['temp']['min']));?>C - <?php echo(round($jsonArray['daily'][0]['temp']['max']));?> C</dt>
                                        <dt id="day8Humidity">Humidity: <?php echo $jsonArray['daily'][7]['humidity'];?>%</dt>
                                        <dt id="day8WindSpeed">Wind Speed: <?php echo(round($jsonArray['daily'][7]['wind_speed']));?>MpH</dt>

				</div>
			</div>
		</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js">
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYqRjg-B_g9VkcS6P2yMTflcknwaZAxzo&callback=initMap" type="text/javascript"></script>
			<script>
				var map;
				var geoJSON;
				var request;
				var gettingData = false;
				var openWeatherMapKey = "a1772b5eb4516dca799fa31e7482ac70"

				function initialize() {
					var mapOptions = {
					zoom: 4,
					center: new google.maps.LatLng(50,-50)
					};

					map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
					// Add interaction listeners to make weather requests
					google.maps.event.addListener(map, 'idle', checkIfDataRequested);

					// Sets up and populates the info window with details
					map.data.addListener('click', function(event) {
						infowindow.setContent(
							"<img src=" + event.feature.getProperty("icon") + ">"
							+ "<br /><strong>" + event.feature.getProperty("city") + "</strong>"
       							+ "<br />" + event.feature.getProperty("temperature") + "&deg;C"
       							+ "<br />" + event.feature.getProperty("weather")
       							);
      							infowindow.setOptions({
         								position:{
           									lat: event.latLng.lat(),
           									lng: event.latLng.lng()
         								},
         								pixelOffset: {
           									width: 0,
           									height: -15
         								}
       							});
      							infowindow.open(map);
    					});
  				}
 					var checkIfDataRequested = function() {
   						// Stop extra requests being sent
   						while (gettingData === true) {
     							request.abort();
     							gettingData = false;
   						}
   						getCoords();
 					};

 					// Get the coordinates from the Map bounds
 					var getCoords = function() {
 						var bounds = map.getBounds();
   						var NE = bounds.getNorthEast();
   						var SW = bounds.getSouthWest();
   						getWeather(NE.lat(), NE.lng(), SW.lat(), SW.lng());
 					};

 					// Make the weather request
					var getWeather = function(northLat, eastLng, southLat, westLng) {
    						gettingData = true;
    						var requestString = "http://api.openweathermap.org/data/2.5/box/city?bbox="
                       				+ westLng + "," + northLat + "," //left top
                       				+ eastLng + "," + southLat + "," //right bottom
                       				+ map.getZoom()
                       				+ "&cluster=yes&format=json"
                       				+ "&APPID=" + openWeatherMapKey;
    						request = new XMLHttpRequest();
    						request.onload = proccessResults;
    						request.open("get", requestString, true);
    						request.send();
  					};

 					// Take the JSON results and proccess them
 					var proccessResults = function() {
 						console.log(this);
   						var results = JSON.parse(this.responseText);
   						if (results.list.length > 0) {
       						resetData();
       						for (var i = 0; i < results.list.length; i++) {
         							geoJSON.features.push(jsonToGeoJson(results.list[i]));
       						}
       						drawIcons(geoJSON);
   						}
 					};

 					var infowindow = new google.maps.InfoWindow();

 					// For each result that comes back, convert the data to geoJSON
 					var jsonToGeoJson = function (weatherItem) {
 						var feature = {
     							type: "Feature",
     							properties: {
       							city: weatherItem.name,
       							weather: weatherItem.weather[0].main,
       							temperature: weatherItem.main.temp,
       							min: weatherItem.main.temp_min,
       							max: weatherItem.main.temp_max,
       							humidity: weatherItem.main.humidity,
       							pressure: weatherItem.main.pressure,
       							windSpeed: weatherItem.wind.speed,
       							windDegrees: weatherItem.wind.deg,
       							windGust: weatherItem.wind.gust,
       							icon: "http://openweathermap.org/img/w/"
       						        + weatherItem.weather[0].icon  + ".png",
       							coordinates: [weatherItem.coord.Lon, weatherItem.coord.Lat]
     							},
     							geometry: {
       							type: "Point",
       							coordinates: [weatherItem.coord.Lon, weatherItem.coord.Lat]
     							}
   						};
   						// Set the custom marker icon
   						map.data.setStyle(function(feature) {
   							return {
       							icon: {
         								url: feature.getProperty('icon'),
         								anchor: new google.maps.Point(25, 25)
       							}
     							};
   						});

   						// returns object
   						return feature;
 					};

 					// Add the markers to the map
 					var drawIcons = function (weather) {
    						map.data.addGeoJson(geoJSON);
    						// Set the flag to finished
    						gettingData = false;
 					};

 					// Clear data layer and geoJSON
 					var resetData = function () {
   						geoJSON = {
     							type: "FeatureCollection",
							features: []
    					};
    					map.data.forEach(function(feature) {
      						map.data.remove(feature);
    					});
  				};

 					google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="map-canvas"></div>
	</body>

<footer class="page-footer" id="footer">
	<div class="container">
		<div class="row">
			<div class="col l6 s12">
				<p class="grey-text text-lighten-4">"Weather Forcast &trade;"</p>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			© 2021 William Tyler (NET302_Project)
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
		<script>
    			function openTab(evt, tabName) {
 				var i, tabcontent, tablinks;
  				tabcontent = document.getElementsByClassName("tabcontent");
  				for (i = 0; i < tabcontent.length; i++) {
    					tabcontent[i].style.display = "none";
  				}
  				tablinks = document.getElementsByClassName("tablinks");
  				for (i = 0; i < tablinks.length; i++) {
    					tablinks[i].className = tablinks[i].className.replace(" active", "");
  				}
  				document.getElementById(tabName).style.display = "block";
  				evt.currentTarget.className += " active";
}
  		</script>
</html>
