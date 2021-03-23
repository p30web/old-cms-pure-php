<?php require_once('../../checklogin.php');
require_once ("../../../user/lib/file/activity_log.php");


if($checkaccc===1)
{//start check access
    // Make a transaction dispatcher instance
    $id= decrypt($_GET['id'],session_id()."inv");


    $db->where("id", $id);
    $withdraw = $db->getOne("withdraw");

    $db->where("id", $withdraw['member_id']);
    $fetch_mem = $db->getOne("members");
    $cash = $fetch_mem['cash'] + ($withdraw['amount'] - $withdraw['member_fee']);

    $user_update= array(
        "cash"=> $cash
    );

    if(is_null($withdraw['type'])){
        $user_update = array(
            "cash"=> $cash
        );
    }

    if(!is_null($withdraw['type']) && $withdraw['type']== "dollar"){
        $user_update = array(
            "dollar_credit"=> $cash
        );
    }

    $db->where("id", $withdraw['member_id']);
    if($db->update("members", $user_update)){
        $db->where("id", $id);
        if($db->delete("withdraw")){
            activity_log($withdraw['member_id'], $_SERVER['REQUEST_URI'],12, "withdraw,members", "برگشت درخواست برداشت وجه");

            header("Location: ".$_SERVER['HTTP_REFERER']);
            echo "<script>
	window.location= ".$_SERVER['HTTP_REFERER'].";
	</script>";
        }

    }


}//end check access
?>