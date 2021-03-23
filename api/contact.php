<?php

//error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);

include("../safeval.php");
require_once('../includes/class/RestService.php');
require_once('../includes/class/MysqlDB/MysqliDb.php');
require_once('../Connections/cn2.php');
require_once('../includes/file/jdf.php');
require_once('../includes/file/function.php');
date_default_timezone_set('Asian/Tehran');

function is_rtl( $string ) {
    $rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
    return preg_match($rtl_chars_pattern, $string);
}

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
    isset($Data['name']) &&
    isset($Data['email']) &&
    isset($Data['subject']) &&
    isset($Data['mobile']) &&
    isset($Data['message'])
) {
    $email = GetSQLValueString($_POST['email'], 'def');
    $name = GetSQLValueString($_POST['name'], 'def');
    $subject = GetSQLValueString($_POST['subject'], 'def');
    $message = GetSQLValueString($_POST['message'], 'def');
    $mobile = GetSQLValueString($_POST['mobile'], 'def');

    if(!is_rtl($subject)){
        $REST->responseArray = array(
            "status" => 200,
            "type" => "danger",
            "message" => "عنوان باید فارسی باشد",
        );
        echo $REST->RseponseToC();
        exit();
    }


    $insert_array = array(
        "sender" => $name,
        "email" => $email,
        "mobile" => $mobile,
        "title" => $subject,
        "text" => $message,
        "read" => '0',
        "status" => '0',
        "created_at" => jdate('Y-m-d H:i:s'),
        "ip" => $_SERVER['REMOTE_ADDR'],
        "portalid" => 0,
    );
    if ($messageid = $db->insert("message", $insert_array)) {

        $tickets_array = array(
            "subject" => $subject,
            "created_at" => jdate('Y/m/d H:i:s'),
            "status_id" => 1,
            "priority" => 1,
            "owner_id" => 0,
            "department_id" => 1,
            "owner_type" => 1,
            "modified_at" => jdate('Y/m/d H:i:s'),
            "owner_email" => $email,
            "owner_ip" => $_SERVER['REMOTE_ADDR'],
        );


        if ($tickets_id = $db->insert("tickets", $tickets_array)) {
            $ticket_message_array = array(
                "ticket_id" => $tickets_id,
                "owner" => 1,
                "seen" => 0,
                "message" => $message,
                "created_at" => jdate('Y/m/d H:i:s'),
                "owner_id" => 0,
                "owner_ip" => $_SERVER['REMOTE_ADDR'],
            );

            if ($ticket_message_id = $db->insert("ticket_message", $ticket_message_array)) {
                $REST->responseArray = array(
                    "status" => 200,
                    "type" => "success",
                    "message"=> "پیام شما ثبت شده است"
                );
            }else {
                $REST->responseArray = array(
                    "status" => 200,
                    "type" => "danger",
                    "message" => "خطا در عملیات",
                );
            }
        }else{
            $REST->responseArray = array(
                "status" => 200,
                "type" => "danger",
                "message" => "خطا در عملیات",
            );
        }

    } else {
        $REST->responseArray = array(
            "status" => 200,
            "type" => "danger",
            "message" => "خطا در عملیات",
        );
    }

} else {
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => "درخواست شما نامعتبر است",
    );
}

echo $REST->RseponseToC();
