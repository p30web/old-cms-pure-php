<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');


$id = decrypt($_GET['id'], session_id() . "mnu");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_menus = $db->getOne("`menus`", $cols);
$fetch_smenus_count = $db->count;


$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('آدرس')->value($_POST['url'])->required();
    $val->name('عنوان')->value($_POST['title'])->required();
    $val->name('پرتال')->value($_POST['portalid'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();

    if ($val->isSuccess()) {

        $url = GetSQLValueString($_POST['url'], 'def');
        $parent_id = GetSQLValueString($_POST['parent_id'], 'int');
        $title = GetSQLValueString($_POST['title'], 'def');
        $entitle = sha1(md5(GetSQLValueString($_POST['entitle'], 'def')));
        $sort= GetSQLValueString($_POST['sort'], 'int');
        $style = GetSQLValueString($_POST['style'], 'def');
        $portalid = GetSQLValueString($_POST['portalid'], 'int');
        $status = GetSQLValueString($_POST['status'], 'def');

        $db->where("id", $id);

        $insert_array = array(
            "url" => $url,
            "type" => ($parent_id == 0) ?  '0' : '1',
            "parent_id" => ($parent_id == 0) ? NULL : $parent_id,
            "title" => $title,
            "entitle" => $entitle,
            "sort" => $sort,
            "style" => $style,
            "portalid" => $portalid,
            "modified_at" => jdate('Y/m/d H:i:s'),
            "status" => $status,
        );
        if ($db->update("menus", $insert_array)) {
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
    <title>Rahaaa | ویرایش منو</title>
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
                                ویرایش منو <?php echo $fetch_menus['title']; ?> </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="menus.php" class="kt-subheader__breadcrumbs-link">
                                    مدیریت منو </a>
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
                                            مشخصات منو <?php echo $fetch_menus['title']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_menu_add" method="post"
                                      action="menu_edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
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

                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>عنوان:</label>
                                                <input type="text" name="title" class="form-control"
                                                       value="<?php echo $fetch_menus['title']; ?>"
                                                       placeholder="عنوان را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">نام انگلیسی:</label>
                                                <input type="text" name="entitle" class="form-control"
                                                       value="<?php echo $fetch_menus['entitle']; ?>"
                                                       placeholder="نام انگلیسی را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>آدرس:</label>
                                                <div class="kt-input-icon">
                                                    <input type="text" name="url" id="url"
                                                           class="form-control"
                                                           value="<?php echo $fetch_menus['url']; ?>"
                                                           placeholder="آدرس را وارد کنید">
                                                    <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i
                                                                class="la la-link"></i></span></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>استایل (آیکون):</label>
                                                <div class="kt-input-icon">
                                                    <input type="text" name="style" id="style"
                                                           class="form-control"
                                                           value="<?php echo $fetch_menus['style']; ?>"
                                                           placeholder="استایل (آیکون) را وارد کنید">
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
                                                            <option value="<?php echo $row_rssettings['id']; ?>" <?php if ($row_rssettings['id'] == $fetch_menus['portalid']) { echo 'selected'; } ?>><?php echo $row_rssettings['name']; ?></option>
                                                            <?php
                                                        } while ($row_rssettings = mysqli_fetch_assoc($rssettings));
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">منو والد:</label>
                                                <select class="form-control kt-select2" id="parent_id" name="parent_id">
                                                    <option value="0" selected>-- منو والد را انتخاب کنید --</option>

                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);
                                                    $query_rsmenus = sprintf("SELECT `id`,`title` FROM `menus` ");
                                                    $rsmenus = mysqli_query($cn, $query_rsmenus) or die(mysqli_error($cn));
                                                    $row_rsmenus = mysqli_fetch_assoc($rsmenus);
                                                    $totalRows_rsmenus = mysqli_num_rows($rsmenus);
                                                    if ($totalRows_rsmenus > 0) {

                                                        do {
                                                            ?>
                                                            <option value="<?php echo $row_rsmenus['id']; ?>" <?php if ($row_rsmenus['id'] == $fetch_menus['parent_id']) { echo 'selected'; } ?>><?php echo $row_rsmenus['title']; ?></option>
                                                            <?php
                                                        } while ($row_rsmenus = mysqli_fetch_assoc($rsmenus));
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-last row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>وضعیت:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" <?php if ($fetch_menus['status'] === '1') echo 'checked'; ?> value="1"> فعال
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" <?php if ($fetch_menus['status'] === '0') echo 'checked'; ?> value="0"> غیر فعال
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>مرتب سازی:</label>
                                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input id="sort" type="text"
                                                           class="form-control bootstrap-touchspin-vertical-btn"
                                                           value="<?php echo $fetch_menus['sort']; ?>"
                                                           name="sort" placeholder="0">
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
                                                    <button type="submit" class="btn btn-primary">ویرایش رکورد
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

    var KTKBootstrapTouchspin = {
        init: function () {
            $("#sort").TouchSpin({
                buttondown_class: "btn btn-secondary",
                buttonup_class: "btn btn-secondary",
                verticalbuttons: !0,
                verticalup: '<i class="la la-plus"></i>',
                verticaldown: '<i class="la la-minus"></i>'
            })
        }
    };

    var KTSelect2 = {
        init: function () {
            $("#portalid").select2({placeholder: "پرتال را انتخاب کنید"}),
                $("#parent_id").select2({placeholder: "منو والد را انتخاب کنید"})
        }
    };

    var KTFormControls = {
        init: function () {
            $("#form_menu_add").validate({
                rules: {
                    title: {required: !0},
                    url: {required: !0},
                    status: {required: !0},
                    portalid: {required: !0},

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
        KTKBootstrapTouchspin.init();
        KTFormControls.init();
        KTSelect2.init();

    });

</script>
<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->

</html>