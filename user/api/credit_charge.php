<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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
    "AllowMethods" => array("POST"),
    "AllowHeaders" => array("Content-Type, charset"),
    "ContentType" => "application/json"
);
$REST->Authorization = false;
$REST->method = array("POST");
$Data = $REST->Processing();

$token = GetSQLValueString($_POST['token'],"def");
$taxid = GetSQLValueString($_POST['taxid'],"def");
$amountTxID = GetSQLValueString($_POST['amount'],"def");


if(!isset($taxid)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => ' خطای 11 : مقدار taxid به درستی ارسال نشده است.'
    );
    echo $REST->RseponseToC();
    exit();
}

if(empty($taxid)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => 'خطای 12 : مقدار taxid خالی می باشد.'
    );
    echo $REST->RseponseToC();
    exit();
}


if(!isset($token)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => ' خطای 13 : مقدار کلید امنیتی به درستی ارسال نشده است.'
    );
    echo $REST->RseponseToC();
    exit();
}

if(empty($token)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => 'خطای 14 : مقدار کلید امنیتی خالی می باشد.'
    );
    echo $REST->RseponseToC();
    exit();
}

if(is_numeric($taxid)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => 'خطای 16 : نوع داده taxid صحیح نمی باشد'
    );
    echo $REST->RseponseToC();
    exit();
}


if(!isset($amountTxID)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => ' خطای 17 : مقدار taxid به درستی ارسال نشده است.'
    );
    echo $REST->RseponseToC();
    exit();
}

if(empty($amountTxID)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => 'خطای 18 : مقدار taxid خالی می باشد.'
    );
    echo $REST->RseponseToC();
    exit();
}

$db->where("token", $token);
$p30web_credit = $db->getOne("p30web_credit");

if(!$db->count > 0){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'خطای 15 : مقدار کلید امنیتی معتبر نمی باشد می باشد.'
    );
    echo $REST->RseponseToC();
    exit();
}

if($p30web_credit['final_price'] != $amountTxID){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'خطای 19 : شما مطابق مبلغ اعلامی واریز را انجام نداده اید ، پس امکان ثبت texid شما وجود ندارد ، با پشتیبانی تماس بگیرید.'
    );
    echo $REST->RseponseToC();
    exit();
}


$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("id", $_SESSION['member_id']);
}

$fetch_mem = $db->getOne("members");

if(!$db->count > 0){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'خطای 16 : امکان ثبت پرداخت برای حساب کاربری شما وجود ندارد.'
    );
    echo $REST->RseponseToC();
    exit();
}

$db->where("trans_id", $taxid);
$fetch_transaction = $db->getOne("block_transaction");

if($db->count > 0){

    $html_data = '<table class="table table-striped" id="transdetails">
  <thead>
    <tr>
      <th scope="col">کد تراکنش</th>
      <th scope="col">تاریخ ثبت</th>
      <th scope="col">مبلغ</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">'.$fetch_transaction['trans_id'].'</th>
      <td>'.$fetch_transaction['created_at'].'</td>
      <td>'.$fetch_transaction['amount'].'</td>
    </tr>
  </tbody>
</table>';
    $REST->responseArray = array(
        "status" => 200,
        "type" => "info",
        "action"=>"show_details",
        "data"=> $html_data,
        "message" => 'تراکنش شما قبلا ثبت شده است، لطفا صبر کنید...'

    );
    echo $REST->RseponseToC();
    exit();
}

$db->where("member_id", $fetch_mem['id']);
$db->where("taxid", $taxid);
$fetch_payment_vrify = $db->getOne("payment_vrify");

//var_dump($fetch_wallets['api_token']);

if(!is_null($fetch_payment_vrify) && time() <= $fetch_payment_vrify["time"] + 180){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => 'لطفا ' . (($fetch_payment_vrify["time"] + 180) - time()) . " ثانیه صببر نمایید و مجدد درخواست دهید. "
    );
    echo $REST->RseponseToC();
    exit();
}

