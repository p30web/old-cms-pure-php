<?php

/**
 * Created by PhpStorm.
 * User: a.ahmadi
 * Date: 12/11/2019
 * Time: 5:26 PM
 */
?>

    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
        #customers th,td {
            text-align: center;
            font-family: Tahoma;
        }
        .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
        .alert-heading {
            color: inherit;
        }
        .alert .close {
            position: relative;
            top: -2px;
            right: -21px;
            line-height: 18px;
            text-align: right;
            direction: rtl;
        }
        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #468847;
        }
        .alert-danger,
        .alert-error {
            background-color: #f2dede;
            border-color: #eed3d7;
            color: #b94a48;
        }
        .alert-info {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #3a87ad;
        }
        .alert-block {
            padding-top: 14px;
            padding-bottom: 14px;
        }
        .alert-block > p,
        .alert-block > ul {
            margin-bottom: 0;
        }
        .alert-block p + p {
            margin-top: 5px;
        }
        tr td:nth-child(4) {max-width: 39px;overflow: auto;}

    </style>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/class/MysqlDB/MysqliDb.php');
require_once('../includes/file/jdf.php');
require_once('../Connections/cn3.php');


if(isset($_GET['pass']) && !empty($_GET['pass'])){
    if($_GET['pass'] != "nmsd23"){
        exit('No accss');
    }
}else {
    exit('No accss');
}

if(isset($_GET['userid']) && !empty($_GET['pass'])){
    $db6->where("user_id", $_GET['userid']);
    $members_activity = $db6->get("member_activity");
}else{
    $members_activity = $db6->get('member_activity');
}

if ($db6->count > 0) {
    //echo "ok : $db6->count";
    echo "<table id='customers'>";
    echo "<tr>";
    echo "<th>شناسه</th>";
    echo "<th>ای پی کاربر</th>";
    echo "<th>شناسه کاربر</th>";
    echo "<th>آدرس درخواست</th>";
    echo "<th>زمان درخواست</th>";
    echo "<th>جدول مورد استفاده</th>";
    echo "<th>نوع</th>";
    echo "<th>پیام</th>";
    echo "</tr>";
    foreach ($members_activity as $member) {
        echo "<tr>";
        foreach ($member as $key => $member_item){
            echo "<td>";
            if($key == "time"){
                echo jdate("Y-m-d H:i:s",$member_item);
            }else {
                echo $member_item;
            }
            echo "</td>";
        }
        echo "</tr>";
    }
}

