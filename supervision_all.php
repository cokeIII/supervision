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
                    <h2>ข้อมูลการนิเทศ</h2>
                    <p>วิทยาลัยเทคนิคชลบุรี</p>
                </div>
            </div>
            <div class="signup-form mt-3 p-2">
                <table id="data_report" class="table" width="100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>บริษัท</th>
                            <th>วันเวลา</th>
                            <th></th>
                            <th></th>
                            <th>เลือกสำหรับพิมพ์บันทึกข้อความ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql2 = "select * from data_report where people_id ='$people_id' group by date_time,business";
                        $res2 = mysqli_query($connect, $sql2);
                        while ($row2 = mysqli_fetch_array($res2)) {
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row2["business"]; ?></td>
                                <td><?php echo $row2["date_time"]; ?></td>
                                <td><a href="reportPDF.php?date_time=<?php echo $row2["date_time"]; ?>&business=<?php echo $row2["business"]; ?>" class="btn btn-info" target="_blank"><i class="fa fa-file-text" aria-hidden="true"></i> พิมพ์รายงาน</a></td>
                                <td><button date_time="<?php echo $row2["date_time"]; ?>" business="<?php echo $row2["business"]; ?>" class="btn btn-danger delItem"><i class="fa fa-trash-o" aria-hidden="true"></i> ลบรายการ</button></td>
                                <td><input date_time="<?php echo $row2["date_time"]; ?>" business="<?php echo $row2["business"]; ?>" type="checkbox" name="selected_data[]" class="selected_data"></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <button id="saveMsg" class="btn btn-primary mt-2 float-right"><i class="fa fa-file-text" aria-hidden="true"></i> บันทึกข้อความ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function() {
        let selected_data = []
        $("#saveMsg").click(function() {
            let i = 0
            $('.selected_data:checkbox:checked').each(function() {
                var status = (this.checked ? $(this).val() : "")
                var date_time = $(this).attr("date_time")
                var business = $(this).attr("business")
                selected_data[i] = {
                    date_time: $(this).attr("date_time"),
                    business: $(this).attr("business")
                }
                i++;

            });
            $.redirect("form_reportPDF2.php", {
                selected_data: selected_data,
            }, "POST");
        })
        $('#data_report').DataTable({
            "scrollX": true
        });
        $(document).on("click", ".delItem", function() {
            if (confirm("คุณต้องการลบรายการ ?")) {
                $.redirect("del_item.php", {
                    date_time: $(this).attr("date_time"),
                    business: $(this).attr("business"),
                    people_id: '<?php echo $people_id; ?>'
                }, "POST");
            }
        })
    });
</script>