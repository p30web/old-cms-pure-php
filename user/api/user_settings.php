<?php
include("../checklogin.php");

//include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
require_once("../lib/file/activity_log.php");
//require_once('../includes/classes/mysql/MysqliDb.php');
//require_once('../Connections/cn.php');
//require_once('../includes/file/jdf.php');
//require_once('../includes/file/function.php');
//date_default_timezone_set('Asian/Tehran');

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
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_members = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_members = $db->getOne("members");
}


if ($db->count > 0) {

    $twostepver = ($_GET['twostepver'] != null) ? GetSQLValueString($_GET['twostepver'], "def") : 'off';
    $update_user = array(
        "two_step" => $twostepver
    );

    $db->where("id", $fetch_members['id']);
    if ($db->update("members", $update_user)) {
        activity_log($fetch_members['id'], $_SERVER['REQUEST_URI'], 2, "members", "بروز رسانی تنظیمات حساب کاربری");
        $REST->responseArray = array(
            "status" => 200,
            "type" => "success",
            "typسe" => $twostepver,
            "message" => "اطلاعات با موفقیت به روز رسانی شد!"

        );
    }


} else {
    $REST->responseArray = array(
        "status" => 403, "msg" => \lib\classes\RestService::$codes['403']

    );
}

echo $REST->RseponseToC();
