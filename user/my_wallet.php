<?php

include("checklogin.php");

require_once('includes/classes/Validation.php');

$walletSelected = "dog";

if(isset($_GET['wallet'])){
    if($_GET['wallet'] == "dog"){
        $walletSelected = "dog";
    } elseif ($_GET['wallet'] == "dollar"){
        $walletSelected = "dollar";
    }
}



$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}




$val = new Validation;
$hasError = 0;


if (!empty($_POST)) {

    if($walletSelected == "dollar"){
        $val->name('آدرس کیف پول پرفکت مانی')->value($_POST['dollar_wallet_addr'])->required();
        if ($val->isSuccess()) {
            $dollar_wallet_addr = GetSQLValueString($_POST['dollar_wallet_addr'], "def");

            if (strpos($dollar_wallet_addr, 'U') !== false) {
                $db->where("id", $fetch_member['id']);
                $member_wallet = array(
                    "dollar_wallet" => $dollar_wallet_addr,
                    "modified_at" => jdate('Y/m/d H:i:s')
                );

                if ( $db->update("members", $member_wallet)) {
                    activity_log($fetch_member['id'], $_SERVER['REQUEST_URI'], 2, "members", "ثبت کیف پول دلاری");
                    header('Location: ' . $_POST['referurl'] . '?add=1');
                    echo "<script>
	window.location= " . $_POST['referurl'] .  "'?add=1';
	</script>";
                    exit;
                } else {
                    $hasError = 1;
                }
            }else {
                $hasError = 1;
                $val->SetErrors("فرمت آدرس کیف پول صحیح نمی باشد.");
            }

        }
    }elseif ($walletSelected == "dog"){
        $val->name('آدرس کیف پول')->value($_POST['wallet_addr'])->required();
        if ($val->isSuccess()) {


            $wallet_addr = GetSQLValueString($_POST['wallet_addr'], "def");

            $db->where("id", $fetch_member['id']);
            $member_wallet = array(
                "wallet" => $wallet_addr,
                "progress" => ($fetch_member['wallet'] == null) ? $fetch_member['progress']+10 : $fetch_member['progress'],
                "modified_at" => jdate('Y/m/d H:i:s')
            );

            if ( $db->update("members", $member_wallet)) {
                activity_log($fetch_member['id'], $_SERVER['REQUEST_URI'], 2, "members", "ثبت کیف پول دوچ کوین");
                header('Location: ' . $_POST['referurl'] . '?add=1');
                echo "<script>
	window.location= " . $_POST['referurl'] . "'?add=1';
	</script>";
                exit;
            } else {
                $hasError = 1;
            }

        }
    }

}

