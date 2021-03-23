<?php
require_once('../../checklogin.php');


$uid = $_SESSION['user_id'];


$db->where("id", $uid);
$cols = array("*");
$fetch_users = $db->getOne("`users`", $cols);
$fetch_users_count = $db->count;


?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | ویرایش پروفایل</title>

</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- begin:: Page -->
<!-- begin:: Header Mobile -->
<?php include($nav_path . "Components/mobile-header.php"); ?>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <!-- begin:: Aside -->
        <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>

        <?php include($nav_path . "Components/main-sidebar.php"); ?>
        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
            <?php include($nav_path . "Components/toolbar.php"); ?>
            <!-- end:: Header -->
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <!-- begin:: Subheader -->
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">

                            <h3 class="kt-subheader__title">
                                ویرایش پروفایل</h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="users.php" class="kt-subheader__breadcrumbs-link">
                                    کاربران </a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

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
                            <div class="kt-portlet ">
                                <div class="kt-portlet__head  kt-portlet__head--noborder">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                        </h3>
                                    </div>
                                    <div class="kt-portlet__head-toolbar">
                                        <a href="#" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                           data-toggle="dropdown">
                                            <i class="flaticon-more-1"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="kt-portlet__body kt-portlet__body--fit-y">
                                    <!--begin::Widget -->
                                    <div class="kt-widget kt-widget--user-profile-1">
                                        <div class="kt-widget__head">
                                            <div class="kt-widget__media">
                                                <?php
                                                if ($fetch_users['image'] != null) {
                                                    echo '<img src="../../../Attachment/img/users/' . $fetch_users['image'] . '" alt="' . $fetch_users['name'] . '">';
                                                } else {
                                                    echo '<div class="kt-badge kt-badge--xl kt-badge--primary"><span>' . substr($fetch_users['name'], 0, 2) . '</span></div>';
                                                }
                                                ?>
                                            </div>
                                            <div class="kt-widget__content">
                                                <div class="kt-widget__section">
                                                    <a href="#" class="kt-widget__username">
                                                        <?php echo $fetch_users['name']; ?>
                                                        <i class="flaticon2-correct kt-font-success"></i>
                                                    </a>
                                                    <span class="kt-widget__subtitle">
                            مدیر سایت
                        </span>
                                                </div>

                                                <div class="kt-widget__action">
                                                    <button type="button" class="btn btn-info btn-sm">گفت گو</button>&nbsp;
                                                    <button type="button" class="btn btn-success btn-sm">دنبال کردن
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-widget__body">
                                            <div class="kt-widget__content">
                                                <div class="kt-widget__info">
                                                    <span class="kt-widget__label">ایمیل:</span>
                                                    <a href="#"
                                                       class="kt-widget__data"><?php echo $fetch_users['email']; ?></a>
                                                </div>
                                                <div class="kt-widget__info">
                                                    <span class="kt-widget__label">موبایل:</span>
                                                    <a href="#"
                                                       class="kt-widget__data"><?php echo $fetch_users['mobile']; ?></a>
                                                </div>
                                                <div class="kt-widget__info">
                                                    <span class="kt-widget__label">آخرین ورود:</span>
                                                    <span class="kt-widget__data"><?php echo $fetch_users['lastlogin']; ?></span>
                                                </div>
                                                <div class="kt-widget__info">
                                                    <span class="kt-widget__label">آخرین ip:</span>
                                                    <span class="kt-widget__data"><?php echo $fetch_users['lastip']; ?></span>
                                                </div>
                                            </div>
                                            <div class="kt-widget__items">
                                                <a href="<?php echo $nav_path; ?>Modules/Users/update_my_profile.php"
                                                   class="kt-widget__item kt-widget__item--active">
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
                                اطلاعات حساب
                            </span>
                        </span>
                                                </a>
                                                <?php
                                                if(in_array("reset_my_pass", $privilegeslist)) {
                                                    ?>
                                                    <a href="reset_my_pass.php" class="kt-widget__item ">
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
                                تفییر رمز عبور
                            </span>
                        </span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
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
                                <div class="col-xl-12">
                                    <div class="kt-portlet">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <h3 class="kt-portlet__head-title">اطلاعات حساب کاربری شما
                                                    <small>بروز رسانی اطلاعات حساب</small>
                                                </h3>
                                            </div>
                                        </div>

                                        <form class="kt-form kt-form--label-right">
                                            <div class="kt-portlet__body">
                                                <div class="kt-section kt-section--first">
                                                    <div class="kt-section__body">
                                                        <div class="row">
                                                            <label class="col-xl-3"></label>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <h3 class="kt-section__title kt-section__title-sm">
                                                                    اطلاعات کاربر:</h3>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">عکس</label>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <div class="kt-avatar kt-avatar--outline kt-avatar--circle"
                                                                     id="kt_apps_user_add_avatar">
                                                                    <div class="kt-avatar__holder"
                                                                         style="background-image: url(<?php echo '../../../Attachment/img/users/' . $fetch_users['image']; ?>);"></div>
                                                                    <label class="kt-avatar__upload"
                                                                           data-toggle="kt-tooltip" title=""
                                                                           data-original-title="Change avatar">
                                                                        <i class="fa fa-pen"></i>
                                                                        <input type="file" name="profile_avatar"
                                                                               accept=".png, .jpg, .jpeg">
                                                                    </label>
                                                                    <span class="kt-avatar__cancel"
                                                                          data-toggle="kt-tooltip" title=""
                                                                          data-original-title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">نام</label>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <input class="form-control" type="text" value="<?php echo $fetch_users['name']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <label class="col-xl-3"></label>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <h3 class="kt-section__title kt-section__title-sm">
                                                                    اطلاعات تماس:</h3>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">شماره تماس</label>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span
                                                                                class="input-group-text"><i
                                                                                    class="la la-phone"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                           value="<?php echo $fetch_users['mobile']; ?>"
                                                                           placeholder="موبایل"
                                                                           aria-describedby="basic-addon1">
                                                                </div>
                                                                <span class="form-text text-muted">شماره تماس میتواند هم شماره همراه و یا ثابت باشد.</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">آدرس ایمیل</label>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span
                                                                                class="input-group-text"><i
                                                                                    class="la la-at"></i></span></div>
                                                                    <input type="text" class="form-control"
                                                                           value="<?php echo $fetch_users['email']; ?>"
                                                                           placeholder="ایمیل"
                                                                           disabled
                                                                           readonly
                                                                           aria-describedby="basic-addon1">
                                                                </div>
                                                                <span class="form-text text-muted">شما قادر به تغییر ایمیل خود نیستید.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="kt-portlet__foot">
                                                <div class="kt-form__actions">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xl-3">
                                                        </div>
                                                        <div class="col-lg-9 col-xl-9">
                                                            <button type="submit" class="btn btn-success">ارسال</button>&nbsp;
                                                            <button type="reset" class="btn btn-secondary">لغو
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
            <!-- begin:: Footer -->
            <?php include($nav_path . "Components/footer.php"); ?>
            <!-- end:: Footer -->            </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Quick Panel -->
<?php include($nav_path . "Components/quick-panel-sidebar.php"); ?>
<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- end::Scrolltop -->
<!-- begin::Sticky Toolbar -->

<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="<?php echo $nav_path; ?>assets/vendors/global/vendors.bundle.js" type="text/javascript"></script>
<script src="<?php echo $nav_path; ?>assets/js/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->


<!--begin::Page Vendors(used by this page) -->
<script src="<?php echo $nav_path; ?>assets/vendors/custom/datatables/datatables.bundle.js"
        type="text/javascript"></script>
<!--end::Page Vendors -->


<!--begin::Page Scripts(used by this page) -->
<script type="text/javascript">

</script>

<!--end::Page Scripts -->
</body>
</html>