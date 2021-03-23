<?php
/**
 * Created by PhpStorm.
 * User: a.ahmadi
 * Date: 2/25/2020
 * Time: 2:47 PM
 */

include("checklogin.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$GetAdminID = null;

if(isset($_GET["a"])){
    $GetAdminID = test_input($_GET["a"]);
} else {
    exit('خطایی رخ داده است.');
}

if(is_null($GetAdminID)){
    exit('خطایی رخ داده است.');
}

$GetAdminID = $_GET["a"];

if (strpos($GetAdminID, "p30u") === false) {
    exit('خطایی رخ داده است.');
}

$GetAdminID = str_replace("p30u",'',$GetAdminID);


$db->where('admin_id', $GetAdminID);

if($db->delete('admin_login')){
    header('Location: ' . 'https://irandogebank.com/user/?logout=1');
    echo "<script>
	window.location= " . "'https://irandogebank.com/user/?logout=1';
	</script>";
} else {
    exit('خطای مهمی رخ داده است');
}


//if($db->update("members", $update_member)){
//
//}

//		echo '<pre>';
//		print_r($insert_array);echo '</pre>';
//		die;