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
?>
<style>
    .font-black {
        color: black;
    }

    .bg3 {
        background-image: url("images/3.jpg");
    }

    .r-center {
        display: flex;
        width: 70px;
        height: 50px;
        /* justify-content: center;  */
        align-items: center;
    }

    .send-center {
        display: flex;
        justify-content: center;
        align-items: center;
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
                <pre>
                <?php //print_r($_SESSION["super_data"]);
                ?>
                </pre>
                <form method="post" id="stdDataForm" action="make_data_std.php" enctype="multipart/form-data">
                    <div id="stdData">
                        <div class="std-item">
                            <h5 class="font-black">นักเรียน/นักศึกษา ลำดับที่ <?php echo (empty($_SESSION["super_data"]["std_data"]) ? "1" : count($_SESSION["super_data"]["std_data"]) + 1); ?></h5>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>รหัสนักศึกษา</label>
                                    <input type="text" name="std_id" class="form-control std_id" required>
                                </div>
                                <div class="col-md-6">
                                    <label>ชื่อ-สกุลนักเรียน นักศึกษา</label>
                                    <input type="text" name="std_name" class="form-control std_name" placeholder="กรุณาพิมพ์รหัสนักศึกษาก่อน" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>ระดับชั้น/กลุ่ม</label>
                                    <input type="text" name="std_level" class="form-control std_level" placeholder="กรุณาพิมพ์รหัสนักศึกษาก่อน" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>แผนกวิชา</label>
                                    <input type="text" name="std_department" class="form-control std_department" placeholder="กรุณาพิมพ์รหัสนักศึกษาก่อน" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <label>รูปภาพขณะทำการนิเทศ</label>
                            <input type="file" id="pic" name="pic" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <img src="images/no_img.jpg" id="pre_pic" width="350" height="auto" class="mt-2">
                    <hr>
                    <h5>หัวข้อติดตามการนิเทศ การฝึกงาน ฝึกอาชีพ ออนไลน์</h5>
                    <div class="row">
                        <div class="col-md-6 mt-3">1.นักเรียน นักศึกษา ฝึกปฏิบัติงานตรงต่อเวลา</div>
                        <div class=" r-center"><input type="radio" name="1" value="ใช่" class="" required>ใช่ </div>
                        <div class=" r-center"><input type="radio" name="1" value="ไม่ใช่" class="" required>ไม่ใช่</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">2.นักเรียน นักศึกษา แต่งกายถูกระเบียบตามข้อปฏิบัติ</div>
                        <div class=" r-center"><input type="radio" name="2" value="ใช่" class="" required>ใช่ </div>
                        <div class=" r-center"><input type="radio" name="2" value="ไม่ใช่" class="" required>ไม่ใช่</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">3.นักเรียน นักศึกษา มีทรงผมถูกระเบียบตามข้อปฏิบัติ</div>
                        <div class=" r-center"><input type="radio" name="3" value="ใช่" class="" required>ใช่ </div>
                        <div class=" r-center"><input type="radio" name="3" value="ไม่ใช่" class="" required>ไม่ใช่</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">4.นักเรียน นักศึกษา มีการลงบันทึกข้อมูลสมุดฝึกงาน ครบถ้วน เป็นปัจจุบัน</div>
                        <div class=" r-center"><input type="radio" name="4" value="ใช่" class="" required>ใช่ </div>
                        <div class=" r-center"><input type="radio" name="4" value="ไม่ใช่" class="" required>ไม่ใช่</div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label>สรุปผลการนิเทศ หรือประเด็นที่พบ พร้อมแนวทางการแก้ไข</label>
                            <textarea name="conclusion" rows="3" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label>ข้อเสนอแนะจากสถานประกอบการ</label>
                            <textarea name="feedback" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-right" id="plus-std"><i class="fa fa-arrow-right" aria-hidden="true"></i> ประเมิน นักเรียน/นักศึกษา คนต่อไป</button>
                        </div>
                    </div>
                    <input type="hidden" name="send" id="send" value="">
                </form>
                <hr>
                <!-- <form action="make_data_std.php" method="post">
                    <input type="hidden" name="send" value="ok"> -->
                <div class="send-center">
                    <button type="button" id="sendData" class="btn btn-success text-center"><i class="fa fa-file-text" aria-hidden="true"></i> ส่งข้อมูลเพื่อทำรายงาน</button>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

</div>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function() {
        $("#pic").change(function() {
            readURL(this)
        })
        $("#sendData").click(function() {
            $("#send").val("ok")
            $("#stdDataForm").submit()
        })
        $(".std_id").keyup(function() {
            if ($(this).val().length > 9) {
                $.ajax({
                    type: "POST",
                    url: "get_std_data.php",
                    dataType: 'json',
                    data: {
                        std_id: $(this).val()
                    },
                    success: function(result) {
                        if (result.grade_name != "null/0") {
                            $(".std_name").val(result.prefix_name + result.stu_fname + " " + result.stu_lname);
                            $(".std_level").val(result.grade_name + "/" + result.student_group_no);
                            $(".std_department").val(result.major_name);
                        }
                    }
                });
            }
        })
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#pre_pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>