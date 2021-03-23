<?php
include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
require_once('../includes/classes/mysql/MysqliDb.php');
require_once('../Connections/cn.php');
require_once('../includes/file/jdf.php');
require_once('../includes/file/function.php');
require_once('../includes/file/activity_log.php');
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
    isset($Data['email']) &&
    isset($Data['password'])
) {
    $email = GetSQLValueString($_POST['email'], 'def');
    $password = sha1(md5(GetSQLValueString($_POST['password'], 'def')));

    $db->where("email", $email);
    $db->where("pass", $password);
    $db->where("status", 1);
    $cols = array(
        "id",
        "name",
        "email",
    );
    $user_det = $db->getOne("users", $cols);
    $token = random_token();
    if ($db->count > 0) {

        $update_array = array(
            "lastlogin"=>jdate('Y-m-d H:i:s'),
            "lastip"=>$_SERVER['REMOTE_ADDR'],
            "token"=>$token,
        );
        $db->where("id", $user_det['id']);
        if($db->update("users", $update_array)){


            // set cookies
            setcookie("token", $token, time() + (86400 * 1), "/"); // 86400 = 1 day

            $user_det['token']=$token;
            $REST->responseArray = array(
                "status" => 200, "msg" => \lib\classes\RestService::$codes['200'],
                "data" => $user_det,
            );
            activity_log($user_det['id'], $_SERVER['REQUEST_URI'],1, "login_admin", "ورود موفق به پنل مدیریت");
        }
        else{
            $REST->responseArray = array(
                "status" => 500, "msg" => \lib\classes\RestService::$codes['500'],
                "message" => "درخواست با خطا مواجه شد!",

            );
            activity_log(0, $_SERVER['REQUEST_URI'],1, "login_admin", "ورود ناموفق به پنل مدیریت");
        }
    } else {
        $REST->responseArray = array(
            "status" => 404, "msg" => \lib\classes\RestService::$codes['404'],
            "message" => "اطلاعات کاربری اشتباه است.",

        );
        activity_log(0, $_SERVER['REQUEST_URI'],1, "login_admin", "ورود ناموفق به پنل مدیریت");
    }
} else {
    $REST->responseArray = array(
        "status" => 406, "msg" => \lib\classes\RestService::$codes['406'],
        "message" => "درخواست شما نامعتبر است",

    );
    activity_log(0, $_SERVER['REQUEST_URI'],1, "login_admin", "ورود ناموفق به پنل مدیریت");
}
echo $REST->RseponseToC();
