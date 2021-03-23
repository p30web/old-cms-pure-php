<?php

include("checklogin.php");

mysqli_select_db($cn, $database_cn);

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $query_active_investment_plan = sprintf("SELECT * FROM `active_investment_plan` WHERE member_id=".$fetch_admin[0]['admin_id']." ORDER BY modified_at DESC");
}else{
    $query_active_investment_plan = sprintf("SELECT * FROM `active_investment_plan` WHERE member_id=".$_SESSION['member_id']." ORDER BY modified_at DESC");
}
$active_investment_plan= mysqli_query($cn, $query_active_investment_plan) or die(mysqli_error($cn));
$row_active_investment_plan = mysqli_fetch_assoc($active_investment_plan);
$totalRows_active_investment_plan = mysqli_num_rows($active_investment_plan);



//$db->where("id", $_SESSION['member_id']);
//$fetch_member = $db->getOne("members");
//
//if($_SESSION['member_id'] != 98){
//    //exit();
//}

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}



$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("member_id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("member_id", $_SESSION['member_id']);
}

$db->where("type", "dollar");
$db->where("status", "1");
$ActiceDollary_plan = $db->get("active_investment_plan");


$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("member_id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("member_id", $_SESSION['member_id']);
}

$db->where("type", "dollar");
$db->where("status", "2");
$DeActiceDollary_plan = $db->get("active_investment_plan");



$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("member_id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("member_id", $_SESSION['member_id']);
}


$db->where("type", "dollar");
$AllDollary_plan = $db->get("active_investment_plan");


$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $params = Array($fetch_admin[0]['admin_id'], '1');
}else{
    $params = Array($_SESSION['member_id'], '1');
}

$ActiceDog_plan = $db->rawQuery("SELECT * FROM `active_investment_plan` WHERE `member_id` = ? AND `status` = ? AND `type` IS NULL", $params);

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $params = Array($fetch_admin[0]['admin_id'], '2');
}else{
    $params = Array($_SESSION['member_id'], '2');
}

$DeActiceDog_plan = $db->rawQuery("SELECT * FROM `active_investment_plan` WHERE `member_id` = ? AND `status` = ? AND `type` IS NULL", $params);


if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $params = Array($fetch_admin[0]['admin_id']);
}else{
    $params = Array($_SESSION['member_id']);
}

$AllDog_plan = $db->rawQuery("SELECT * FROM `active_investment_plan` WHERE `member_id` = ? AND `type` IS NULL", $params);




