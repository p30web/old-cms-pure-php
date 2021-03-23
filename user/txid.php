<?php
require_once('simple_html_dom.php');

//// Find all images
//foreach($html->find('img') as $element){
//    echo $element->src . '<br>';
//}

$ch = curl_init("https://api.blockcypher.com/v1/doge/main/txs/3f68ee567316e0870328072b4c129d615c9bcb596541703a9ffd9fa905854901");

//curl_setopt($ch,CURLOPT_HEADER,1);

curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);

curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);

$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo "<pre>";
    print_r($response);
    echo "</pre>";
}
