<?php
    session_start();
    include_once("connect.php");
	$username = $_POST['username'];
    $password = $_POST['pass'];
		$strSQL = "SELECT * FROM people WHERE people_id='".$username."' and people_id ='".$password."' ";
		$objQuery = mysqli_query($connect,$strSQL);
		$objResult = mysqli_fetch_array($objQuery);
		if(!$objResult)	{
			if($username=="admin" && $password=="chontech"){
				$_SESSION['user']="admin";
				header( "location: report/index.php" );
			}else{
				$_SESSION['error_login']="error";
				header( "location: index.php" );
			}
				// echo "username and Password Incorrect!";
		}
		else
		{
			$_SESSION["people_name"] = $objResult["people_name"]." ".$objResult["people_surname"];
			$_SESSION["people_id"] = $objResult["people_id"];
			//echo "<meta http-equiv='refresh' content='0;url= company.php'>";
			header("location: supervision_bus.php");
		}
