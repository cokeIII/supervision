<?php
session_start();
if (!isset($_SESSION["people_id"]) && !isset($_SESSION["user"])) {
    header("location: index.php");
}
header('Content-Type: text/html; charset=utf-8');
?>
<link rel="stylesheet" type="text/css" href="css/menu.css">
<!--===============================================================================================-->
<style>
    .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-nav">
    <img src="images\ovec-removebg.png" alt="Logo" style="width:40px;">
    <a class="navbar-brand ml-3 title-name" href="#">ระบบรายงานการนิเทศ</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if (!isset($_SESSION["user"])) { ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link link-text" href="supervision_bus.php">เพิ่มข้อมูลการนิเทศ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-text" href="supervision_all.php">ข้อมูลการนิเทศ</a>
                </li>
            </ul>
        <?php } else { ?>

        <?php } ?>
        <span class="navbar-text text-name">
            <p><?php if (isset($_SESSION["user"])) {
                    echo $_SESSION["user"];
                } else {
                    echo $_SESSION["people_name"];
                } ?></p>
        </span>
        <span class="navbar-text">
            <a class="nav-link color-logout" href="logout.php">Logout</a>
        </span>
    </div>

    </div>
</nav>