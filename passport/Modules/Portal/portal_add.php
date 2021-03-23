<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');



$val = new Validation;
$hasError = 0;

if (!empty($_POST)) {
    $val->name('نام پرتال')->value($_POST['name'])->required();
    $val->name('وضعیت')->value($_POST['status'])->required();
    $val->name('عنوان')->value($_POST['title'])->required();
    $val->name('نمایش')->value($_POST['can_sees'])->required();
    $val->name('دامنه')->value($_POST['domain'])->required();
    if ($val->isSuccess()) {
        $imguploaded = 0;
        $imguploaded2 = 0;
        $imguploaded3 = 0;

        // if logo
        if($_FILES['logo']) {
            $imgName = 'logo' . time();
            $handle = new upload($_FILES['logo']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $imgName;
                $handle->image_resize = false;
                $handle->image_ratio_crop = false;
                $handle->jpeg_quality = 200;
                $handle->image_ratio = true;
                $handle->dir_chmod = 0777;
                $handle->file_max_size = '5242880'; // 5mb
                $handle->allowed = array('image/*');
                $handle->image_convert = 'png';
                $handle->process('../../../Attachment/img/settings/');
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
                        $handle2->image_convert = 'png';
                        $handle2->process('../../../Attachment/img/settings/thumbs/');
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

        if($_FILES['logo2']) {
            $imgName2 = 'logo2' . time();
            $handle = new upload($_FILES['logo2']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $imgName2;
                $handle->image_resize = false;
                $handle->image_ratio_crop = false;
                $handle->jpeg_quality = 200;
                $handle->image_ratio = false;
                $handle->dir_chmod = 0777;
                $handle->file_max_size = '5242880'; // 5mb
                $handle->allowed = array('image/*');
                $handle->image_convert = 'png';
                $handle->process('../../../Attachment/img/settings/');
                if ($handle->processed) {
//            $handle->clean();
                    $imguploaded2 = 1;
                    //image upload
                    $handle2 = new upload($handle->file_dst_pathname);
                    if ($handle2->uploaded) {
                        $handle2->file_new_name_body = $imgName2;
                        $handle2->image_resize = true;
                        $handle2->image_x = 50;
                        $handle2->image_y = 50;
                        $handle2->image_ratio_crop = true;
                        $handle2->jpeg_quality = 200;
                        $handle2->image_ratio = true;
                        $handle2->dir_chmod = 0777;
                        $handle2->file_max_size = '5242880'; // 5mb
                        $handle2->allowed = array('image/*');
                        $handle2->image_convert = 'png';
                        $handle2->process('../../../Attachment/img/settings/thumbs/');
                        if ($handle2->processed) {
//                    $handle2->clean();
                            $imguploaded2 = 2;
                        } else {
                            echo 'error : ' . $handle2->error;
                        }
                    }

                } else {
                    echo 'error : ' . $handle->error;
                }
            }
        }

        if($_FILES['favicon']) {
            $imgName3 = 'icon' . time();
            $handle = new upload($_FILES['favicon']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $imgName3;
                $handle->image_resize = false;
                $handle->image_ratio_crop = false;
                $handle->jpeg_quality = 200;
                $handle->image_ratio = false;
                $handle->dir_chmod = 0777;
                $handle->file_max_size = '5242880'; // 5mb
                $handle->allowed = array('image/*');
                $handle->image_convert = 'ico';
                $handle->process('../../../Attachment/img/settings/');
                if ($handle->processed) {
//            $handle->clean();
                    $imguploaded3 = 1;
//                    //image upload
//                    $handle2 = new upload($handle->file_dst_pathname);
//                    if ($handle2->uploaded) {
//                        $handle2->file_new_name_body = $imgName;
//                        $handle2->image_resize = true;
//                        $handle2->image_x = 50;
//                        $handle2->image_y = 50;
//                        $handle2->image_ratio_crop = true;
//                        $handle2->jpeg_quality = 200;
//                        $handle2->image_ratio = true;
//                        $handle2->dir_chmod = 0777;
//                        $handle2->file_max_size = '5242880'; // 5mb
//                        $handle2->allowed = array('image/x-icon');
//                        $handle2->image_convert = 'ico';
//                        $handle2->process('../../../Attachment/img/settings/thumbs/');
//                        if ($handle2->processed) {
////                    $handle2->clean();
//                            $imguploaded = 2;
//                        } else {
//                            echo 'error : ' . $handle2->error;
//                        }
//                    }

                } else {
                    echo 'error : ' . $handle->error;
                }
            }
        }
        $name= GetSQLValueString($_POST['name'], 'def');
        $status= GetSQLValueString($_POST['status'], 'def');
        $domain= GetSQLValueString($_POST['domain'], 'def');
        $can_sees= GetSQLValueString($_POST['can_sees'], 'def');
        $email= GetSQLValueString($_POST['email'], 'def');
        $tel= GetSQLValueString($_POST['tel'], 'def');
        $author= GetSQLValueString($_POST['author'], 'def');
        $title= GetSQLValueString($_POST['title'], 'def');
        $copyright= GetSQLValueString($_POST['copyright'], 'def');
        $keywords= GetSQLValueString($_POST['keywords'], 'def');
        $description= GetSQLValueString($_POST['description'], 'def');
        $contacttitle= GetSQLValueString($_POST['contacttitle'], 'def');
        $contacttext= GetSQLValueString($_POST['contacttext'], 'def');

        $logo = ($imguploaded > 0) ? $imgName . '.png' : null;
        $logo2 = ($imguploaded2 > 0) ? $imgName2 . '.png' : null;
        $favicon = ($imguploaded3 > 0) ? $imgName3 . '.ico' : null;

        $insert_array = array(
            "name"=> $name,
            "domain"=> $domain,
            "can_sees"=> $can_sees,
            "email"=> $email,
            "tel"=> $tel,
            "author"=> $author,
            "title"=> $title,
            "copyright"=> $copyright,
            "keywords"=> $keywords,
            "description"=> $description,
            "contacttitle"=> $contacttitle,
            "contacttext"=> $contacttext,
            "logo"=> $logo,
            "logo2"=> $logo2,
            "favicon"=> $favicon,
            "status"=> $status,
        );
        if ($db->insert("settings", $insert_array)) {
            header('Location: ' . $_POST['referurl'].'?add=1');
            echo "<script>
	window.location= " . $_POST['referurl'] . "'?add=1';
	</script>";
            exit;
        }
    }else{
        $hasError = 1;
    }
}

?>
<!DOCTYPE html>
<html lang="en" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head>
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | افزودن پرتال جدید</title>
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
                                افزودن پرتال جدید </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="portals.php" class="kt-subheader__breadcrumbs-link">
                                    مدیریت پرتال ها </a>
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
                                            مشخصات پرتال جدید
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_portal_add" method="post" action="portal_add.php" enctype="multipart/form-data">
                                    <div class="kt-portlet__body">
                                        <?php
                                        if($hasError === 1) {
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
                                        if($_GET['add'] == 1) {
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
                                            <div class="col-lg-3 form-group-sub">
                                                <label>نام پرتال:</label>
                                                <input type="text" name="name" class="form-control"
                                                       placeholder="نام پرتال را وارد کنید">
                                            </div>
                                            <div class="col-lg-3 form-group-sub">
                                                <label class="">دامنه:</label>
                                                <input type="text" name="domain" class="form-control"
                                                       placeholder="دامنه را وارد کنید">
                                            </div>
                                            <div class="col-lg-3 form-group-sub">
                                                <label class="">نام وبسایت / اپ:</label>
                                                <input type="text" name="title" class="form-control"
                                                       placeholder="نام وبسایت / اپ را وارد کنید">
                                            </div>
                                            <div class="col-lg-3 form-group-sub">
                                                <label class="">نویسنده:</label>
                                                <input type="text" name="author" class="form-control"
                                                       placeholder="نویسنده را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>کلمات کلیدی:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="la la-tag"></i></span></div>
                                                    <input type="text" name="keywords" id="keywords" class="form-control"
                                                           placeholder="کلمات کلیدی را وارد کنید"
                                                           aria-describedby="basic-addon1">
                                                </div>
                                                <span class="form-text text-muted">کلمات کلیدی با "," جدا می شوند.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>کپی رایت:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="la la-copyright"></i></span></div>
                                                    <input type="text" name="copyright" id="copyright" class="form-control"
                                                           placeholder="کپی رایت را وارد کنید"
                                                           aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>توضیحات:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="description" placeholder="توضیحات مربوط به فعالیت وبسایت یا اپلیکیشن" rows="8"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 form-group-sub">
                                                <label>تلفن:</label>
                                                <input type="text" name="tel" class="form-control"
                                                       placeholder="تلفن را وارد کنید">
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                                <label class="">فکس:</label>
                                                <input type="text" name="fax" class="form-control"
                                                       placeholder="فکس را وارد کنید">
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                                <label class="">ایمیل:</label>
                                                <input type="text" name="email" class="form-control"
                                                       placeholder="ایمیل را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>عنوان تماس با ما:</label>
                                                <input type="text" name="contacttitle" class="form-control"
                                                       placeholder="عنوان تماس با ما را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>متن تماس با ما:</label>
                                                <div class="kt-input-icon">
                                                    <textarea class="form-control" name="contacttext" placeholder="متن تماس با ما برای نمایش در سایت" rows="12"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 form-group-sub">
                                                <label>لوگو:</label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo" name="logo">
                                                    <label class="custom-file-label" for="customFile">انتخاب کنید</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 form-group-sub">
                                            <label>لوگو 2:</label>
                                            <div></div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo2" name="logo2">
                                                <label class="custom-file-label" for="customFile">انتخاب کنید</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group-sub">
                                        <label>آیکون:</label>
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="favicon" name="favicon">
                                            <label class="custom-file-label" for="customFile">انتخاب کنید</label>
                                        </div>
                                    </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <div class="col-lg-6 form-group-sub">
                                                <label>نمایش:</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="can_sees" value="0">
                                                        عدم نمایش
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="can_sees" value="2">
                                                        فقط کاربران (مدیران)
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio kt-radio--solid">
                                                        <input type="radio" name="can_sees" checked value="1">
                                                        نمایش به همه
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
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
    var KTFormControls = {
        init: function () {
            $("#form_portal_add").validate({
                rules: {
                    name: {required: !0},
                    title: {required: !0},
                    can_sees: {required: !0},
                    domain: {required: !0},
                    status: {required: !0},
                    logo: {
                        accept: "image/*",
                    },
                    logo2: {
                        accept: "image/*",
                    },
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