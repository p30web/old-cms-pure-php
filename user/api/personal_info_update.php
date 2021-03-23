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
		$_GET['firstname'] &&
		$_GET['lastname']
	) {

		$firstname = ($_GET['firstname'] != null) ? GetSQLValueString($_GET['firstname'],"def") : $fetch_members['firstname'];
		$lastname = ($_GET['lastname'] != null) ? GetSQLValueString($_GET['lastname'],"def") : $fetch_members['lastname'];
		$cellphone = ($_GET['cellphone'] != null) ? GetSQLValueString($_GET['cellphone'],"def") : $fetch_members['cellphone'];
		$gender = ($_GET['gender'] != null) ? GetSQLValueString($_GET['gender'],"def") : $fetch_members['gender'];

		$update_user = array(
			"firstname"=> $firstname,
			"lastname"=> $lastname,
			"cellphone"=> $cellphone,
			"gender"=> $gender,
			"progress" => ($fetch_members['gender'] == null) ? $fetch_members['progress']+60 : $fetch_members['progress']
		);

		$db->where("id", $fetch_members['id']);
		if($db->update("members", $update_user)){
			activity_log($fetch_members['id'], $_SERVER['REQUEST_URI'],2, "members", "بروز رسانی اطلاعات شخصی");
			$REST->responseArray = array(
				"status" => 200,
				"type"=> "success",
				"message"=> "اطلاعات با موفقیت به روز رسانی شد!"

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
