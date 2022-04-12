<?php
    require_once "../connect.php";
    if(isset($_POST["date1"]) && isset($_POST["date2"])) {
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
        $jsonData = "";
        $i = 0;
        $jsonData .='<table class="table" id="durTable">
        <thead>
            <tr>
                <th>ที่</th>
                <th>ชื่อครูผู้สอน</th>
                <th>จำนวนรายการที่สอน</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="contentData">';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

            $jsonData .='<tr>
                <td> '. ++$i .'</td>
                <td> '. $row["people_name"].' '.$row["people_surname"].'</td>
                <td> '. $row["countRow"].'</td>
                <td><button class="btn btn-primary"><a href="../showLean.php?people_id='.$row["people_id"].'&people_name='.$row["people_name"].'&people_surname='.$row["people_surname"].'"><i class="fa fa-list icon-color"></i></a></button></td>
                </tr>';
        
            } 
        }
        $jsonData .='</tbody>
        </table>';
    }
    echo json_encode($jsonData);
?>