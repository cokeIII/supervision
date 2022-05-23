<head>
    <title>วิทยาลัยเทคนิคชลบุรี</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/ovec-removebg.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../css/setFont.css">
    <!--===============================================================================================-->
</head>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<!--===============================================================================================-->
<style>
    .dur-table {
        margin-top: 0%;
    }

    .txt-link {
        color: white !important;
    }

    .icon-color {
        color: black;
    }

    .h-auto {
        height: 100%;
        width: 100%;
        position: absolute;
        right: 0;
        top: 0;
    }

</style>

<body>
    <?php
    require_once "menu.php";
    require_once "../connect.php";
    if (!empty($_POST["date_time_1"]) && !empty($_POST["date_time_2"])) {
        $date1 = $_POST["date_time_1"];
        $date2 = $_POST["date_time_2"];
        $sql = "select * from data_report d
        inner join people p on p.people_id = d.people_id
        where date_time between date('$date1')  and date('$date2')
        ";
    } else {
        $sql = "select * from data_report d
        inner join people p on p.people_id = d.people_id
        ";
    }

    $sqlDMin = "select date_time from data_report order by date_time limit 1";
    $resDMin = mysqli_query($connect, $sqlDMin);
    $rowDMin = mysqli_fetch_array($resDMin);
    $dateMin = explode(" ",$rowDMin["date_time"])[0];
    $dateMax = date("Y-m-d");
    $result = mysqli_query($connect, $sql);
    ?>
    <div class="main">

        <div class="container">
            <div class="signup-content">
                <div class="signup-img">
                    <img src="../images/2.jpg" alt="" class="h-auto">
                    <div class="signup-img-content">
                        <h2>สรุปการติดตามการนิเทศฝึกงาน</h2>
                        <p>วิทยาลัยเทคนิคชลบุรี</p>
                    </div>
                </div>
                <div class="signup-form">
                    <form method="post" action="../report_all_word.php" target="_blank">
                        <input type="hidden" name="date_time_1" value="<?php echo (!empty($_POST["date_time_1"]) ? $_POST["date_time_1"] : $dateMin); ?>" required>
                        <input type="hidden" name="date_time_2" value="<?php echo (!empty($_POST["date_time_2"]) ? $_POST["date_time_2"] : $dateMax); ?>" required>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">พิมพ์รายงานสรุป</button>
                            </div>
                        </div>
                    </form>
                    <form action="index.php" method="post">

                        <div class="row p-4 mt-3">
                            <div class="col-md-2">
                                <h5>ตั้งแต่วันที่</h5>
                            </div>
                            <div class="col-md-3 mt-1">
                                <input type="date" name="date_time_1" id="date_time_1" value="<?php echo (!empty($_POST["date_time_1"]) ? $_POST["date_time_1"] : $dateMin); ?>">
                            </div>
                            <div class="col-md-2 mt-1">
                                <h5>ถึงวันที่</h5>
                            </div>
                            <div class="col-md-3 mt-1">
                                <input type="date" name="date_time_2" id="date_time_2" value="<?php echo (!empty($_POST["date_time_2"]) ? $_POST["date_time_2"] : $dateMax); ?>">
                            </div>
                            <div class="col-md-2 mt-1">
                                <button class="btn btn-success "> เลือกวันที่ </button>
                            </div>
                        </div>
                    </form>
                    <div class="row dur-table p-4 mt-2">
                        <div class="col-md-12" id="contentData">
                            <table class="table" id="durTable">
                                <thead>
                                    <tr>
                                        <th>ที่</th>
                                        <th>ชื่อครูนิเทศ</th>
                                        <th>ชื่อสถานประกอบการ</th>
                                        <th>วันเวลา</th>
                                        <th></th>
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
                                                <td><?php echo $row["business"]; ?></td>
                                                <td><?php echo $row["date_time"]; ?></td>
                                                <td><a href="../reportPDF.php?people_id=<?php echo $row["people_id"]; ?>&date_time=<?php echo $row["date_time"]; ?>&business=<?php echo $row["business"]; ?>" class="btn btn-info" target="_blank"><i class="fa fa-file-text" aria-hidden="true"></i> พิมพ์รายงาน</a></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!--===============================================================================================-->
<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/bootstrap/js/popper.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/daterangepicker/moment.min.js"></script>
<script src="../vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="../vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="../js/main.js"></script>
<script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $("#durTable").DataTable()
    })
</script>