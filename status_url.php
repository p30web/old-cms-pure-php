<?php
require_once('includes/class/MysqlDB/MysqliDb.php');
include ("includes/file/jdf.php");
require_once('Connections/cn.php');
require_once('Connections/cn2.php');

$string=
    $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
    $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
    $_POST['PAYMENT_BATCH_NUM'].':'.
    $_POST['PAYER_ACCOUNT'].':'.strtoupper(md5("ARd66Du29s6raEuAWBbNrBMGf")).':'.
    $_POST['TIMESTAMPGMT'];

$hash=strtoupper(md5($string));

$orderID = rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9);

$trans_id = "PW" . $orderID . "OR" . rand(1,9);

$payment_log = array(
    "amount"=> 0,
    "order_id"=> 0,
    "member_id"=> 1,
    "trans_id"=> $trans_id,
    "created_at"=> jdate('Y-m-d H:i:s'),
    "description"=> "تایید پرداخت",
    "response" => json_encode($_POST),
);

$db->insert("payment_log" , $payment_log);

file_put_contents("test.txt", print_r($_POST,true). PHP_EOL, FILE_APPEND);

if($hash==$_POST['V2_HASH']){ // processing payment if only hash is valid

    //$order=wc_get_order($_POST['PAYMENT_ID']);
    
    file_put_contents("test.txt", "ok". PHP_EOL, FILE_APPEND);

//    if($order->has_status('completed')){
//        WC_Gateway_Pm::log('Aborting, Order #'.$order->id.' is already complete.');
//        exit;
//    }

//    $this->validate_amount($order, $_POST['PAYMENT_AMOUNT']);
//    $this->validate_account($order, $_POST['PAYEE_ACCOUNT']);

//    $order->add_order_note(__('PM payment completed', 'woocommerce'));
//    $order->payment_complete($_POST['PAYMENT_ID']);

}else{ // you can also save invalid payments for debug purposes
    
    file_put_contents("test.txt", 'Hash mismatch: '.$_POST['V2_HASH'].' vs. '.$hash. PHP_EOL, FILE_APPEND);

}