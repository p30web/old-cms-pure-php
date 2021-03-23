<?php
include("checklogin.php");

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("id", $_SESSION['member_id']);
}

$fetch_user = $db->getOne("members");


$TypeWallet = "notfound";


if(isset($_GET['type'])){
    if($_GET['type'] == "dog"){
        $TypeWallet = "dog";
    }elseif($_GET['type'] == "dollar"){
        $TypeWallet = "dollar";
    }
}

if($TypeWallet == "notfound"){
    exit("خطایی رخ داده است");
}

if($_GET['id']){
    $id = decrypt($_GET['id'], session_id() . "wtd");
    $id = GetSQLValueString($id, 'int');

    $db->where("member_id", $fetch_user['id']);

    $db->where("id", $id);

    $fetch_withdraw = $db->getOne("withdraw");
//
//echo "<pre>";
//    print_r($fetch_withdraw);
//    print_r($fetch_withdraw['amount']);

    $db->where("member_id", $fetch_user['id']);

    $db->where("id", $id);

    $update_array=array(
        "status"=> 3,
        "updated_at"=> jdate('Y-m-d H:i:s'),
    );

    if($db->update("withdraw", $update_array)){

        $fetch_userCash = $fetch_user["cash"];
        $fetch_dollar_credit = $fetch_user["dollar_credit"];

        $db->where("id", $fetch_user['id']);


        if($TypeWallet == "dollar"){
            $update_array=array(
                "dollar_credit"=> $fetch_dollar_credit + $fetch_withdraw['amount'],
                "updated_at"=> jdate('Y-m-d H:i:s'),
            );
        }elseif ($TypeWallet =="dog"){
            $update_array=array(
                "cash"=> $fetch_userCash + $fetch_withdraw['amount'],
                "updated_at"=> jdate('Y-m-d H:i:s'),
            );
        }

        if($db->update("members", $update_array)){
            echo "<script>window.location='".$_SERVER['HTTP_REFERER']."';</script>";
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>

<body>

</body>
</html>

