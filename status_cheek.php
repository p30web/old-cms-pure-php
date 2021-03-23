<?php
require_once('includes/class/MysqlDB/MysqliDb.php');
include ("includes/file/jdf.php");
require_once('Connections/cn.php');
require_once('Connections/cn2.php');

if(!isset($_POST['PAYMENT_ID'])){
    exit();
}

$string=
    $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
    $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
    $_POST['PAYMENT_BATCH_NUM'].':'.
    $_POST['PAYER_ACCOUNT'].':'.strtoupper(md5("ARd66Du29s6raEuAWBbNrBMGf")).':'.
    $_POST['TIMESTAMPGMT'];

$hash=strtoupper(md5($string));

if($hash==$_POST['V2_HASH']){ // processing payment if only hash is valid

    $orderID = rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9);

    $trans_id = "PW" . $orderID . "OR" . rand(1,9);

    $db->where("order_id", $_POST['PAYMENT_ID']);

    $fetch_Pay = $db->getOne("payment_log");

    if ($db->count > 0) {
        $payment_log = array(
            "amount"=> $fetch_Pay['amount'],
            "order_id"=> $_POST['PAYMENT_ID'],
            "member_id"=> $fetch_Pay['member_id'],
            "trans_id"=> $trans_id,
            "created_at"=> jdate('Y-m-d H:i:s'),
            "description"=> "تایید پرداخت",
            "response" => json_encode($_POST),
        );

        $db->insert("payment_log" , $payment_log);

        $insert_transaction = array(
            "destination_wallet"=> "0",
            "description"=> 'افزایش موجودی کیف پول دلاری',
            "member_id"=> $fetch_Pay['member_id'],
            "invoice_type"=> 1,
            "created_at"=> jdate('Y-m-d H:i:s'),
            "modified_at"=> jdate('Y-m-d H:i:s'),
            "status"=> '1',
            "time"=> time(),
            "pay_code"=> $orderID,
            "trans_id"=> $trans_id,
            "amount"=> $fetch_Pay['amount'],
            "price"=> $fetch_Pay['amount'],
            "payment_method" => "perfectmoney"
        );
        
        $db->insert("block_transaction" , $insert_transaction);

        $db->where("id", $fetch_Pay['member_id']);

        $fetch_mem = $db->getOne("members");

        $update_member = array(
            "dollar_credit" => $fetch_mem['dollar_credit'] + $fetch_Pay['amount'],
        );

        $db->where("id", $fetch_mem['id']);

        $db->update("members", $update_member);
    }

}else{ // you can also save invalid payments for debug purposes

    file_put_contents("test.txt", 'Hash mismatch: '.$_POST['V2_HASH'].' vs. '.$hash. PHP_EOL, FILE_APPEND);

}