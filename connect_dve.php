<?php
$host = "43.229.78.70";
$user = "ctc";
$password = '';
$db = "dvt";
$connectDve = mysqli_connect("$host", "$user", "$password", "$db","3306");
$connectDve->set_charset("utf8");

// Check connection
if ($connectDve->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}



$dbDve2020 = "dve2020";
$connectDve2020 = mysqli_connect("$host", "$user", "$password", "$dbDve2020","3306");
$connectDve2020->set_charset("utf8");

// Check connection
if ($connectDve2020->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
