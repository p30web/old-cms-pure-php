<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');

$id = decrypt($_GET['id'], session_id() . "aps");
$id = GetSQLValueString($id, 'int');

mysqli_select_db($cn, $database_cn);
$query_rsapps = sprintf("SELECT `name` FROM apps WHERE `id` = $id");
$rsapps = mysqli_query($cn, $query_rsapps) or die(mysqli_error($cn));
$row_rsapps = mysqli_fetch_assoc($rsapps);
$totalRows_rsapps = mysqli_num_rows($rsapps);


$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('نام ابزار')->value($_POST['name'])->required();
    $val->name('مرتب سازی')->value($_POST['sort'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();
    $val->name('مسیر')->value($_POST['path'])->required();
    $val->name('نمایش در منو')->value($_POST['showinmenu'])->required();
    $val->name('نام صفحه')->value($_POST['page'])->required();
    if ($val->isSuccess()) {
        $name = GetSQLValueString($_POST['name'], 'def');
        $status = GetSQLValueString($_POST['status'], 'def');
        $cat = GetSQLValueString($_POST['cat'], 'int');
        $path = GetSQLValueString($_POST['path'], 'def');
        $page = GetSQLValueString($_POST['page'], 'def');
        $icon = GetSQLValueString($_POST['icon'], 'def');
        $description = GetSQLValueString($_POST['description'], 'def');
        $sort = GetSQLValueString($_POST['sort'], 'int');
        $showinmenu = GetSQLValueString($_POST['showinmenu'], 'def');
        $extraparam = GetSQLValueString($_POST['extraparam'], 'def');
        $insert_array = array(
            "name" => $name,
            "cat" => $cat,
            "path" => $path,
            "page" => $page,
            "sort" => $sort,
            "icon" => $icon,
            "description" => $description,
            "extraparam" => $extraparam,
            "showinmenu" => $showinmenu,
            "status" => $status,
        );
        if ($db->insert("app_modules", $insert_array)) {
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
    <title>Rahaaa | افزودن ابزار جدید</title>
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
                                افزودن ابزار جدید ماژول <?php echo $row_rsapps['name']; ?> </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="module_utility.php?id=<?php echo $_GET['id']; ?>"
                                   class="kt-subheader__breadcrumbs-link">
                                    ماژول ابزار ماژول <?php echo $row_rsapps['name']; ?> </a>
                                <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
                            </div>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="module_list.php" class="kt-subheader__breadcrumbs-link">
                                    ماژول ها و ابزار </a>
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
                                            مشخصات ابزار جدید
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="kt_form_module" method="post"
                                      action="module_utility_add.php">
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
                                            <div class="col-lg-6 form-group-sub">
                                                <label>نام ابزار:</label>
                                                <input type="text" name="name" class="form-control"
                                                       placeholder="نام ماژول را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">ماژول:</label>
                                                <select class="form-control kt-select2" id="cat" name="cat">
                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);
                                                    $query_rsappsmodules = sprintf("SELECT `id`,`name` FROM apps");
                                                    $rsappsmodules = mysqli_query($cn, $query_rsappsmodules) or die(mysqli_error($cn));
                                                    $row_rsappsmodules = mysqli_fetch_assoc($rsappsmodules);
                                                    $totalRows_rsappsmodules = mysqli_num_rows($rsappsmodules);
                                                    if ($totalRows_rsappsmodules > 0) {

                                                        do {
                                                            ?>
                                                            <option value="<?php echo $row_rsappsmodules['id']; ?>" <?php if ($id === $row_rsappsmodules['id']) echo 'selected'; ?> ><?php echo $row_rsappsmodules['name']; ?></option>
                                                            <?php
                                                        } while ($row_rsappsmodules = mysqli_fetch_assoc($rsappsmodules));
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>مسیر:</label>
                                                <input type="text" name="path" class="form-control"
                                                       placeholder="مسیر را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">صفحه:</label>
                                                <input type="text" name="page" class="form-control"
                                                       placeholder="صفحه را وارد کنید">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>توضیحات:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="description"
                                                              placeholder="توضیحات را بنویسید" rows="8"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>استایل (آیکون):</label>
                                                <input type="text" name="icon" class="form-control"
                                                       placeholder="استایل (آیکون) را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">پارامتر:</label>
                                                <input type="text" name="extraparam" class="form-control"
                                                       placeholder="پارامتر را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <div class="col-lg-4 form-group-sub">
                                                <label>نمایش در منو:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="showinmenu" checked value="1">
                                                        بلی
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="showinmenu" value="0"> خیر
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
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
                                            <div class="col-lg-4 form-group-sub">
                                                <label>مرتب سازی:</label>
                                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input id="kt_touchspin_4" type="text"
                                                           class="form-control bootstrap-touchspin-vertical-btn"
                                                           value="" name="sort" placeholder="0">
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
    var KTSelect2 = {
        init: function () {
            $("#cat, #kt_select2_1_validate").select2({placeholder: "Select a state"})
        }
    };
    var KTKBootstrapTouchspin = {
        init: function () {
            $("#kt_touchspin_4, #kt_touchspin_2_4").TouchSpin({
                buttondown_class: "btn btn-secondary",
                buttonup_class: "btn btn-secondary",
                verticalbuttons: !0,
                verticalup: '<i class="la la-plus"></i>',
                verticaldown: '<i class="la la-minus"></i>'
            })
        }
    };
    var KTFormControls = {
        init: function () {
            $("#kt_form_module").validate({
                rules: {
                    name: {required: !0},
                    cat: {required: !0},
                    path: {required: !0},
                    page: {required: !0},
                    sort: {required: !0, digits: !0},
                    status: {required: !0},
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
        KTKBootstrapTouchspin.init();
        KTSelect2.init();

    });

</script>
<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->

</html>