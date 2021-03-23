<?php
require_once('includes/classes/mysql/MysqliDb.php');
require_once('Connections/cn.php');
require_once('Connections/cn2.php');
require_once('Connections/cn3.php');

date_default_timezone_set('Asia/Tehran');
require_once('lib/datetime/jdf.php');

include("lib/file/function.php");
include("lib/file/activity_log.php");
include("safeval.php");


require_once('includes/classes/restful/RestService.php');
require_once ("lib/file/activity_log.php");
//
require_once 'includes/classes/blockio/block_io.php';

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


    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'عیر مجاز'

    );


echo $REST->RseponseToC();