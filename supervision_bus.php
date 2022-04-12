<?php include "header.php"; ?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<!--===============================================================================================-->
<?php
// session_start();
include "menu.php";
include "connect.php";
$people_id = $_SESSION["people_id"];

date_default_timezone_set("Asia/Bangkok");
$new_date = date('Y-m-d');

$sql2 = "SELECT p1.`people_id`,p1.`people_name`,p1.`people_surname`,p3.`people_dep_name`,p3.`people_dep_id`
  FROM people p1
  INNER join people_pro p2 on p1.`people_id`= p2.`people_id`
  INNER JOIN people_dep p3 ON p2.`people_dep_id`= p3.`people_dep_id`
  where p3.`people_depgroup_id`= '3' and  p1.`people_id`='$people_id'";

$F = mysqli_query($connect, $sql2);
$row = mysqli_fetch_array($F);
$_SESSION["people_dep_name"] = $row["people_dep_name"];
$_SESSION["super_data"] = array();
?>
<style>
    .font-black {
        color: black;
    }

    .bg3 {
        background-image: url("images/3.jpg");
    }
</style>
<div class="main mt-5">

    <div class="container">
        <div class="signup-content">
            <div class="signup-img bg3">
                <!-- <img src="images/3.jpg" alt="" height="auto"> -->
                <div class="signup-img-content">
                    <h2>เพิ่มข้อมูลการนิเทศ</h2>
                    <p>วิทยาลัยเทคนิคชลบุรี</p>
                </div>
            </div>
            <div class="signup-form mt-3 p-2">
                <form method="post" action="make_data_bus.php">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>วันเวลา</label>
                            <input type="datetime-local" name="date_time" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>ชื่อสถานประกอบการ</label>
                            <input type="text" name="business" class="form-control" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-right" id="plus-std"><i class="fa fa-arrow-right" aria-hidden="true"></i> ถัดไป</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php include "footer.php"; ?>