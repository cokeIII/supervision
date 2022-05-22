<?php
error_reporting(0);
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=สรุปรายงานการนิเทศ.doc");
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
function convertImage($originalImage, $outputImage, $quality)
{
    // jpg, png, gif or bmp?
    $exploded = explode('.', $originalImage);
    $ext = $exploded[count($exploded) - 1];

    if (preg_match('/jpg|jpeg/i', $ext))
        $imageTmp = imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i', $ext))
        $imageTmp = imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i', $ext))
        $imageTmp = imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i', $ext))
        $imageTmp = imagecreatefrombmp($originalImage);
    else
        return 0;

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}
require_once 'connect.php';
$date1 = $_POST["date_time_1"];
$date2 = $_POST["date_time_2"];
$sql = "select * from data_report d
inner join people p on p.people_id = d.people_id
where d.date_time between date('$date1')  and date('$date2') group by d.people_id,d.date_time";

$que = mysqli_query($connect, $sql);
?>
<html>
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
            while ($rowData = mysqli_fetch_array($queData)) {
                if (file_exists( 'uploads_img/' . $rowData["pic"])) {
                    $images = 'uploads_img/' . $rowData["pic"];
                    $new_images = 'MyResize/' . $rowData["pic"];
                    $width = 100; //*** Fix Width & Heigh (Autu caculate) ***//
                    $size = GetimageSize($images);
                    $height = round($width * $size[1] / $size[0]);
                    // convertImage('uploads_img/' . $rowData["pic"], 'uploads_img/' . $rowData["pic"], 100);
                    $images_orig = ImageCreateFromJPEG($images);
                    $photoX = ImagesX($images_orig);
                    $photoY = ImagesY($images_orig);
                    $images_fin = ImageCreateTrueColor($width, $height);
                    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                    ImageJPEG($images_fin, $new_images);
                    ImageDestroy($images_orig);
                    ImageDestroy($images_fin);

                    $path = 'MyResize/' . $rowData["pic"];
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            ?>
                <tr>
                    <td><?php echo $j; ?></td>
                    <td class="no-w"><?php echo $rowData["std_name"]; ?></td>
                    <td><?php echo $rowData["conclusion"]; ?></td>
                    <td width="100" height="auto"><img src="<?php echo $base64; ?>" alt="" width="100" height="auto"></td>
                </tr>
            <?php $j++;
            } ?>
        </table>
        <br>
    <?php $i++;
    } ?>
</body>