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
    $_GET['hash']
    ) {

        $id = decrypt($_GET['hash'], $fetch_members['password']);

        $UserID = $fetch_members['id'];

        $UnicCode = "ir" . $UserID . date("y") . rand(1,9) . date("d") . rand(1,9);

        $db->where("member_id", $id);
        $db->where("status", '0');
        if($db->count < 3){
            $fetch_req = $db->get("change_wallet_request", null);
            $insert_wallet_req = array(
                "member_id"=> $id,
                "url"=> 'https://www.irandogebank.com/user/change_wallet.php?vrifycode='. md5($UnicCode),
                "status"=> '0',
                'wallet_type' => 'dollar',
                "requestcode" => md5($UnicCode),
                "old_wallet" => $fetch_members['wallet'],
            );

            if($db->insert("change_wallet_request", $insert_wallet_req)){
                activity_log($fetch_members['id'], $_SERVER['REQUEST_URI'],1, "change_wallet_request", "درخواست تغییر کیف پول دلاری");

                $to = $fetch_members['email'];
                $subject = 'درخواست تغییر کیف پول | ایران دوج';
                $from = 'noreply@irandogebank.com';

                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Create email headers
                $headers .= 'From: '.$from."\r\n".
                    'Reply-To: '.$from."\r\n" .
                    'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message
                $message = '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"  content="text/html charset=UTF-8" />
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
                            تفییر کیف پول</span><br>
                            برای تغییر کیف پول خود روی لینک زیر کلیک کنید
                            <!-- ============================== -->
                            <!-- button -->
                            <!-- ============================== -->
                            <table align=\'center\' class=\'full-width\' width=\'100%\'>
                                <tr>
                                    <td align=\'center\' style=
                                    \'padding:20px 0 10px 0;\'>
                                        <a href="'.$insert_wallet_req['url'].'" style=\'border-radius:25px;background-color:#52aef4;border-top:12px solid #52aef4;border-bottom:12px solid #52aef4;border-right:18px solid #52aef4;border-left:18px solid #52aef4;color:#ffffff;display:inline-block;font-family:Arial, sans-serif;font-size:16px;font-style:normal;font-weight:normal;line-height:16px;text-align:center;text-decoration:none;\'
                                        target=\'_blank\'>تغییر کیف پول</a>
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
                if(mail($to, $subject, $message, $headers)){
                    $REST->responseArray = array(
                        "status" => 200,
                        "type"=> "success",
                        "message"=> "درخواست شما ثبت شد، یک ایمیل حاوی لینک تغییر کیف پول برای شما فرستاده میشود."

                    );
                } else{
                    $REST->responseArray = array(
                        "status" => 200,
                        "type"=> "danger",
                        "message"=> "خطایی در سرور رخ داده است"

                    );
                }

            }else {
                $REST->responseArray = array(
                    "status" => 200,
                    "type"=> "danger",
                    "message"=> "خطایی در ثبت درخواست شما به وجود آمده است"

                );
            }

        }else{
            $REST->responseArray = array(
                "status" => 200,
                "type"=> "danger",
                "message"=> "درخواست شما غیر مجاز است"

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
