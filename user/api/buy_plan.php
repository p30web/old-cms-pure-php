<?php
include("../checklogin.php");

require_once('../includes/classes/restful/RestService.php');
require_once ("../lib/file/activity_log.php");

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



if (
    $_SESSION['member_id'] &&
    $_GET['pid']
) {

    $pid = GetSQLValueString($_GET['pid'],"int");

    if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
        $uid = $fetch_admin[0]['admin_id'];
    }else{
        $uid = $_SESSION['member_id'];
    }

    $db->where("id", $uid);
    $db->where("status", "1");
    $fetch_mem = $db->getOne("members", ["id", "wallet", "active", "cash"]);
    $member_row_count = $db->count;

    $db->where("id", $pid);
    $db->where("status", "1");
    $fetch_plan = $db->getOne("investment_plan");
    $plan_row_count = $db->count;

    if(
        $member_row_count > 0 &&
        $plan_row_count > 0
    ){

        if($fetch_mem['cash'] >= $fetch_plan['price']){
            $tnow = time();
            $tleft = mktime(24,0,0) - $tnow;

            $daily_profit=0;
            $d = $fetch_plan['price'] * ($fetch_plan['interest_rate'] / 100);
            if ($fetch_plan['period_type'] === "month") {
                $daily_profit = number_format((float)$d / 30, 4, '.', '');
            } else if ( $fetch_plan['period_type'] === "3month") {
                $daily_profit = number_format((float)$d / 30, 4, '.', '');

            }else if ( $fetch_plan['period_type'] === "6month") {
                $daily_profit = number_format((float)$d / 30, 4, '.', '');
            }

            else if ( $fetch_plan['period_type'] === "yearly") {
                $daily_profit = number_format((float)$d / 30, 4, '.', '');
            }


            else if ($fetch_plan['period_type'] === "day") {
                $daily_profit = number_format((float)$d, 4, '.', '');
            }


            $insert_active_plan = array(
                "plan_id"=> $pid,
                "title"=> $fetch_plan['title'],
                "member_id"=> $uid,
                "daily_profit"=> $daily_profit,
                "first_day_profit"=> $tleft*$daily_profit/24/60/60,
                "price"=> $fetch_plan['price'],
                "unit_id"=> $fetch_plan['unit_id'],
                "interest_rate"=> $fetch_plan['interest_rate'],
                "period"=> $fetch_plan['period'],
                "period_type"=> $fetch_plan['period_type'],
                "modified_at"=> jdate('Y-m-d H:i:s'),
                "time"=> $tnow,
                "status"=> '1',
            );
            if($db->insert("active_investment_plan", $insert_active_plan)){

                $update_member = array(
                    "cash"=> $fetch_mem['cash'] - $fetch_plan['price']
                );
                $db->where("id", $uid);
                if($db->update("members", $update_member)){
                    activity_log($uid, $_SERVER['REQUEST_URI'],1, "active_investment_plan", "خرید پلن دوج کوین جدید به مبلغ ". $fetch_plan['price']);
                    $REST->responseArray = array(
                        "status" => 200,
                        "type" => "success",
                        "message" => ' پلن '.$fetch_plan['title'].' برای شما فعال شد '
                    );
                }else{
                    $REST->responseArray = array(
                        "status" => 200,
                        "type" => "error",
                        "message" => 'خطایی در سرور رخ داده است!'
                    );
                }
            }else{
                $REST->responseArray = array(
                    "status" => 200,
                    "type" => "error",
                    "message" => 'خطایی در سرور رخ داده است!'
                );
            }


        }else{
            $REST->responseArray = array(
                "status" => 200,
                "type" => "warning",
                "message" => 'موجودی حساب کافی نیست.'
            );
        }

    }else{
        $REST->responseArray = array(
            "status" => 200,
            "type" => "error",
            "message" => 'غیر مجاز'
        );
    }

}else {
    $REST->responseArray = array(
        "status" => 200,
        "type" => "error",
        "message" => 'غیر مجاز'
    );
}

echo $REST->RseponseToC();