<?php
/**
 * Created by p30web.org
 * User: a.ahmadi
 * Date: 12/7/2019
 * Time: 8:48 PM
 */

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
isset($Data['email'])
) {
    $email = GetSQLValueString($_POST['email'], 'def');
    $db->where("email", $email);
    $cols = array(
        "id",
        "firstname",
        "lastname",
        "email",
        "img",
        "status",
        "two_step"
    );
    $user_det = $db->getOne("members", $cols);


    if ($db->count > 0) {
        $email_verified_code = uniqid(mt_rand(10, 99));
        $update_array = array(
            "email_verified_code" => $email_verified_code
        );
        $db->where("id", $user_det['id']);

        if ($db->update("members", $update_array)) {
            //	activity_log($user_det['id'], $_SERVER['REQUEST_URI'],2, "members", "ورود دو مرحله ای ، ارسال کد تایید");


            $to = $user_det['email'];
            $subject = 'ایمیل بازیابی پسورد';
            $from = 'noreply@irandogebank.com';

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

            // Create email headers
            $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Compose a simple HTML email message
            $message = '<!DOCTYPE html><html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <style type="text/css">
    div, p, a, li, td {
    -webkit-text-size-adjust:none;
    }
    body {
    margin:0;
    padding:0;
    }
    @media screen and (max-width: 480px) {
    table[class="tmp--container"] {
    width:360px !important;
    }
    table[class="tmp--container-padding"] {
    width:360px !important;
    padding:20px !important;
    }
    table[class="tmp--container-padding-top"] {
    width:360px !important;
    padding:20px 0 0 0 !important;
    }
    table[class="tmp--container-padding-bottom"] {
    width:360px !important;
    padding:0 0 20px 0 !important;
    }
    table[class="hero"] {
    width:100% !important;
    }
    table[class="tmp--full-width"] {
    width:100% !important;
    float:left !important;
    padding:0 !important;
    }
    td[class="tmp--full-width"] {
    width:100% !important;
    float:left !important;
    padding:0 !important;
    }
    td[class="tmp--full-width-padding-bottom"] {
    width:100% !important;
    float:left !important;
    padding:0 0 25px 0 !important;
    }
    td[class="tmp--full-width-center"] {
    width:100% !important;
    float:left !important;
    padding:10px 0 10px 0 !important;
    text-align:center !important;
    }
    table[class="wrapper-padding"] {
    padding:20px !important;
    }
    tr[class="wrapper-padding"] {
    padding:20px !important;
    }
    td[class="wrapper-padding"] {
    padding:20px !important;
    }
    td[class="col-padding-bottom"] {
    padding:0 0 25px 0 !important;
    }
    img[class="photo"] {
    width:100% !important;
    height:auto !important;
    }
    td[class="row"]{
    width:100% !important;
    }
    td[class="tmp--hide"] {
    display:none !important;
    }
    }
    </style>
    <title></title>
</head>

<!-- background color -->
<body bgcolor="#F3F3F4">

    <!-- background color -->
    <table bgcolor="#F3F3F4" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <!-- preheader -->
                <table align=\'center\' border=\'0\' cellpadding=\'0\' cellspacing=\'0\' class=\'tmp--container\' width=\'600\'>
                    <tr>
                        <td align=\'center\' class=\'full-width-center\' style=\'color:#4f4f4f;background-color:#ffffff;font-family:Arial, sans-serif;font-size:11px;font-style:normal;font-weight:normal;padding:10px 20px 10px 20px; padding:10px 20px 10px 20px;\'
                        width=\'100%\'>Irandogebank.com</td>
                    </tr>
                </table>
              <!-- end preheader -->
            </td>
        </tr>
        <tr>
            <td>
                <!-- header -->
                <table align=\'center\' border=\'0\' cellpadding=\'0\' cellspacing=\'0\' class=\'tmp--container\' style=\'background-color:#ffffff;\' width=\'600\'>
                    <tr>
                        <td style=\'padding:10px 20px 10px 20px;\' width=\'100%\'>
                            <center>
                                <img src="http://irandogebank.com/Attachment/img/settings/logo1565647848.png">
                            </center>
                        </td>
                    </tr>
                </table>
              <!-- header -->
            </td>
        </tr>
        <tr>
            <td>
                <!-- content area: hero image -->

                <!-- end content area: hero image -->

                <!-- content area: primary headline and text -->
                <table align=\'center\' border=\'0\' cellpadding=\'0\' cellspacing=\'0\' class=\'tmp--container\' style=\'background-color:#ffffff;\' width=\'600\'>
                    <tr>
                        <td align=\'left\' style=\'color:#4f4f4f;font-family:Arial,sans-serif;font-size:16px;font-style:normal;font-weight:normal;line-height:20px;padding:20px;text-align:center;vertical-align:top;\' width=\'100%\'>
                            <span style=\'color:#4f4f4f;display:inline-block;font-family:Arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;padding:5px 0 10px 0;\'>
                            برای بازیابی رمز عبور خود از لینک زیر استفاده کنید 
                            </span><br>
                            لینک بازیابی رمز عبور :
                            <!-- ============================== -->
                            <!-- button -->
                            <!-- ============================== -->
                            <table align=\'center\' class=\'full-width\' width=\'100%\'>
                                <tr>
                                    <td align=\'center\' style=
                                    \'padding:20px 0 10px 0;\'>
                                        <a href="https://irandogebank.com/user/login.php?action=resetpass&verfycode='. $email_verified_code .'">برای بازیابی رمز عبور خود اینجا کلیک کنید</a>
                                    </td>
                                </tr>
                            </table>
                          <!-- end button -->
                        </td>
                    </tr>
                </table>
                <!-- end content area: primary headline and text -->

                <!-- content area: two column wrapper -->

              <!-- end content area: wrapper for columns -->
            </td>
        </tr>

    </table>
  <!-- end global email wrapper -->
</body>
</html>';

            // Sending email
            if (mail($to, $subject, $message, $headers)) {
                $REST->responseArray = array(
                    "status" => 200,
                    "two_step" => 'on',
                    "type" => 'warning',
                    "message" => "ایمیل ریست رمز عبور برای شما ارسال شده است. لطفا صبر کنید...",
                    "data" => array(
                        "email" => $user_det['email'],
                        "image" => $user_det['img'],
                    )
                );
            } else {
                $REST->responseArray = array(
                    "status" => 500,
                    "type" => "danger",
                    "message" => "خطایی در سرور رخ داده است"

                );
            }

        }

        else{
            $REST->responseArray = array(
                "status" => 500,
                "type"=> "danger",
                "message"=> "خطایی در سرور رخ داده است"

            );
        }
    }
    else{
        $REST->responseArray = array(
            "status" => 404, "msg" => \lib\classes\RestService::$codes['404'],
            "message" => "اطلاعات کاربری اشتباه است.",

        );
    }

}

else {
    $REST->responseArray = array(
        "status" => 406, "msg" => \lib\classes\RestService::$codes['406'],
        "message" => "درخواست شما نامعتبر است",

    );
}
echo $REST->RseponseToC();