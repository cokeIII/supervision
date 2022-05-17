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

    .dott {
      text-decoration: none;
      border-bottom: 2px dotted black !important;
    }

    .txt-h {
      text-align: center;
      font-weight: bold;
      font-size: 28px;
    }

    .content {
      padding: 24px;

    }

    .txt-center {
      text-align: center;
    }

    .ta-content {
      /* text-align: center; */
      font-size: 20px;
    }

    .line-top {
      line-height: 0.2;
    }

    .line-top2 {
      line-height: 1.5;
    }

    .txt-right {
      text-align: right;
    }

    @page {
      margin-top: 11.33px;
    }
  </style>
</head>
<?php
$people_name = $_SESSION["people_name"];
// $date_time = $_POST["date_time"];
$std_qty = $_POST["std_qty"];
$doc_qty = $_POST["doc_qty"];
$bus_qty = $_POST["bus_qty"];
$people_stagov_name = $_POST["people_stagov_name"];
$sup_using = $_POST["sup_using"]; //array
$car_school_plate = "";
$car_private_plate = "";
$app_name = "";
foreach ($sup_using as $key => $value) {
  if ($value == "รถวิทยาลัยฯทะเบียน") {
    $car_school = $value;
    $car_school_plate = $value . " " . $_POST["car_school_plate"];
  } else if ($value == "รถส่วนตัวทะเบียน") {
    $car_private = $value;
    $car_private_plate = $value . " " . $_POST["car_private_plate"];
  } else if ($value == "นิเทศโดยใช้รูปแบบออนไลน์ โปรแกรม/App") {
    $app = $value;
    $app_name = $value . " " . $_POST["app_name"];
  }
}
$person2 = $_POST["person2"];
$person_qty = $_POST["person_qty"];
$all_conclusion = $_POST["all_conclusion"];
$sup_qty = $_POST["sup_qty"];
$sup_day = $_POST["sup_day"];
$term = $_POST["term"];
$year_edu = $_POST["year_edu"];
$all_feedback = $_POST["all_feedback"];
?>

