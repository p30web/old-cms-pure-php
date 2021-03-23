<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');

$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('عنوان')->value($_POST['title'])->required();
    $val->name('گروه مطالب')->value($_POST['category'])->required();
    $val->name('نوع اعضاء')->value($_POST['memtype'])->required();
    $val->name('نمایش')->value($_POST['view'])->required();
    $val->name('پرتال')->value($_POST['portalid'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();

    if ($val->isSuccess()) {

        $imguploaded = 0;
        if ($_FILES['image']) {
            $imgName = 'post' . time();
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


        $category = GetSQLValueString($_POST['category'], "def");
        $category = implode(",", $category);
        $title = GetSQLValueString($_POST['title'], "def");
        $title2 = GetSQLValueString($_POST['subtitle'], "def");
        $mintext = GetSQLValueString($_POST['mintext'], "def");
        $abstract = GetSQLValueString($_POST['abstract'], "def");
        $textbody = GetSQLValueString($_POST['textbody'], "def");
        $imagealt = GetSQLValueString($_POST['imagealt'], "def");
        $author = GetSQLValueString($_POST['author'], "def");
//        $authorid = GetSQLValueString($_POST['authorid'], "def");
//        $startdate = GetSQLValueString($_POST['startdate'], "def");
//        $enddate = GetSQLValueString($_POST['enddate'], "def");
//        $scoreplus = GetSQLValueString($_POST['scoreplus'], "def");
//        $scoreminus = GetSQLValueString($_POST['scoreminus'], "def");
//        $starcount = GetSQLValueString($_POST['starcount'], "def");
//        $starsum = GetSQLValueString($_POST['starsum'], "def");
//        $password = GetSQLValueString($_POST['password'], "def");
//        $passcount = GetSQLValueString($_POST['passcount'], "def");
//        $urltype = GetSQLValueString($_POST['urltype'], "def");
//        $url = GetSQLValueString($_POST['url'], "def");
//        $relatedview = GetSQLValueString($_POST['relatedview'], "def");
//        $related = GetSQLValueString($_POST['related'], "def");
        $comment = GetSQLValueString($_POST['comment'], "def");
        $commentview = GetSQLValueString($_POST['commentview'], "def");
//        $viewcount = GetSQLValueString($_POST['viewcount'], "def");
//        $fixed = GetSQLValueString($_POST['fixed'], "def");
        $special = GetSQLValueString($_POST['special'], "def");
//        $user = GetSQLValueString($_POST['user'], "def");
        $view = GetSQLValueString($_POST['view'], "def");
        $image = ($imguploaded > 0) ? $imgName . '.jpg' : null;
        $keywords = GetSQLValueString($_POST['keywords'], "def");
        $memtype = GetSQLValueString($_POST['memtype'], "def");
        $portalid = GetSQLValueString($_POST['portalid'], "int");
        $showinhome = GetSQLValueString($_POST['showinhome'], "def");
        $sort = GetSQLValueString($_POST['sort'], "int");
        $status = GetSQLValueString($_POST['status'], "def");

        $insert_array = array(
            "category" => $category,
            "title" => $title,
            "title2" => $title2,
            "created_at" => jdate('Y/m/d H:i:s'),
            "settime" => time(),
            "modified_at" => jdate('Y/m/d H:i:s'),
            "mintext" => $mintext,
            "abstract" => $abstract,
            "textbody" => $textbody,
            "image" => $image,
//            "image2" => $image2,
            "imagealt" => $imagealt,
            "author" => $author,
            "authorid" => $_SESSION['user_id'],
//            "startdate" => $startdate,
//            "enddate" => $enddate,
            "scoreplus" => 0,
            "scoreminus" => 0,
            "starcount" => 0,
            "starsum" => 0,
//            "password" => $password,
//            "passcount" => $passcount,
//            "urltype" => $urltype,
//            "url" => $url,
//            "relatedview" => $relatedview,
//            "related" => $related,
            "memtype" => $memtype,
            "comment" => $comment,
            "commentview" => $commentview,
//            "viewcount" => $viewcount,
            "keywords" => $keywords,
            "portalid" => $portalid,
//            "fixed" => $fixed,
            "special" => $special,
            "user" => $_SESSION['user_id'],
            "view" => $view,
            "showinhome" => ($showinhome == 'on') ? '1' : '0',
            "sort" => $sort,
            "status" => $status,
        );
        if ($db->insert("posts", $insert_array)) {
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
    <title>Rahaaa | افزودن مطالب</title>
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
                                افزودن مطالب </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="posts.php" class="kt-subheader__breadcrumbs-link">
                                    مطالب </a>
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
                                            مشخصات مطلب جدید
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_post_add" method="post"
                                      action="post_add.php" enctype="multipart/form-data">
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
                                                <label>عنوان:</label>
                                                <input type="text" name="title" class="form-control"
                                                       placeholder="عنوان را وارد کنید">
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label class="">عنوان فرعی:</label>
                                                <input type="text" name="subtitle" class="form-control"
                                                       placeholder="عنوان فرعی را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>گروه مطالب:</label>
                                                <select class="form-control kt-select2" id="category" name="category[]"
                                                        multiple="multiple">
                                                    <option value="0" selected>گروه اصلی</option>

                                                    <?php
                                                    mysqli_select_db($cn, $database_cn);
                                                    $query_post_category = sprintf("SELECT * FROM `post_category` ORDER BY id ASC");
                                                    $post_category = mysqli_query($cn, $query_post_category) or die(mysqli_error($cn));
                                                    $row_post_category = mysqli_fetch_assoc($post_category);
                                                    $totalRows_post_category = mysqli_num_rows($post_category);
                                                    if ($totalRows_post_category > 0) {

                                                        do {
                                                            ?>
                                                            <option value="<?php echo $row_post_category['code']; ?>"><?php echo $row_post_category['name']; ?></option>
                                                            <?php
                                                        } while ($row_post_category = mysqli_fetch_assoc($post_category));
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>نوع مطلب:</label>
                                                <select class="form-control kt-select2" id="special" name="special">
                                                    <option value="0">معمولی</option>
                                                    <option value="1">ویژه</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>وضعیت نظر:</label>
                                                <select class="form-control kt-select2" id="comment" name="comment">
                                                    <option value="0">بدون نظر</option>
                                                    <option value="1">نظر با تائيد</option>
                                                    <option value="2">نظر بدون تائيد</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>نمایش نظرات:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="commentview" checked value="1"> فعال
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="commentview" value="0"> غیر فعال
                                                        <span></span>
                                                    </label>
                                                </div>
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
                                                            <option value="<?php echo $row_rssettings['id']; ?>"><?php echo $row_rssettings['name']; ?></option>
                                                            <?php
                                                        } while ($row_rssettings = mysqli_fetch_assoc($rssettings));
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>نوع اعضا:</label>
                                                <select class="form-control kt-select2" id="memtype" name="memtype">
                                                    <option value="0">همه</option>
                                                    <option value="1">اعضا</option>
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
                                                <label>متن جایگزین عکس:</label>
                                                <input type="text" name="imagealt" class="form-control"
                                                       placeholder="متن جایگزین عکس را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-6 form-group-sub row">
                                                <label class="col-6 col-form-label">در صفحه اصلی نمایش داده
                                                    شود. </label>
                                                <div class="col-2">
                                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                                    <label>
                                                        <input type="checkbox" name="showinhome">
                                                        <span></span>
                                                    </label>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>متن کوتاه:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="mintext" id="mintext"
                                                              placeholder="متن کوتاه" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>خلاصه مطلب:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="abstract" id="abstract"
                                                              placeholder="خلاصه مطلب" rows="20"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>متن کامل مطلب:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="textbody" id="textbody"
                                                              placeholder="متن کامل مطلب" rows="20"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>کلمات کلیدی:</label>
                                                <div class="kt-input-icon">
                                                    <input type="text" name="keywords" id="keywords"
                                                           class="form-control"
                                                           placeholder="کلمات کلیدی را وارد کنید">
                                                    <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i
                                                                    class="la la-tag"></i></span></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>مرتب سازی:</label>
                                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <input id="sort" type="text"
                                                           class="form-control bootstrap-touchspin-vertical-btn"
                                                           value="" name="sort" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">

                                            <div class="col-lg-6 form-group-sub">
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
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" value="2"> در حال بررسی
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="status" value="3"> پیش نویس
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 form-group-sub">
                                                <label>نمایش:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="view" checked value="1"> فعال
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="view" value="0"> غیر فعال
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

    CKEDITOR.replace('textbody');
    CKEDITOR.replace('abstract');

    var KTSelect2 = {
        init: function () {
            $("#portalid").select2({placeholder: "پرتال را انتخاب کنید"}),
                $("#level").select2({placeholder: "سطح را انتخاب کنید"}),
                $("#category").select2({placeholder: "گروه مطالب را انتخاب کنید"})
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
            $("#form_post_add").validate({
                rules: {
                    title: {required: !0},
                    category: {required: !0},
                    status: {required: !0},
                    portalid: {required: !0},
                    memtype: {required: !0},
                    sort: {required: !0},
                    view: {required: !0},

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