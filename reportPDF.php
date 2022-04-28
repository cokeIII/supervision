<?php
// Require composer autoload

session_start();
require_once 'vendor/autoload.php';
require_once 'vendor/mpdf/mpdf/mpdf.php';
require_once 'connect.php';
$date_time = $_GET["date_time"];
$arrDate = explode(" ", $date_time);
$business = $_GET["business"];
$people_id = $_SESSION["people_id"];
$people_dep_name = $_SESSION["people_dep_name"];
$people_name = $_SESSION["people_name"];
$sql = "select * from data_report where date_time='$date_time' and business='$business' and people_id='$people_id'";
$user_name = $_SESSION["people_name"];
$que = mysqli_query($connect, $sql);

header('Content-Type: text/html; charset=utf-8');
// เพิ่ม Font ให้กับ mPDF
$mpdf = new mPDF();

function DateThai($strDate)
{
  $strYear = date("Y", strtotime($strDate)) + 543;
  $strMonth = date("n", strtotime($strDate));
  $strDay = date("j", strtotime($strDate));
  $strHour = date("H", strtotime($strDate));
  $strMinute = date("i", strtotime($strDate));
  $strSeconds = date("s", strtotime($strDate));
  $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
  $strMonthThai = $strMonthCut[$strMonth];
  // return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
  return "$strDay $strMonthThai $strYear";
}
ob_start(); // Start get HTML code
?>


<!DOCTYPE html>
<html>

<head>
  <title>วิทยาลัยเทคนิคชลบุรี</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/ovec-removebg.ico" />
  <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
  <style>
    body {


      font-family: "thsarabun";


    }

    .txt-h {
      text-align: center;
    }

    .content {
      padding: 24px;

    }

    .ta-content {
      /* text-align: center; */
      font-size: 18px;
    }
  </style>
</head>

<body>
  <h2 class="txt-h"><strong><u> แบบรายงานผลการนิเทศ การฝึกงาน ฝึกอาชีพ ออนไลน์</u></strong></h2>
  <table width="100%" class="ta-content">
    <tr>
      <td><strong>ชื่อ-สกุลครูนิเทศ </strong></td>
      <td> <?php echo $people_name; ?></td>
      <td><strong>แผนกวิชา </strong></td>
      <td> <?php echo $people_dep_name; ?></td>
    </tr>
    <tr>
      <td><strong>วัน/เดือน/ปี </strong></td>
      <td> <?php echo DateThai($arrDate[0]); ?></td>
      <td><strong>เวลา </strong></td>
      <td> <?php echo $arrDate[1]; ?></td>
    </tr>
    <tr>
      <td><strong>ชื่อสถานประกอบการ </strong></td>
      <td> <?php echo $business; ?></td>
    </tr>
    <?php $i = 1;
    while ($row = mysqli_fetch_assoc($que)) { ?>
      <tr>
        <td><strong><?php echo $i++; ?>. ชื่อ-สกุลนักเรียน นักศึกษา </strong></td>
        <td><?php echo $row["std_name"]; ?></td>
      </tr>
      <tr>
        <td><strong>รหัสนักศึกษา </strong></td>
        <td><?php echo $row["std_id"]; ?></td>
        <td><strong>ระดับชั้น/กลุ่ม </strong></td>
        <td><?php echo $row["std_level"]; ?></td>
        <td><strong>แผนกวิชา </strong></td>
        <td><?php echo $row["std_department"]; ?></td>
      </tr>
    <?php } ?>
  </table>
  <pagebreak></pagebreak>
  <?php
  $que2 = mysqli_query($connect, $sql);
  while ($row2 = mysqli_fetch_assoc($que2)) { ?>
    <table width="100%" class="ta-content">
      <tr>
        <td><strong>รหัสนักศึกษา </strong></td>
        <td><?php echo $row2["std_id"]; ?></td>
        <td><strong>ระดับชั้น/กลุ่ม </strong></td>
        <td><?php echo $row2["std_level"]; ?></td>
        <td><strong>แผนกวิชา </strong></td>
        <td><?php echo $row2["std_department"]; ?></td>
      </tr>
    </table>
    <p class="ta-content"><strong>รูปภาพขณะทำการปฐมนิเทศ</strong></p>
    <img src="uploads_img/<?php echo $row2["pic"]; ?>" height="350">
    <div class="ta-content">
      <p><strong>หัวข้อติดตามการนิเทศ การฝึกงาน ฝึกอาชีพ ออนไลน์</strong></p>
      <table class="ta-content">
        <tr>
          <td>1.นักเรียน นักศึกษา ฝึกปฏิบัติงานตรงต่อเวลา</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="11" id="11" <?php echo ($row2["q1"] == "ใช่" ? "checked='checked'" : "") ?>> ใช่ <input type="checkbox" name="12" id="12" <?php echo ($row2["q1"] == "ไม่ใช่" ? "checked='checked'" : "") ?>> ไม่ใช่</td>
        </tr>
        <tr>
          <td>2.นักเรียน นักศึกษา แต่งกายถูกระเบียบตามข้อปฏิบัติ</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="21" id="21" <?php echo ($row2["q2"] == "ใช่" ? "checked='checked'" : "") ?>> ใช่ <input type="checkbox" name="22" id="22" <?php echo ($row2["q2"] == "ไม่ใช่" ? "checked='checked'" : "") ?>> ไม่ใช่</td>
        </tr>
        <tr>
          <td>3.นักเรียน นักศึกษา มีทรงผมถูกระเบียบตามข้อปฏิบัติ</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="31" id="31" <?php echo ($row2["q3"] == "ใช่" ? "checked='checked'" : "") ?>> ใช่ <input type="checkbox" name="32" id="32" <?php echo ($row2["q3"] == "ไม่ใช่" ? "checked='checked'" : "") ?>> ไม่ใช่</td>
        </tr>
        </tr>
        <tr>
          <td>4.นักเรียน นักศึกษา มีการลงบันทึกข้อมูลสมุดฝึกงาน ครบถ้วน เป็นปัจจุบัน</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="31" id="31" <?php echo ($row2["q4"] == "ใช่" ? "checked='checked'" : "") ?>> ใช่ <input type="checkbox" name="32" id="32" <?php echo ($row2["q4"] == "ไม่ใช่" ? "checked='checked'" : "") ?>> ไม่ใช่</td>
        </tr>
      </table>
      <p><strong>สรุปผลการนิเทศ หรือประเด็นที่พบ พร้อมแนวทางการแก้ไข</strong></p>
      <p><?php echo $row2["conclusion"] ?></p>
      <p><strong>ข้อเสนอแนะจากสถานประกอบการ</strong></p>
      <p><?php echo $row2["feedback"] ?></p>
    </div>
    <pagebreak></pagebreak>
  <?php } ?>

</body>

</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$taget = "pdf/" . $people_id . ".pdf";
$mpdf->Output($taget);
ob_clean();
ob_end_flush();
header("location: $taget");
?>

<!-- ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF.pdf">คลิกที่นี้</a> -->