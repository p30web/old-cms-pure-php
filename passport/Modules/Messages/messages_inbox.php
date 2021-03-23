<?php
require_once('../../checklogin.php');
?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | پیام های دریافتی</title>

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
                                پیام های دریافتی </h3>

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

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-back"></i>
			</span>
                                <h3 class="kt-portlet__head-title">
                                    لیست پیام ها
                                </h3>
                            </div>

                        </div>

                        <div class="kt-portlet__body">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                   id="message_table">
                                <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>کاربر</th>
                                    <th>عنوان</th>
                                    <th>پرتال</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php

                                mysqli_select_db($cn, $database_cn);
                                $query_message = sprintf("SELECT * FROM `message` ORDER BY created_at DESC");
                                $rsmessage = mysqli_query($cn, $query_message) or die(mysqli_error($cn));
                                $row_rsmessage = mysqli_fetch_assoc($rsmessage);
                                $totalRows_rsmessage = mysqli_num_rows($rsmessage);

                                if ($totalRows_rsmessage > 0) {
                                    do {
                                        ?>

                                        <tr>
                                            <td><?php echo $row_rsmessage['id']; ?></td>
                                            <td>
                                                <div class="kt-user-card-v2">
                                                    <div class="kt-user-card-v2__pic">
                                                        <?php

                                                            echo '<div class="kt-badge kt-badge--xl kt-badge--primary"><span>'.substr($row_rsmessage['sender'], 0,2).'</span></div>';

                                                        ?>
                                                    </div>
                                                    <div class="kt-user-card-v2__details">
                                                        <span class="kt-user-card-v2__name"><?php echo $row_rsmessage['sender']; ?></span>
                                                        <a href="#" class="kt-user-card-v2__email kt-link"><?php echo $row_rsmessage['email']; ?></a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $row_rsmessage['title']; ?></td>
                                            <td><?php
                                                mysqli_select_db($cn, $database_cn);
                                                $query_rssettings = sprintf("SELECT `id`,`name` FROM `settings` WHERE id=%d ", $row_rsmessage['portalid']);
                                                $rssettings = mysqli_query($cn, $query_rssettings) or die(mysqli_error($cn));
                                                $row_rssettings = mysqli_fetch_assoc($rssettings);
                                                $totalRows_rssettings = mysqli_num_rows($rssettings);
                                                echo $row_rssettings['name'];
                                                ?></td>
                                            <td><span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill"><?php echo $row_rsmessage['created_at']; ?></span></td>

                                            <td><?php
                                                if ($row_rsmessage['read'] === '1') {
                                                    echo '<span class="kt-badge kt-badge--warning kt-badge--inline kt-badge--pill">خوانده شده</span>';
                                                } elseif ($row_rsmessage['read'] === '0') {
                                                    echo '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">خوانده نشده</span>';
                                                } else {
                                                    echo '<span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill">نا مشخص</span>';
                                                }
                                                ?>
                                                <br>
                                                <?php
                                                if ($row_rsmessage['status'] == '1') {
                                                    echo '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill mt-1">فعال</span>';
                                                } elseif ($row_rsmessage['status'] == '0') {
                                                    echo '<span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill mt-1">غیر فعال</span>';
                                                } else {
                                                    echo '<span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill mt-1">نا مشخص</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if (in_array("change_status", $privilegeslist)) { ?><a
                                                    class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                                    href="<?php ?>../../change_status.php?table=<?php echo encrypt('message', session_id() . "sts"); ?>&field=<?php echo encrypt('status', session_id() . "sts"); ?>&id=<?php echo encrypt($row_rsmessage['id'], session_id() . "sts"); ?>">
                                                        <i class="la la-toggle-on"></i>
                                                    </a><?php } ?>
                                                <?php if (in_array("messages_det", $privilegeslist)) { ?>
                                                    <a href="messages_det.php?id=<?php echo encrypt($row_rsmessage['id'], session_id() . "msg"); ?>"
                                                       class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                                       title="چزئیات">
                                                        <i class="la la-search"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } while ($row_rsmessage = mysqli_fetch_assoc($rsmessage));
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
<script type="text/javascript">
    "use strict";
    var KTDatatablesBasicPaginations = {
        init: function () {
            $("#message_table").DataTable({
                responsive: !0,
                pagingType: "full_numbers",
                columnDefs: []
            })
        }
    };
    jQuery(document).ready(function () {
        KTDatatablesBasicPaginations.init()
    });
</script>

<!--end::Page Scripts -->
</body>
</html>