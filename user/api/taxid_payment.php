<?php
include("../checklogin.php");

require_once('../includes/classes/restful/RestService.php');
require_once ("../lib/file/activity_log.php");

//require_once '../includes/classes/blockio/block_io.php';


function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

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




$amount = GetSQLValueString($_POST['amount'],"def");

$fetch_admin = $db->get("admin_login");

if(!is_numeric($amount)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'خطای 33 - مبلغ باید به صورت عددی باشد.'
    );
}
else if(!is_decimal($amount)){
    $REST->responseArray = array(
        "status" => 200,
        "type" => "danger",
        "message" => 'خطای 32 - ثبت taxid فقط برای تراکنش هایی که از طریق بخش افزایش موجودی ثبت شده اند امکان پذیر می باشد.'
    );
}else{

    if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
        $db->where("member_id", $fetch_admin[0]['admin_id']);
        $db->where("final_price", $amount);
        $fetch_p30web_credit = $db->getOne("p30web_credit");
    }else{
        $db->where("member_id", $_SESSION['member_id']);
        $db->where("final_price", $amount);
        $fetch_p30web_credit = $db->getOne("p30web_credit");
    }

    if(!is_null($fetch_p30web_credit)){
        if ($_POST['txid']) {
            $taxid = GetSQLValueString($_POST['txid'],"def");

            $randWallet = rand(2,5);
            $db->where("id", $randWallet);
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

                    $db->where("member_id", $fetch_mem['id']);
                    $db->where("taxid", $taxid);
                    $fetch_payment_vrify = $db->getOne("payment_vrify");

                    if(!is_null($fetch_payment_vrify) && time() <= $fetch_payment_vrify["time"] + 180){

                        $REST->responseArray = array(
                            "status" => 200,
                            "type" => "warning",
                            "message" => 'لطفا ' . (($fetch_payment_vrify["time"] + 180) - time()) . " ثانیه صببر نمایید و مجدد درخواست دهید. "
                        );

//                echo jdate('Y-m-d H:i:s',$fetch_payment_vrify["time"]);
//                echo "------------------";
//                echo jdate('Y-m-d H:i:s',$fetch_payment_vrify["time"] + 120);
//
//              print_r($fetch_payment_vrify);

                    }else {
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

                             if($result['data']['confirmations'] >= 3){
                                 $datap30web = $result['data']['outputs'];

                                 $final_result = array();

                                 foreach ($datap30web as $output){
                                     if($output['type'] == "scripthash"){
                                         $final_result = $output;
                                     }
                                 }

//                                $Ouput0 = $final_result['value'];
//                                $final_mablagh = $Ouput0 + 0;
//                                $db->where("final_price", $final_mablagh);
//                                $p30web_credit = $db->getOne("p30web_credit");

                                 $tx_output_array = $result['data']['outputs'];

                                 $tx_det = array();
                                 foreach ($tx_output_array as $output){
                                     if($output['type'] == "scripthash" && $output['address'] === $fetch_wallets['ac_wallet']){
                                         $tx_det = $output;
                                     }
                                 }

                                 if($amount == $tx_det['value']){

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

                                 } else{
                                     $REST->responseArray = array(
                                         "status" => 200,
                                         "type" => "danger",
                                         "message" => 'خطای 46 - امکان تایید پرداخت با این taxid وجود ندارد، به بخش افزایش موجودی مراجعه کنید و طبق مراحل پیش روید و یا در صورت وجود مشکل با پشتیبانی تماس بگیرید'

                                     );
                                 }


                             }else{
                                 $db->where("member_id", $fetch_mem['id']);
                                 $db->where("taxid", $taxid);
                                 $fetch_payment_vrify = $db->getOne("payment_vrify");

                                 if(is_null($fetch_payment_vrify)){
                                     $insert_payment_vrify = array(
                                         "member_id"=> $fetch_mem['id'],
                                         "status" => "1",
                                         "time"=> time(),
                                         "description"=> 'تعداد confirmation ها هنوز به عدد 3 نرسیده است',
                                         "created_at" => jdate('Y-m-d H:i:s'),
                                         "request_time" => $result['data']['time'],
                                         "taxid"=> $result['data']['txid'],
                                         "confirmations" => $result['data']['confirmations'],
                                     );

                                     if($db->insert("payment_vrify" , $insert_payment_vrify)){
                                         $REST->responseArray = array(
                                             "status" => 200,
                                             "type" => "warning",
                                             "message" => 'تعداد confirmation ها هنوز به عدد 3 نرسیده است، لطفا چند دقیقه صببر کنید و چند دقیقه دیگر مجدد درخواست دهید.'
                                         );
                                     }else{
                                         $REST->responseArray = array(
                                             "status" => 200,
                                             "type" => "warning",
                                             "message" => 'خطایی رخ داده است، چند دقیقه دیگر مجدد تلاش کنید'
                                         );
                                     }
                                 }else {
                                     $update_payment_vrify = array(
                                         "member_id"=> $fetch_mem['id'],
                                         "status" => "2",
                                         "time"=> time(),
                                         "description"=> 'تعداد confirmation ها هنوز به عدد 3 نرسیده است',
                                         "created_at" => jdate('Y-m-d H:i:s'),
                                         "request_time" => $result['data']['time'],
                                         "taxid"=> $result['data']['txid'],
                                         "confirmations" => $result['data']['confirmations'],
                                     );

                                     $db->where("taxid", $taxid);
                                     $db->where("id", $fetch_mem['id']);
                                     if($db->update("payment_vrify", $update_payment_vrify)){
                                         $REST->responseArray = array(
                                             "status" => 200,
                                             "type" => "warning",
                                             "message" => 'تعداد confirmation ها هنوز به عدد 3 نرسیده است، لطفا چند دقیقه صببر کنید و چند دقیقه دیگر مجدد درخواست دهید.'
                                         );
                                     }else{
                                         $REST->responseArray = array(
                                             "status" => 200,
                                             "type" => "warning",
                                             "message" => 'خطایی رخ داده است، چند دقیقه دیگر مجدد تلاش کنید'
                                         );
                                     }
                                 }

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
    }else{
        $REST->responseArray = array(
            "status" => 200,
            "type" => "danger",
            "message" => 'خطای 26 - امکان پرداخت با این مشخصات وجود ندارد - با پشتیبانی تماس بگیرید.'

        );
    }


}






echo $REST->RseponseToC();