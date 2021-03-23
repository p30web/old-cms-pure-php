<?php

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://block.io/api/v2/withdraw/?api_key=3a78-9311-b8eb-85b9&amounts=2&to_addresses=DJhSgdspopP9CLNUqWFAYaxgFb2K49zgjg",
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

	
	$curl1 = curl_init();
	$r = json_encode($response);
	curl_setopt_array($curl1, array(
		CURLOPT_URL =>'https://block.io/api/v2/sign_and_finalize_withdrawal/?api_key=3a78-9311-b8eb-85b9&signature_data='.$r,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache"
		),
	));

	$response1 = curl_exec($curl1);
	$err1 = curl_error($curl1);

	curl_close($curl1);
	if ($err1) {
		echo "cURL Error #:" . $err1;
	} else {
		echo '<pre>';
		print_r($response1);echo '</pre>';
	}
}