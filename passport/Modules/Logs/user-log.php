<?php
require_once('../../checklogin.php');

if(isset($_GET['userid'])){
    $userid = $_GET['userid'];
}else{
    exit("خطایی رخ داده است.");
}

if(isset($_GET['table'])){
    if(empty($_GET['table'])){
        $user_table = 15;
    }else {
        $user_table = $_GET['table'];
    }
}else{
    $user_table = 15;
}



if(!is_numeric($userid)){
    exit("خطایی رخ داده است.");
}

?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

<!-- /Added by HTTrack -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | مدیریت فعالیت ها</title>
    <style>
        .pagination {
            list-style-type: none;
            padding: 10px 0;
            display: inline-flex;
            justify-content: space-between;
            box-sizing: border-box;
            width: 225px;
        }
        .pagination li {
            box-sizing: border-box;
            padding-right: 10px;
        }
        .pagination li a {
            box-sizing: border-box;
            background-color: #e2e6e6;
            padding: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            color: #616872;
            border-radius: 4px;
        }
        .pagination li a:hover {
            background-color: #d4dada;
        }
        .pagination .next a, .pagination .prev a {
            text-transform: uppercase;
            font-size: 12px;
        }
        .pagination .currentpage a {
            background-color: #518acb;
            color: #fff;
        }
        .pagination .currentpage a:hover {
            background-color: #518acb;
        }
    </style>
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
                                تیک های پشتیبانی </h3>

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
                                    <?php echo "لیست کامل فعالیت های اخیر کاربر : " . " " . $userid; ?>
                                </h3>
                            </div>

                        </div>

                        <div class="kt-portlet__body">
                            <!--begin: Datatable -->
                            <?php

                            //											mysqli_select_db($DbLog, $log_database_cn2);
                            //											$query_message = sprintf("SELECT * FROM `member_activity` ORDER BY type ASC, id DESC");
                            //
                            //                                            $rsmessage = mysqli_query($DbLog, $query_message) or die(mysqli_error($DbLog));
                            //											$row_rsmessage = mysqli_fetch_assoc($rsmessage);
                            //											$totalRows_rsmessage = mysqli_num_rows($rsmessage);

                            //var_dump(11111111111111111);

                            $mysqli = mysqli_connect('localhost', "irandoge_ird_usr", "xhrC.NMS1?%)", "irandoge_dogecoin_log");

                            $mysqli->set_charset("utf8");

                            if($user_table == 15){
                                $query = 'SELECT COUNT(*) FROM `member_activity` WHERE `user_id` =' . $userid;
                                //var_dump($query);
                            }else{
                                $query = 'SELECT COUNT(*) FROM `member_activity` WHERE `user_id` = ' . $userid . ' AND `table` LIKE ' . "'" . $user_table . "'";
                                //var_dump($query);
                            }

                            // Get the total number of records from our table "students".
                            $total_pages = $mysqli->query($query)->fetch_row()[0];



                            //var_dump($total_pages);

                            // Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
                            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

                            // Number of results to show on each page.
                            $num_results_on_page = 50;

                            if($user_table == 15){
                                $query_table = 'SELECT * FROM `member_activity` WHERE `user_id` = ? ORDER BY id DESC LIMIT ?,?';
                            }else{
                                $query_table = 'SELECT * FROM `member_activity` WHERE `user_id` = ? AND `table` = ? ORDER BY id DESC LIMIT ?,?';
                                //var_dump($query_table);
                            }

                            if ($stmt = $mysqli->prepare($query_table)) {
                                // Calculate the page to get the results we need from our table.
                                $calc_page = ($page - 1) * $num_results_on_page;

                                if($user_table == 15){
                                    $stmt->bind_param('sss', $userid,$calc_page, $num_results_on_page);
                                }else{
                                    $stmt->bind_param('ssss', $userid,$user_table,$calc_page, $num_results_on_page);
                                }

                                $stmt->execute();
                                // Get the results...
                                $result = $stmt->get_result();
                                $stmt->close();
                            }

                            ?>


                            <table class="table table-striped- table-bordered table-hover table-checkable">
                                <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>ای پی کاربر</th>
                                    <th>شناسه کاربر</th>
                                    <th>زمان</th>
                                    <th>جدول</th>
                                    <th>نوع درخواست</th>
                                    <th>پیام</th>
                                </tr>
                                </thead>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['user_ip']; ?></td>
                                        <td><a href="https://irandogebank.com/passport/Modules/Logs/user-log.php?userid=<?php echo $row['user_id']; ?>" ><span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill"><?php echo $row['user_id']; ?></span></a> </td>
                                        <td><span class="kt-badge kt-badge--warning kt-badge--inline kt-badge--pill"><?php  echo jdate( "Y/m/d - H:i:s" , $row['time'] ); ?></span></td>
                                        <td><span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill"><?php echo $row['table']; ?></span></td>
                                        <td><span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill"><?php echo $row['type']; ?></span></td>
                                        <td><span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill"><?php echo $row['message']; ?></span></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>

                            <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="prev"><a href="user-log.php?userid=<?php echo $userid; ?>&?page=<?php echo $page-1 ?>">قبلی</a></li>
                                    <?php endif; ?>

                                    <?php if ($page > 3): ?>
                                        <li class="start"><a href="user-log.php?userid=<?php echo $userid; ?>&page=1">1</a></li>
                                        <li class="dots">...</li>
                                    <?php endif; ?>

                                    <?php if ($page-2 > 0): ?><li class="page"><a href="user-log.php?userid=<?php echo $userid; ?>&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                                    <?php if ($page-1 > 0): ?><li class="page"><a href="user-log.php?userid=<?php echo $userid; ?>&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                                    <li class="currentpage"><a href="user-log.php?userid=<?php echo $userid; ?>&page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                    <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="user-log.php?userid=<?php echo $userid; ?>&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                                    <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page"><a href="user-log.php?userid=<?php echo $userid; ?>&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                                    <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                                        <li class="dots">...</li>
                                        <li class="end"><a href="user-log.php?userid=<?php echo $userid; ?>&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                    <?php endif; ?>

                                    <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                        <li class="next"><a href="user-log.php?userid=<?php echo $userid; ?>&page=<?php echo $page+1 ?>">بعدی</a></li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>


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
            $("#message_table").DataTable()
        }
    };
    jQuery(document).ready(function () {
        KTDatatablesBasicPaginations.init()
    });
</script>

<!--end::Page Scripts -->
</body>
</html>