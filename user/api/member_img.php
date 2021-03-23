<?php
//include("../checklogin.php");

//include("../safeval.php");
require_once('../includes/classes/restful/RestService.php');
require_once ("../lib/file/activity_log.php");
require_once('../includes/classes/upload/class.upload.php');
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

$id = decrypt($Data['id'], "dgf");
$db->where("id", $id);
$fetch_members = $db->getOne("members");


if ($db->count > 0) {

	if ($_FILES['image']) {
		$imguploaded = 0;

		$imgName = 'avatar' . time();
		$handle = new upload($_FILES['image']);
		if ($handle->uploaded) {
			$handle->file_new_name_body = $imgName;
			$handle->image_resize = true;
			$handle->image_x = 170;
			$handle->image_y = 170;
			$handle->image_ratio_crop = true;
			$handle->jpeg_quality = 200;
			$handle->image_ratio = true;
			$handle->dir_chmod = 0777;
			$handle->file_max_size = '5242880'; // 5mb
			$handle->allowed = array('image/*');
			$handle->image_convert = 'jpg';
			$handle->process('../../Attachment/img/members/');
			if ($handle->processed) {
				//            $handle->clean();
				$imguploaded = 1;
				//image upload
				$handle2 = new upload($handle->file_dst_pathname);
				if ($handle2->uploaded) {
					$handle2->file_new_name_body = $imgName;
					$handle2->image_resize = true;
					$handle2->image_x = 50;
					$handle2->image_y = 50;
					$handle2->image_ratio_crop = true;
					$handle2->jpeg_quality = 200;
					$handle2->image_ratio = true;
					$handle2->dir_chmod = 0777;
					$handle2->file_max_size = '5242880'; // 5mb
					$handle2->allowed = array('image/*');
					$handle2->image_convert = 'jpg';
					$handle2->process('../../Attachment/img/members/thumbs/');
					if ($handle2->processed) {
						//                    $handle2->clean();
						$imguploaded = 2;
					} else {
						echo 'error : ' . $handle2->error;
					}
				}

			} else {
				echo 'error : ' . $handle->error;
			}
		}
		if($imguploaded > 0){
			$img = $imgName . '.jpg';
			$insert_array = array(

				"img" => $img,
				"progress" => ($fetch_members['img'] == null) ? $fetch_members['progress']+10 : $fetch_members['progress']

			);
			$db->where("id", $id);
			if ($db->update("members", $insert_array)) {
				$REST->responseArray = array(
					"status" => 200,
					"type"=> "success",
					"message"=> "آواتار شما بروز رسانی شد!"

				);
			}
		}else{
			$REST->responseArray = array(
				"status" => 200,
				"type"=> "danger",
				"message"=> "خطا در آپلود!"

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
