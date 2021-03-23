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

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$Id = null;

if(isset($_GET['id'])){
    $Id = test_input($_GET['id']);
}else{
    exit('خطایی رخ داده است.');
}

if($Id == null){
    exit('خطایی رخ داده است.');
}




?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | داشبورد</title>
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
                                    درآمد کسب شده </h3>
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
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--info">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    درآمد کل حساب دوج کوین :
                                                </h3>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-info">
                                                    <?php

                                                    $db->where("member_id", $Id);
                                                    $db->where("status", '1');
                                                    $fetch_active_plan = $db->get("active_investment_plan", null);

                                                    $tleft = mktime(24,0,0) - time();

                                                    $tdy_balance = 0;
                                                    foreach ($fetch_active_plan as $value) {


                                                        $date = date('Y-m-d', $value['time']);
                                                        $today = date('Y-m-d');

                                                        if ($date == $today) {
                                                            $tdy_balance += $value['daily_profit'] - ($value['daily_profit'] / 24 / 60 / 60 * $tleft);
                                                        } else {
                                                            $tdy_balance += $value['daily_profit'] - ($value['daily_profit'] / 24 / 60 / 60 * $tleft);
                                                        }
                                                    }

                                                    echo ($fetch_member['profit'] > 0) ? number_format((float)$fetch_member['profit']+$tdy_balance, 8, '.', '') : number_format((float)$tdy_balance, 8, '.', '');

                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--success">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    درآمد کل دلاری کاربر :
                                                </h3>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-success">
                                                    <?php

                                                    $db->where("member_id", $Id);
                                                    $db->where("type", "dollar");
                                                    $db->where("status", '1');
                                                    $fetch_active_plan = $db->get("active_investment_plan", null);

                                                    $tleft = mktime(24,0,0) - time();

                                                    $tdy_balance = 0;

                                                    echo ($fetch_member['dollar_profit'] > 0) ? number_format((float)$fetch_member['dollar_profit']+$tdy_balance, 8, '.', '') : number_format((float)$tdy_balance, 8, '.', '');

                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--danger">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    تعداد پلن های کاربر :
                                                </h3>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    <?php
                                                    $db->where("member_id", $Id);
                                                    $db->get("active_investment_plan");
                                                    echo $db->count;

                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--danger">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    پلن های فعال کاربر :
                                                </h3>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    <?php
                                                    $db->where("member_id", $Id);
                                                    $db->where("status", 1);
                                                    $db->get("active_investment_plan");
                                                    echo $db->count;

                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--danger">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    پلن های غیرفعال کاربر :
                                                </h3>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    <?php
                                                    $db->where("member_id", $Id);
                                                    $db->where("status", 2);
                                                    $db->get("active_investment_plan");
                                                    echo $db->count;

                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--danger">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    پلن های لغوی کاربر :
                                                </h3>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    <?php
                                                    $db->where("member_id", $Id);
                                                    $db->where("status", 3);
                                                    $db->get("active_investment_plan");
                                                    echo $db->count;

                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="trans_table" role="grid" aria-describedby="trans_table_info" style="width: 1268px;">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 452.25px;">شماره پلن</th>
                                    <th class="sorting" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 102.25px;" >عنوان</th>
                                    <th class="sorting" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 154.25px;" >سود روزانه</th>
                                    <th class="sorting" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 173.25px;" >قیمت</th>
                                    <th class="sorting" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 86.25px;" >درصد سود</th>
                                    <th class="sorting" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 86.25px;" >بازه زمانی</th>
                                    <th class="sorting" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 56.25px;" >وضعیت</th>
                                    <th class="sorting" tabindex="0" aria-controls="trans_table" rowspan="1" colspan="1" style="width: 56.25px;" >نوع</th>
                                </tr>
                                </thead>

                                <tbody>

                                <?php

                                $db->where("member_id", $Id);
                                $fetch_active_plan = $db->get("active_investment_plan", null);

                                //print_r($fetch_active_plan);

                                if(count($fetch_active_plan) != 0){
                                    foreach ($fetch_active_plan as $item){
                                        echo '<tr role="row" class="odd">';

                                        echo '<td>پلن : ' . $item['id'] . '</td>';
                                        echo '<td>' . $item['title'] . '</td>';
                                        echo '<td>' . $item['daily_profit'] . '</td>';
                                        echo '<td>' . $item['price'] . '</td>';
                                        echo '<td>' . $item['interest_rate'] . '</td>';
                                        echo '<td>' . $item['period'] . ' ماه </td>';

                                        if($item['status'] == 1){
                                            echo '<td> فعال </td>';
                                        }elseif($item['status'] == 2){
                                            echo '<td> غیرفعال </td>';
                                        }elseif($item['status'] == 3){
                                            echo '<td> لغو شده </td>';
                                        }

                                        if(is_null($item['type'])){
                                            echo '<td> دوج کوین </td>';
                                        }else{
                                            echo '<td> دلاری </td>';
                                        }


                                        echo '</tr>';

                                    }
                                }



                                ?>


                                </tbody>

                            </table>
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

<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>