<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');

$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('نام')->value($_POST['name'])->required();
    $val->name('کد یکتا')->value($_POST['code'])->required();
    $val->name('مرتب سازی')->value($_POST['sort'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();
    $val->name('نوع اسلایدر')->value($_POST['memtype'])->required();
    $val->name('پرتال')->value($_POST['portalid'])->required();
    $val->name('نمایش در منو')->value($_POST['showinmenu'])->required();
    $val->name('نمایش در صفحه اصلی')->value($_POST['showinhome'])->required();

    if ($val->isSuccess()) {

        $imguploaded = 0;
        if ($_FILES['image']) {
            $imgName = 'slc' . time();
            $handle = new upload($_FILES['image']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $imgName;
                $handle->image_resize = false;
                $handle->image_ratio_crop = false;
                $handle->jpeg_quality = 200;
                $handle->image_ratio = false;
                $handle->dir_chmod = 0777;
                $handle->file_max_size = '5242880'; // 5mb
                $handle->allowed = array('image/*');
                $handle->image_convert = 'jpg';
                $handle->process('../../../Attachment/img/slideshows/');
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
                        $handle2->process('../../../Attachment/img/slideshows/thumbs/');
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

        $code = GetSQLValueString($_POST['code'], 'def');
        $params = GetSQLValueString($_POST['params'], 'def');
        $pagename = GetSQLValueString($_POST['pagename'], 'def');
        $name = GetSQLValueString($_POST['name'], 'def');
//        $type = GetSQLValueString($_POST['type'], 'def');
//        $level = GetSQLValueString($_POST['level'], 'int');
        $description = GetSQLValueString($_POST['description'], 'def');
//        $header = GetSQLValueString($_POST['header'], 'def');
        $style = GetSQLValueString($_POST['style'], 'def');
        $keywords = GetSQLValueString($_POST['keywords'], 'def');
        $memtype = GetSQLValueString($_POST['memtype'], 'def');
        $portalid = GetSQLValueString($_POST['portalid'], 'int');
        $showinmenu = GetSQLValueString($_POST['showinmenu'], 'def');
        $showinhome = GetSQLValueString($_POST['showinhome'], 'def');
        $sort = GetSQLValueString($_POST['sort'], 'int');
        $status = GetSQLValueString($_POST['status'], 'def');

        $image = ($imguploaded > 0) ? $imgName . '.jpg' : null;

        $insert_array = array(
            "code" => $code ,
            "params" => $params ,
            "pagename" => $pagename ,
            "name" => $name ,
//            "type" => $type ,
            "level" => 0 ,
            "description" => $description ,
//            "header" => $header ,
            "image" => $image ,
            "style" => $style ,
            "keywords" => $keywords ,
            "memtype" => $memtype ,
            "portalid" => $portalid ,
            "showinmenu" => $showinmenu ,
            "showinhome" => $showinhome ,
            "sort" => $sort ,
            "status" => $status
        );
        if ($db->insert("slideshowcat", $insert_array)) {
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
    <title>Rahaaa | افزودن اسلایدر جدید</title>
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
                                اسلایدر جدید </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="slideshow_cat.php" class="kt-subheader__breadcrumbs-link">
                                    مدیریت اسلایدر ها </a>
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
                                            اسلایدر جدید
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_slideshowcat_add" method="post"
                                      action="slideshow_cat_add.php" enctype="multipart/form-data">
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
                                                <label>نام:</label>
                                                <input type="text" name="name" class="form-control"
                                                       placeholder="نام را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">کد یکتا:</label>
                                                <input type="text" name="code" class="form-control"
                                                       placeholder="کد یکتا را وارد کنید">
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
                                                    <label class="custom-file-label" for="customFile">انتخاب
                                                        کنید</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>توضیحات:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="description"  id="description" placeholder="توضیحات" rows="20"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>پارامتر ها:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="params"  id="params" placeholder="پارامتر ها" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 form-group-sub">
                                                <label>استایل:</label>
                                                <input type="text" name="style" class="form-control"
                                                       placeholder="استایل را وارد کنید">
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                                <label class="">کلمات کلیدی:</label>
                                                <input type="text" name="keywords" class="form-control"
                                                       placeholder="کلمات کلیدی را وارد کنید">
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                                <label>مرتب سازی:</label>
                                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input id="sort" type="text"
                                                           class="form-control bootstrap-touchspin-vertical-btn"
                                                           value="" name="sort" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
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
                                                <label>نوع اسلایدر:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="memtype" checked value="0"> عکس
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="memtype" value="1">فیلم
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">

                                            <div class="col-lg-4 form-group-sub">
                                                <label>نمایش در منو:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="showinmenu" checked value="1"> بلی
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="showinmenu" value="0">خیر
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                                <label>نمایش در صفحه اصلی:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="showinhome" checked value="1"> بلی
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="showinhome" value="0">خیر
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

    CKEDITOR.replace('description');

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
            $("#portalid").select2({placeholder: "پرتال را انتخاب کنید"})
        }
    };

    var KTFormControls = {
        init: function () {
            $("#form_slideshowcat_add").validate({
                rules: {
                    name: {required: !0},
                    code: {required: !0},
                    status: {required: !0},
                    memtype: {required: !0},
                    sort: {required: !0},
                    portalid: {required: !0},
                    showinmenu: {required: !0},
                    showinhome: {required: !0},

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