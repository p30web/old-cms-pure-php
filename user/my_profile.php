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
    <title>ایران دوج | پروفایل کاربری</title>
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
                                    پروفایل من
                                </h3>

                                <span class="kt-subheader__separator kt-hidden"></span>
                                <div class="kt-subheader__breadcrumbs">
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
                                                       class="kt-widget__item kt-widget__item--active">
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
                                                    <a href="personal_information.php" class="kt-widget__item ">
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

                                                    <a href="change_password.php" class="kt-widget__item ">
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
                                                    <a href="my_wallet.php" class="kt-widget__item">
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
                                    <div class="col-xl-6">
                                        <!--begin:: Widgets/Order Statistics-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        وضعیت سرمایه گذاری
                                                    </h3>
                                                </div>

                                            </div>
                                            <div class="kt-portlet__body kt-portlet__body--fluid">
                                                <div class="kt-widget12">
                                                    <?php
                                                   $db->where("member_id", $fetch_member['id']);
                                                   $fetch_active_plan = $db->get("active_investment_plan", null);
                                                    $totalRows_active_investment_plan = $db->count;

                                                    if ($totalRows_active_investment_plan > 0) {
                                                        print_r($row_active_investment_plan);
                                                        ?>
                                                        <div class="kt-widget12__content">
                                                            <div class="kt-widget12__item" style="display:none;">
                                                                <div class="kt-widget12__info">
                                                                    <span class="kt-widget12__desc">کل سرمایه گذاری</span>
                                                                    <span class="kt-widget12__value">
                                                                        <?php
                                                                        $all_pay=0;
                                                                        foreach ($fetch_active_plan as $value){
                                                                            $all_pay += $value['price'];
                                                                        }
                                                                        echo '<span class="kt-font-primary">'.$all_pay.' DOGE</span>';
                                                                        ?>
                                                                    </span>
                                                                </div>

                                                                <div class="kt-widget12__info">
                                                                    <span class="kt-widget12__desc">کل سود حاصل</span>
                                                                    <span class="kt-widget12__value">
                                                                        <?php
                                                                        $all_profit=0;
                                                                        foreach ($fetch_active_plan as $value){
                                                                            $all_profit += ($value['interest_rate']*$value['price']);
                                                                        }
                                                                        echo '<span class="kt-font-primary">'.$all_profit.' DOGE</span>';
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="kt-widget12__item">
                                                                <div class="kt-widget12__info">
                                                                    <span class="kt-widget12__desc">کل پلن ها</span>
                                                                    <span class="kt-widget12__value kt-font-info">
                                                                        <?php
                                                                        echo $totalRows_active_investment_plan;
                                                                        ?>
                                                                    </span>
                                                                </div>

                                                                <div class="kt-widget12__info">
                                                                    <span class="kt-widget12__desc">پلن های فعال</span>
                                                                    <span class="kt-widget12__value kt-font-info">
                                                                        <?php
                                                                        $aactiveplancount = 0;
                                                                        foreach ($fetch_active_plan as $value){
                                                                            if($value['status'] === '1'){
                                                                                $aactiveplancount ++;
                                                                            }
                                                                        }
                                                                        echo $aactiveplancount;
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="kt-widget12__chart" style="height:250px;">
                                                            <canvas id="kt_chart_order_statistics"></canvas>
                                                        </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                            <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                                <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                                    کاربر گرامی!
                                                                    <br>شما پلنی فعال نکرده اید
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end:: Widgets/Order Statistics-->            </div>
                                    <div class="col-xl-6">
                                        <!--begin:: Widgets/Tasks -->
                                        <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        زیر مجموعه های من
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="kt_widget4_tab1_content">
                                                        <div class="kt-widget4">
                                                            <?php
                                                        mysqli_select_db($cn, $database_cn);

                                                            $fetch_admin = $db->get("admin_login");

                                                            if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                                $query_member_subs= sprintf("SELECT * FROM `members` WHERE `parent_id`= %d ORDER BY `create_at` DESC LIMIT 0,10", $fetch_admin[0]['admin_id']);

                                                            }else{
                                                                $query_member_subs= sprintf("SELECT * FROM `members` WHERE `parent_id`= %d ORDER BY `create_at` DESC LIMIT 0,10", $fetch_member['id']);
                                                            }

                                                        $member_subs = mysqli_query($cn, $query_member_subs) or die(mysqli_error($cn));
                                                        $row_member_subs = mysqli_fetch_assoc($member_subs);
                                                        $totalRows_member_subs = mysqli_num_rows($member_subs);

                                                        if ($totalRows_member_subs > 0) {
                                                            do {
                                                                ?>

                                                                <div class="kt-widget4__item">
                                                                    <div class="kt-widget4__pic kt-widget4__pic--pic">
                                                                        <?php if ($row_member_subs['img'] != null) {
                                                                            echo '<div class="kt-widget__media kt-hidden-"><img src="../Attachment/img/members/' . $row_member_subs['img'] . ' " alt="' . $fetch_member['firstname'] . '"></div>';
                                                                        } else {
                                                                            echo '<span class="kt-userpic kt-userpic--info "><span>' . substr($row_member_subs["firstname"], 0, 2) . '</span></span>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="kt-widget4__info">
                                                                        <a href="#" class="kt-widget4__username">
                                                                           <?php echo $row_member_subs['firstname'].' '.$row_member_subs['lastname']; ?>
                                                                        </a>
                                                                        <p class="kt-widget4__text">
                                                                            تاریخ عضویت:<?php echo $row_member_subs['create_at'];?>
                                                                        </p>
                                                                    </div>
                                                                    <?php
                                                                    if($row_member_subs['status'] === '1'){
                                                                        echo '<span class="btn btn-label-success">فعال</span>';
                                                                    }else{
                                                                        echo '<span class="btn btn-label-danger">غیر فعال</span>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                } while($row_member_subs = mysqli_fetch_assoc($member_subs));
                                                            }else{
                                                            ?>
                                                                <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                                    <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                                        <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                                            کاربر گرامی!
                                                                            <br>شما زیر مجوعه ای ندارید
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end:: Widgets/Tasks -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <!--begin:: Widgets/Notifications-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        رویداد ها
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);

                                                    $fetch_admin = $db->get("admin_login");

                                                    if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                        $query_notification_type= sprintf("SELECT notification_type.id, notification_type.name FROM `notification_queue` INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d ", $fetch_admin[0]['admin_id']);

                                                    }else{
                                                        $query_notification_type= sprintf("SELECT notification_type.id, notification_type.name FROM `notification_queue` INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d ", $fetch_member['id']);
                                                    }

                                                    $notification_type= mysqli_query($cn, $query_notification_type) or die(mysqli_error($cn));
                                                    $row_notification_type = mysqli_fetch_assoc($notification_type);
                                                    $totalRows_notification_type = mysqli_num_rows($notification_type);

                                                    if($totalRows_notification_type > 0) {
                                                        ?>
                                                        <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold"
                                                            role="tablist">
                                                            <?php
                                                            $i=0;
                                                            do {

                                                                ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link <?php if($i === 0 ) echo 'active'; ?>" data-toggle="tab"
                                                                       href="#ra-notification-<?php echo $row_notification_type['id']; ?>-tb" role="tab">
                                                                        <?php echo $row_notification_type['name']; ?>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                                $i++;
                                                            } while($row_notification_type = mysqli_fetch_assoc($notification_type));
                                                            ?>
                                                        </ul>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold"
                                                            role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" data-toggle="tab"
                                                                       href="#no_notifications_logs" role="tab">
                                                                        رویداد ها
                                                                    </a>
                                                                </li>
                                                        </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                <div class="tab-content">
                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);

                                                    $fetch_admin = $db->get("admin_login");

                                                    if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                        $query_notification_type= sprintf("SELECT notification_type.id, notification_type.name FROM `notification_queue` INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d ", $fetch_admin[0]['admin_id']);
                                                    }else{
                                                        $query_notification_type= sprintf("SELECT notification_type.id, notification_type.name FROM `notification_queue` INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d ", $fetch_member['id']);
                                                    }
                                                    
                                                    $notification_type= mysqli_query($cn, $query_notification_type) or die(mysqli_error($cn));
                                                    $row_notification_type = mysqli_fetch_assoc($notification_type);
                                                    $totalRows_notification_type = mysqli_num_rows($notification_type);

                                                    if($totalRows_notification_type > 0) {
                                                        $i = 0;
                                                        do{
                                                    ?>
                                                    <div class="tab-pane  <?php if($i === 0 ) echo 'active'; ?>" id="ra-notification-<?php echo $row_notification_type['id']; ?>-tb"
                                                         aria-expanded="true">
                                                        <?php
                                                        mysqli_select_db($cn, $database_cn);
                                                        $fetch_admin = $db->get("admin_login");

                                                        if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                            $query_notification= sprintf("SELECT notification_queue.id AS notification_id, notification_queue.time, notification_queue.icon, notification_queue.status, notification_queue.notification_type_id, notification_type.name AS notification_type_name, notification_message.title FROM `notification_queue` INNER JOIN notification_message ON notification_queue.id = notification_message.notification_id INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d and notification_queue.notification_type_id=%d", $fetch_admin[0]['admin_id'], $row_notification_type['id']);
                                                        }else{
                                                            $query_notification= sprintf("SELECT notification_queue.id AS notification_id, notification_queue.time, notification_queue.icon, notification_queue.status, notification_queue.notification_type_id, notification_type.name AS notification_type_name, notification_message.title FROM `notification_queue` INNER JOIN notification_message ON notification_queue.id = notification_message.notification_id INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d and notification_queue.notification_type_id=%d", $fetch_member['id'], $row_notification_type['id']);
                                                        }
                                                        $notification = mysqli_query($cn, $query_notification) or die(mysqli_error($cn));
                                                        $row_notification = mysqli_fetch_assoc($notification);
                                                        $totalRows_notification = mysqli_num_rows($notification);

                                                        if($totalRows_notification > 0){

                                                        ?>
                                                        <div class="kt-notification">
                                                            <?php
                                                            do{
                                                            ?>
                                                            <a href="#" class="kt-notification__item">
                                                                <div class="kt-notification__item-icon">
                                                                    <?php echo $row_notification['icon']; ?>
                                                                </div>
                                                                <div class="kt-notification__item-details">
                                                                    <div class="kt-notification__item-title">
                                                                        <?php echo $row_notification['title']; ?>
                                                                    </div>
                                                                    <div class="kt-notification__item-time">
                                                                        <?php
                                                                        echo ago_time($row_notification['time']);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <?php
                                                            } while($row_notification = mysqli_fetch_assoc($notification));
                                                            ?>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                        $i++;
                                                    } while($row_notification_type = mysqli_fetch_assoc($notification_type));
                                                    }else{
                                                        ?>
                                                        <div class="tab-pane active" id="no_notifications_logs" role="tabpanel">
                                                            <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                                <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                                    <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                                        کاربر گرامی!
                                                                        <br>رویدادی برای شما وجود ندارد
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end:: Widgets/Notifications-->
                                    </div>
                                    <div class="col-xl-6">
                                        <!--begin:: Widgets/Last Updates-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-portlet__head">
                                                <div class="kt-portlet__head-label">
                                                    <h3 class="kt-portlet__head-title">
                                                        فعالیت های اخیر
                                                    </h3>
                                                </div>

                                            </div>
                                            <div class="kt-portlet__body">
                                                <!--begin::widget 12-->
                                                <div class="kt-timeline-v2">
                                                    <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                                                        <?php
                                                        mysqli_select_db($cn_log, $log_database_cn);

                                                        $fetch_admin = $db->get("admin_login");

                                                        if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                            $query_member_activity= sprintf("SELECT * FROM `member_activity` WHERE `user_id`= %d ORDER BY `time` DESC LIMIT 0,10", $fetch_admin[0]['admin_id']);

                                                        }else{
                                                            $query_member_activity= sprintf("SELECT * FROM `member_activity` WHERE `user_id`= %d ORDER BY `time` DESC LIMIT 0,10", $fetch_member['id']);
                                                        }
                                                        
                                                        $member_activity = mysqli_query($cn_log, $query_member_activity) or die(mysqli_error($cn_log));
                                                        $row_member_activity = mysqli_fetch_assoc($member_activity);
                                                        $totalRows_member_activity = mysqli_num_rows($member_activity);

                                                        if ($totalRows_member_activity > 0) {
                                                            do {
                                                                ?>
                                                                <div class="kt-timeline-v2__item">
                                                                    <span class="kt-timeline-v2__item-time"><?php echo jdate("H:i", $row_member_activity['time']); ?></span>
                                                                    <div class="kt-timeline-v2__item-cricle">
                                                                        <i class="fa fa-genderless kt-font-<?php
                                                                        switch ($row_member_activity['type']) {
                                                                            case 0:
                                                                                echo "dark";
                                                                                break;
                                                                            case 1:
                                                                                echo "primary";
                                                                                break;
                                                                            case 2:
                                                                                echo "success";
                                                                                break;
                                                                            case 3:
                                                                                echo "danger";
                                                                                break;
                                                                            default:
                                                                                echo "warning";
                                                                        }
                                                                        ?>"></i>
                                                                    </div>
                                                                    <div class="kt-timeline-v2__item-text  kt-padding-top-5">
                                                                        <?php echo $row_member_activity['message']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            } while($row_member_activity = mysqli_fetch_assoc($member_activity));
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <!--end::Widget 12-->
                                            </div>
                                        </div>
                                        <!--end:: Widgets/Last Updates-->
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
    KTUtil.ready(function () {
        KTAppUserProfile.init()
    });
</script>
<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>