$db->where("member_id", $fetch_mem['id']);
$transaction_request = $db->getOne("transaction_request");

$RequestDate = date('ymd',$transaction_request['time']);
$Today = date('ymd');

if(!is_null($transaction_request) && $RequestDate != $Today){
    $Update_transaction_request = array(
        "confirmations" => 0,
        "time" => time(),
    );

    if(!$db->update("transaction_request" , $Update_transaction_request)){
        $REST->responseArray = array(
            "status" => 200,
            "type" => "warning",
            "message" => 'خطایی رخ داده است، چند دقیقه دیگر مجدد تلاش کنید'
        );
        echo $REST->RseponseToC();
        exit();
    };

    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'خطای 1902 : به دلیل درخواست بیش از حد مجاز روزانه حساب کاربری شما تا 24 ساعت آینده امکان ثبت Taxid را نخواهد داشت ، بعد از 24 ساعت مجدد میتوانید درخواست دهید '
    );

    echo $REST->RseponseToC();
    exit();
}

if(is_null($transaction_request) || $transaction_request['confirmations'] <= 6 ){

    $db->where("member_id", $fetch_mem['id']);
    $transaction_request = $db->getOne("transaction_request");

    if(is_null($transaction_request)){
        $insert_transaction_request = array(
            "member_id"=> $fetch_mem['id'],
            "time"=> time(),
            "confirmations" => 1,
        );
        if(!$db->insert("transaction_request" , $insert_transaction_request)){
            $REST->responseArray = array(
                "status" => 200,
                "type" => "warning",
                "message" => 'خطایی رخ داده است، چند دقیقه دیگر مجدد تلاش کنید'
            );
            echo $REST->RseponseToC();
            exit();
        };
    }else{
        $Update_transaction_request = array(
            "confirmations" => $transaction_request['confirmations'] + 1,
        );

        if(!$db->update("transaction_request" , $Update_transaction_request)){
            $REST->responseArray = array(
                "status" => 200,
                "type" => "warning",
                "message" => 'خطایی رخ داده است، چند دقیقه دیگر مجدد تلاش کنید'
            );
        };

    }
} else {
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'خطای 1902 : به دلیل درخواست بیش از حد مجاز روزانه حساب کاربری شما تا 24 ساعت آینده امکان ثبت Taxid را نخواهد داشت ، بعد از 24 ساعت مجدد میتوانید درخواست دهید '
    );
    
    echo $REST->RseponseToC();
    exit();
}


$db->where("txid", $taxid);
$get_pending_transaction = $db->getOne("pending_transaction");

if(is_null($get_pending_transaction)) {
    $insert_pending_transaction = array(
        "member_id"=> $fetch_mem['id'],
        "time"=> time(),
        "txid" => $taxid,
        "token" => $token,
        "amount_txid" => $amountTxID,
        "final_amount" => $p30web_credit['final_price'],
        "user_wallet" => $fetch_mem['wallet'],
        "status" => 0,
    );
    if(!$db->insert("pending_transaction" , $insert_pending_transaction)){
        $REST->responseArray = array(
            "status" => 200,
            "type" => "warning",
            "message" => 'خطایی رخ داده است، چند دقیقه دیگر مجدد تلاش کنید'
        );
        echo $REST->RseponseToC();
        exit();
    }else{
        $REST->responseArray = array(
            "status" => 200,
            "type" => "success",
            "message" => 'درخواست شما ثبت شد و طی 1 ساعت آینده پرداخت شما به صورت اتوماتیک پردازش می شود و اعتبار شما افزایش پیدا خواهد کرد'
        );
        echo $REST->RseponseToC();
        exit();
    }
}else{
    $REST->responseArray = array(
        "status" => 200,
        "type" => "warning",
        "message" => 'این txid قبلا ثبت شده است و امکان ثبت مجدد آن وجود ندارد.'
    );
    echo $REST->RseponseToC();
    exit();
}
