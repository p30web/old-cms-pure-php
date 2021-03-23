<?php
require_once('../../checklogin.php');
?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | پارامتر ها</title>

</head>
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
                                پارامتر ها </h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="" class="kt-subheader__breadcrumbs-link">
                                    داشبورد </a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="alert alert-light alert-elevate" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                        <div class="alert-text">
                            مشتریان گرامی، هر گونه ویرایش و افزودن موردی در این بخش فقط با هماهنگی پشتیبانی انجام شود،
                            در غیر اینصورت مسئولیت آن به عهده شماست.
                        </div>
                    </div>

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-back"></i>
			</span>
                                <h3 class="kt-portlet__head-title">
                                    پارامتر ها
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">
                                        <?php
                                        if(in_array("settings_param_add", $privilegeslist)) echo '<a href="settings_param_add.php" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i>رکورد جدید</a>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__body">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                   id="kt_table_1">
                                <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>نام</th>
                                    <th>کد</th>
                                    <th>مقدار</th>
                                    <th>ثبت</th>
                                    <th>آخرین ویرایش</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php

                                mysqli_select_db($cn, $database_cn);
                                $query_rssettings_param = sprintf("SELECT * FROM settings_param ORDER BY id ASC");
                                $rssettings_param = mysqli_query($cn, $query_rssettings_param) or die(mysqli_error($cn));
                                $row_rssettings_param = mysqli_fetch_assoc($rssettings_param);
                                $totalRows_rssettings_param = mysqli_num_rows($rssettings_param);

                                if ($totalRows_rssettings_param > 0) {
                                    do {
                                        ?>

                                        <tr>
                                            <td><?php echo $row_rssettings_param['id']; ?></td>
                                            <td><?php echo $row_rssettings_param['name']; ?></td>
                                            <td><?php echo $row_rssettings_param['code']; ?></td>
                                            <td><?php echo $row_rssettings_param['value']; ?></td>
                                            <td><?php echo $row_rssettings_param['created_at']; ?></td>
                                            <td><?php echo $row_rssettings_param['updated_at']; ?></td>
                                            <td>
                                                <?php if(in_array("settings_param_edit", $privilegeslist)) { ?>
                                                    <a href="settings_param_edit.php?id=<?php echo encrypt($row_rssettings_param['id'], session_id() . "pst"); ?>" class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                                       title="ویرایش">
                                                        <i class="la la-edit"></i>
                                                    </a>
                                                <?php } ?>
                                                <?php if(in_array("settings_param_delete", $privilegeslist)) { ?><a class="btn btn-sm btn-clean btn-icon btn-icon-md text-danger" onClick="return confirm('آیا مطمئنید می خواهید اطلاعات را حذف کنید ؟');"  href="settings_param_delete.php?id=<?php echo encrypt($row_rssettings_param['id'], session_id() . "pst"); ?>"><i class="la la-trash text-danger "></i> </a><?php } ?>

                                            </td>
                                        </tr>
                                        <?php
                                    } while ($row_rssettings_param = mysqli_fetch_assoc($rssettings_param));
                                }
                                ?>
                                </tbody>

                            </table>
                            <!--end: Datatable -->
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
<?php include($nav_path . "Components/quick-panel-sidebar.php"); ?>
<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<!-- end::Scrolltop -->
<!-- begin::Sticky Toolbar -->

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
<!--end::Global Theme Bundle -->


<!--begin::Page Vendors(used by this page) -->
<script src="<?php echo $nav_path; ?>assets/vendors/custom/datatables/datatables.bundle.js"
        type="text/javascript"></script>
<!--end::Page Vendors -->


<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo $nav_path; ?>assets/js/pages/crud/datatables/basic/paginations.js"
        type="text/javascript"></script>

<!--end::Page Scripts -->
</body>
</html>