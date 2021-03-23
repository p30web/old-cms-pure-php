<?php
include("../safeval.php");
require_once('../includes/class/RestService.php');
require_once('../includes/class/MysqlDB/MysqliDb.php');
require_once('../Connections/cn2.php');
require_once('../includes/file/jdf.php');
require_once('../includes/file/function.php');
date_default_timezone_set('Asian/Tehran');

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

if (
    isset($Data['mc-email'])
) {
    $email = GetSQLValueString($_POST['mc-email'], 'def');



    $insert_array = array(
        "email" => $email,
        "status" => '1',
        "created_at" => jdate('Y-m-d H:i:s'),
        "portalid" => 0,
    );
    if ($newsletterid = $db->insert("newsletter", $insert_array)) {


        $REST->responseArray = array(
            "status" => 200,
            "type" => "success",
            "message"=> "اشتراک شما ثبت شده است"
        );

    } else {
        $REST->responseArray = array(
            "status" => 500, "type" => "danger",
            "message" => "اشنراک تکراری است",

        );
    }
} else {
    $REST->responseArray = array(
        "status" => 406, "type" => "danger",
        "message" => "درخواست شما نامعتبر است",

    );
}
echo $REST->RseponseToC();
