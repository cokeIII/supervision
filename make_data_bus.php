<?php
header('Content-Type: text/html; charset=UTF-8');
require_once "connect.php";
session_start();

$_SESSION["super_data"]["date_time"] = $_POST["date_time"];
$_SESSION["super_data"]["business"] = $_POST["business"];

header("location: supervision_std.php");