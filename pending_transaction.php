<?php

/**
 * Update by P30web.org
 * User: a.ahmadi
 * Date: 12/10/2019
 * Time: 10:04 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('/home/irandogebank/public_html/includes/class/MysqlDB/MysqliDb.php');
require_once('/home/irandogebank/public_html/Connections/cn2.php');
require_once('/home/irandogebank/public_html/includes/file/function.php');
require_once ("/home/irandogebank/public_html/user/lib/file/activity_log.php");

date_default_timezone_set('Asian/Tehran');

$db->where("id", 1);
$get_txid_api = $db->getOne('txid_api');

$RequestDate = date('ymd',$get_txid_api['time']);
$Today = date('ymd');

if($RequestDate != $Today){
    $Update_txid_api = array(
        "time" => time(),
        "last_update_time" => time(),
        "count_request" => 1
    );
    $db->update("txid_api" , $Update_txid_api);
}else{
    if($get_txid_api['count_request'] >= $get_txid_api['api_max_request']){
        echo "تعداد درخواست روازنه به اتمام رسیده است ما بقی درخواست ها 24 ساعت آینده انجام خواهد شد.";
        exit();
    }
}


$db->where("status", 0);
$get_pending_transaction = $db->get('pending_transaction');


if ($db->count > 0) {

    foreach ($get_pending_transaction as $transaction){


        $RequireTime = $transaction['time'] + (30 * 60);
        $CurentTime = time();

        //var_dump($RequireTime);
        //var_dump($CurentTime);

//        var_dump($CurentTime > $RequireTime);

        // تایم فعلی با زمان ثبت درخواست بررسی می شود که باید بیش از 30 دقیقه باشه

        if($CurentTime > $RequireTime){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.blockcypher.com/v1/doge/main/txs/" . $transaction['txid'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $get_transaction_from_block = $response;
            $get_transaction_from_block = json_decode($get_transaction_from_block , true);

            // بررسی می کنیم ببینیم ایا خطا داشته درخواست مون

            if (!$err) {
                $db->where("id", 1);
                $get_txid_api = $db->getOne('txid_api');

                $Update_txid_api = array(
                    "last_update_time" => time(),
                    "count_request" => $get_txid_api['count_request'] + 1
                );

                $db->update("txid_api" , $Update_txid_api);

                if(array_key_exists('error', $get_transaction_from_block)){

                    $db->where("id", $transaction['id']);
                    $get_transaction = $db->getOne('pending_transaction');

                    $Update_transaction = array(
                        "admin_description" => $get_transaction_from_block['error'],
                        "status" => 2,
                        "update_time" => time()
                    );

                    $db->where("id", $transaction['id']);
                    $db->update("pending_transaction" , $Update_transaction);

                }

                else{
                    // print_r($get_transaction_from_block);

                    $confirmations = $get_transaction_from_block['confirmations'];

                    $Transaction_outputs = $get_transaction_from_block['outputs'];

                    //var_dump($transaction['id']);

                    if($confirmations >= 3){

                        echo $transaction['id'] . " : is 3 confirm";
                        echo "<hr>";

                        $tx_det = array();
                        foreach ($Transaction_outputs as $output){
                            if($output['script_type'] == "pay-to-script-hash" && $output['addresses'][0] === "9tiYCRCeWFhoYaKSsoW2fNMrGpPeiq28BZ"){
                                $tx_det = $output;
                            }
                        }

                        //echo $tx_det['value'];
                        $RequireAmount = $tx_det['value'];

                        $final_Amount = $transaction['final_amount'] . "00";
                        $final_Amount = str_replace(".","",$final_Amount);

                        //var_dump($final_Amount,$final_Amount);
                        //var_dump($RequireAmount != $final_Amount);

                        $db->where("id", $transaction['id']);
                        $get_transaction_requir = $db->getOne('pending_transaction');

                        if($RequireAmount != $final_Amount){

                            print_r($get_transaction_requir);

                            $mablagh_eshtebah = array(
                                "admin_description" => "مبلغ واریزی شده با مقدار نشان داده شده به کاربر متفاوت می باشد. مبلغی که کاربر باید پرداخت میکرده : " . $final_Amount . " مبلغ پرداخت شده : " . $RequireAmount,
                                "status" => 3,
                                "update_time" => time(),
                            );

                            $db->where("id", $transaction['id']);
                            $db->update("pending_transaction" , $mablagh_eshtebah);
                        }else{

//                            echo "مبلغ اوکی هست";
//
//                            echo "<pre>";
//                            print_r($tx_det);
//                            echo "</pre>";

                            $db->where("trans_id", $transaction['txid']);

                            $fetch_transaction = $db->getOne("block_transaction");

                            if(!$db->count > 0){
                                $insert_transaction = array(
                                    "destination_wallet" => $tx_det['addresses'][0],
                                    "description"=> 'افزایش موجودی حساب',
                                    "member_id"=> $transaction['member_id'],
                                    "invoice_type"=> 1,
                                    "created_at"=> time(),
                                    "modified_at"=> time(),
                                    "status"=> '1',
                                    "time"=> time(),
                                    "pay_code"=> $transaction['txid'],
                                    "trans_id"=> $transaction['txid'],
                                    "amount"=> $tx_det['value'],
                                    "price"=> $tx_det['value'],
                                );

                                if($db->insert("block_transaction" , $insert_transaction)){

                                    $db->where("id", $transaction['member_id']);
                                    $get_member = $db->getOne('members');

                                    $update_member=array(
                                        "cash" => $get_member['cash']+ $transaction['final_amount'],
                                        "updated_at" => time(),
                                    );

                                    if($db->update("members", $update_member)) {
                                        activity_log($transaction['member_id'], $_SERVER['REQUEST_URI'], 12, "block_transaction,members", "افزایش موجودی حساب، مبلغ : " . $transaction['final_amount']);



                                        $payOk = array(
                                            "admin_description" => "پرداخت موفق",
                                            "status" => 1,
                                            "update_time" => time(),
                                        );

                                        $db->where("id", $transaction['id']);
                                        $db->update("pending_transaction" , $payOk);
                                    }

                                }
                            }else {
                                //echo "قبلا اطلاعات ثبت شده";

                                $payRepetitious = array(
                                    "admin_description" => "این txid قبلا ثبت شده است",
                                    "status" => 4,
                                    "update_time" => time(),
                                );

                                $db->where("id", $transaction['id']);
                                $db->update("pending_transaction" , $payRepetitious);
                            }
                        }
                    }else {
                        //echo $transaction['id'] . " : is not 3 confirm";
                        //echo "<hr>";
                    }
                }

            }

            else {
                //echo "error curl";
            }


        }else{
           // echo "no-ok";
        }
    }

    // $get_pending_transaction['txid'];

    //$get_pending_transaction['time'];




    //print_r($get_pending_transaction);
}


echo 'واریز مبلغ با موفقیت انجام شد';