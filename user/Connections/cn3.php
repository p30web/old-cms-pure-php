<?php
error_reporting(1);

$log_hostname_cn = "localhost";
$log_database_cn = "irandoge_dogecoin_log";
$log_username_cn = "irandoge_ird_usr";
$log_password_cn = "xhrC.NMS1?%)";


// Create connection
$cn_log = mysqli_connect($log_hostname_cn, $log_username_cn, $log_password_cn, $log_database_cn) or trigger_error(mysqli_error($log_database_cn),E_USER_ERROR);
// Check connection
if (!$cn_log) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($cn_log,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

?>