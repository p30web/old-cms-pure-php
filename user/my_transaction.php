<?php

include("checklogin.php");

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}



mysqli_select_db($cn, $database_cn);

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $query_block_transaction = sprintf("SELECT * FROM `block_transaction` WHERE `member_id` = ".$fetch_admin[0]['admin_id']." ORDER BY `created_at` DESC");
}else{
    $query_block_transaction = sprintf("SELECT * FROM `block_transaction` WHERE `member_id` = ".$_SESSION['member_id']." ORDER BY `created_at` DESC");
}

$block_transaction = mysqli_query($cn, $query_block_transaction) or die(mysqli_error($cn));
$row_block_transaction = mysqli_fetch_assoc($block_transaction);
$totalRows_block_transaction = mysqli_num_rows($block_transaction);

?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | گردش حساب</title>
    <?php include("root-head.php"); ?>
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-page--loading-enabled kt-page--loading kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-subheader--enabled kt-subheader--transparent kt-page--loading">

<!-- begin::Page loader -->

<!-- end::Page Loader -->
<!-- begin:: Page -->
<?php include("Components/mobile_header.php"); ?>
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">
            <?php include("Components/header.php"); ?>
            <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                    <!-- begin:: Subheader -->
                    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                        <div class="kt-container ">
                            <div class="kt-subheader__main">

                                <h3 class="kt-subheader__title">
                                    گردش حساب </h3>
                                <span class="kt-subheader__separator kt-hidden"></span>
                                <div class="kt-subheader__breadcrumbs">
                                    <a href="#" class="kt-subheader__breadcrumbs-home">
                                        <i class="flaticon2-shelter"></i></a>
                                    <span class="kt-subheader__breadcrumbs-separator"></span>
                                    <a href="index.php" class="kt-subheader__breadcrumbs-link">
                                        داشبورد
                                    </a>

                                    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end:: Subheader -->
                    <!-- begin:: Content -->
                    <div class="kt-container  kt-grid__item kt-grid__item--fluid">

                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-line-chart"></i>
			</span>
                                    <h3 class="kt-portlet__head-title">
                                        لیست تراکنش های من
                                    </h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable" id="trans_table">
                                    <thead>
                                    <tr>
                                        <th>کد تراکنش</th>
                                        <th>تاریخ ثبت</th>
                                        <th>ملبغ</th>
                                        <th>توضیحات</th>
                                        <th>نوع تراکنش</th>
                                        <th>وضعیت</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    if($totalRows_block_transaction > 0) {

                                        do {

                                            ?>
                                            <tr>
                                                <td><span class="kt-badge kt-badge--primary kt-badge--inline kt-badge--pill kt-badge--rounded"><?php echo $row_block_transaction['trans_id']; ?></span></td>
                                                <td><?php echo $row_block_transaction['created_at']; ?></td>
                                                <td><strong class="kt-font-bold kt-font-primary"><?php echo $row_block_transaction['amount']; ?> <?php if(is_null($row_block_transaction['payment_method'])){ echo "DOGE";} else{echo "دلار";} ?></strong></td>
                                                <td><?php echo $row_block_transaction['description']; ?></td>
                                                <td>
                                                    <?php

                                                    switch ($row_block_transaction['invoice_type']) {
                                                        case 1:
                                                            echo '<span class="btn btn-label-info">شارژ حساب</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="btn btn-label-info">برداشت</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="btn btn-label-info">نا مشخص</span>';
                                                    }

                                                    ?>

                                                    </td>
                                                <td>
                                                    <?php

                                                    switch ($row_block_transaction['status']) {
                                                        case '0':
                                                            echo '<span class="btn btn-label-primary">درحال انتظار</span>';
                                                            break;
                                                        case '1':
                                                            echo '<span class="btn btn-label-success">موفق</span>';
                                                            break;
                                                        case '2':
                                                            echo '<span class="btn btn-label-danger">ناموفق</span>';
                                                            break;
                                                        case '3':
                                                            echo '<span class="btn btn-label-warning">خطا در تراکنش</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="btn btn-label-info">نا مشخص</span>';
                                                    }

                                                    ?>
                                                </td>

                                            </tr>
                                            <?php
                                        } while($row_block_transaction = mysqli_fetch_assoc($block_transaction));
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
            </div>

            <!-- begin:: Footer -->
            <?php include ("footer.php");?>
            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<?php include ("footer-script.php");?>
<script type="text/javascript">
    "use strict";
    var KTDatatablesBasicPaginations = {
        init: function () {
            $("#trans_table").DataTable({
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
<!-- end::Body -->

</html>