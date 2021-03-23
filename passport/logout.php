<?php
setcookie("token", urlencode("logout"), time() - 1, "/");
$logoutGoTo = "login.php";
if (!isset($_SESSION)) {
    @session_start();
}
$_SESSION['user_email'] = NULL;
$_SESSION['user_pass'] = NULL;
$_SESSION['user_chpass'] = NULL;
$_SESSION["user_sessionid"]=NULL;
$_SESSION["user_website"]=NULL;
unset($_SESSION['user_email']);
unset($_SESSION['user_pass']);
unset($_SESSION['user_chpass']);
unset($_SESSION['user_sessionid']);
unset($_SESSION['user_website']);
unset($_SESSION['user_domain']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
    exit;
}
