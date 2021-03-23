<?php

include("checklogin.php");

//if($_SESSION['member_id'] != 98){
//    exit();
//}

$PlanType = "dog";

if(isset($_GET['plan-type'])){
    if($_GET['plan-type'] == "dog"){
        $PlanType = "dog";
    } elseif ($_GET['plan-type'] == "dollar"){
        $PlanType = "dollar";
    }
}


mysqli_select_db($cn, $database_cn);
if($PlanType == "dollar"){
    $query_investment_plan = sprintf("SELECT * FROM `dollar_investment_plan` WHERE status = '1' AND `end_date` IS NULL ORDER BY sort ASC");
}elseif ($PlanType == "dog"){
    $query_investment_plan = sprintf("SELECT * FROM `investment_plan` WHERE status = '1' AND `end_date` IS NULL ORDER BY sort ASC");
}
$investment_plan = mysqli_query($cn, $query_investment_plan) or die(mysqli_error($cn));
$row_investment_plan = mysqli_fetch_assoc($investment_plan);
$totalRows_investment_plan = mysqli_num_rows($investment_plan);



?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | پلن های سرمایه گذاری</title>
    <?php include("root-head.php"); ?>
    <style>
        a.active-type {
            background: #3d94fb !important;
            color: #fff !important;
            border: 2px solid transparent !important;
        }
        .plan-t2{
            border-radius: 3px;
            width: 100px;
            display: inline-block;
            margin-left: 5px;
            font-size: 15px;
            text-align: center;
            padding: 7px 13px;
            background: transparent;
            color: #3d94fb;
            border: 2px solid #5867dd;
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
                                    پلن های سرمایه گذاری
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
                        <div class="kt-portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon">
                                        <i class="fa fa-donate kt-menu__link-icon"></i>
                                    </span>
                                    <h3 class="kt-portlet__head-title">
                                        پلن های سرمایه گذاری
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">

                                <div class="select-plan-box" style="border: 2px solid #b5bcdf;padding: 10px;margin: 7px;background: #f9f9fc;border-radius: 5px;">

                                    <div class="p30web" style="
    font-size: 16px;
    padding-top: 5px;
">نوع پلنی که میخواهید سرمایه گذاری کنید را انتخاب کنید : </div><div class="box" style="
    /* width: 100%; */
    height: 50px;
    margin-top: 17px;
">
                                        <a href="https://www.irandogebank.com/user/pricing_plan.php?plan-type=dog" class="plan-t2 <?php echo ($PlanType == "dog") ? 'active-type' : ''; ?>">دوج کوین</a>
                                        <a href="https://www.irandogebank.com/user/pricing_plan.php?plan-type=dollar" class="plan-t2 <?php echo ($PlanType == "dollar") ? 'active-type' : ''; ?>">دلار</a>
                                    </div>

                                </div>
                                <div class="kt-pricing-1" style="border: 2px solid #b5bcdf;border-radius: 4px;margin: 6px;">

                                    <?php

                                    if($PlanType == "dog"){
                                        $text = "دوج کوین";
                                    }elseif ($PlanType == "dollar"){
                                        $text = "دلاری";
                                    }

                                    ?>

                                    <h3 class="kt-portlet__head-title" style="margin-top: 21px;margin-bottom: 2px;">
                                        <?php echo "پلن های سرمایه گذاری : " . " " . $text?>
                                    </h3>
                                    <div class="kt-pricing-1__items row">
                                        <?php
                                        do {
                                            ?>
                                            <div class="kt-pricing-1__item col-lg-3">

                                                <span class="kt-pricing-1__price"><?php

                                                    if($PlanType == "dog"){
                                                        echo $row_investment_plan['price'];
                                                        echo " Ð ";
                                                    }elseif ($PlanType == "dollar"){
                                                        echo $row_investment_plan['price'];
                                                        echo " $ ";
                                                    }

                                                    ?>

                                                </span>
                                                <h2 class="kt-pricing-1__subtitle"><?php echo $row_investment_plan['title'] ?></h2>
                                                <span class="kt-pricing-1__description">
                                                <ul class="pricing_plan_detail">
                                <li><span>درصد سود:</span><strong><?php echo $row_investment_plan['interest_rate']; ?>
                                        %</strong></li>
                                <li><span>سود در هر روز:</span><strong>
                                         <?php

                                         if($PlanType == "dog"){
                                             echo " Ð ";
                                         }

                                         $d = $row_investment_plan['price'] * ($row_investment_plan['interest_rate'] / 100);
                                         if ($row_investment_plan['period_type'] === "month") {
                                             echo number_format((float)$d / 30, 2, '.', '');
                                         } else if ($row_investment_plan['period_type'] === "day") {
                                             echo number_format((float)$d, 2, '.', '');
                                         }

                                         if ($PlanType == "dollar"){
                                             echo " $ ";
                                         }
                                         ?>



                                    </strong></li>
                                <li><span>سود در هر ماه:</span><strong>
                                        <?php

                                        if($PlanType == "dog"){
                                            echo " Ð ";
                                        }

                                        $d = $row_investment_plan['price'] * ($row_investment_plan['interest_rate'] / 100);
                                        if ($row_investment_plan['period_type'] === "month") {
                                            echo $d;
                                        }

                                        if ($PlanType == "dollar"){
                                            echo " $ ";
                                        }


                                        ?>
                                    </strong></li>
                                <li><span>دوره زمانی:</span><strong> <?php
                                        if ($row_investment_plan['period_type'] === "month") {
                                            echo $row_investment_plan['period'] . ' ماه';
                                        } else if ($row_investment_plan['period_type'] === "day") {
                                            echo $row_investment_plan['period'] . ' روز';
                                        }
                                        ?>
                                    </strong></li>
                            </ul>
                                            </span>
                                                <div class="kt-pricing-1__btn">

                                                    <?php if($PlanType == "dog") : ?>
                                                        <button type="button" onclick="ByPlan(<?php echo $row_investment_plan['id']; ?>)"
                                                                class="btn btn-brand btn-custom btn-pill btn-wide btn-uppercase btn-bolder btn-sm">
                                                            خرید پلن
                                                        </button>
                                                    <?php endif; ?>
                                                    <?php if($PlanType == "dollar") : ?>
                                                        <button type="button" onclick="ByPlanDollary(<?php echo $row_investment_plan['id']; ?>)"
                                                                class="btn btn-brand btn-custom btn-pill btn-wide btn-uppercase btn-bolder btn-sm">
                                                            خرید پلن
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php
                                        } while($row_investment_plan = mysqli_fetch_assoc($investment_plan));
                                        ?>
                                    </div>
                                </div>
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
<script>
    function ByPlan(i) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };


        if (i != null && i !== 0) {
            swal.fire({
                title: "آیا مطمئن هستید؟",
                text: "آیا میخواهید پلن مورد نظر را فعال کنید؟",
                type: "warning",
                showCancelButton: !0,
                cancelButtonText: "لغو!",
                confirmButtonText: "بله، فعال شود"
            }).then(function (e) {
                e.value && $.ajax({
                    type: "GET",
                    url: "api/buy_plan.php",
                    data: {pid: i},
                    success: function (data) {
                        if (data.status === 200 && data.type === "success") {
                            toastr.success(data.message);
                        }else if (data.status === 200 && data.type === "error") {
                            toastr.error(data.message);
                        }else if (data.status === 200 && data.type === "warning") {
                            toastr.warning(data.message);
                        }
                    },
                });
            });

        }
    }
    function ByPlanDollary(i) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };


        if (i != null && i !== 0) {
            swal.fire({
                title: "آیا مطمئن هستید؟",
                text: "آیا میخواهید پلن مورد نظر را فعال کنید؟",
                type: "warning",
                showCancelButton: !0,
                cancelButtonText: "لغو!",
                confirmButtonText: "بله، فعال شود"
            }).then(function (e) {
                e.value && $.ajax({
                    type: "GET",
                    url: "api/dollar_buy_plan.php",
                    data: {pid: i},
                    success: function (data) {
                        if (data.status === 200 && data.type === "success") {
                            toastr.success(data.message);
                        }else if (data.status === 200 && data.type === "error") {
                            toastr.error(data.message);
                        }else if (data.status === 200 && data.type === "warning") {
                            toastr.warning(data.message);
                        }
                    },
                });
            });

        }
    }
</script>
</body>
<!-- end::Body -->

</html>