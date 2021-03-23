<?php
require_once('includes/classes/mysql/MysqliDb.php');
require_once('Connections/cn.php');
require_once('Connections/cn2.php');


date_default_timezone_set('Asia/Tehran');
require_once('lib/datetime/jdf.php');

include("lib/file/function.php");
include("safeval.php");

@session_start();


if (isset($_COOKIE["token"]) && $_COOKIE["token"] != null) {

    $token = GetSQLValueString($_COOKIE['token'], 'def');

    $db->where("token", $token);
    $db->where("status", 1);
    $user_det = $db->getOne("users");
    if ($db->count > 0) {
        setcookie("token", urlencode("logout"), time() - 1, "/");
        $pid = (int)$user_det['portalid'];

        $db->where("id", $pid);
        $cols = array("*");
        $fetch_set = $db->getOne("settings", $cols);

        $_SESSION["user_email"] = $user_det['email'];
        $_SESSION["user_id"] = $user_det['id'];
        $_SESSION["user_pass"] = $user_det['pass'];
        $_SESSION["user_token"] = $user_det['token'];
        $_SESSION["user_chpass"] = $user_det['pass'];
        $_SESSION["user_sessionid"] = session_id();
        $_SESSION["lastlogintime"] = $user_det['lastlogin'];
        $_SESSION["lastloginip"] = $user_det['lastip'];
        $_SESSION["portalid"] = $user_det['portalid'];
        $_SESSION["user_name"] = $user_det['name'];
        $_SESSION["user_domain"] = $fetch_set['domain'];
        $_SESSION["user_website"] = "irandogebank.com";
        $starttime = time();
        $endtime = $starttime + 30;

        $_SESSION["endtime"] = $endtime;


        $endtime = $_SESSION["endtime"];
        $enddate_member = date('Y-m-d H:i:s', $endtime);

        if (time() <= $endtime) {
            $starttime = time();
            $endtime = $starttime + 900;
            $_SESSION["endtime"] = $endtime;
        } else if (time() >= $endtime) {
            header('Location: login.php');
            echo "<script> window.location= 'login.php' </script>";
            exit;
        }

        if ($_SESSION["user_chpass"] == $_SESSION["user_pass"] and $_SESSION["user_sessionid"] == session_id() and $_SESSION["user_website"] == $_SESSION["user_domain"]) {
            $condition_portal = " and portalid=" . $_SESSION['portalid'] . "  ";
            $condition_getdata_portal = " and (portalid=" . $_SESSION['portalid'] . " or portalid='-1')  ";

            $endtime = $_SESSION["endtime"];
            $enddate_member = date('Y-m-d H:i:s', $endtime);

            if (time() <= $endtime) {
                $starttime = time();
                $endtime = $starttime + 900;
                $_SESSION["endtime"] = $endtime;
            } else if (time() >= $endtime) {
                header('Location: login.php');
                echo "<script>
	window.location= 'login.php';
	</script>";
                exit;
            }

            $user_email = "-1";
            if (isset($_SESSION['user_email'])) {
                $user_email = $_SESSION['user_email'];
            }

            $db->where("email", $user_email);
            $cols = array("id", "privileges", "name", "image");
            $fetch_user_priv = $db->getOne("users", $cols);

            $user_image = $fetch_user_priv['image'];

            if (strpos($_SERVER['PHP_SELF'], 'modules') > 0)
                $nav_path = '../../';
            else
                $nav_path = '';

            $privilegeslist = explode(",", $fetch_user_priv['privileges']);
            $privilegeslist[] = "index";
            $privilegeslist[] = "functiondata";
            $privilegeslist[] = "function";
            $privilegeslist[] = "access_denied";
            $checkaccc = 1;
            $pagename = explode("/", $_SERVER['PHP_SELF']);
            $tedadpager = count($pagename);
            $pagename2 = $pagename[$tedadpager - 1];
            $pagename = explode(".php", $pagename2);
            $finalpagename = $pagename[0];
            if (!in_array($finalpagename, $privilegeslist)) {
                $checkaccc = 0;
                header('Location: access_denied.php?ref=' . $_SERVER['HTTP_REFERER']);
                echo "<script>
	window.location= 'access_denied.php?ref=" . $_SERVER['HTTP_REFERER'] . "';
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
    } else {
        header('Location: login.php');
        echo "<script>
	window.location= 'login.php';
	</script>";
        exit;
    }
} else if ($_SESSION["user_chpass"] == $_SESSION["user_pass"] and $_SESSION["user_sessionid"] == session_id() and $_SESSION["user_website"] == $_SESSION["user_domain"]) {
    $condition_portal = " and portalid=" . $_SESSION['portalid'] . "  ";
    $condition_getdata_portal = " and (portalid=" . $_SESSION['portalid'] . " or portalid='-1')  ";


    $endtime = $_SESSION["endtime"];
    $enddate_member = date('Y-m-d H:i:s', $endtime);

    if (time() <= $endtime) {
        $starttime = time();
        $endtime = $starttime + 900;
        $_SESSION["endtime"] = $endtime;
    } else if (time() >= $endtime) {
        header('Location: login.php');
        echo "<script>
	window.location= 'login.php';
	</script>";
        exit;
    }

    $user_email = "-1";
    if (isset($_SESSION['user_email'])) {
        $user_email = $_SESSION['user_email'];
    }

    $db->where("email", $user_email);
    $cols = array("id", "privileges", "name", "image");
    $fetch_user_priv = $db->getOne("users", $cols);

    $user_image = $fetch_user_priv['image'];

    if (strpos($_SERVER['PHP_SELF'], 'modules') > 0)
        $nav_path = '../../';
    else
        $nav_path = '';

    $privilegeslist = explode(",", $fetch_user_priv['privileges']);
    $privilegeslist[] = "index";
    $privilegeslist[] = "functiondata";
    $privilegeslist[] = "function";
    $privilegeslist[] = "access_denied";
    $checkaccc = 1;
    $pagename = explode("/", $_SERVER['PHP_SELF']);
    $tedadpager = count($pagename);
    $pagename2 = $pagename[$tedadpager - 1];
    $pagename = explode(".php", $pagename2);
    $finalpagename = $pagename[0];
    if (!in_array($finalpagename, $privilegeslist)) {
        $checkaccc = 0;
        header('Location: access_denied.php?ref=' . $_SERVER['HTTP_REFERER']);
        echo "<script>
	window.location= 'access_denied.php?ref=" . $_SERVER['HTTP_REFERER'] . "';
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

?>
