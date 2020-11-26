<?php
	$city = "plymouth,uk"
	$apicall = "api.openweathermap.org/data/2.5/weather?q="$city"&appid=a1772b5eb4516dca799fa31e7482ac70";
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

		<title>UK Weather</title>

	</head>
	<body>

		<h1>Enter City</h1>
		<div class="row">
			<div class="input-field col s8">
				<input placeholder="City Name" name="cityName" id="customerName" type="text" class="validate" maxlength="50" required>
			</div>
		</div>

<footer class="page-footer" style="background-color: #2C3539">
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
