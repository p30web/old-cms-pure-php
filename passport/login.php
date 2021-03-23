<?php
@session_start();
require_once('includes/classes/mysql/MysqliDb.php');
require_once('Connections/cn.php');
require_once('lib/datetime/jdf.php');
date_default_timezone_set('Asia/Tehran');


?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> ورود به سایت</title>
    <?php include("root-head.php"); ?>
    <link href="assets/css/pages/login/login-3.rtl.css" rel="stylesheet" type="text/css" />

</head>
<body  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading"  >


<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(media/bg/bg-3.jpg);">
            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                <div class="kt-login__container">
                    <div class="kt-login__logo">
                        <a href="#">
                            <img src="media/logos/logo-5.png">
                        </a>
                    </div>
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">ورود به مدیریت</h3>
                        </div>
                        <form class="kt-form">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="ایمیل" name="email" autocomplete="off">
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="رمز عبور" name="password">
                            </div>
                            <div class="row kt-login__extra">
                                <div class="col">
                                    <label class="kt-checkbox">
                                        <input type="checkbox" name="remember"> به خاطر سپردن
                                        <span></span>
                                    </label>
                                </div>

                            </div>
                            <div class="kt-login__actions">
                                <button id="kt_login_signin_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">ورود</button>
                            </div>
                        </form>
                    </div>
                    <div class="kt-login__account">
					<span class="kt-login__account-msg">
						سیستم مدیریت
					</span>&nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {"colors":{"state":{"brand":"#5d78ff","dark":"#282a3c","light":"#ffffff","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
</script>
<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="assets/vendors/global/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->




<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/login/login-general.js" type="text/javascript"></script>
<!--end::Page Scripts -->


</html>