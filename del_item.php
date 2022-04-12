<?php
require_once "connect.php";

$date_time = $_POST["date_time"];
$business = $_POST["business"];
$people_id = $_POST["people_id"];

$sql = "delete from data_report where date_time = '$date_time' and business='$business' and people_id = '$people_id'";
$res =mysqli_query($connect,$sql);

if($res){
    header("location: supervision_all.php");
}
