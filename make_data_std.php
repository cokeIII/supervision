<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
$index = count($_SESSION["super_data"]["std_data"]);

$people_id = $_SESSION["people_id"];

$_SESSION["super_data"]["std_data"][$index]["std_id"] = $_POST["std_id"];
$_SESSION["super_data"]["std_data"][$index]["std_name"] = $_POST["std_name"];
$_SESSION["super_data"]["std_data"][$index]["std_level"] = $_POST["std_level"];
$_SESSION["super_data"]["std_data"][$index]["std_department"] = $_POST["std_department"];
$target_dir = "uploads_img/";
$pic_name = $_POST["std_id"] . "_" . $people_id . "_" . str_replace("-", "", str_replace(":", "", str_replace("/", "", $_SESSION["super_data"]["date_time"]))) . ".jpg";
$target_file = $target_dir . trim($pic_name);
$uploadOk = 1;
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$_SESSION["super_data"]["std_data"][$index]["pic"] = $pic_name;
$_SESSION["super_data"]["std_data"][$index]["1"] = $_POST["1"];
$_SESSION["super_data"]["std_data"][$index]["2"] = $_POST["2"];
$_SESSION["super_data"]["std_data"][$index]["3"] = $_POST["3"];
$_SESSION["super_data"]["std_data"][$index]["4"] = $_POST["4"];
$_SESSION["super_data"]["std_data"][$index]["conclusion"] = $_POST["conclusion"];
$_SESSION["super_data"]["std_data"][$index]["feedback"] = $_POST["feedback"];
if (empty($_POST["send"])) {
    header("location: supervision_std.php");
} else {
    header("location: save_data.php");
}
