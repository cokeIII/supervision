<?php
// Require composer autoload

session_start();
require_once 'vendor/autoload.php';
require_once 'vendor/mpdf/mpdf/mpdf.php';
require_once 'connect.php';
$date1 = $_POST["date_time_1"];
$date2 = $_POST["date_time_2"];
$sql = "select * from data_report d
inner join people p on p.people_id = d.people_id
where d.date_time between date('$date1')  and date('$date2') group by d.people_id,d.date_time";

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

        .no-w {
            white-space: nowrap;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <h2 class="txt-h">แบบรายงานผลการนิเทศ การฝึกงาน ฝึกอาชีพ ออนไลน์</h2>
    <h2 class="txt-h">ระหว่างวันที่ <?php echo DateThai($date1); ?> ถึงวันที่ <?php echo DateThai($date2); ?></h2>
    <?php $i = 1;
    while ($row = mysqli_fetch_array($que)) { ?>
        <table border="1" class="ta-content" width="100%">
            <tr>
                <td colspan="4"><?php echo $i . ". "; ?>ครูนิเทศก์ <?php echo $row["people_name"] . " " . $row["people_surname"] . " (" . $row["business"] . ")"; ?> </td>
            </tr>
            <tr>
                <td class="txt-h">ลำดับ</td>
                <td class="txt-h">ชื่อ - สกุล</td>
                <td class="txt-h">สรุปผลการนิเทศ หรือประเด็นที่พบ พร้อมแนวทางการแก้ไข</td>
                <td class="txt-h">รูปภาพ</td>
            </tr>
            <?php $j = 1;
            $date_time = $row["date_time"];
            $business = $row["business"];
            $people_id = $row["people_id"];
            $sqlData = "select * from data_report where date_time='$date_time' and business='$business' and people_id='$people_id'";
            $queData = mysqli_query($connect, $sqlData);
            while ($rowData = mysqli_fetch_array($queData)) { ?>
                <tr>
                    <td><?php echo $j; ?></td>
                    <td class="no-w"><?php echo $rowData["std_name"]; ?></td>
                    <td><?php echo $rowData["conclusion"]; ?></td>
                    <td><img src="uploads_img/<?php echo $rowData["pic"]; ?>" width="100" height="auto"> </td>
                </tr>
            <?php $j++;
            } ?>
        </table>
        <br>
    <?php $i++;
    } ?>
</body>

</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$taget = "pdf/report_all.pdf";
$mpdf->Output($taget);
ob_clean();
ob_end_flush();
header("location: $taget");
?>

<!-- ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF.pdf">คลิกที่นี้</a> -->