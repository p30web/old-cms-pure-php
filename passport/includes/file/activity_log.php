<?php

 function activity_log($user_id, $req_uri,$type, $table, $message){
     error_reporting(0);

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

     mysqli_select_db($cn_log, $log_database_cn);
     $query_log = "INSERT INTO `member_activity`(`user_ip`, `user_id`, `request_uri`, `time`, `table`, `type`, `message`) VALUES (
'".$_SERVER['REMOTE_ADDR']."',
".$user_id.",
'".$req_uri."',
'".time()."',
'".$table."',
".$type.",
'".$message."'
)";
     $rsslidesh = mysqli_query($cn_log, $query_log) or die(mysqli_error($cn_log));
     //echo $query_log;


 }