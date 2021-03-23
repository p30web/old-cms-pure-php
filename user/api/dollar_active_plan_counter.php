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
    "AllowMethods" => array("GET"),
    "AllowHeaders" => array("Content-Type, charset"),
    "ContentType" => "application/json"
);
$REST->Authorization = false;
$REST->method = array("GET");
$Data = $REST->Processing();

$fetch_admin = $db->get("admin_login");
if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){

    $db->where("member_id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("member_id", $_SESSION['member_id']);
}

$db->where("status", '1');
$db->where("type", "dollar");
$fetch_active_plan = $db->get("active_investment_plan");

$tleft = mktime(24,0,0) - time();

//$tleft = $fetch_active_plan['time'] - time();

///$tleft2 = 1;

$tdy_balance = 0;
foreach ($fetch_active_plan as $value){

    $timestamp = "1313000474";

    //$tleft2 = $value['time'];

    //$tleft = mktime(24,0,0) - time();

    //$tleft3 = $value['time'] - time();

    $date = date('Y-m-d', $value['time']);
    $today = date('Y-m-d');

    if ($date == $today) {
        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
    }else{
        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
    }


    //                            $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
}


$fetch_admin = $db->get("admin_login");
if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $db->where("status", "1");
    $fetch_mem = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $db->where("status", "1");
    $fetch_mem = $db->getOne("members");
}


$REST->responseArray = array(
    "status" => 200,
    "type" => "success",
    "tleft" => $tleft,
    "tdy_balance" => $tdy_balance,
    //"mktime" => mktime(24,0,0),
    //"d" => $fetch_active_plan['time'],
    //"date" => date("Y m d h:i:s",$tleft2),
    "message" => jdate("H:i:s"),
    "totalIncome" => ($fetch_mem['dollar_profit'] > 0) ? number_format((float)$fetch_mem['dollar_profit']+$tdy_balance, 8, '.', '') : number_format((float)$tdy_balance, 8, '.', ''),
    "todayIncome" => number_format((float)$tdy_balance, 8, '.', '')
);

echo $REST->RseponseToC();