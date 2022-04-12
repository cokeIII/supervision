<?php
// Require composer autoload

session_start();
require_once '../vendor/autoload.php';
require_once '../vendor/mpdf/mpdf/mpdf.php';
require_once '../connect.php';
$dep = $_POST["dep"];
$date1 = $_POST["date1"];
$date2 = $_POST["date2"];
if($dep != ""){
    $sql = "select upl.*, peo.people_name, peo.people_surname, peo.people_id, count(upl.people_id) as countRow
    from 
    upload_data upl left join people peo 
    on upl.people_id = peo.people_id
    where upl.people_dep_id = '$dep' and upl.learn_date between '$date1' and '$date2' 
    group by upl.people_id";
} else {
    $sql = "select upl.*, peo.people_name, peo.people_surname, peo.people_id, count(upl.people_id) as countRow
    from 
    upload_data upl left join people peo 
    on upl.people_id = peo.people_id
    where upl.learn_date between '$date1' and '$date2'
    group by upl.people_id";
}
$result = $connect->query($sql);
$sqlDep = "select people_dep_id,people_dep_name from people_dep where people_dep_id ='$dep'";
$resultDep = $connect->query($sqlDep);
$rowDep = $resultDep->fetch_assoc();

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

        td,
        th {
            font-size: 20px;
            text-align: center;
        }
        table,tr,th,td{
            border: 1px solid black;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;      
        }
    </style>
</head>

<body>

    <h2 class="txt-h">สรุปการสอนออนไลน์</h2>
    <h2 class="txt-h"><?php if(!empty($rowDep["people_dep_name"])){?>แผนกวิชา <?php echo $rowDep["people_dep_name"]; }?></h2>
    <h2 class="txt-h">วันที่ <?php echo DateThai($_POST["date1"]) ?> ถึงวันที่ <?php echo DateThai($_POST["date2"]) ?></h2>

    <table class="table">
        <thead>
            <tr>
                <th>&nbsp;ที่&nbsp;</th>
                <th>&nbsp;ชื่อครูผู้สอน&nbsp;</th>
                <th>&nbsp;&nbsp;จำนวนรายการที่สอน&nbsp;&nbsp;</th>
                <th>&nbsp;&nbsp;&nbsp;หมายเหตุ&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $row["people_name"] . "  " . $row["people_surname"]; ?></td>
                        <td><?php echo $row["countRow"]; ?></td>
                        <td></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

</body>

</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$taget = "../pdf/" ."admin". ".pdf";
$mpdf->Output($taget);
ob_end_flush();
header("location: $taget");
?>

<!-- ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF.pdf">คลิกที่นี้</a> -->