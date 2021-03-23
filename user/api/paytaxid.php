<?php
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

$db->where("token", $token);
$p30web_credit = $db->getOne("p30web_credit");

$tokenStatus = 1;

if(!$db->count > 0){
    $tokenStatus = 0;
}


$fetch_admin = $db->get("admin_login");
if (
    $_POST['txid']
) {
    $amount = GetSQLValueString($_POST['amount'],"def");
    $taxid = GetSQLValueString($_POST['txid'],"def");

    $db->where("id", 2);
    $fetch_wallets = $db->getOne("wallets");

    if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
        $db->where("id", $fetch_admin[0]['admin_id']);
        $fetch_mem = $db->getOne("members");
    }else{
        $db->where("id", $_SESSION['member_id']);
        $fetch_mem = $db->getOne("members");
    }

    if($db->count > 0){
        
        $db->where("trans_id", $taxid);
//        $db->where("amount", $amount);
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
        }else{
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://block.io/api/v2/get_raw_transaction/?api_key=".$fetch_wallets['api_token']."&txid=".$taxid,
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

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $get_transaction_from_block = $response;
            }

            if($get_transaction_from_block == false || $get_transaction_from_block == null){
                $REST->responseArray = array(
                    "status" => 200,
                    "type" => "danger",
                    "message" => 'تراکنشی با این مشخصات ثبت نشده است!'

                );
            }else{
                $result = json_decode($get_transaction_from_block, true);
                
               // print_r($result);

                if($result['status'] === "success"){

                    if($result['data']['confirmations'] > 2){

                        $datap30web = $result['data']['outputs'];

                        $final_result = array();

                        foreach ($datap30web as $output){
                            if($output['type'] == "scripthash"){
                                $final_result = $output;
                            }
                        }



                        $Ouput0 = $final_result['value'];

                        $final_mablagh = $Ouput0 + 0;

                        $db->where("final_price", $final_mablagh);
                        $p30web_credit = $db->getOne("p30web_credit");


                        if($db->count > 0){

                            $tx_output_array = $result['data']['outputs'];

                            $tx_det = array();
                            foreach ($tx_output_array as $output){
                                if($output['type'] == "scripthash" && $output['address'] === $fetch_wallets['ac_wallet']){
                                    $tx_det = $output;
                                }
                            }

                            if($tx_det['address'] === $fetch_wallets['ac_wallet']){
                                $insert_transaction = array(
                                    "destination_wallet"=> $tx_det['address'],
                                    "description"=> 'افزایش موجودی حساب',
                                    "member_id"=> $fetch_mem['id'],
                                    "invoice_type"=> 1,
                                    "created_at"=> jdate('Y-m-d H:i:s'),
                                    "modified_at"=> jdate('Y-m-d H:i:s'),
                                    "status"=> '1',
                                    "time"=> $result['data']['time'],
                                    "pay_code"=> $result['data']['txid'],
                                    "trans_id"=> $result['data']['txid'],
                                    "amount"=> $tx_det['value'],
                                    "price"=> $tx_det['value'],
                                );
                                if($db->insert("block_transaction" , $insert_transaction)){

                                    $update_member=array(
                                        "cash" => $fetch_mem['cash']+ $tx_det['value'],
                                    );
                                    $db->where("id", $fetch_mem['id']);
                                    if($db->update("members", $update_member)){
                                        activity_log($fetch_mem['id'], $_SERVER['REQUEST_URI'],12, "block_transaction,members", "افزایش موجودی حساب، مبلغ : ".$tx_det['value']);
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
      <th scope="row">'.$insert_transaction['trans_id'].'</th>
      <td>'.$insert_transaction['created_at'].'</td>
      <td>'.$insert_transaction['amount'].'</td>
    </tr>
  </tbody>
</table>';

                                        $REST->responseArray = array(
                                            "status" => 200,
                                            "type" => "success",
                                            "action"=>"show_details",
                                            "data"=> $html_data,
                                            "message" => 'تراکنش موفق، لطفا صبر کنید...'

                                        );
                                    }else{
                                        $REST->responseArray = array(
                                            "status" => 200,
                                            "type" => "danger",
                                            "message" => 'خطا در انجام عملیات'

                                        );
                                    }

                                }
                            }else{
                                // wallet address not same
                                $REST->responseArray = array(
                                    "status" => 200,
                                    "type" => "danger",
                                    "message" => 'خطا در انجام عملیات'

                                );
                            }

                        }

                        else{
                            $REST->responseArray = array(
                                "status" => 200,
                                "type" => "danger",
                                "message" => 'امکان تایید پرداخت با این taxid وجود ندارد، به بخش افزایش موجودی مراجعه کنید و طبق مراحل پیش روید و یا در صورت وجود مشکل با پشتیبانی تماس بگیرید'

                            );
                        }


                    }else{
                        $REST->responseArray = array(
                            "status" => 200,
                            "type" => "warning",
                            "action"=> "interval",
                            "message" => 'درحال دریافت تایید تراکنش، لطفا تا تایید تراکنش منتظر بمانید...'
                        );
                    }

                }else{
                    $REST->responseArray = array(
                        "status" => 200,
                        "type" => "danger",
                        "message" => 'تراکنش ناموفق'

                    );
                }
            }
        }

    }else{
        $REST->responseArray = array(
            "status" => 401
        );
    }

} else {
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'عیر مجاز'

    );
}

echo $REST->RseponseToC();