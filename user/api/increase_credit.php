<?php
include("../checklogin.php");

require_once('../includes/classes/restful/RestService.php');
require_once ("../lib/file/activity_log.php");

$REST = new \lib\classes\RestService();
$crypto = new \lib\classes\Crypto();


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("id", $_SESSION['member_id']);
}

$fetch_mem = $db->getOne("members", ["id", "wallet", "active", "cash"]);

$Mablagh = test_input($_POST['mablagh']);

if($Mablagh == null || empty($Mablagh)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'مقدار مبلغ نمی تواند خالی باشد'

    );
}

if(!is_numeric ($Mablagh)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'مقدار مبلغ باید عددی باشد'
    );
}

if(!strlen($Mablagh) >= 2 ){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'میزان دوج کوین وارد شده کمتر از حداقل میزان ممکن می باشد'
    );
}


$rand = rand(1,9).rand(1,9).rand(1,9);

$newMablagh = intval($Mablagh).".000".$rand;

$token = "Ir" . $rand . "dfc" . rand(1,100);


$insert_transaction = array(
    "member_id"=> $fetch_mem['id'],
    "base_price" => intval($Mablagh),
    "final_price" => $newMablagh,
    "token" =>$token,
    "created_at"=> time(),
);

if($db->insert("p30web_credit" , $insert_transaction)){
        $REST->responseArray = array(
            "status" => 200,
            "type" => "success",
            "action"=>"show_details",
            "final_mablagh"=> $newMablagh,
            "token"=> $token,
            "message" => 'اطلاعات با موفقیت ثبت شد'
        );
}

else{
        $REST->responseArray = array(
            "status" => 200,
            "type" => "danger",
            "message" => 'خطا در انجام عملیات'
        );
}

echo $REST->RseponseToC();