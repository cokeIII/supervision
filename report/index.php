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
    .h-auto{
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

    $sql = "select upl.*, peo.people_name, peo.people_surname, peo.people_id, count(upl.people_id) as countRow
    from 
    upload_data upl left join people peo 
    on upl.people_id = peo.people_id 
    where upl.learn_date = CURDATE() group by upl.people_id";

    $result = $connect->query($sql);
    $sqlDep = "select * from people_dep WHERE `people_depgroup_id`=3";
    $resultDep = $connect->query($sqlDep);

    ?>
    <div class="main">

        <div class="container">
            <div class="signup-content">
                <div class="signup-img">
                    <img src="../images/2.jpg" alt="" class="h-auto">
                    <div class="signup-img-content">
                        <h2>สรุปการสอนออนไลน์</h2>
                        <p>วิทยาลัยเทคนิคชลบุรี</p>
                    </div>
                </div>
                <div class="signup-form">
                    <form action="pdf.php" method="post">
                        <div class="row mt-5 ml-3">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="day1">วันที่</label>
                                    <input class="form-control" type="date" name="date1" id="day1" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="day2">ถึง วันที่</label>
                                    <input class="form-control" type="date" name="date2" id="day2" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dep">แผนกวิชา</label>
                                    <select class="form-control" id="dep" name="dep">
                                        <option value="">ทุกแผนกวิชา</option>
                                        <?php
                                        if ($resultDep->num_rows > 0) {
                                            while ($rowDep = $resultDep->fetch_assoc()) {
                                        ?>
                                                <option value="<?php echo $rowDep["people_dep_id"]; ?>"><?php echo $rowDep["people_dep_name"]; ?></option>
                                        <?php
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success mt-3" type="submit"><i class="fa fa-file-pdf-o icon-color"></i></button>
                            </div>

                        </div>
                    </form>
                    <div class="row dur-table p-4 mt-3">
                        <div class="col-md-12" id="contentData">
                            <table class="table" id="durTable">
                                <thead>
                                    <tr>
                                        <th>ที่</th>
                                        <th>ชื่อครูผู้สอน</th>
                                        <th>จำนวนรายการที่สอน</th>
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
                                                <td><?php echo $row["countRow"]; ?></td>
                                                <td><button class="btn btn-primary"><a href="../showLean.php?people_id=<?php echo $row["people_id"];?>&people_name=<?php echo $row["people_name"];?>&people_surname=<?php echo $row["people_surname"]; ?>"><i class="fa fa-list icon-color"></i></a></button></td>
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
        $("#day1").change(function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "getData.php",
                data: {
                    date1: $("#day1").val(),
                    date2: $("#day2").val(),
                    dep: $("#dep").val()
                },
                success: function(result) {
                    $("#contentData").html(result)
                    $("#durTable").DataTable()
                }
            });
        })
        $("#day2").change(function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "getData.php",
                data: {
                    date1: $("#day1").val(),
                    date2: $("#day2").val(),
                    dep: $("#dep").val()
                },
                success: function(result) {
                    $("#contentData").html(result)
                    $("#durTable").DataTable()
                }
            })
        })
        $("#dep").change(function() {
            $.ajax({
                type: "POST",
                url: "getData.php",
                dataType: 'json',
                data: {
                    date1: $("#day1").val(),
                    date2: $("#day2").val(),
                    dep: $("#dep").val()
                },
                success: function(result) {
                    $("#contentData").html(result)
                    $("#durTable").DataTable()
                }
            });
        })
    })
</script>