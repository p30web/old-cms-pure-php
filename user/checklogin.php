<?php
require_once('includes/classes/mysql/MysqliDb.php');
require_once('Connections/cn.php');
require_once('Connections/cn0.php');
require_once('Connections/cn2.php');
require_once('Connections/cn3.php');


date_default_timezone_set('Asia/Tehran');
require_once('lib/datetime/jdf.php');

include("lib/file/function.php");
include("lib/file/activity_log.php");
include("safeval.php");

@session_start();

$db->where("id", 1);
$settings = $db->getOne("settings");
if($settings['status'] == 0){
	header('Location: access_denied.php');
	echo "<script> window.location= 'access_denied.php' </script>";
	exit;
	die;
}
if (isset($_COOKIE["membertoken"]) && $_COOKIE["membertoken"] != null) {

	$token = GetSQLValueString($_COOKIE['membertoken'], 'def');

	$db->where("token", $token);
	$db->where("status", 1);
	$user_det = $db->getOne("members");
	if ($db->count > 0) {
		setcookie("membertoken", urlencode("logout"), time() - 1, "/");
		//        $pid = (int)$user_det['portalid'];
		$pid = 1;

		$db->where("id", $pid);
		$cols = array("*");
		$fetch_set = $db->getOne("settings", $cols);

		// 		if ($fetch_setp['status'] == 0) {
		// 			header('Location: access_denied.php?ref=' . $_SERVER['HTTP_REFERER']);
		// 			echo "<script>
		// 	window.location= 'access_denied.php?ref=" . $_SERVER['HTTP_REFERER'] . "';
		// 	</script>";
		// 			exit;
		// 		}

		$_SESSION["member_email"] = $user_det['email'];
		$_SESSION["member_id"] = $user_det['id'];
		$_SESSION["member_pass"] = $user_det['password'];
		$_SESSION["member_cash"] = $user_det['cash'];
		$_SESSION["member_status"] = $user_det['status'];
		$_SESSION["member_token"] = $user_det['token'];
		$_SESSION["member_chpass"] = $user_det['password'];
		$_SESSION["member_sessionid"] = session_id();
		$_SESSION["memberlastlogintime"] = $user_det['last_login'];
		$_SESSION["memberlastloginip"] = $user_det['last_ip'];
		$_SESSION["memberportalid"] = $pid;
		$_SESSION["member_name"] = $user_det['firstname'];
		$_SESSION["member_lastname"] = $user_det['lastname'];
		$_SESSION["member_website"] = "irandogebank.com/user";
		$starttime = time();
		$endtime = $starttime + 30;

		$_SESSION["memberendtime"] = $endtime;


		$endtime = $_SESSION["memberendtime"];
		$enddate_member = date('Y-m-d H:i:s', $endtime);

		if (time() <= $endtime) {
			$starttime = time();
			$endtime = $starttime + 900;
			$_SESSION["memberendtime"] = $endtime;
		} else if (time() >= $endtime) {
			header('Location: login.php');
			echo "<script> window.location= 'login.php' </script>";
			exit;
		}

		if ($_SESSION["member_chpass"] == $_SESSION["member_pass"] and $_SESSION["member_sessionid"] == session_id() and $_SESSION["member_website"] == "irandogebank.com/user") {
			$condition_portal = " and portalid=" . $_SESSION['memberportalid'] . "  ";
			$condition_getdata_portal = " and (portalid=" . $_SESSION['memberportalid'] . " or portalid='-1')  ";

			$user_email = "-1";
			if (isset($_SESSION['member_email'])) {
				$user_email = $_SESSION['member_email'];
			}

			$db->where("email", $user_email);
			$cols = array("id", "firstname", "lastname", "img");
			$fetch_user_priv = $db->getOne("members", $cols);

			$user_image = $fetch_user_priv['img'];


			$checkaccc = 1;
			$pagename = explode("/", $_SERVER['PHP_SELF']);
			$tedadpager = count($pagename);
			$pagename2 = $pagename[$tedadpager - 1];
			$pagename = explode(".php", $pagename2);
			$finalpagename = $pagename[0];

		} else {
			header('Location: login.php');
			echo "<script>
	window.location= 'login.php';
	</script>";
			exit;
		}
	} else {
		header('Location: login.php');
		echo "<script>
	window.location= 'login.php';
	</script>";
		exit;
	}
} else if ($_SESSION["member_chpass"] == $_SESSION["member_pass"] and $_SESSION["member_sessionid"] == session_id() and $_SESSION["member_website"] == "irandogebank.com/user") {

	$condition_portal = " and portalid=" . $_SESSION['memberportalid'] . "  ";
	$condition_getdata_portal = " and (portalid=" . $_SESSION['memberportalid'] . " or portalid='-1')  ";

	$user_email = "-1";
	if (isset($_SESSION['member_email'])) {
		$user_email = $_SESSION['member_email'];
	}

	$db->where("email", $user_email);
	$cols = array("id", "firstname", "lastname", "img");
	$fetch_user_priv = $db->getOne("members", $cols);

	$user_image = $fetch_user_priv['img'];

	$checkaccc = 1;
	$pagename = explode("/", $_SERVER['PHP_SELF']);
	$tedadpager = count($pagename);
	$pagename2 = $pagename[$tedadpager - 1];
	$pagename = explode(".php", $pagename2);
	$finalpagename = $pagename[0];


	if (time() <= $_SESSION["memberendtime"]) {
		$starttime = time();
		$endtime = $starttime + 900;
		$_SESSION["memberendtime"] = $endtime;
	} else if (time() >= $_SESSION["memberendtime"]) {
		header('Location: login.php');
		echo "<script> window.location= 'login.php' </script>";
		exit;
	}

} else {

	header('Location: login.php');
	echo "<script>
	window.location= 'login.php';
	</script>";
	exit;
}

?>