?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | کیف پول من</title>
    <?php include("root-head.php"); ?>
    <style>
        a.active-type {
            background: #3d94fb !important;
            color: #fff !important;
            border: 2px solid transparent !important;
        }
        .plan-t2{
            border-radius: 3px;
            width: 212px;
            display: inline-block;
            margin-left: 5px;
            font-size: 15px;
            text-align: center;
            padding: 7px 13px;
            background: transparent;
            color: #3d94fb;
            border: 2px solid #5867dd;
        }
        .selected-plan-form {
            background: #f9f9fc;
            width: 96%;
            margin: 0px auto;
            margin-top: 15px;
            border: 2px solid #b5bcdf;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        @media only screen and (max-width: 520px) {
            .plan-t2 {
                margin-bottom: 12px;
            }

            .select-plan-box {
                height: 177px;
            }

        }

    </style>
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
                                    کبف پول من
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

                            <!--Begin:: App Aside-->
                            <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">
                                <!--begin:: Widgets/Applications/User/Profile1-->
                                <div class="kt-portlet kt-portlet--height-fluid-">
                                    <div class="kt-portlet__head  kt-portlet__head--noborder">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__body kt-portlet__body--fit-y">
                                        <!--begin::Widget -->
                                        <div class="kt-widget kt-widget--user-profile-1">
                                            <div class="kt-widget__head">
                                                <div class="kt-widget__media">
                                                    <?php if ($fetch_member['img'] != null) {
                                                        echo '<img class="" alt="Pic" src="../Attachment/img/members/' . $fetch_member['img'] . '"/>';
                                                    } else {
                                                        echo '<span class="kt-header__topbar-icon kt-header__topbar-icon--brand"><b>' . substr($fetch_member["firstname"], 0, 2) . '</b></span>';
                                                    } ?>
                                                </div>
                                                <div class="kt-widget__content">
                                                    <div class="kt-widget__section">
                                                        <a href="#" class="kt-widget__username">
                                                            <?php
                                                            if ($fetch_member['active'] === 0) {
                                                                echo '<i class="flaticon2-correct kt-font-warning mr-2"></i>';
                                                            } elseif ($fetch_member['active'] === 1) {
                                                                echo '<i class="flaticon2-correct kt-font-success mr-2"></i>';
                                                            }

                                                            echo $fetch_member["firstname"] . ' ' . $fetch_member["lastname"];

                                                            ?>

                                                        </a>
                                                        <span class="kt-widget__subtitle">
                                                            <?php
                                                            $ex = explode("@", $fetch_member["email"]);
                                                            echo $ex[0];
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-widget__body">
                                                <div class="kt-widget__content">
                                                    <p class="kt-section__info">
                                                        وضعیت پروفایل شما: <strong><?php echo $fetch_member['progress']; ?>%</strong>
                                                    </p>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar kt-bg-primary" role="progressbar" style="width: <?php echo $fetch_member['progress']; ?>%;" aria-valuenow="<?php echo $fetch_member['progress']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <br>
                                                    <div class="kt-widget__info">
                                                        <span class="kt-widget__label">ایمیل:</span>
                                                        <a href="#"
                                                           class="kt-widget__data"><?php echo $fetch_member["email"]; ?></a>
                                                    </div>
                                                    <div class="kt-widget__info">
                                                        <span class="kt-widget__label">شماره تماس:</span>
                                                        <a href="#"
                                                           class="kt-widget__data"><?php echo $fetch_member["cellphone"]; ?></a>
                                                    </div>
                                                    <div class="kt-widget__info">
                                                        <span class="kt-widget__label">آخرین ip:</span>
                                                        <span class="kt-widget__data"><?php echo $fetch_member["last_ip"]; ?></span>
                                                    </div>
                                                </div>
                                                <div class="kt-widget__items">
                                                    <a href="my_profile.php"
                                                       class="kt-widget__item">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon id="Bound" points="0 0 24 0 24 24 0 24"/>
        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
              id="Shape" fill="#000000" fill-rule="nonzero"/>
        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
              id="Path" fill="#000000" opacity="0.3"/>
    </g>
</svg>                            </span>
                            <span class="kt-widget__desc">
                                پروفایل کاربری
                            </span>
                        </span>
                                                    </a>
                                                    <a href="msg_inbox.php"
                                                       class="kt-widget__item">
                                                        <span class="kt-widget__section">
                                                            <span class="kt-widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                                        <path d="M22,15 L22,19 C22,20.1045695 21.1045695,21 20,21 L4,21 C2.8954305,21 2,20.1045695 2,19 L2,15 L6.27924078,15 L6.82339262,16.6324555 C7.09562072,17.4491398 7.8598984,18 8.72075922,18 L15.381966,18 C16.1395101,18 16.8320364,17.5719952 17.1708204,16.8944272 L18.118034,15 L22,15 Z" id="Combined-Shape" fill="#000000"/>
                                                                        <path d="M2.5625,13 L5.92654389,7.01947752 C6.2807805,6.38972356 6.94714834,6 7.66969497,6 L16.330305,6 C17.0528517,6 17.7192195,6.38972356 18.0734561,7.01947752 L21.4375,13 L18.118034,13 C17.3604899,13 16.6679636,13.4280048 16.3291796,14.1055728 L15.381966,16 L8.72075922,16 L8.17660738,14.3675445 C7.90437928,13.5508602 7.1401016,13 6.27924078,13 L2.5625,13 Z" id="Path" fill="#000000" opacity="0.3"/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <span class="kt-widget__desc">
                                                                پیام های من
                                                            </span>
                                                        </span>
                                                    </a>
                                                    <a href="personal_information.php" class="kt-widget__item  ">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
              id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
              id="Mask-Copy" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg>                            </span>
                            <span class="kt-widget__desc">
                                اطلاعات شخصی
                            </span>
                        </span>
                                                    </a>
                                                    <a href="change_password.php" class="kt-widget__item">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect id="bound" x="0" y="0" width="24" height="24"/>
        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
              id="Path-50" fill="#000000" opacity="0.3"/>
        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
              id="Mask" fill="#000000" opacity="0.3"/>
        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
              id="Mask-Copy" fill="#000000" opacity="0.3"/>
    </g>
