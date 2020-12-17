<?php
$locName = $_POST['locName'];
shell_exec("/var/www/NET302-Project/pythonScripts/bin/python3 /var/www/NET302-Project/pythonScripts/get_request.py $locName");
header("location:../index.php?location=$locName");
?>
