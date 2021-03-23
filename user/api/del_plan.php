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

$REST->responseArray = array(
    "status" => 200,
    "type" => "error",
    "message" => 'در حال حاظر لغو پلن غیرفعال می باشد.'
);

echo $REST->RseponseToC();

exit();

if (
    $_SESSION['member_id'] &&
    $_GET['pid']
) {
    $pid = GetSQLValueString($_GET['pid'],"int");
    $uid = $_SESSION['member_id'];

    $db->where("id", $uid);
    $db->where("status", "1");
    $fetch_mem = $db->getOne("members");

    $db->where("id", $pid);
    $db->where("status", "1");
    $fetch_plan = $db->getOne("active_investment_plan");
    $plan_row_count = $db->count;

    if(
        $plan_row_count > 0
    ){

        $update_plan = array(
            "status"=> '3'
        );
        $db->where("id", $pid);
        if($db->update("active_investment_plan", $update_plan)){

            // $back = $fetch_plan['price'] * 0.95;

            //var_dump($fetch_plan);
            //exit();

            if(is_null($fetch_plan['type'])){
                //var_dump("ok");
                $back = $fetch_plan['price'] * 0.95;
                $update_member = array(
                    "cash"=> $fetch_mem['cash'] + $back
                );
            }

            if(!is_null($fetch_plan['type']) && $fetch_plan['type']== "dollar"){
                //var_dump("ok3");
                $back = $fetch_plan['price'] - 5;
                $update_member = array(
                    "dollar_credit"=> $fetch_mem['dollar_credit'] + $back
                );
            }

            //  var_dump(!is_null($fetch_plan['type']));

            // echo "<br>";

            // var_dump($fetch_plan['type']== "dollar");

            // echo "<br>";

            // var_dump($fetch_plan['type']);

            //print_r($update_member);
//exit();

            $db->where("id", $uid);
            if($db->update("members", $update_member)){
                activity_log($uid, $_SERVER['REQUEST_URI'],1, "active_investment_plan", "لغو پلن به مبلغ ". $fetch_plan['price']);
                $REST->responseArray = array(
                    "status" => 200,
                    "type" => "success",
                    "message" => ' پلن '.$fetch_plan['title'].' برای شما لغو شد '
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

