<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');




$id = decrypt($_GET['id'], session_id() . "pct");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_post_category = $db->getOne("`post_category`", $cols);
$fetch_post_category_count = $db->count;




$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('نام')->value($_POST['name'])->required();
    $val->name('کد یکتا')->value($_POST['code'])->required();
    $val->name('نوع اعضاء')->value($_POST['memtype'])->required();
    $val->name('سطح')->value($_POST['level'])->required();
    $val->name('پرتال')->value($_POST['portalid'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();

    if ($val->isSuccess()) {

        $imguploaded = 0;
        $headeruploaded = 0;
        if ($_FILES['image']) {
            $imgName = 'pstc' . time();
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
                $handle->process('../../../Attachment/img/posts/');
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
                        $handle2->process('../../../Attachment/img/posts/thumbs/');
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

        if ($_FILES['header']) {
            $headerimgName = 'pstch' . time();
            $handle = new upload($_FILES['header']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $headerimgName;
                $handle->image_resize = false;
                $handle->image_ratio_crop = false;
                $handle->jpeg_quality = 200;
                $handle->image_ratio = false;
                $handle->dir_chmod = 0777;
                $handle->file_max_size = '5242880'; // 5mb
                $handle->allowed = array('image/*');
                $handle->image_convert = 'jpg';
                $handle->process('../../../Attachment/img/posts/');
                if ($handle->processed) {
//            $handle->clean();
                    $headeruploaded = 1;
                    //image upload
                    $handle2 = new upload($handle->file_dst_pathname);
                    if ($handle2->uploaded) {
                        $handle2->file_new_name_body = $headerimgName;
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
                        $handle2->process('../../../Attachment/img/posts/thumbs/');
                        if ($handle2->processed) {
//                    $handle2->clean();
                            $headeruploaded = 2;
                        } else {
                            echo 'error : ' . $handle2->error;
                        }
                    }

                } else {
                    echo 'error : ' . $handle->error;
                }
            }
        }

        $code = GetSQLValueString($_POST['code'], "def");
        $pagename = GetSQLValueString($_POST['pagename'], "def");
        $name = GetSQLValueString($_POST['name'], "def");
        $type = GetSQLValueString($_POST['type'], "def");
        $level = GetSQLValueString($_POST['level'], "int");
        $description = GetSQLValueString($_POST['description'], "def");
        $header = ($headeruploaded > 0) ? $headerimgName . '.jpg' : $fetch_post_category['header'];
        $image = ($imguploaded > 0) ? $imgName . '.jpg' : $fetch_post_category['image'];
        $style = GetSQLValueString($_POST['style'], "def");
        $keywords = GetSQLValueString($_POST['keywords'], "def");
        $memtype = GetSQLValueString($_POST['memtype'], "def");
        $portalid = GetSQLValueString($_POST['portalid'], "int");
        $showinmenu = GetSQLValueString($_POST['showinmenu'], "def");
        $showinhome = GetSQLValueString($_POST['showinhome'], "def");
        $sort = GetSQLValueString($_POST['sort'], "int");
        $status = GetSQLValueString($_POST['status'], "def");

        $db->where("id", $id);
        $insert_array = array(
            "code" => $code,
            "pagename" => $pagename,
            "name" => $name,
            "type" => '1',
            "level" => $level,
            "description" => $description,
            "header" => $header,
            "image" => $image,
            "style" => $style,
            "contenttype" => 1,
            "keywords" => $keywords,
            "memtype" => $memtype,
            "portalid" => $portalid,
            "showinmenu" => ($showinmenu == 'on') ? '1' : '0',
            "showinhome" => ($showinhome == 'on') ? '1' : '0',
            "sort" => $sort,
            "status" => $status,
        );
        if ($db->update("post_category", $insert_array)) {
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
    <title>Rahaaa | ویرایش گروه مطالب</title>
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
                                ویرایش گروه مطالب <?php echo $fetch_post_category['name']; ?> </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="post_cats.php" class="kt-subheader__breadcrumbs-link">
                                    گروه مطالب </a>
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
                                            مشخصات گروه مطالب <?php echo $fetch_post_category['name']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_post_cat_edit" method="post"
                                      action="post_cat_edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
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
                                                <label>نام:</label>
                                                <input type="text" name="name" class="form-control"
                                                       value="<?php echo $fetch_post_category['name']; ?>"
                                                       placeholder="نام را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">کد یکتا:</label>
                                                <input type="text" name="code" class="form-control"
                                                       value="<?php echo $fetch_post_category['code']; ?>"
                                                       placeholder="کد یکتا را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>نام صفحه:</label>
                                                <input type="text" name="pagename" class="form-control"
                                                       value="<?php echo $fetch_post_category['pagename']; ?>"
                                                       placeholder="نام صفحه را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">استایل:</label>
                                                <input type="text" name="style" class="form-control"
                                                    value="<?php echo $fetch_post_category['style']; ?>"
                                                       placeholder="استایل را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">پرتال:</label>
                                                <select class="form-control kt-select2" id="portalid" name="portalid">

                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);
                                                    $query_rssettings = sprintf("SELECT `id`,`name` FROM `settings` ");
                                                    $rssettings = mysqli_query($cn, $query_rssettings) or die(mysqli_error($cn));
                                                    $row_rssettings = mysqli_fetch_assoc($rssettings);
                                                    $totalRows_rssettings = mysqli_num_rows($rssettings);
                                                    if ($totalRows_rssettings > 0) {

                                                        do {
                                                            ?>
                                                            <option value="<?php echo $row_rssettings['id']; ?>" <?php if ($row_rssettings['id'] == $fetch_post_category['portalid']) { echo 'selected'; } ?>><?php echo $row_rssettings['name']; ?></option>
                                                            <?php
                                                        } while ($row_rssettings = mysqli_fetch_assoc($rssettings));
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">سطح:</label>
                                                <select class="form-control kt-select2" id="level" name="level">
                                                    <option value="0" <?php if ($fetch_post_category['level'] == '0') { echo 'selected'; } ?>>گروه اصلی</option>

                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);
                                                    $query_post_category = sprintf("SELECT `code`,`id`,`name` FROM `post_category` WHERE id != %s ORDER BY id ASC", $fetch_post_category['id']);
                                                    $post_category = mysqli_query($cn, $query_post_category) or die(mysqli_error($cn));
                                                    $row_post_category = mysqli_fetch_assoc($post_category);
                                                    $totalRows_post_category = mysqli_num_rows($post_category);
                                                    if ($totalRows_post_category > 0) {

                                                        do {
                                                            ?>
                                                            <option value="<?php echo $row_post_category['id']; ?>" <?php if ($row_post_category['id'] === $fetch_post_category['level']) { echo 'selected'; } ?>><?php echo $row_post_category['name']; ?></option>
                                                            <?php
                                                        } while ($row_post_category = mysqli_fetch_assoc($post_category));
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>عکس:</label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image"
                                                           name="image">
                                                    <label class="custom-file-label" for="customFile">انتخاب
                                                        کنید</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>هدر:</label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="header"
                                                           name="header">
                                                    <label class="custom-file-label" for="customFile">انتخاب
                                                        کنید</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6 form-group-sub row">
                                                <label class="col-6 col-form-label">در صفحه اصلی نمایش داده
                                                    شود. </label>
                                                <div class="col-2">
                                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                    <label>
                                                        <input type="checkbox" <?php if ($fetch_post_category['showinhome'] === '1') echo 'checked'; ?> name="showinhome">
                                                        <span></span>
                                                    </label>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="col-6 form-group-sub row">
                                                <label class="col-6 col-form-label">در منو نمایش داده شود. </label>
                                                <div class="col-2">
                                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                    <label>
                                                        <input type="checkbox" <?php if ($fetch_post_category['showinmenu'] === '1') echo 'checked'; ?> name="showinmenu">
                                                        <span></span>
                                                    </label>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>توضیحات:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="description" id="description"
                                                              placeholder="توضیحات" rows="20"><?php echo $fetch_post_category['description']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>کلمات کلیدی:</label>
                                                <div class="kt-input-icon">
                                                    <input type="text" name="keywords" id="keywords"
                                                           class="form-control"
                                                           value="<?php echo $fetch_post_category['keywords']; ?>"
                                                           placeholder="کلمات کلیدی را وارد کنید">
                                                    <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i
                                                                class="la la-tag"></i></span></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>نوع اعضاء:</label>
                                                <select class="form-control kt-select2" id="memtype" name="memtype">
                                                    <option value="0" <?php if ($row_rssettings['id'] == '0') { echo 'selected'; } ?>>همه</option>
                                                    <option value="1" <?php if ($row_rssettings['id'] == '1') { echo 'selected'; } ?>>کاربران</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">

                                            <div class="col-lg-6 form-group-sub">
                                                <label>وضعیت:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" <?php if ($fetch_post_category['status'] === '1') echo 'checked'; ?> value="1"> فعال
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" <?php if ($fetch_post_category['status'] === '0') echo 'checked'; ?> value="0"> غیر فعال
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>مرتب سازی:</label>
                                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input id="sort" type="text"
                                                           class="form-control bootstrap-touchspin-vertical-btn"
                                                           value="<?php echo $fetch_post_category['sort']; ?>" name="sort" placeholder="0">
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
                $("#level").select2({placeholder: "سطح را انتخاب کنید"})
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
            $("#form_post_cat_edit").validate({
                rules: {
                    name: {required: !0},
                    code: {required: !0},
                    status: {required: !0},
                    portalid: {required: !0},
                    memtype: {required: !0},
                    sort: {required: !0},
                    level: {required: !0},

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