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


$db->where("id", $_SESSION['member_id']);
$fetch_members = $db->getOne("members");


if ($db->count > 0) {

   if($_GET['id']){
       $id = GetSQLValueString($_GET['id'], "int");
       $db->where("id", $id);
       $db->where("member_id", $fetch_members['id']);
       $fetch_msg_detail = $db->getOne("member_messages" ,["text", "title", "created_at"]);
       if($db->count >0){
           $db->where("id", $id);
           $update_array = array(
               "seen"=> 1
           );
           if($db->update("member_messages", $update_array)){
               $REST->responseArray = array(
                   "status" => 200,
                   "data" => $fetch_msg_detail
               );
           }else{
               $REST->responseArray = array(
                   "status" => 500, "msg" => \lib\classes\RestService::$codes['500']
               );
           }
       }else{
           $REST->responseArray = array(
               "status" => 404, "msg" => \lib\classes\RestService::$codes['404']
           );
       }
   }else{
       $REST->responseArray = array(
           "status" => 406, "msg" => \lib\classes\RestService::$codes['406']
       );
   }

} else {
    $REST->responseArray = array(
        "status" => 403, "msg" => \lib\classes\RestService::$codes['403']
    );
}

echo $REST->RseponseToC();
