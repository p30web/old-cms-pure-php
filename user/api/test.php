<?php

include("../checklogin.php");

require_once('../includes/classes/restful/RestService.php');
require_once ("../lib/file/activity_log.php");

$db->where("token", 'Ir897dfc9');
$fetch_mem = $db->getOne("p30web_credit");


$final_price = $fetch_mem['final_price'];


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://block.io/api/v2/get_raw_transaction/?api_key=3a78-9311-b8eb-85b9&txid=7e2551ecaf77510ee0444070d51a5da7e228af1af194cc42900582cea6215549",
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

$JSon = json_decode($get_transaction_from_block);

$data = $JSon->data;

$output= $data->outputs;

$Ouput0 = $output[0];

print_r($Ouput0->value);

$final_mablagh = 20.00089700 + 0;

if($final_price == $final_mablagh){
    echo "yses";
}else{
    echo "no";
}

