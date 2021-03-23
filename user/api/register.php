<?php
include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
require_once('../includes/classes/mysql/MysqliDb.php');
require_once('../Connections/cn.php');
require_once('../includes/file/jdf.php');
require_once('../includes/file/function.php');
include("../lib/file/activity_log.php");
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
	isset($Data['firstname']) &&
	isset($Data['lastname']) &&
	isset($Data['password']) &&
	$Data['action'] === "register" &&
	isset($Data['email']) &&
	isset($Data['rpassword'])
) {



			$email = GetSQLValueString($_POST['email'], 'def');
			$firstname = GetSQLValueString($_POST['firstname'], 'def');
			$lastname = GetSQLValueString($_POST['lastname'], 'def');
			$rpassword = sha1(md5(GetSQLValueString($_POST['rpassword'], 'def')));
			$password = sha1(md5(GetSQLValueString($_POST['password'], 'def')));
			$ref= GetSQLValueString($_POST['ref'], 'int');

			if($ref != null || $ref != 0){
				$db->where("id", $ref);
				$parent_det = $db->getOne("members", "id");
			}

			$token = random_token();

			$insert_array = array(
				"firstname" => $firstname,
				"lastname" => $lastname,
				"password" => $password,
				"email" => $email,
				"token" => $token,
				"parent_id" => ($parent_det['id'] != null || $parent_det['id'] != 0) ? $parent_det['id'] : NULL ,
				"cash" => 0,
				"active" => 0,
				"progress" => 20,
				"last_login" => jdate('Y-m-d H:i:s'),
				"modified_at" => jdate('Y-m-d H:i:s'),
				"create_at" => jdate('Y-m-d H:i:s'),
				"last_ip" => $_SERVER['REMOTE_ADDR'],
				"status" => '1',
			);
			//			print_r($insert_array);
			//			die;
			if ($memid = $db->insert("members", $insert_array)) {
				activity_log($memid, $_SERVER['REQUEST_URI'],1, "members", "ساخت حساب کاربری");


				// set cookies
				setcookie("membertoken", $token, time() + (86400 * 1), "/"); // 86400 = 1 day
				$user_det['token'] = $token;

				$REST->responseArray = array(
					"status" => 200,
					"message" => "ثبت نام با موفقیت انجام شد، لطفا منتظر بمانید...",
					"type"=> "success",
					"data" => array(
						"id" => $memid,
						"firstname" => $firstname,
						"lastname" => $lastname,
						"password" => $password,
						"email" => $email,
						"token" => $token,
						"status"=> 1
					)
				);

			} else {
				$REST->responseArray = array(
					"status" => 500,
					"message" => "خطا در عملیات",

				);
			}

} else {
	$REST->responseArray = array(
		"status" => 406,
		"message" => "درخواست شما نامعتبر است",

	);
}
echo $REST->RseponseToC();
