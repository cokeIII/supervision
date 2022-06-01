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

$sqlList = "select * from training t
inner join business b on b.business_id = t.business_id
inner join student s on s.student_id = t.student_id
inner join prefix p on p.prefix_id = s.perfix_id
";
$resList = mysqli_query($connect, $sqlList);

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
                <table class="table" id="list_super">
                    <tr>
                        <th>ลำดับ</th>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อ - สกุล</th>
                        <th>สถานประกอบการ</th>
                        <th></th>
                    </tr>
                    <?php $i = 0;
                    while ($rowList = mysqli_fetch_array($resList)) { ?>
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td><?php echo $rowList["student_id"]; ?></td>
                            <td><?php echo $rowList["prefix_name"].$rowList["stu_fname"]." ".$rowList["stu_lname"]; ?></td>
                            <td><?php echo $rowList["business_name"]; ?></td>
                            <td><button class="btn btn-success">นิเทศ</button></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</div>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function() {
        $('#list_super').DataTable();
    });
</script>