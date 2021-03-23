<?php
include("../checklogin.php");

require_once('../includes/classes/restful/RestService.php');

//require_once '../includes/classes/blockio/block_io.php';

$REST = new \lib\classes\RestService();
$crypto = new \lib\classes\Crypto();

$REST->CorsArray = array(
    "AllowOrigin" => array("*"),
    "MaxAge" => 10,
    "AllowCredentials" => true,
    //  "ExposeHeaders"=> array("Cache-Control", "Content-Language"),
    "AllowMethods" => array("POST"),
    "AllowHeaders" => array("Content-Type, charset"),
    "ContentType" => "application/json"
);
$REST->Authorization = false;
$REST->method = array("POST");
$Data = $REST->Processing();

$db->where("id", $Data['myData']);
$active_plane_det= $db->getOne("active_investment_plan");

$now = time();

if($active_plane_det['period_type'] === "month"){
    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(30 * 24 * 60 * 60);
}
elseif ($active_plane_det['period_type'] === "3month"){
    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(90 * 24 * 60 * 60);
}

elseif ($active_plane_det['period_type'] === "6month"){
    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(180 * 24 * 60 * 60);
}

elseif ($active_plane_det['period_type'] === "yearly"){
    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(365 * 24 * 60 * 60);
}

elseif ($active_plane_det['period_type'] === "day"){
    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(1 * 24 * 60 * 60);
}
$tfid =  abs($now - $endtime)/60/60/24;

$sd = date("Y-m-d H:i:s", $now);
$ed = date("Y-m-d H:i:s", $endtime);
$start_date = new DateTime($sd);
$since_start = $start_date->diff(new DateTime($ed));
$time =  $since_start->m.' ماه ';
$time .= $since_start->d.' روز ';
$time .= $since_start->h.' ساعت ';
$time .= $since_start->i.' دقیقه ';
$time .= $since_start->s.' ثانیه ';

$REST->responseArray = array(
    "status" => 200,
    "type" => "success",
    "message" => $time,
    "sd" => $sd,
    "ed" => $ed,
);

echo $REST->RseponseToC();