</svg>                            </span>
                            <span class="kt-widget__desc">
                                تغییر رمز عبور
                            </span>
                        </span>
                                                    </a>
                                                    <a href="my_wallet.php" class="kt-widget__item  kt-widget__item--active">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                        <circle id="Oval-47" fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                                        <rect id="Rectangle-162" fill="#000000" opacity="0.3"
                                              transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) "
                                              x="3" y="3" width="18" height="7" rx="1"/>
                                        <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z"
                                              id="Combined-Shape" fill="#000000"/>
                                    </g>
                                </svg>
                            </span>
                            <span class="kt-widget__desc">
                                کیف پول من
                            </span>
                        </span>
                                                    </a>
                                                    <a href="user_settings.php" class="kt-widget__item ">
                        <span class="kt-widget__section">
                            <span class="kt-widget__icon">

                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                        <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z"
                                              id="Combined-Shape" fill="#000000"/>
                                        <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z"
                                              id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                            <span class="kt-widget__desc">
                                تنظیمات
                            </span>
                        </span>
                                                    </a>
                                                    <a href="my_activity.php"
                                                       class="kt-widget__item">
                                                        <span class="kt-widget__section">
                                                            <span class="kt-widget__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                                        <path d="M14.2330207,14.3666907 L16.3111786,18.8233147 C16.4278814,19.0735846 16.3196038,19.3710749 16.0693338,19.4877777 L14.2567182,20.3330142 C14.0064483,20.449717 13.708958,20.3414394 13.5922552,20.0911694 L11.4668267,15.5331733 L8.85355339,18.1464466 C8.7597852,18.2402148 8.63260824,18.2928932 8.5,18.2928932 C8.22385763,18.2928932 8,18.0690356 8,17.7928932 L8,5.13027585 C8,5.00589283 8.04636089,4.88597544 8.13002996,4.79393946 C8.31578343,4.58961065 8.63200759,4.57455235 8.8363364,4.76030582 L18.1424309,13.2203917 C18.2368163,13.3061967 18.2948385,13.424831 18.3046218,13.5520135 C18.3258009,13.8273425 18.1197718,14.0677099 17.8444428,14.088889 L14.2330207,14.3666907 Z" id="Combined-Shape" fill="#000000"/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            <span class="kt-widget__desc">
                                                                فعالیت های من
                                                            </span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Widget -->
                                    </div>
                                </div>
                                <!--end:: Widgets/Applications/User/Profile1-->

                            </div>
                            <!--End:: App Aside-->

                            <!--Begin:: App Content-->

                            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 order-lg-12 order-xl-12">
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        مشخصات کیف پول من
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="kt-heading kt-heading--md" style="margin-bottom: 23px;width: 96%;margin: 0px auto;margin-top: 10px;">
                                                <div class="alert alert-dark" role="alert" style="background: #5867dd;border: 1px solid #5867dd;">
                                                    <div class="alert-text">از طریق این بخش میتوانید کیف پول های خود را مدیریت کنید</div>
                                                </div>
                                            </div>

                                            <div class="select-plan-box" style="border: 2px solid #b5bcdf;padding: 10px;margin: 7px;background: #f9f9fc;border-radius: 5px;width: 96%;margin: 0px auto;">
                                                <div class="p30web" style="font-size: 16px;padding-top: 5px;">کیف پول خود را انتخاب کنید : </div>
                                                <div class="box" style="height: 50px;margin-top: 17px;">
                                                    <a href="https://www.irandogebank.com/user/my_wallet.php?wallet=dog" class="plan-t2 <?php echo ($walletSelected == "dog") ? 'active-type' : ''; ?>">مشاهده کیف پول دوج کوین</a>
                                                    <a href="https://www.irandogebank.com/user/my_wallet.php?wallet=dollar" class="plan-t2 <?php echo ($walletSelected == "dollar") ? 'active-type' : ''; ?>">مشاهده کیف پول دلاری</a>
                                                </div>
                                            </div>

                                            <div class="selected-plan-form">

                                                <?php if($walletSelected == "dog"): ?>
                                                    <!--begin::Form-->
                                                    <form class="kt-form" id="form_deposit" method="post">
                                                        <?php
                                                        if ($fetch_member['wallet'] != null && is_null($fetch_admin)) {
                                                            ?>
                                                            <div class="kt-portlet__body">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <label>آدرس کیف پول دوج کوین شما :</label>
                                                                    <span class="form-text text-muted" style="margin-bottom: 6px;">در زیر میتوانید آدرس کیف پول دوج کوین خود را مشاهده کنید ، در صورتی که میخواهید آن را تغییر دهید میتوانید از گزینه ویرایش کیف پول استفاده نمایید.</span>
                                                                    <div id="kt_clipboard_4"
                                                                         style="border: 4px solid #eaeaea; padding: 10px;"><?php echo $fetch_member['wallet']; ?></div>
                                                                    <div class="kt-space-10"></div>
                                                                </div>
                                                            </div>
                                                            <div class="kt-portlet__foot">
                                                                <input type="hidden" name="hash" value="<?php echo encrypt($fetch_member['id'], $fetch_member['password']); ?>">
                                                                <div class="kt-form__actions">
                                                                    <button type="submit" id="change_wallet_request" class="btn btn-primary">ویرایش کیف پول دوج کوین</button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }

                                                        else if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0 && $fetch_member['wallet'] != null)
                                                        {
                                                            ?>

                                                            <div class="kt-portlet__body">
                                                                <?php
                                                                if ($hasError === 1) {
                                                                    ?>
                                                                    <div class="form-group form-group-last ">
                                                                        <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                                            <div class="alert-icon"><i class="flaticon-warning"></i>
                                                                            </div>
                                                                            <div class="alert-text">
                                                                                <?php echo $val->displayErrors(); ?>
                                                                            </div>
                                                                            <div class="alert-close">
                                                                                <button type="button" class="close" data-dismiss="alert"
                                                                                        aria-label="Close">
                                                                <span aria-hidden="true"><i
                                                                        class="la la-close"></i></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="kt-section kt-section--first">
                                                                    <div class="col-md-6">
                                                                        <label>آدرس کیف پول دوج کوین:</label>
                                                                        <input type="text" name="wallet_addr" class="form-control"
                                                                                value="<?php echo $fetch_member['wallet']; ?>">
                                                                        <span class="form-text text-muted">آدرس کیف پول دوج کوین خود را وارد کنید</span>
                                                                        <button type="submit" class="btn btn-primary" style="margin-top: 12px;padding-right: 20px;padding-left: 20px;">ویرایش حساب</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }

                                                        else {
                                                            ?>
                                                            <div class="kt-portlet__body">
                                                                <?php
                                                                if ($hasError === 1) {
                                                                    ?>
                                                                    <div class="form-group form-group-last ">
                                                                        <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                                            <div class="alert-icon"><i class="flaticon-warning"></i>
                                                                            </div>
                                                                            <div class="alert-text">
                                                                                <?php echo $val->displayErrors(); ?>
                                                                            </div>
                                                                            <div class="alert-close">
                                                                                <button type="button" class="close" data-dismiss="alert"
                                                                                        aria-label="Close">
                                                                <span aria-hidden="true"><i
                                                                        class="la la-close"></i></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="kt-section kt-section--first">
                                                                    <div class="col-md-6">
                                                                        <label>آدرس کیف پول دوج کوین:</label>
                                                                        <input type="text" name="wallet_addr" class="form-control"
                                                                               placeholder="*********">
                                                                        <span class="form-text text-muted">آدرس کیف پول دوج کوین خود را وارد کنید</span>
                                                                        <button type="submit" class="btn btn-primary" style="margin-top: 12px;padding-right: 20px;padding-left: 20px;">افزودن حساب</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </form>
                                                    <!--end::Form-->
                                                <?php endif; ?>

                                                <?php if($walletSelected == "dollar"): ?>
                                                    <!--begin::Form-->
                                                    <form class="kt-form" id="form_deposit_dollar" method="post">
                                                        <?php
                                                        if ($fetch_member['dollar_wallet'] != null && is_null($fetch_admin)) {
                                                            ?>
                                                            <div class="kt-portlet__body">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <label>آدرس کیف پول دلاری شما ( پرفکت مانی) :</label>
                                                                    <span class="form-text text-muted" style="margin-bottom: 6px;">در زیر میتوانید آدرس کیف پول دوج کوین خود را مشاهده کنید ، در صورتی که میخواهید آن را تغییر دهید میتوانید از گزینه ویرایش کیف پول استفاده نمایید.</span>
                                                                    <div id="kt_clipboard_4"
                                                                         style="border: 4px solid #eaeaea; padding: 10px;"><?php echo $fetch_member['dollar_wallet']; ?></div>
                                                                    <div class="kt-space-10"></div>
                                                                </div>
                                                            </div>
                                                            <div class="kt-portlet__foot">
                                                                <input type="hidden" name="hash" value="<?php echo encrypt($fetch_member['id'], $fetch_member['password']); ?>">
                                                                <div class="kt-form__actions">
                                                                    <button type="submit" id="change_dollar_wallet_request" class="btn btn-primary">ویرایش کیف پول</button>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }

                                                        else if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0 && $fetch_member['dollar_wallet'] != null)
                                                        {
                                                            ?>
                                                            <div class="kt-portlet__body">
                                                                <?php
                                                                if ($hasError === 1) {
                                                                    ?>
                                                                    <div class="form-group form-group-last ">
                                                                        <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                                            <div class="alert-icon"><i class="flaticon-warning"></i>
                                                                            </div>
                                                                            <div class="alert-text">
                                                                                <?php echo $val->displayErrors(); ?>
                                                                            </div>
                                                                            <div class="alert-close">
                                                                                <button type="button" class="close" data-dismiss="alert"
                                                                                        aria-label="Close">
                                                                <span aria-hidden="true"><i
                                                                        class="la la-close"></i></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="kt-section kt-section--first">
                                                                    <div class="col-md-12">
                                                                        <label>آدرس کیف پول دلاری ( پرفکت مانی):</label>
                                                                        <input type="text" name="dollar_wallet_addr" class="form-control"
                                                                               placeholder="*********" value="<?php echo $fetch_member['dollar_wallet']; ?>">
                                                                        <span class="form-text text-muted">آدرس کیف پول دلاری خود را وارد کنید، توجه داشته باشید کیف پول فقط پرفکت مانی مورد قبول می باشد.</span>
                                                                        <button type="submit" class="btn btn-primary" style="margin-top: 12px;padding-right: 20px;padding-left: 20px;">ویرایش حساب</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }

                                                        else {
                                                            ?>
                                                            <div class="kt-portlet__body">
                                                                <?php
                                                                if ($hasError === 1) {
                                                                    ?>
                                                                    <div class="form-group form-group-last ">
                                                                        <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                                            <div class="alert-icon"><i class="flaticon-warning"></i>
                                                                            </div>
                                                                            <div class="alert-text">
                                                                                <?php echo $val->displayErrors(); ?>
                                                                            </div>
                                                                            <div class="alert-close">
                                                                                <button type="button" class="close" data-dismiss="alert"
                                                                                        aria-label="Close">
                                                                <span aria-hidden="true"><i
                                                                        class="la la-close"></i></span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="kt-section kt-section--first">
                                                                    <div class="col-md-12">
                                                                        <label>آدرس کیف پول دلاری ( پرفکت مانی):</label>
                                                                        <input type="text" name="dollar_wallet_addr" class="form-control"
                                                                               placeholder="*********">
                                                                        <span class="form-text text-muted">آدرس کیف پول دلاری خود را وارد کنید، توجه داشته باشید کیف پول فقط پرفکت مانی مورد قبول می باشد.</span>
                                                                        <button type="submit" class="btn btn-primary" style="margin-top: 12px;padding-right: 20px;padding-left: 20px;">افزودن حساب</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </form>
                                                    <!--end::Form-->
                                                <?php endif; ?>

                                            </div>


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
    var KTFormControls = {
        init: function () {
            $("#form_my_wallet").validate({
                rules: {
                    wallet_addr: {required: !0}

                }, invalidHandler: function (e, r) {
                    console.log(e);
                    swal.fire({
                        title: "",
                        text: "در ارسال شما خطاهایی وجود دارد. لطفا آنها را اصلاح کنید",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary",
                        onClose: function (e) {
                        }
                    }), e.preventDefault()
                }
            })
        }
    };
    KTUtil.ready(function () {
        KTAppUserProfile.init();
        KTFormControls.init();

        var i = function (t, i, e) {
            var n = $('<div class="kt-alert kt-alert--outline alert alert-' + i + ' alert-dismissible m-3" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="la la-close"></i></button>\t\t\t<span></span>\t\t</div>');
            t.find(".alert").remove(), n.prependTo(t), KTUtil.animateClass(n[0], "fadeIn animated"), n.find("span").html(e)
        };
        $("#change_wallet_request").click(function (t) {
            t.preventDefault();
            var e = $(this), n = $(this).closest("form");
            // console.log(1);
            n.validate({
                rules: {
                    hash:{ required: true}

                }, invalidHandler: function (e, r) {
                    // console.log(e);
                    swal.fire({
                        title: "",
                        text: "در ارسال شما خطاهایی وجود دارد. لطفا آنها را اصلاح کنید",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary",
                        onClose: function (e) {
                        }
                    }), e.preventDefault()
                }
            }),
            n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                n.ajaxSubmit({
                    url: "api/change_wallet_request.php",
                    method: "GET",
                    success: function (t, s, r, a) {

                        if (r.status === 200) {
                            i(n, r.responseJSON.type, r.responseJSON.message);
                            setTimeout(function () {
                                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                            }, 2e3);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        setTimeout(function () {
                            e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", "درخواست با خطا مواجه شده است")
                        }, 2e3);
                    }
                }));
        });
        $("#change_dollar_wallet_request").click(function (t) {
            t.preventDefault();
            var e = $(this), n = $(this).closest("form");
            // console.log(1);
            n.validate({
                rules: {
                    hash:{ required: true}

                }, invalidHandler: function (e, r) {
                    // console.log(e);
                    swal.fire({
                        title: "",
                        text: "در ارسال شما خطاهایی وجود دارد. لطفا آنها را اصلاح کنید",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary",
                        onClose: function (e) {
                        }
                    }), e.preventDefault()
                }
            }),
            n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                n.ajaxSubmit({
                    url: "api/change_dollar_wallet_request.php",
                    method: "GET",
                    success: function (t, s, r, a) {

                        if (r.status === 200) {
                            i(n, r.responseJSON.type, r.responseJSON.message);
                            setTimeout(function () {
                                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                            }, 2e3);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        setTimeout(function () {
                            e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", "درخواست با خطا مواجه شده است")
                        }, 2e3);
                    }
                }));
        });
    });
</script>
<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>