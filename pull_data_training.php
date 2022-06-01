<?php
require_once "connect_dve.php";
require_once "connect.php";
require_once 'class.ProgressBar.php';
$sqlTraining = "
        select * from request_training where school_id = '1320026101' and last_status = 'approve'
    ";
echo 'ข้อมูลการฝึกงาน<br />';
$p = new ProgressBar();
echo '<div style="width: 300px;">';
$p->render();
echo '</div>';

$resTraining = mysqli_query($connectDve, $sqlTraining);
$totalLoad = mysqli_num_rows($resTraining);
$i = 0;
while ($rowTraining = mysqli_fetch_array($resTraining)) {
    $student_id = $rowTraining["student_id"];
    $business_id = $rowTraining["business_id"];
    $start_date = $rowTraining["start_date"];
    $end_date  = $rowTraining["end_date"];
    $location = $rowTraining["location"];

    $sqlInsert = "replace into training 
        (
            student_id,
            business_id,
            start_date,
            end_date,
            location
        ) values (
            '$student_id',
            '$business_id',
            '$start_date',
            '$end_date',
            '$location'
        )";

    mysqli_query($connect, $sqlInsert);
    $i++;
    $p->setProgressBarProgress($i * 100 / $totalLoad);
    usleep(1000000 * 0.01);
}
$p->setProgressBarProgress(100);
echo 'Done.<br />';
echo 'ข้อมูลสถานประกอบการ<br />';

$p2 = new ProgressBar(0,2);
echo '<div style="width: 300px;">';
$p2->render();
echo '</div>';

$sqlBus = "
        select * from business
    ";  
$resBus = mysqli_query($connectDve2020, $sqlBus);

$j = 0;
$num = mysqli_fetch_array($resBus);
$totalLoad2 = mysqli_num_rows($resBus);

if ($totalLoad2 <= 0) {
    echo "<h2>No records found.</h2>";
} else {
    while ($rowBus = mysqli_fetch_assoc($resBus)) {
        $business_id = $rowBus["business_id"];
        $business_name = $rowBus["business_name"];
        $tax_code = $rowBus["tax_code"];
        $house_code = $rowBus["house_code"];
        $address_no = $rowBus["address_no"];
        $road = $rowBus["road"];
        $subdistrict_id = $rowBus["subdistrict_id"];
        $district_id = $rowBus["district_id"];
        $province_id = $rowBus["province_id"];
        $postcode = $rowBus["postcode"];
        $business_phone = $rowBus["business_phone"];

        $sqlInsertDve = "replace into business 
                (
                    business_id,
                    business_name,
                    tax_code,
                    house_code,
                    address_no,
                    road,
                    subdistrict_id,
                    district_id,
                    province_id,
                    postcode,
                    business_phone
                ) values (
                    '$business_id',
                    '$business_name',
                    '$tax_code',
                    '$house_code',
                    '$address_no',
                    '$road',
                    '$subdistrict_id',
                    '$district_id',
                    '$province_id',
                    '$postcode',
                    '$business_phone'
                )
            ";
        $j++;
        mysqli_query($connect, $sqlInsertDve);
        $p2->setProgressBarProgress($j * 100 / $totalLoad2);
        // usleep(1000000 * 0.001);
    }
    $p2->setProgressBarProgress(100);

    echo 'Done.<br />';
}
