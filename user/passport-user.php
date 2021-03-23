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

//$db->where("admin_id", $GetAdminID);
$db->where("user_id", 1);

$fetch_admin = $db->getOne("admin_login");

if(is_null($fetch_admin)){
    $insert_array = array(
        "admin_id" => $GetAdminID,
        "user_id" => 1,
    );

    if ( $db->insert("admin_login", $insert_array)) {
        header('Location: ' . 'https://irandogebank.com/user/?adminlogin=1');
        echo "<script>
	window.location= " . "'https://irandogebank.com/user/?adminlogin=1';
	</script>";
        exit;
    }else{
        exit('خطای مهمی رخ داده است');
    }

}

//print_r($fetch_admin);

$db->where("user_id", 1);

$insert_array = array(
    "admin_id" => $GetAdminID,
);

if ($db->update("admin_login", $insert_array)) {
    header('Location: ' . 'https://irandogebank.com/user/?adminlogin=1');
    echo "<script>
	window.location= " . "'https://irandogebank.com/user/?adminlogin=1';
	</script>";
    exit;
}else{
    exit('خطای مهمی رخ داده است');
}



//if($db->update("members", $update_member)){
//
//}

//		echo '<pre>';
//		print_r($insert_array);echo '</pre>';
//		die;