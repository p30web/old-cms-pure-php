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
    isset($Data['activation_code']) &&
    isset($Data['email']) &&
    //isset($Data['ac-recaptcha-response']) &&
    $Data['action'] === "two_step"
) {
    $curl = curl_init();
    $recaptchaCToken = GetSQLValueString($_POST['ac-recaptcha-response'], 'def');
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "secret=6LfEgMYUAAAAAC_9TA-U9OtuQs5GFK9JGLAKOrnp&response=" . $recaptchaCToken . "&remoteip=" . $_SERVER['REMOTE_ADDR'],
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
        ),
    ));

    $response = curl_exec($curl);
    //$err = curl_error($curl);

    $err = 0;

    curl_close($curl);

    if ($err) {
        $REST->responseArray = array(
            "status" => 500, "msg" => \lib\classes\RestService::$codes['500'],
            "message" => "خطا در ارسال اطلاعات",

        );
    } else {

        //$rec_res = json_decode($response, true);
        $rec_res['success'] = true;
        $rec_res['hostname'] = "irandogebank.com";
        $rec_res['action'] = "login";

        if (
            $rec_res['success'] === true &&
            $rec_res['hostname'] === "irandogebank.com"&&
            $rec_res['action'] === "login"
        ) {

            $email = GetSQLValueString($_POST['email'], 'def');
            $activation_code = GetSQLValueString($_POST['activation_code'], 'def');

            $db->where("email", $email);
            $db->where("activation_code", $activation_code);
            $cols = array(
                "id",
                "firstname",
                "lastname",
                "email",
                "status",
                "two_step"
            );
            $user_det = $db->getOne("members", $cols);
            $token = random_token();
            if ($db->count > 0) {

                if ($user_det['status'] === '1') {
                    $update_array = array(
                        "last_login" => jdate('Y-m-d H:i:s'),
                        "last_ip" => $_SERVER['REMOTE_ADDR'],
                        "token" => $token,
                    );
                    $db->where("id", $user_det['id']);
                    if ($db->update("members", $update_array)) {
                        activity_log($user_det['id'], $_SERVER['REQUEST_URI'], 2, "members", "ورو دو مرحله ای موفق");


                        // set cookies
                        setcookie("membertoken", $token, time() + (86400 * 1), "/"); // 86400 = 1 day

                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                        // Create email headers
                        $headers .= 'From: '.'noreply@irandogebank.com'."\r\n".
                            'Reply-To: '.'noreply@irandogebank.com'."\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                        mail($user_det['email'],'گزارش ورود به حساب کاربری شما در ایران دوج', "ورود به حساب کاربری شما با ای پی : " . $_SERVER['REMOTE_ADDR'] . " صورت گرفته است، اگر این ورود توسط شما نبوده است حتما در اسرع وقت با مدیریت تماس حاصل فرمایید.", $headers);


                        $user_det['token'] = $token;
                        $REST->responseArray = array(
                            "status" => 200,
                            "message" => "ورود موفق. منتظر بمانید...",
                            "type" => 'success',
                            "data" => $user_det,
                        );
                    } else {
                        $REST->responseArray = array(
                            "status" => 500, "msg" => \lib\classes\RestService::$codes['500'],
                            "message" => "درخواست با خطا مواجه شد!",

                        );
                    }
                } else {
                    $REST->responseArray = array(
                        "status" => -1,
                        "message" => "حساب کاربری شما مسدود میباشد!",

                    );
                }
            } else {
                $REST->responseArray = array(
                    "status" => 404, "msg" => \lib\classes\RestService::$codes['404'],
                    "message" => "اطلاعات کاربری اشتباه است.",

                );
            }

        } else {
            $REST->responseArray = array(
                "status" => 403, "msg" => \lib\classes\RestService::$codes['403'],
                "message" => "ورود غیر مجاز",

            );
        }
    }

} else {
    $REST->responseArray = array(
        "status" => 406, "msg" => \lib\classes\RestService::$codes['406'],
        "message" => "درخواست شما نامعتبر است",

    );
}
echo $REST->RseponseToC();
