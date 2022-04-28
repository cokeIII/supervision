<?php include "header.php"; ?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<!--===============================================================================================-->
<?php
// session_start();
include "menu.php";
include "connect.php";
$people_id = $_SESSION["people_id"];
$selected_data = $_POST["selected_data"];

date_default_timezone_set("Asia/Bangkok");
$new_date = date('Y-m-d');
function getFeedback($people_id, $selected_data)
{
    global $connect;
    $ret = "";
    foreach ($selected_data as $key => $value) {
        $date_time = $value["date_time"];
        $business = $value["business"];
        $sql = "select  feedback from data_report 
        where people_id='$people_id' 
        and date_time = '$date_time' 
        and business = '$business'
        ";
        $res = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($res);
        $ret .= "-" . $row["feedback"] . "&#10;";
    }
    return $ret;
}

function getConclusion($people_id, $selected_data)
{
    global $connect;
    $ret = "";
    foreach ($selected_data as $key => $value) {
        $date_time = $value["date_time"];
        $business = $value["business"];
        $sql = "select  conclusion from data_report 
        where people_id='$people_id' 
        and date_time = '$date_time' 
        and business = '$business'
        ";
        $res = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($res);
        $ret .= "-" . $row["conclusion"] . "&#10;";
    }
    return $ret;
}
function countPage($people_id, $selected_data)
{
    global $connect;
    $ret = 0;
    foreach ($selected_data as $key => $value) {
        $date_time = $value["date_time"];
        $business = $value["business"];
        $sql = "select count(std_id) as countPage from data_report 
        where people_id='$people_id' 
        and date_time = '$date_time' 
        and business = '$business'
        ";
        $res = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($res);
        $ret += $row["countPage"];
    }
    return $ret;
}
function nameBus($people_id, $selected_data)
{
    global $connect;
    $ret = 0;
    $check_bus = "";
    foreach ($selected_data as $key => $value) {
        $date_time = $value["date_time"];
        $business = $value["business"];
        $sql = "select count(std_id) as countPage from data_report 
        where people_id='$people_id' 
        and date_time = '$date_time' 
        and business = '$business'
        ";
        $res = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($res);
        if ($check_bus != $business) {
            $ret++;
            $check_bus = $business;
        }
    }
    return $ret;
}
$sql2 = "SELECT p4.*,p1.`people_id`,p1.`people_name`,p1.`people_surname`,p3.`people_dep_name`,p3.`people_dep_id`
  FROM people p1
  INNER join people_pro p2 on p1.`people_id`= p2.`people_id`
  INNER JOIN people_dep p3 ON p2.`people_dep_id`= p3.`people_dep_id`
  INNER JOIN people_stagov p4 ON p2.`people_stagov_id`= p4.`people_stagov_id`
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

    .float-left {
        float: left !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-radio {
        margin-top: 5px;
        width: 20px;
    }
</style>
<div class="main mt-5">
    <div class="container">
        <div class="signup-content">
            <div class="signup-img bg3">
                <!-- <img src="images/3.jpg" alt="" height="auto"> -->
                <div class="signup-img-content">
                    <h2>พิมพ์บันทึกข้อความ</h2>
                    <p>วิทยาลัยเทคนิคชลบุรี</p>
                </div>
            </div>
            <div class="signup-form mt-3 p-5">

                <form method="post" action="reportPDF2.php" target="_blank">
                    <div class="row mt-2">
                        <div class="col-md-6 border p-3">
                            <p class="text-primary">* ข้อมูลสามารถปรับเปลี่ยนและแก้ไขได้</p>
                            <!-- <label>วันเวลา</label>
                            <input type="date" name="date_time" class="form-control" value="<?php echo date('Y-m-d\TH:i:s'); ?>" required> -->
                        </div>
                        <div class="col-md-6 border p-3">
                            <label>จำนวนนักเรียน นักศึกษาที่รับการนิเทศรวม</label>
                            <input type="number" name="std_qty" class="form-control" placeholder="จำนวนนักเรียน นักศึกษาที่รับการนิเทศรวม" value="<?php echo countPage($people_id, $selected_data); ?>" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 border p-3">
                            <label>สิ่งที่ส่งมาด้วย แบบนิเทศนักเรียนนักศึกษาฝึกงาน ฝึกอาชีพ ในสถานประกอบการ</label>
                            <input type="number" name="doc_qty" class="form-control" required placeholder="จำนวนเอกสาร ฉบับ" value="<?php echo countPage($people_id, $selected_data) + count($selected_data) ?>">
                        </div>
                        <div class="col-md-6 border p-3">
                            <label>จำนวนสถานประกอบการ</label>
                            <input type="number" name="bus_qty" class="form-control" required placeholder="จำนวนสถานประกอบการ" value="<?php echo nameBus($people_id, $selected_data); ?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 border p-3">
                            <label>ข้าพเจ้า <?php echo $_SESSION["people_name"]; ?> ตำแหน่ง </label>
                            <input type="text" class="form-control" name="people_stagov_name" value="<?php echo $row["people_stagov_name"]; ?>">
                        </div>
                        <div class="col-md-6 border p-3">
                            <label>การนิเทศโดยใช้</label>
                            <div class="row">
                                <div class="col-md-2">
                                    <input class="w-radio" id="car_school" type="checkbox" value="รถวิทยาลัยฯทะเบียน" name="sup_using[]">
                                </div>
                                <div class="col-md-10">
                                    รถวิทยาลัยฯทะเบียน <input type="text" id="car_school_plate" name="car_school_plate" class="form-control" placeholder="ทะเบียนรถวิทยาลัย">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <input class="w-radio" id="car_private" type="checkbox" value="รถส่วนตัวทะเบียน" name="sup_using[]">
                                </div>
                                <div class="col-md-10">
                                    รถส่วนตัวทะเบียน <input type="text" id="car_private_plate" name="car_private_plate" class="form-control" placeholder="ทะเบียนรถส่วนตัว">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <input class="w-radio" id="app" name="app" type="checkbox" value="นิเทศโดยใช้รูปแบบออนไลน์ โปรแกรม/App" name="sup_using[]">
                                </div>
                                <div class="col-md-10">
                                    นิเทศโดยใช้รูปแบบออนไลน์ โปรแกรม/App <input type="text" id="app_name" name="app_name" class="form-control" placeholder="โปรแกรม/App">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 border p-3">
                            <label>พร้อมด้วย</label>
                            <textarea placeholder="ชื่อผู้ที่ออกนิเทศด้วย" class="form-control" name="person2" rows="3" cols="5"></textarea>
                            <label>รวม</label>
                            <input type="number" name="person_qty" class="form-control" required placeholder="จำนวนคน">
                        </div>
                        <div class="col-md-6 border p-3">
                            สรุปผลการนิเทศหรือประเด็นที่พบ พร้อมแนวทางการแก้ไข
                            <textarea class="form-control" name="all_conclusion" id="all_conclusion" cols="30" rows="10"><?php echo trim(getConclusion($people_id, $selected_data)); ?></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 border p-3">
                            <label>ได้ออกนิเทศนักเรียน นักศึกษาฝึกงาน ฝึกอาชีพ ครั้งที่</label>
                            <input type="number" name="sup_qty" class="form-control" required placeholder="จำนวนครั้ง">
                            <label>ในวันที่</label>
                            <input type="date" name="sup_day" id="sup_day" class="form-control">
                            <label>ภาคเรียนที่</label>
                            <input type="number" name="term" class="form-control" required placeholder="ภาคเรียน">
                            <label>ปีการศึกษา</label>
                            <input type="number" name="year_edu" class="form-control" required placeholder="ปีการศึกษา">
                        </div>
                        <div class="col-md-6 border p-3">
                            ข้อเสนอแนะหรือประเด็นที่ต้องการได้รับคำแนะนำจากผู้บังคับบัญชา
                            <textarea class="form-control" name="all_feedback" id="all_feedback" cols="30" rows="10"><?php echo getFeedback($people_id, $selected_data); ?></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-right" id="plus-std"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function() {
        $("#car_school_plate").hide();
        $("#car_private_plate").hide();
        $("#app_name").hide();
        car_school_plate = false
        car_private_plate = false
        app_name = false
        $("#car_school").click(function() {
            car_school_plate = !car_school_plate
            if (car_school_plate) {
                $("#car_school_plate").fadeIn();
            } else {
                $("#car_school_plate").hide();
            }
        })

        $("#car_private").click(function() {
            car_private_plate = !car_private_plate
            if (car_private_plate) {
                $("#car_private_plate").fadeIn();
            } else {
                $("#car_private_plate").hide();
            }
        })

        $("#app").click(function() {
            app_name = !app_name
            if (app_name) {
                $("#app_name").fadeIn();
            } else {
                $("#app_name").hide();
            }
        })
    })
</script>