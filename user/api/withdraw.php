<?php
include("../checklogin.php");

//include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
//require_once('../includes/classes/mysql/MysqliDb.php');
//require_once('../Connections/cn.php');
//require_once('../includes/file/jdf.php');
//require_once('../includes/file/function.php');
//date_default_timezone_set('Asian/Tehran');
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

if (
	$_GET['withdrawal_amount']
) {

	$db->where("code", "estimate_fee");
	$estimate_fee = $db->getOne("settings_param", "value");

	$amount = GetSQLValueString($_GET['withdrawal_amount'], "def");
	$fee = 0;
	//	if ($amount >= 5000){
	//		$fee = ($amount / 100) * 0.2;
	//	}  else{
	//		$fee = $estimate_fee['value'];
	//	}

	$fee = $amount * 0.005;

	$total_amount = $amount+$fee ;
	if($amount != 0 || $amount != null ){
		$db->where("id", $_SESSION['member_id']);
		$fetch_mem = $db->getOne("members", ["id", "wallet", "active", "cash"]);
//		if($fetch_mem['active'] === 1){
			if($fetch_mem['wallet'] != null){
				;
				if($fetch_mem['cash'] > $total_amount){
					if($total_amount >= 50){
						$db->where("status", 0);
						$db->where("member_id", $fetch_mem['id']);
						$db->get("withdraw", null, "id");

						if($db->count === 0){
							$insert_array = array(
								"amount"=> $total_amount,
								"wallet"=> $fetch_mem['wallet'],
								"member_id"=> $fetch_mem['id'],
								"created_at"=> jdate('Y-m-d H:i:s'),
								"updated_at"=> jdate('Y-m-d H:i:s'),
								"status"=> 0,
								"member_fee"=> $fee,
							);
							if($db->insert("withdraw", $insert_array)){

								$user_update= array(
									"cash"=> $fetch_mem['cash'] - $total_amount
								);
								$db->where("id", $fetch_mem['id']);
								if($db->update("members", $user_update)){
									activity_log($fetch_mem['id'], $_SERVER['REQUEST_URI'],12, "withdraw,members", "درخواست برداشت وجه");
									$REST->responseArray = array(
										"status" => 200,
										"type" => "success",
										"message" => 'درخواست شما با موفقیت ثبت شد.'

									);
								}
							}
						}else{
							$REST->responseArray = array(
								"status" => 200,
								"type" => "danger",
								"message" => 'شما یک درخواست در صف پرداخت دارید و قادر به ثبت درخواست مجدد نیستید!'

							);
						}
					}else{
						$REST->responseArray = array(
							"status" => 200,
							"type" => "danger",
							"message" => 'حداقل درخواست برداشت 50 دوج می باشد'

						);
					}
				}else{
					$REST->responseArray = array(
						"status" => 200,
						"type" => "danger",
						"message" => 'موجودی برای برداشت کافی نیست!'

					);
				}
			}else{
				$REST->responseArray = array(
					"status" => 200,
					"type" => "danger",
					"message" => 'کیف پول ثبت نشده'

				);
			}
//		}else{
//			$REST->responseArray = array(
//				"status" => 200,
//				"type" => "warning",
//				"message" => 'حساب خود را تایید کنید'
//
//			);
//		}
	}
	else{
		$REST->responseArray = array(
			"status" => 200,
			"type" => "danger",
			"message" => 'مبلغ غیر مجاز'

		);
	}


} else {
	$REST->responseArray = array(
		"status" => 200,
		"type" => "danger",
		"message" => 'عیر مجاز'

	);
}

echo $REST->RseponseToC();
