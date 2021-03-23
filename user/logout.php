<?php
include("lib/file/activity_log.php");
setcookie("membertoken", urlencode("logout"), time() - 1, "/");
$logoutGoTo = "login.php";
if (!isset($_SESSION)) {
    @session_start();
}
$_SESSION['member_email'] = NULL;
$_SESSION['membermember_pass'] = NULL;
$_SESSION['member_chpass'] = NULL;
$_SESSION["member_sessionid"]=NULL;
$_SESSION["member_website"]=NULL;
unset($_SESSION['member_email']);
unset($_SESSION['member_pass']);
unset($_SESSION['member_chpass']);
unset($_SESSION['member_sessionid']);
unset($_SESSION['member_website']);
unset($_SESSION['member_domain']);
if ($logoutGoTo != "") {

    // activity_log($_SESSION['member_id'], $_SERVER['REQUEST_URI'],0, "-", "خروج از حساب کاربری");
    header("Location: $logoutGoTo");
    exit;
}
