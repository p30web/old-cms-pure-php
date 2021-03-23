<?php
/**
 * Created by p30web.org
 * User: a.ahmadi
 * Date: 12/8/2019
 * Time: 12:32 AM
 */

include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
require_once ("../lib/file/activity_log.php");
require_once('../includes/classes/mysql/MysqliDb.php');
require_once('../Connections/cn.php');
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



if (isset($Data['verfycode']) && isset($Data['newpass']) && isset($Data['confrimnewpass'])){

    $email_verified_code = GetSQLValueString($_POST['verfycode'], 'def');
    $db->where("email_verified_code", $email_verified_code);
    $fetch_members = $db->getOne("members");

    if ($db->count > 0) {

        $newpass =  sha1(md5(GetSQLValueString($_POST['newpass'],"def")));
        $cconfrimnewpass = sha1(md5(GetSQLValueString($_POST['confrimnewpass'],"def")));

        if($newpass === $cconfrimnewpass){
            $update_user = array(
                "password"=> $newpass,
                "email_verified_code" => null
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
                "message"=> "رمز عبور و تکرار آن باید یکسان باشند!"

            );
        }

    } else {
        $REST->responseArray = array(
            "status" => 403,
            "type"=> "danger",
            "message"=> "امکان بازیابی رمز عبور با این لینک امکان پذیر نمی باشد، مجدد درخواست بازیابی پسورد ارسال نمایید"
        );
    }
} else{
    $REST->responseArray = array(
        "status" => 406,
        "type"=> "danger",
        "message"=> "اطلاعات وارد شده صحیح نمی باشد"

    );
}


echo $REST->RseponseToC();

