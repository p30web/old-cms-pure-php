<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');

$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('ایمیل')->value($_POST['email'])->required();
    $val->name('نام کامل')->value($_POST['name'])->required();
    $val->name('رمز عبور')->value($_POST['password'])->required();
    $val->name('تکرار رمز عبور')->value($_POST['confrimpassword'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();

    if ($val->isSuccess()) {
        $imguploaded = 0;
        if($_FILES['image']) {
            $imgName = 'avatar' . time();
            $handle = new upload($_FILES['image']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $imgName;
                $handle->image_resize = true;
                $handle->image_x = 170;
                $handle->image_y = 170;
                $handle->image_ratio_crop = true;
                $handle->jpeg_quality = 200;
                $handle->image_ratio = true;
                $handle->dir_chmod = 0777;
                $handle->file_max_size = '5242880'; // 5mb
                $handle->allowed = array('image/*');
                $handle->image_convert = 'jpg';
                $handle->process('../../../Attachment/img/users/');
                if ($handle->processed) {
//            $handle->clean();
                    $imguploaded = 1;
                    //image upload
                    $handle2 = new upload($handle->file_dst_pathname);
                    if ($handle2->uploaded) {
                        $handle2->file_new_name_body = $imgName;
                        $handle2->image_resize = true;
                        $handle2->image_x = 50;
                        $handle2->image_y = 50;
                        $handle2->image_ratio_crop = true;
                        $handle2->jpeg_quality = 200;
                        $handle2->image_ratio = true;
                        $handle2->dir_chmod = 0777;
                        $handle2->file_max_size = '5242880'; // 5mb
                        $handle2->allowed = array('image/*');
                        $handle2->image_convert = 'jpg';
                        $handle2->process('../../../Attachment/img/users/thumbs/');
                        if ($handle2->processed) {
//                    $handle2->clean();
                            $imguploaded = 2;
                        } else {
                            echo 'error : ' . $handle2->error;
                        }
                    }

                } else {
                    echo 'error : ' . $handle->error;
                }
            }
        }

        $email = GetSQLValueString($_POST['email'], 'def');
        $name = GetSQLValueString($_POST['name'], 'def');
        $cellphone = GetSQLValueString($_POST['cellphone'], 'def');
        $img = ($imguploaded > 0) ? $imgName . '.jpg' : null;
        $password = sha1(md5(GetSQLValueString($_POST['password'], 'def')));
        $portalid = GetSQLValueString($_POST['portalid'], 'def');
        $status = GetSQLValueString($_POST['status'], 'def');

        $insert_array = array(
            "email" => $email,
            "name" => $name,
            "mobile" => $cellphone,
            "image" => $img,
            "pass" => $password,
            "token" => '0',
            "level" => 1,
            "portalid" => $portalid,
            "create_at" => jdate('Y/m/d H:i:s'),
            "modified_at" => jdate('Y/m/d H:i:s'),
            "status" => $status,
        );
        if ($db->insert("users", $insert_array)) {
            header('Location: ' . $_POST['referurl'] . '?add=1');
            echo "<script>
	window.location= " . $_POST['referurl'] . "'?add=1';
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
    <title>Rahaaa | افزودن کاربر جدید</title>
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
                                افزودن کاربر جدید </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="users.php" class="kt-subheader__breadcrumbs-link">
                                    مدیریت کاربران </a>
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
                                            مشخصات کاربر جدید
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_user_add" method="post"
                                      action="user_add.php" enctype="multipart/form-data">
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
                                        <?php
                                        if ($_GET['add'] == 1) {
                                            ?>
                                            <div class="form-group form-group-last ">
                                                <div class="alert alert-success" role="alert" id="kt_form_1_msg">
                                                    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
                                                    <div class="alert-text">
                                                        رکورد شما با موفقیت ثبت شد.
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
                                        <div class="form-group row">
                                            <div class="col-lg-4 form-group-sub">
                                                <label>ایمیل:</label>
                                                <input type="text" name="email" class="form-control"
                                                       placeholder="ایمیل را وارد کنید">
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                                <label class="">تلفن همراه:</label>
                                                <input type="text" name="cellphone" class="form-control"
                                                       placeholder="تلفن همراه را وارد کنید">
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                                <label class="">نام:</label>
                                                <input type="text" name="name" class="form-control"
                                                       placeholder="نام را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>رمز عبور:</label>
                                                <div class="kt-input-icon">
                                                    <input type="password" name="password" id="password"
                                                           class="form-control"
                                                           placeholder="رمز عبور را وارد کنید">
                                                    <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i
                                                                class="la la-lock"></i></span></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>تکرار رمز عبور:</label>
                                                <div class="kt-input-icon">
                                                    <input type="password" name="confrimpassword" class="form-control"
                                                           placeholder="تکرار رمز عبور را وارد کنید">
                                                    <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i
                                                                class="la la-lock"></i></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">پرتال:</label>
                                                <select class="form-control kt-select2" id="portalid" name="portalid">
                                                    <option value="" selected>-- پرتال را انتخاب کنید --</option>

                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);
                                                    $query_rssettings = sprintf("SELECT `id`,`name` FROM `settings` ");
                                                    $rssettings = mysqli_query($cn, $query_rssettings) or die(mysqli_error($cn));
                                                    $row_rssettings = mysqli_fetch_assoc($rssettings);
                                                    $totalRows_rssettings = mysqli_num_rows($rssettings);
                                                    if ($totalRows_rssettings > 0) {

                                                        do {
                                                            ?>
                                                            <option value="<?php echo $row_rssettings['id']; ?>"><?php echo $row_rssettings['name']; ?></option>
                                                            <?php
                                                        } while ($row_rssettings = mysqli_fetch_assoc($rssettings));
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>عکس:</label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="customFile">انتخاب کنید</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-last row">
                                            <div class="col-lg-4 form-group-sub">
                                                <label>وضعیت:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" checked value="1"> فعال
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" value="0"> غیر فعال
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary">ثبت رکورد جدید
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
                <!-- end:: Content -->
            </div>

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
    var KTSelect2 = {
        init: function () {
            $("#portalid").select2({placeholder: "پرتال را انتخاب کنید"})
        }
    };

    var KTFormControls = {
        init: function () {
            $("#form_user_add").validate({
                rules: {
                    email: {required: !0, email: !0},
                    name: {required: !0},
                    status: {required: !0},
                    password: {required: !0},
                    portalid: {required: !0},
                    confrimpassword: {required: !0, equalTo: "#password"},
                    image: {
                        accept: "image/*",
                    }

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
        KTSelect2.init();

    });

</script>
<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->

</html>