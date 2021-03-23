<?php
include("checklogin.php");


$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}

?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head>
    <title>ایران دوج | کیف پول من</title>
    <?php include("root-head.php"); ?>
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-page--loading-enabled kt-page--loading kt-app__aside--left kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-subheader--enabled kt-subheader--transparent kt-page--loading">

<!-- begin::Page loader -->

<!-- end::Page Loader -->
<!-- begin:: Page -->
<?php include("Components/mobile_header.php"); ?>
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">
            <?php include("Components/header.php"); ?>
            <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                    <!-- begin:: Subheader -->
                    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                        <div class="kt-container ">
                            <div class="kt-subheader__main">
                                <button class="kt-subheader__mobile-toggle kt-subheader__mobile-toggle--left"
                                        id="kt_subheader_mobile_toggle"><span></span></button>

                                <h3 class="kt-subheader__title">
                                    تایید تغییر کیف پول
                                </h3>

                                <span class="kt-subheader__separator kt-hidden"></span>
                                <div class="kt-subheader__breadcrumbs">
                                    <a href="#" class="kt-subheader__breadcrumbs-home">
                                        <i class="flaticon2-shelter"></i></a>
                                    <span class="kt-subheader__breadcrumbs-separator"></span>
                                    <a href="my_profile.php" class="kt-subheader__breadcrumbs-link">
                                        پروفایل من
                                    </a>
                                    <a href="#" class="kt-subheader__breadcrumbs-home">
                                        <i class="flaticon2-shelter"></i></a>
                                    <span class="kt-subheader__breadcrumbs-separator"></span>
                                    <a href="index.php" class="kt-subheader__breadcrumbs-link">
                                        داشبورد
                                    </a>

                                    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end:: Subheader -->
                    <!-- begin:: Content -->
                    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                        <!--Begin::App-->
                        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
                            <!--Begin:: App Aside Mobile Toggle-->
                            <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
                                <i class="la la-close"></i>
                            </button>
                            <!--End:: App Aside Mobile Toggle-->

                            <!--Begin:: App Content-->

                            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                                <div class="row">

                                    <div class="col-xl-12 col-lg-12 order-lg-12 order-xl-12">
                                        <?php

                                        if(!isset($_GET['vrifycode'])){
                                            $Massege = "درخواست شما نامعتبر است";
                                            $Type = "danger";
                                        }

                                        function test_input($data) {
                                            $data = trim($data);
                                            $data = stripslashes($data);
                                            $data = htmlspecialchars($data);
                                            return $data;
                                        }


                                        $db->where("requestcode", test_input($_GET['vrifycode']));
                                        $db->where("member_id", $fetch_member['id']);
                                        $db->where("status", '0');
                                        $GetRequestWallet = $db->getOne("change_wallet_request");

                                        if ($db->count > 0) {

                                            $update_wallet_request = array(
                                                "status"=> 2,
                                            );

                                            $db->where("requestcode", test_input($_GET['vrifycode']));
                                            $db->where("member_id", $fetch_member['id']);
                                            $db->where("status", '0');

                                            $wallet_type = $GetRequestWallet['wallet_type'];

                                            $wallet_type = "dog";

                                            if(!is_null($GetRequestWallet['wallet_type'])){
                                                $wallet_type = $GetRequestWallet['wallet_type'];
                                            }

                                            if($db->update("change_wallet_request", $update_wallet_request)){
                                                if($wallet_type == "dog"){
                                                    $update_Wallet = array(
                                                        "wallet"=> null,
                                                    );
                                                }elseif($wallet_type== "dollar"){
                                                    $update_Wallet = array(
                                                        "dollar_wallet"=> null,
                                                    );
                                                }

                                                $db->where("id", $GetRequestWallet['member_id']);
                                                if($db->update("members", $update_Wallet)){
                                                    activity_log($fetch_member['id'], 'change_wallet.php',2, "members", "تغییر کیف پول");
                                                    $Massege = "ایمیل تغییر کیف پول شما تایید شد، شما هم اکنون میتوانید با مراجعه به صفحه مدیریت حساب ها آدرس کیف پول جدید خود را وارد کنید";
                                                    $Type = "success";
                                                }else {
                                                    $Massege = "تایید کیف پول انجام نشد، مجدد با مراجعه به صفحه مدیریت حساب ها درخواست ویرایش کیف پول ارسال نمایید";
                                                    $Type = "danger";
                                                }
                                            }else{
                                                $Massege = "تایید کیف پول انجام نشد، مجدد با مراجعه به صفحه مدیریت حساب ها درخواست ویرایش کیف پول ارسال نمایید";
                                                $Type = "danger";
                                            }
                                        }else{
                                            $Massege = "کد تایید ایمیل نامعتبر می باشد، مجدد درخواست تغییر کیف پول ارسال نمایید";
                                            $Type = "danger";
                                        }

                                        ?>
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        بررسی ایمیل تایید کیف پول
                                                    </h3>
                                                </div>
                                            </div>
                                            <!--begin::Form-->
                                            <div class="kt-portlet__body">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="alert alert-<?php echo $Type ?>" role="alert">
                                                        <div class="alert-text"><?php echo $Massege ?></div>
                                                    </div>
                                                    <div class="kt-space-10"></div>
                                                </div>
                                            </div>
                                            <!--end::Form-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End:: App Content-->
                        </div>
                        <!--End::App-->
                    </div>
                    <!-- end:: Content -->
                </div>
            </div>

            <!-- begin:: Footer -->
            <?php include("footer.php"); ?>
            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<?php include("footer-script.php"); ?>
<script src="assets/js/pages/dashboard.js" type="text/javascript"></script>
<script>
    "use strict";
    var KTAppUserProfile = {
        init: function () {
            new KTOffcanvas("kt_user_profile_aside", {
                overlay: !0,
                baseClass: "kt-app__aside",
                closeBy: "kt_user_profile_aside_close",
                toggleBy: "kt_subheader_mobile_toggle"
            })
        }
    };

</script>
<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>