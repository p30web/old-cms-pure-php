<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Tehran');
$mysqli=mysqli_connect("$database_Host", "$database_User", "$database_Password", "$database_Name") or die ('خطا در اتصال به دیتابیس  ممکن است مشخصات نام کاربری و کلمه رمز را اشتباه وارد کرده باشید');
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
//initiate mysql connection for utf8 support;
mysqli_query($mysqli, "SET NAMES 'utf8'");

?>
