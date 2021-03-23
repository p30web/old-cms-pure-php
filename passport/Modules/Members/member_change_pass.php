<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');


$id = decrypt($_GET['id'], session_id() . "mem");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_members = $db->getOne("`members`", $cols);
$fetch_members_count = $db->count;


$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('رمز عبور')->value($_POST['password'])->required();
    $val->name('تکرار رمز عبور')->value($_POST['confrimpassword'])->required();

    if ($val->isSuccess()) {

        $password = sha1(md5(GetSQLValueString($_POST['password'], 'def')));

        $db->where("id", $id);

        $insert_array = array(

            "password" => $password,
            "modified_at" => jdate('Y/m/d H:i:s'),
        );
        if ($db->update("members", $insert_array)) {
            header('Location: ' . $_POST['referurl'] . '');
            echo "<script>
	window.location= " . $_POST['referurl'] . ";
	</script>";
            exit;
        }
    } else {
        $hasError = 1;
    }
}

?>
<!DOCTYPE html>
<html lang="en" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head>
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | تغییر رمز عبور</title>
</head>
<!-- end::Head -->

<!-- begin::Body -->
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
                                تغییر رمز عبور </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="members.php" class="kt-subheader__breadcrumbs-link">
                                    مدیریت اعضاء </a>
                                <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--begin::Portlet-->
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            تغییر رمز
                                            عبور <?php echo $fetch_members['firstname'] . ' ' . $fetch_members['lastname']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_mem_changepass" method="post"
                                      action="member_change_pass.php?id=<?php echo $_GET['id']; ?>"
                                      enctype="multipart/form-data">
                                    <div class="kt-portlet__body">
                                        <?php
                                        if ($hasError === 1) {
                                            ?>
                                            <div class="form-group form-group-last ">
                                                <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
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
                                        <div class="col-md-8">
                                            <div class="form-group row">
                                                <label class="col-3 col-form-label">رمز عبور</label>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                                        class="la la-lock"></i></span></div>
                                                        <input type="password" name="password" id="password" class="form-control"
                                                               placeholder="رمز عبور را وارد کنید"
                                                               aria-describedby="basic-addon1">
                                                    </div>
                                                    <span class="form-text text-muted">رمز عبور جدید را وارد کنید</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-3 col-form-label">تکرار رمز عبور</label>
                                                <div class="col-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                                        class="la la-lock"></i></span></div>
                                                        <input type="password" name="confrimpassword" id="confrimpassword" class="form-control"
                                                               placeholder="تکرار رمز عبور را وارد کنید"
                                                               aria-describedby="basic-addon1">
                                                    </div>
                                                    <span class="form-text text-muted">رمز عبور جدید را تکرار کنید</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="referurl"
                                           value="<?php echo $_SERVER['HTTP_REFERER']; ?> "/>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary">بروزرسانی رمز عبور
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Portlet-->

                        </div>
                    </div>
                </div>
                <!-- end:: Content -->                </div>

            <!-- begin:: Footer -->
            <?php include($nav_path . "Components/footer.php"); ?>
            <!-- end:: Footer -->            </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Quick Panel -->
<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- begin::Global Config(global config for global JS sciprts) -->
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
<script type="text/javascript">

    var KTFormControls = {
        init: function () {
            $("#form_mem_changepass").validate({
                rules: {
                    password: {required: !0},
                    confrimpassword: {required: !0, equalTo: "#password"}

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
    jQuery(document).ready(function () {
        KTFormControls.init();

    });

</script>
<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->

</html>