<body>
  <table class="ta-content" width="100%">
    <tr>
      <td height="56.7px" width="auto">
        <img src="images/Picture1.png" alt="" width="auto" height="56.7px">
      </td>
      <td class="txt-h">บันทึกข้อความ</td>
    </tr>
    <tr>
      <td colspan="2"><strong>ส่วนราชการ</strong>.....................งานอาชีวศึกษาระบบทวิภาคี วิทยาลัยเทคนิคชลบุรี....................................................................................</td>
    </tr>
    <tr>
      <td colspan="2"><strong>ที่</strong>......................................................................................................<strong>วันที่</strong>.................<strong>เดือน</strong>...................................<strong>พ.ศ.</strong>..........................</td>
    </tr>
    <tr>
      <td colspan="2"><strong>เรื่อง</strong>.....................รายงานการนิเทศนักเรียน นักศึกษาฝึกงาน ฝึกอาชีพ..............................................................................................</td>
    </tr>
    <tr>
      <td colspan="2" class="txt-center line-top">
        <p class="">______________________________________________________________________________________________
        <p>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="line-top2">เรียน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการวิทยาลัยเทคนิคชลบุรี</td>
    </tr>
    <tr>
      <td colspan="2">สิ่งที่ส่งมาด้วย แบบนิเทศนักเรียนนักศึกษาฝึกงาน ฝึกอาชีพ ในสถานประกอบการ <?php echo $doc_qty; ?> ฉบับ</td>
    </tr>
  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td width="16%">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า
      </td>
      <td class="dott txt-center">
        <?php echo $people_name; ?>
      </td>
      <td width="8%">
        ตำแหน่ง
      </td>
      <td class="dott txt-center">
        <?php echo $people_stagov_name; ?>
      </td>
    </tr>

  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td width="10%">พร้อมด้วย</td>
      <td class="dott txt-center"><?php echo $person2; ?></td>
      <td width="5%">รวม</td>
      <td class="dott txt-center"><?php echo $person_qty; ?></td>
      <td width="5%">คน</td>
    </tr>
  </table>
  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td width="42%">ได้ออกนิเทศนักเรียน นักศึกษาฝึกงาน ฝึกอาชีพ ครั้งที่</td>
      <td width="5%" class="dott txt-center"><?php echo $sup_qty; ?></td>
      <td width="8%" class="txt-center">ในวันที่</td>
      <td class="dott txt-center"><?php echo DateThai($sup_day); ?></td>
    </tr>
  </table>
  <table class="ta-content" width="40%">
    <tr>
      <td width="28%">ภาคเรียนที่</td>
      <td class="dott txt-center"><?php echo $term; ?></td>
      <td width="25%" class="txt-center">ปีการศึกษา</td>
      <td width="35%" class="dott txt-center"><?php echo $year_edu; ?></td>
    </tr>
  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td>ดังรายละเอียดต่อไปนี้</td>
    </tr>
  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td width="43%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนนักเรียน นักศึกษาที่รับการนิเทศรวม</td>
      <td width="10%" class="dott txt-center"><?php echo $std_qty; ?></td>
      <td width="10%">คน&nbsp;&nbsp;&nbsp;</td>
      <td width="22%">จำนวนสถานประกอบการ</td>
      <td width="10%" class="dott txt-center"><?php echo $bus_qty; ?></td>
      <td>แห่ง</td>
    </tr>
  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td width="15%">การนิเทศโดยใช้</td>
      <td width=21%><input type="checkbox" <?php echo (!empty($car_school_plate) ? 'checked="true"' : '') ?>> <?php echo "รถวิทยาลัยฯทะเบียน"; ?></td>
      <td class="dott txt-center"><?php echo $_POST["car_school_plate"]; ?></td>
      <td width=20%><input type="checkbox" <?php echo (!empty($car_private_plate) ? 'checked="true"' : '') ?>> <?php echo "รถส่วนตัวทะเบียน"; ?></td>
      <td class="dott txt-center"><?php echo $_POST["car_private_plate"]; ?></td>
    </tr>
  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td width="15%"></td>
      <td width=43%><input type="checkbox" <?php echo (!empty($app_name) ? 'checked="true"' : '') ?>> <?php echo "นิเทศโดยใช้รูปแบบออนไลน์ โปรแกรม/App (ระบุ)"; ?></td>
      <td class="dott txt-center"><?php echo $_POST["app_name"]; ?></td>
    </tr>
  </table>
  <table class="ta-content" width="100%">
    <tr>
      <td>สรุปผลการนิเทศหรือประเด็นที่พบ พร้อมแนวทางการแก้ไข</td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo str_replace("-", " -", $all_conclusion); ?></td>
    </tr>
    <tr>
      <td>ข้อเสนอแนะหรือประเด็นที่ต้องการได้รับคำแนะนำจากผู้บังคับบัญชา</td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo str_replace("-", " -", $all_feedback); ?></td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณา</td>
    </tr>
  </table>
  <pagebreak></pagebreak>
  <table width="100%" class="ta-content">
    <tr>
      <td width="60%"></td>
      <td class="txt-center">ลงชื่อ....................................................................</td>
    </tr>
    <tr>
      <td width="60%"></td>
      <td class="txt-center">(<?php echo $people_name; ?>) ครูนิเทศก์</td>
    </tr>
  </table>
  <br>
  <table width="100%" class="ta-content">
    <tr>
      <td width="60%">ลงชื่อ.......................................................................</td>
      <td class="txt-center">ลงชื่อ.......................................................................</td>
    </tr>
    <tr>
      <td width="60%">(.................................................................................) </td>
      <td class="txt-center">(นายปิฏิวัฒน์ อรรถนาถ) </td>
    </tr>
    <tr>
      <td width="60%">หัวหน้าแผนกวิชา <?php echo $_SESSION["people_dep_name"]; ?></td>
      <td class="txt-center">หัวหน้างานอาชีวศึกษาระบบทวิภาคี</td>
    </tr>
  </table>
  <table width="100%" class="ta-content">
    <tr>
      <td>เรียน ผู้อำนวยการเพื่อโปรด</td>
    </tr>
    <tr>
      <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;๑.ทราบ</td>
      <td> ทราบ</td>
    </tr>
    <tr>
      <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;๒.พิจารณา................................................................</td>
      <td> มอบงานทวิภาคีรวบรวมข้อมูล</td>
    </tr>
  </table>
  <br>
  <table width="100%" class="ta-content">
    <tr>
      <td width="60%">ลงชื่อ.......................................................................</td>
      <td class="txt-center">ลงชื่อ.......................................................................</td>
    </tr>
    <tr>
      <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( นายอภิชาติ อนุกูลเวช )</td>
      <td class="txt-center">( นายนิทัศน์ วีระโพธิ์ประสิทธิ์ )</td>
    </tr>
    <tr>
      <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รองผู้อำนวยการฝ่ายวิชาการ</td>
      <td class="txt-center">ผู้อำนวยการวิทยาลัยเทคนิคชลบุรี</td>
    </tr>
  </table>
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