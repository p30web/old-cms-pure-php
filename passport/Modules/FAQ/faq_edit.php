<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');


$id = decrypt($_GET['id'], session_id() . "faq");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_faq = $db->getOne("`faq`", $cols);
$fetch_faq_count = $db->count;



$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('گروه')->value($_POST['category'])->required();
    $val->name('عنوان')->value($_POST['title'])->required();
    $val->name('مرتب سازی')->value($_POST['sort'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();

    if ($val->isSuccess()) {



        $title = GetSQLValueString($_POST['title'], "def");
        $style = GetSQLValueString($_POST['style'], "def");
        $category = GetSQLValueString($_POST['category'], "def");
        $description = GetSQLValueString($_POST['description'], "def");
        $sort = GetSQLValueString($_POST['sort'], "int");
        $status = GetSQLValueString($_POST['status'], "def");

        $db->where("id", $id);

        $insert_array = array(
            "title" => $title,
            "style" => $style,
            "category" => $category,
            "description" => $description,
            "date" => jdate('Y/m/d H:i:s'),
            "sort" => $sort,
            "status" => $status,
        );

        if ($db->update("faq", $insert_array)) {
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
    <title>Rahaaa | ویرایش سوالات</title>
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
                                ویرایش سوال <?php echo $fetch_faq['title']; ?>  </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="faq_cats.php" class="kt-subheader__breadcrumbs-link">
                                    دسته بندی سوالات متداول </a>
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
                                            مشخصات سوال <?php echo $fetch_faq['title']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_faq_edit" method="post"
                                      action="faq_edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
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
                                                       value="<?php echo $fetch_faq['title']; ?> "
                                                       placeholder="عنوان را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">استایل:</label>
                                                <input type="text" name="style" class="form-control"
                                                       value="<?php echo $fetch_faq['style']; ?> "
                                                       placeholder="استایل را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 form-group-sub">
                                                <label class="">گروه:</label>
                                                <select class="form-control kt-select2" id="category" name="category">
                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);
                                                    $query_faqcat = sprintf("SELECT `id`,`name`,`code` FROM `faqcat` ");
                                                    $rsfaqcat = mysqli_query($cn, $query_faqcat) or die(mysqli_error($cn));
                                                    $row_rsfaqcat = mysqli_fetch_assoc($rsfaqcat);
                                                    $totalRows_rsfaqcat = mysqli_num_rows($rsfaqcat);
                                                    if ($totalRows_rsfaqcat > 0) {

                                                        do {
                                                            ?>
                                                            <option value="<?php echo $row_rsfaqcat['code']; ?>" <?php if ($row_rsfaqcat['code'] == $fetch_faq['category']) { echo 'selected'; } ?>><?php echo $row_rsfaqcat['name']; ?></option>
                                                            <?php
                                                        } while ($row_rsfaqcat = mysqli_fetch_assoc($rsfaqcat));
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>توضیحات:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="description" id="description"
                                                              placeholder="توضیحات" rows="20"><?php echo $fetch_faq['description']; ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>وضعیت:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" <?php if ($fetch_faq['status'] === '1') echo 'checked'; ?> value="1"> فعال
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" <?php if ($fetch_faq['status'] === '0') echo 'checked'; ?> value="0"> غیر فعال
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>مرتب سازی:</label>
                                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input id="sort" type="text"
                                                           class="form-control bootstrap-touchspin-vertical-btn"
                                                           value="<?php echo $fetch_faq['sort']; ?> " name="sort" placeholder="0">
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

    CKEDITOR.replace('description');

    var KTSelect2 = {
        init: function () {
            $("#portalid").select2({placeholder: "پرتال را انتخاب کنید"}),
                $("#category").select2({placeholder: "سطح را انتخاب کنید"})
        }
    };
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
    var KTFormControls = {
        init: function () {
            $("#form_faq_edit").validate({
                rules: {
                    title: {required: !0},
                    category: {required: !0},
                    status: {required: !0},
                    sort: {required: !0},

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
        KTKBootstrapTouchspin.init();

    });

</script>
<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->

</html>