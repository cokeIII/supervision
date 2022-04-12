<?php
require_once "connect.php";
session_start();
$people_id = $_SESSION["people_id"];
$date_time = $_SESSION["super_data"]["date_time"];
$business = $_SESSION["super_data"]["business"];
$std_data = $_SESSION["super_data"]["std_data"];

foreach ($std_data as $key => $value) {
    if (!empty($value["std_id"])) {
        $std_id = $value["std_id"];
        $std_name = $value["std_name"];
        $std_level = $value["std_level"];
        $std_department = $value["std_department"];
        $pic = $value["pic"];
        $q1 = $value["1"];
        $q2 = $value["2"];
        $q3 = $value["3"];
        $q4 = $value["4"];
        $conclusion = $value["conclusion"];
        $feedback = $value["feedback"];

        echo $sql = "insert into data_report (
        people_id,
        date_time,
        business,
        std_id,
        std_name,
        std_level,
        std_department,
        pic,
        q1,
        q2,
        q3,
        q4,
        conclusion,
        feedback
    ) values(
        '$people_id',
        '$date_time',
        '$business',
        '$std_id',
        '$std_name',
        '$std_level',
        '$std_department',
        '$pic',
        '$q1',
        '$q2',
        '$q3',
        '$q4',
        '$conclusion',
        '$feedback'
    )";
        $res = mysqli_query($connect, $sql);
        if ($res) {
            $_SESSION["super_data"] = array();
            header("location: supervision_all.php");
        }
    }
}
