<?php
require_once "connect.php";
session_start();
header('Content-Type: text/html; charset=UTF-8');

$std_id = $_POST["std_id"];

$sql = "select * from student s
inner join student_group g on g.student_group_id = s.group_id
inner join prefix p on p.prefix_id = s.perfix_id 
where s.student_id = '$std_id'
";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);
$data = array();

$data["stu_fname"] = $row["stu_fname"];
$data["stu_lname"] = $row["stu_lname"];
$data["prefix_name"] = $row["prefix_name"];
$data["student_group_no"] = number_format($row["student_group_no"]);
$data["grade_name"] = $row["grade_name"];
$data["major_name"] = $row["major_name"];

echo json_encode($data);