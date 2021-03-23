<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');


$id = decrypt($_GET['id'], session_id() . "usr");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_users = $db->getOne("`users`", $cols);
$fetch_users_count = $db->count;


$db->where("status", "1");
$cols = array("id", "app_id", "name", "style", "sort");
$db->orderBy("sort", "ASC");
$fetch_apps = $db->get("apps", null, $cols);
$numrows_apps = $db->count;

for ($i = 0; $i < $numrows_apps; $i++) {
    $db->where("status", "1");
    $db->where("cat", $fetch_apps[$i]['id']);
    $cols = array("id", "page", "name", "cat", "sort");
    $db->orderBy("sort", "ASC");
    $fetch_app_modules = $db->get("app_modules", null, $cols);
    $Levelistarray[] = array(
        "apps" => $fetch_apps[$i]['name'],
        "apps_style" => $fetch_apps[$i]['style'],
        "apps_app_id" => $fetch_apps[$i]['app_id'],
        "modules" => $fetch_app_modules
    );
}

$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('سطح دسترسی')->value($_POST['privileges'])->required();

    if ($val->isSuccess()) {

        $privileges = implode(",", $_POST['privileges']);

        $db->where("id", $id);

        $insert_array = array(

            "privileges" => $privileges,
            "modified_at" => jdate('Y/m/d H:i:s'),
        );
        if ($db->update("users", $insert_array)) {
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
    <title>Rahaaa | سطح دسترسی</title>
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
                                سطح دسترسی </h3>

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
                                            سطح دسترسی <?php echo $fetch_users['name']; ?>
                                        </h3>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="kt-form kt-form--label-right" id="form_user_privileges" method="post"
                                      action="user_privileges.php?id=<?php echo $_GET['id']; ?>"
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
                                        <div class="form-group">
                                            <div class="kt-checkbox-inline">

                                                    <label class="kt-checkbox">
                                                        <input id="checkAll" name="privileges[]"
                                                               value=""
                                                               type="checkbox">
                                                        دسترسی کامل
                                                        <span></span>
                                                    </label>
                                            </div>
                                            <br>
                                        </div>
                                        <?php
                                        $i = 0;
                                        foreach ($Levelistarray as $level) {

                                        ?>
                                        <div class="form-group">
                                            <label><?php echo $level['apps_style'] . ' ' . $level['apps']; ?></label>
                                            <div class="kt-checkbox-inline">
                                                <?php
                                                $z = 0;
                                                for ($i = 0;$i < count($level['modules']);$i++) {
                                                    if ($z === 4) $z = 0;
                                                    ?>
                                                    <label class="kt-checkbox">
                                                        <input name="privileges[]"
                                                               value="<?php echo $level['modules'][$i]['page']; ?>"
                                                               type="checkbox" <?php if (in_array($level['modules'][$i]['page'], explode(",", $fetch_users['privileges']))) echo 'checked'; ?>>
                                                        <?php echo $level['modules'][$i]['name']; ?>
                                                        <span></span>
                                                    </label>
                                                    <?php
                                                    if ($z === 3) {
                                                    }
                                                    ?>
                                                    <?php $z++;
                                                }
                                                ?>
                                            </div>
                                            <hr>
                                            <br>
                                        </div>
                                    <?php $i++;
                                    } ?>
                                    </div>
                                    <input type="hidden" name="referurl"
                                           value="<?php echo $_SERVER['HTTP_REFERER']; ?> "/>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <button type="submit" class="btn btn-primary">بروزرسانی سطح دسترسی
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
            $("#form_user_privileges").validate({
                rules: {
                    privileges: {required: !0},

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

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });

</script>
<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->

</html>