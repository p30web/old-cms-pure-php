<?php require_once('../../checklogin.php');


if($checkaccc===1)
{//start check access
// Make a transaction dispatcher instance
    $id= decrypt($_GET['id'],session_id()."mnu");


    $db->where("id", $id);
    if($db->delete("menus")){
        header("Location: ".$_SERVER['HTTP_REFERER']);
        echo "<script>
	window.location= ".$_SERVER['HTTP_REFERER'].";
	</script>";
    }

}//end check access
?>