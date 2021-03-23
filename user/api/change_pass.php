<?php
include("../checklogin.php");

//include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
require_once ("../lib/file/activity_log.php");
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
    if(
        $_GET['currentpass'] &&
        $_GET['newpass'] &&
        $_GET['confrimnewpass']
    ) {

        $currentpass = sha1(md5(GetSQLValueString($_GET['currentpass'],"def")));
        $newpass =  sha1(md5(GetSQLValueString($_GET['newpass'],"def")));
        $cconfrimnewpass = sha1(md5(GetSQLValueString($_GET['confrimnewpass'],"def")));

        if($newpass === $cconfrimnewpass){
            if($currentpass === $fetch_members['password']){

                $update_user = array(
                    "password"=> $newpass
                );

                $db->where("id", $fetch_members['id']);
                if($db->update("members", $update_user)){
                    activity_log($fetch_members['id'], $_SERVER['REQUEST_URI'],2, "members", "بروز رسانی رمز عبور");
                    $REST->responseArray = array(
                        "status" => 200,
                        "type"=> "success",
                        "message"=> "اطلاعات با موفقیت به روز رسانی شد!"

                    );
                }

            }else{
                $REST->responseArray = array(
                    "status" => 200,
                    "type"=> "danger",
                    "message"=> "رمز عبور فعلی اشتباه است!"

                );
            }
        }else{
            $REST->responseArray = array(
                "status" => 200,
                "type"=> "danger",
                "message"=> "مرز عبور و تکرار آن باید یکسان باشند!"

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