?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | پلن های فعال</title>
    <?php include("root-head.php"); ?>
    <style>
        .kt-callout .kt-callout__body .kt-callout__content .kt-callout__title {
            font-size: 1rem;
        }
        .kt-pw-success {
            border: 2px solid #3d8c40;
            box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -moz-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -webkit-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -ms-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -o-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
        }

        .kt-pw-primary {
            border: 2px solid #587de6;
            box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -moz-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -webkit-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -ms-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -o-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
        }

        .kt-pw-danger {
            border: 2px solid #fd27eb;
            box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -moz-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -webkit-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -ms-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -o-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
        }

        .kt-pw-warning {
            border: 2px solid #ffb822;
            box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -moz-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -webkit-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -ms-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
            -o-box-shadow: 1px 1px 7px rgba(0,0,0,.1);
        }

    </style>
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
                                    پلن های فعال
                                </h3>

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
                        <!--begin::Portlet-->
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--info">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    تعداد کل پلن ها
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-info">
                                                    <?php
                                                    echo $totalRows_active_investment_plan;
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
                                                    پلن های فعال
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-success">
                                                    <?php
                                                    $db->where("status", "1");
                                                    $db->where("member_id", $fetch_member['id']);
                                                    $db->get("active_investment_plan", null, "id");
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
                                                    پلن های غیر فعال
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    <?php
                                                    $db->where("status", "1", "!=");
                                                    $db->where("member_id", $fetch_member['id']);
                                                    $db->get("active_investment_plan", null, "id");
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
                            <div class="col-lg-3">
                                <div class="kt-portlet kt-callout kt-callout--info">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    پلن های فعال دلاری
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-info">
                                                    <?php echo count($ActiceDollary_plan); ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="kt-portlet kt-callout kt-callout--danger">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    کل پلن های دلاری
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    <?php echo count($AllDollary_plan); ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="kt-portlet kt-callout kt-callout--success">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    پلن های غیر فعال دوج کوین
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-success">
                                                    <?php echo count($DeActiceDog_plan); ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="kt-portlet kt-callout kt-callout--info">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    پلن های فعال دوج کوین
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-info">
                                                    <?php echo count($ActiceDog_plan); ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="kt-portlet kt-callout kt-callout--success">
                                    <div class="kt-portlet__body">
                                        <div class="kt-callout__body">
                                            <div class="kt-callout__content">
                                                <h3 class="kt-callout__title">
                                                    پلن های غیر فعال دلاری
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-success">
                                                    <?php echo count($DeActiceDollary_plan); ?>
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
                                                    کل پلن های دوج کوین
                                                </h3>
                                                <p class="kt-callout__desc">
                                                    تا ساعت <?php echo jdate("H:i:s"); ?>
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    <?php echo count($AllDog_plan); ?>
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
                                                    به زودی
                                                </h3>
                                                <p class="kt-callout__desc" style="color: #f9eafb;">
                                                    ....
                                                </p>
                                            </div>
                                            <div class="kt-callout__action">
                                                <h3 class="kt-font-danger">
                                                    0
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
											<span class="kt-portlet__head-icon">
												<i class="fa fa-donate kt-menu__link-icon"></i>
											</span>
                                    <h3 class="kt-portlet__head-title">
                                        وضعیت درآمدی شما :
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <?php
                                //                                        $db->where("member_id", $fetch_member['id']);
                                //                                        $db->where("status", '1');
                                //                                        $fetch_active_plan = $db->get("active_investment_plan", null);

                                $params = Array($_SESSION['member_id'], '1');
                                $fetch_active_plan = $db->rawQuery("SELECT * FROM `active_investment_plan` WHERE `member_id` = ? AND `status` = ? AND `type` IS NULL", $params);

                                $tleft = mktime(24,0,0) - time();

                                $tdy_balance = 0;
                                foreach ($fetch_active_plan as $value){

                                    $timestamp = "1313000474";

                                    $date = date('Y-m-d', $value['time']);
                                    $today = date('Y-m-d');

                                    if ($date == $today) {
                                        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                    }else{
                                        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                    }


                                    //                            $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="kt-portlet kt-callout kt-callout--success kt-pw-success">
                                            <div class="kt-portlet__body">
                                                <div class="kt-callout__body">
                                                    <div class="kt-callout__content" style="flex: 1;">
                                                        <h3 class="kt-callout__title">
                                                            درآمد کل از دوج کوین
                                                        </h3>
                                                        <p class="kt-callout__desc">
                                                            تا ساعت <?php echo jdate("H:i:s"); ?>
                                                        </p>
                                                    </div>
                                                    <div class="kt-callout__action">
                                                        <h3 class="kt-font-success" id="totalIncome">
                                                            <?php

                                                            echo ($fetch_member['profit'] > 0) ? number_format((float)$fetch_member['profit']+$tdy_balance, 8, '.', '') : number_format((float)$tdy_balance, 8, '.', '');
                                                            ?>
                                                            DOGE</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="kt-portlet kt-callout kt-callout--primary kt-pw-primary">
                                            <div class="kt-portlet__body">
                                                <div class="kt-callout__body">
                                                    <div class="kt-callout__content" style="flex: 1;">
                                                        <h3 class="kt-callout__title">
                                                            درآمد امروز دوج کوین
                                                        </h3>
                                                        <p class="kt-callout__desc">
                                                            تا ساعت <?php echo jdate("H:i:s"); ?>
                                                        </p>
                                                    </div>
                                                    <div class="kt-callout__action">
                                                        <h3 class="kt-font-primary" id="todayIncome">
                                                            <?php
                                                            echo number_format((float)$tdy_balance, 8, '.', '');
                                                            ?>
                                                            DOGE
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php

                                $db->where("member_id", $_SESSION['member_id']);
                                $db->where("type", "dollar");
                                $db->where("status", "1");
                                $fetch_active_plan = $db->get("active_investment_plan");

                                $tleft = mktime(24,0,0) - time();

                                $tdy_balance = 0;

                                foreach ($fetch_active_plan as $value){

                                    $timestamp = "1313000474";

                                    $date = date('Y-m-d', $value['time']);
                                    $today = date('Y-m-d');

                                    if ($date == $today) {
                                        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                    }else{
                                        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                    }

                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="kt-portlet kt-callout kt-callout--danger kt-pw-danger">
                                            <div class="kt-portlet__body">
                                                <div class="kt-callout__body">
                                                    <div class="kt-callout__content" style="flex: 1;">
                                                        <h3 class="kt-callout__title">
                                                            کل درآمد دلاری :
                                                        </h3>
                                                        <p class="kt-callout__desc">
                                                            تا ساعت <?php echo jdate("H:i:s"); ?>
                                                        </p>
                                                    </div>
                                                    <div class="kt-callout__action">
                                                        <h3 class="kt-font-danger" id="totalDollarIncome">
                                                            <?php

                                                            echo ($fetch_member['profit'] > 0) ? number_format((float)$fetch_member['profit']+$tdy_balance, 8, '.', '') : number_format((float)$tdy_balance, 8, '.', '');
                                                            ?>
                                                            Dollar</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="kt-portlet kt-callout kt-callout--warning kt-pw-warning">
                                            <div class="kt-portlet__body">
                                                <div class="kt-callout__body">
                                                    <div class="kt-callout__content" style="flex: 1;">
                                                        <h3 class="kt-callout__title">
                                                            درآمد دلاری امروز
                                                        </h3>
                                                        <p class="kt-callout__desc">
                                                            تا ساعت <?php echo jdate("H:i:s"); ?>
                                                        </p>
                                                    </div>
                                                    <div class="kt-callout__action">
                                                        <h3 class="kt-font-warning" id="todayDollarIncome">
                                                            <?php
                                                            echo number_format((float)$tdy_balance, 8, '.', '');
                                                            ?>
                                                            Dollar
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
											<span class="kt-portlet__head-icon">
												<i class="fa fa-donate kt-menu__link-icon"></i>
											</span>
                                    <h3 class="kt-portlet__head-title">
                                        پلن های سرمایه گذاری شما :
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <?php
                                if($totalRows_active_investment_plan > 0) {
                                    ?>
                                    <div class="kt-pricing-1">
                                        <div class="kt-pricing-1__items row">

                                            <?php
                                            do {

//                                                $params = Array($row_active_investment_plan['plan_id']);
//                                                $row_investment_plan = $db->rawQuery("SELECT * FROM `investment_plan` WHERE `id` = ?", $params);

                                                // print_r($row_investment_plan);


                                                mysqli_select_db($cn, $database_cn);
                                                $query_investment_plan = sprintf("SELECT * FROM `investment_plan` WHERE id = " . $row_active_investment_plan['plan_id'] . " ");
                                                $investment_plan = mysqli_query($cn, $query_investment_plan) or die(mysqli_error($cn));
                                                $row_investment_plan = mysqli_fetch_assoc($investment_plan);

                                                ?>
                                                <div class="kt-pricing-1__item col-lg-3">
                                                    <div class="kt-portlet__head kt-portlet__head--right kt-portlet__head--noborder  kt-ribbon kt-ribbon--clip kt-ribbon--left kt-ribbon--info">
                                                        <div class="kt-ribbon__target" style="top: 12px;">
                                                            <span class="kt-ribbon__inner"></span><?php
                                                            active_plan_status($row_active_investment_plan['status']);
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <span class="kt-pricing-1__price"><?php echo $row_active_investment_plan['price'] ?>
                                                        <?php echo (is_null($row_active_investment_plan['type'])) ? "Ð" : "$"; ?> </span>
                                                    <h2 class="kt-pricing-1__subtitle"><?php echo $row_active_investment_plan['title'] ?></h2>
                                                    <span class="kt-pricing-1__description">
														<ul class="pricing_plan_detail">
															<li><span>درصد سود:</span><strong><?php echo $row_active_investment_plan['interest_rate']; ?>
																%</strong></li>
															<li><span>سود در هر روز:</span><strong>
																<?php
                                                                $d = $row_active_investment_plan['price'] * ($row_active_investment_plan['interest_rate'] / 100);
                                                                if ($row_active_investment_plan['period_type'] === "month") {
                                                                    echo number_format((float)$d / 30, 2, '.', '');
                                                                }

                                                                else if ($row_active_investment_plan['period_type'] === "3month") {
                                                                    echo number_format((float)$d / 30, 2, '.', '');
                                                                }

                                                                else if ($row_active_investment_plan['period_type'] === "6month") {
                                                                    echo number_format((float)$d / 30, 2, '.', '');
                                                                }

                                                                else if ($row_active_investment_plan['period_type'] === "yearly") {
                                                                    echo number_format((float)$d / 30, 2, '.', '');
                                                                }

                                                                else if ($row_active_investment_plan['period_type'] === "day") {
                                                                    echo number_format((float)$d, 2, '.', '');
                                                                }
                                                                ?> <?php echo (is_null($row_active_investment_plan['type'])) ? "Ð" : "$"; ?>
																</strong></li>
															<li><span>سود در هر ماه:</span><strong>
																<?php
                                                                $d = $row_active_investment_plan['price'] * ($row_active_investment_plan['interest_rate'] / 100);
                                                                if ($row_active_investment_plan['period_type'] === "month") {
                                                                    echo $d;
                                                                }
                                                                else {
                                                                    echo $d;
                                                                }
                                                                ?> <?php echo (is_null($row_active_investment_plan['type'])) ? "Ð" : "$"; ?>
																</strong></li>
															<li><span>دوره زمانی:</span><strong> <?php
                                                                    if ($row_active_investment_plan['period_type'] === "month") {
                                                                        echo $row_active_investment_plan['period'] . ' ماه';
                                                                    } else if ($row_active_investment_plan['period_type'] === "day") {
                                                                        echo $row_active_investment_plan['period'] . ' روز';
                                                                    }

                                                                    else if ($row_active_investment_plan['period_type'] === "3month") {
                                                                        echo 'سه ماه';
                                                                    }
                                                                    else if ($row_active_investment_plan['period_type'] === "6month") {
                                                                        echo 'شش ماه';
                                                                    }

                                                                    else if ($row_active_investment_plan['period_type'] === "yearly") {
                                                                        echo 'یکساله';
                                                                    }


                                                                    ?>
																</strong></li>
														</ul>
													</span>
                                                    <div class="kt-pricing-1__btn">
                                                        <?php if(is_null($row_active_investment_plan['type'])) : ?>
                                                            <a href="active_pln_details.php?id=<?php echo encrypt($row_active_investment_plan['id'], session_id()."acp")?>"
                                                               class="btn btn-brand btn-custom btn-pill btn-wide btn-uppercase btn-bolder btn-sm">
                                                                جزئیات پلن
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if(!is_null($row_active_investment_plan['type'])) : ?>
                                                            <a href="active_pln_details.php?type=dollar&id=<?php echo encrypt($row_active_investment_plan['id'], session_id()."acp")?>"
                                                               class="btn btn-brand btn-custom btn-pill btn-wide btn-uppercase btn-bolder btn-sm">
                                                                جزئیات پلن
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php
                                            } while ($row_active_investment_plan = mysqli_fetch_assoc($active_investment_plan));

                                            ?>


                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo '<h4 class="kt-font-primary text-center">شما پلن فعالی ندارید!</h4>';
                                }
                                ?>
                            </div>
                        </div>
                        <!--end::Portlet-->
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
<script>
    $(document).ready(function(){

        function counterPlan() {
            $.ajax({
                url: "api/active_plan_counter.php",
                method: "GET",
                success: function (t, s, r, a) {

                    if (r.status === 200) {
                        $('.kt-callout__desc').html('تا ساعت '+r.responseJSON.message)
                        $('#todayIncome').html(r.responseJSON.todayIncome+' DOGE')
                        $('#totalIncome').html(r.responseJSON.totalIncome+' DOGE')
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {

                }
            });
            setTimeout(function(){
                counterPlan()
            }, 1000);
        }
        counterPlan();

        function DollarcounterPlan() {
            $.ajax({
                url: "api/dollar_active_plan_counter.php",
                method: "GET",
                success: function (t, s, r, a) {

                    if (r.status === 200) {
                        //$('.kt-callout__desc').html('تا ساعت '+r.responseJSON.message)
                        $('#todayDollarIncome').html(r.responseJSON.todayIncome+' Dollar')
                        $('#totalDollarIncome').html(r.responseJSON.totalIncome+' Dollar')
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {

                }
            });
            setTimeout(function(){
                DollarcounterPlan()
            }, 1000);
        }
        DollarcounterPlan();
    });
</script>
</html>