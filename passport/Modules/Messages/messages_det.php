<?php
require_once('../../checklogin.php');


$id = decrypt($_GET['id'], session_id() . "msg");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_message = $db->getOne("`message`", $cols);
$fetch_message_count = $db->count;


?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | جزئیات پیام</title>

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
                                جزئیات پیام</h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="messages_inbox.php" class="kt-subheader__breadcrumbs-link">
                                    پیام های دریافتی </a>
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
                                    پیام <?php echo $fetch_message['sender']; ?>
                                </h3>
                            </div>

                        </div>

                        <div class="kt-portlet__body">
                            <div class="kt-infobox">
                                <div class="kt-infobox__header">
                                    <h4 class="kt-infobox__title">عنوان: <span
                                                class="kt-font-primary"><?php echo $fetch_message['title']; ?></span>
                                    </h4>
                                </div>
                                <div class="kt-infobox__body">
                                    <div class="kt-infobox__section">
                                        <h3 class="kt-infobox__subtitle">متن پیام</h3>
                                        <div class="kt-infobox__content">
                                            <?php echo $fetch_message['text']; ?>
                                        </div>
                                    </div>
                                    <div class="kt-infobox__section">
                                        <h3 class="kt-infobox__subtitle">اطلاعات بیشتر</h3>
                                        <div class="kt-infobox__content">
                                            <div class="kt-section">
					<span class="kt-section__info">
						جزئیات مربوط به پیام فرستاده شده:
					</span>
                                                <div class="kt-section__content">
                                                    <table class="table">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>فرستنده</th>
                                                            <th>موبایل</th>
                                                            <th>ایمیل</th>
                                                            <th>تاریخ ارسال</th>
                                                            <th>ip</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row"><?php echo $fetch_message['sender']; ?></th>
                                                            <td><?php echo $fetch_message['mobile']; ?></td>
                                                            <td><?php echo $fetch_message['email']; ?></td>
                                                            <td><?php echo $fetch_message['created_at']; ?></td>
                                                            <td><?php echo $fetch_message['ip']; ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="change_read.php?id=<?php echo encrypt($fetch_message['id'], session_id() . "red"); ?>" class="btn btn-label-<?php if($fetch_message['read'] == 1){ echo 'warning'; }else{ echo 'success'; } ?> btn-pill">
                                        <?php
                                        if($fetch_message['read'] == 1){
                                            echo 'خوانده شده';
                                        }else{
                                            echo 'خوانده نشده';
                                        }
                                        ?>
                                    </a>
                                </div>
                            </div>
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