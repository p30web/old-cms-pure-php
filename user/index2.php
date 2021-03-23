<?php

include("checklogin.php");

$fetch_admin = $db->get("admin_login");


$cols = array("*");
$fetch_settings_param = $db->get("settings_param");

echo '<pre style="display: none">';
//print_r($fetch_settings_param);

$TodayTimestap = time();
$GetNewDate = new DateTime($fetch_settings_param['15']['value']);
$GetNewDateTimestamp = $GetNewDate->getTimestamp();
echo $GetNewDateTimestamp;
echo "\n";
echo $TodayTimestap;
echo "\n";
echo $GetNewDateTimestamp - $TodayTimestap;
echo "\n";
echo date("Y-m-d H:i:s",time());
echo '</pre>';

//var_dump($fetch_admin[0]['id']);



if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}


?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WXL678V');</script>
    <!-- End Google Tag Manager -->

    <title>ایران دوج | داشبورد</title>
    <?php include("root-head.php"); ?>



</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-page--loading-enabled kt-page--loading kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-subheader--enabled kt-subheader--transparent kt-page--loading">


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WXL678V"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


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
                                    داشبورد </h3>
                            </div>
                        </div>
                    </div>
                    <!-- end:: Subheader -->
                    <!-- begin:: Content -->
                    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                        <!--Begin::Dashboard 5-->
                        <!--Begin::Row-->

                        <?php if($fetch_member['two_step'] == "off"): ?>
                            <div class="col-xl-12" style="padding:0;">
                                <div class=" alert alert-light alert-elevate fade show " role="alert" style="color: #856404;background-color: #fff3cd;border-color: #ffeeba;">
                                    <div class="alert-icon">
                                        <i class="flaticon-warning kt-font-brand" style="color: #856404 !important;line-height: 2px;"></i></div>
                                    <div class="alert-text">حساب کاربری شما ایمن نمی باشد، برای ایمن سازی حساب کاربری خود پیشنهاد میکنیم ورود دو مرحله ای را فعال نمایید : <a class="kt-link kt-font-bold" href="https://irandogebank.com/user/user_settings.php">برای فعال سازی ورود دو مرحله ای اینجا کلیک کنید</a>.
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                        <?php 
                        
            
                        if(($GetNewDateTimestamp - $TodayTimestap) >= 0): ?>

                            <div class="col-xl-12" style="padding:0;">
                                <div class="alert alert-brand" role="alert">
                                    <div class="m-alert__text" style="width: 80%;display: inherit !important;line-height: 31px;font-size: 15px;">
                                        <strong> <?php echo $fetch_settings_param['14']['value'];?> </strong>   -  (<p style="margin-bottom: 0;" id="p30web11">لطفا چند ثانیه صببر کنید</p>)
                                    </div>

                                    <div class="m-alert__actions" style="width:20%;text-align: left;">
                                        <a href="plan-relevance.php" class="btn btn-label-info btn-sm btn-upper" style="text-align: left;border: 2px solid;color: #ffff;font-size: 15px;">
                                        مشاهده توضیحات بیشتر
                                        </a>
                                    </div>

                                    <script>
                                        // Set the date we're counting down to
                                        var countDownDate = new Date("<?php echo $fetch_settings_param['15']['value'] ?>").getTime();

                                        // Update the count down every 1 second
                                        var x = setInterval(function() {

                                            // Get today's date and time
                                            var now = new Date().getTime();

                                            // Find the distance between now and the count down date
                                            var distance = countDownDate - now;

                                            // Time calculations for days, hours, minutes and seconds
                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            // Output the result in an element with id="demo"
                                            document.getElementById("p30web11").innerHTML = days + " روز " + hours + " ساعت "
                                                + minutes + " دقیقه " + seconds + " ثانیه ";

                                            // If the count down is over, write some text
                                            if (distance < 0) {
                                                clearInterval(x);
                                                document.getElementById("p30web11").innerHTML = "EXPIRED";
                                            }
                                        }, 1000);
                                    </script>
                                </div>
                            </div>

                        <?php endif; ?>

                        <div class="row">
                            <div class="col-xl-12">
                                <!--begin:: Widgets/Applications/User/Profile3-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget kt-widget--user-profile-3">
                                            <div class="kt-widget__top">

                                                <?php if ($fetch_member['img'] != null) {
                                                    echo '<div class="kt-widget__media kt-hidden-"><img src="../Attachment/img/members/' . $fetch_member['img'] . ' " alt="' . $fetch_member['firstname'] . '"></div>';
                                                } else {
                                                    echo '<div class="kt-widget__media kt-hidden-"><img src="/assets/images/avatar-icon-images-4.jpg
" alt="' . $fetch_member['firstname'] . '"></div>';
                                                }
                                                ?>
                                                <div class="kt-widget__content">
                                                    <div class="kt-widget__head">
                                                        <a href="#" class="kt-widget__username">

                                                            <?php
                                                            if ($fetch_member['active'] === 0) {
                                                                echo '<i class="flaticon2-correct kt-font-warning mr-2"></i>';
                                                            } elseif ($fetch_member['active'] === 1) {
                                                                echo '<i class="flaticon2-correct kt-font-success mr-2"></i>';
                                                            }
                                                            echo $fetch_member["firstname"] . ' ' . $fetch_member["lastname"];

                                                            ?>
                                                        </a>

                                                        <div class="kt-widget__action">
                                                            <a href="my_profile.php"
                                                               class="btn btn-label-success btn-sm btn-upper">
                                                                پروفایل من
                                                            </a>&nbsp;
                                                        </div>
                                                    </div>

                                                    <div class="kt-widget__subhead">
                                                        <a href="#"><i
                                                                    class="flaticon2-new-email ml-1"></i><?php echo $fetch_member['email']; ?>
                                                        </a>
                                                        <a href="#"><i
                                                                    class="flaticon2-phone ml-1"></i><?php echo $fetch_member['cellphone']; ?>
                                                        </a>
                                                    </div>

                                                    <div class="kt-widget__info">
                                                        <div class="kt-widget__desc">
                                                            <span>آخرین ورود: </span><strong
                                                                    class="kt-font-primary"><?php echo substr($fetch_member['last_login'], 8, 2); ?>
                                                                <span><?php echo monthname(substr($fetch_member['last_login'], 5, 2)); ?></span>
                                                                ساعت
                                                                <span><?php echo substr($fetch_member['last_login'], 11, 8); ?></span></strong>
                                                            <br>
                                                            <span>آخرین ip وارد شده: </span><strong
                                                                    class="kt-font-primary"><?php echo $fetch_member['last_ip']; ?></strong>
                                                        </div>
                                                        <div class="kt-widget__progress">
                                                            <div class="kt-widget__text">
                                                                وضعیت پروفایل شما
                                                            </div>
                                                            <div class="progress" style="height: 5px;width: 100%;">
                                                                <div class="progress-bar kt-bg-success"
                                                                     role="progressbar"
                                                                     style="width: <?php echo $fetch_member['progress']; ?>%;"
                                                                     aria-valuenow="<?php echo $fetch_member['progress']; ?>"
                                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <div class="kt-widget__stats">
                                                                <?php echo $fetch_member['progress']; ?>%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-widget__bottom">
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="fa fa-wallet"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">موجودی حساب دوج کوین : </span>
                                                        <span class="kt-widget__value"><span>DOGE </span><?php echo  number_format((float)$fetch_member['cash'],8, '.', ''); ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                $db->where("member_id", $fetch_member['id']);
                                                $db->where("status", '1');
                                                $fetch_active_plan = $db->get("active_investment_plan", null);

                                                $tleft = mktime(24,0,0) - time();

                                                $tdy_balance = 0;
                                                foreach ($fetch_active_plan as $value){


                                                    $date = date('Y-m-d', $value['time']);
                                                    $today = date('Y-m-d');

                                                    if ($date == $today) {
                                                        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                                    }else{
                                                        $tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                                    }


                                                    //															$tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                                }
                                                ?>
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="fa fa-chart-area"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">درآمد کل حساب دوج کوین : </span>
                                                        <span class="kt-widget__value" id="totalIncome"><span>DOGE </span>
																	<?php

                                                                    echo ($fetch_member['profit'] > 0) ? number_format((float)$fetch_member['profit']+$tdy_balance, 8, '.', '') : number_format((float)$tdy_balance, 8, '.', '');
                                                                    ?>

																</span>
                                                    </div>
                                                </div>

                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">در آمد امروز دوج کوین : </span>
                                                        <span class="kt-widget__value" id="todayIncome"><span>DOGE </span>
																	<?php
                                                                    echo number_format((float)$tdy_balance, 8, '.', '');

                                                                    ?>
																</span>
                                                    </div>
                                                </div>
                                                <!--
<div class="kt-widget__item">
<div class="kt-widget__icon">
<i class="fa fa-money-bill-wave"></i>
</div>
<div class="kt-widget__details">
<span class="kt-widget__title">قابل برداشت امروز</span>
<span class="kt-widget__value"><span>DOGE </span><?php echo  number_format((float)$fetch_member['cashout'],8, '.', ''); ?></span>
</div>
</div>
-->
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="flaticon-network"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <div class="kt-section__content kt-section__content--solid">
																	<span class="kt-badge kt-badge--unified-info kt-badge--lg kt-badge--bold"><?php
                                                                        $db->where("parent_id", $fetch_member['id']);
                                                                        $db->get("members", null, "id");
                                                                        echo $db->count;
                                                                        ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-widget__bottom">
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="fa fa-wallet"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">موجودی حساب دلاری : </span>
                                                        <span class="kt-widget__value"><span>Dollar </span><?php echo  number_format((float)$fetch_member['dollar_credit'],8, '.', ''); ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                $db->where("member_id", $fetch_member['id']);
                                                $db->where("type", "dollar");
                                                $db->where("status", '1');
                                                $fetch_active_plan = $db->get("active_investment_plan", null);

                                                $tleft = mktime(24,0,0) - time();

                                                $tdy_balance = 0;
                                                //														foreach ($fetch_active_plan as $value){
                                                //
                                                //
                                                //															$date = date('Y-m-d', $value['time']);
                                                //															$today = date('Y-m-d');
                                                //
                                                //															if ($date == $today) {
                                                //																$tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                                //															}else{
                                                //																$tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                                //															}
                                                //
                                                //
                                                //															//															$tdy_balance += $value['daily_profit'] - ($value['daily_profit']/24/60/60*$tleft);
                                                //														}
                                                ?>
                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="fa fa-chart-area"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">کل درآمد دلاری : </span>
                                                        <span class="kt-widget__value" id="totalDollarIncome"><span>Dollar </span>
																	<?php

                                                                    echo ($fetch_member['dollar_profit'] > 0) ? number_format((float)$fetch_member['dollar_profit']+$tdy_balance, 8, '.', '') : number_format((float)$tdy_balance, 8, '.', '');
                                                                    ?>

																</span>
                                                    </div>
                                                </div>

                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="fa fa-coins"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <span class="kt-widget__title">درآمد دلاری امروز : </span>
                                                        <span class="kt-widget__value" id="todayDollarIncome"><span>Dollar </span>
																	<?php
                                                                    echo number_format((float)$tdy_balance, 8, '.', '');

                                                                    ?>
																</span>
                                                    </div>
                                                </div>
                                                <!--
<div class="kt-widget__item">
<div class="kt-widget__icon">
<i class="fa fa-money-bill-wave"></i>
</div>
<div class="kt-widget__details">
<span class="kt-widget__title">قابل برداشت امروز</span>
<span class="kt-widget__value"><span>DOGE </span><?php echo  number_format((float)$fetch_member['cashout'],8, '.', ''); ?></span>
</div>
</div>
-->

                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__icon">
                                                        <i class="flaticon-network"></i>
                                                    </div>
                                                    <div class="kt-widget__details">
                                                        <div class="kt-section__content kt-section__content--solid">
																	<span class="kt-badge kt-badge--unified-info kt-badge--lg kt-badge--bold"><?php
                                                                        $db->where("parent_id", $fetch_member['id']);
                                                                        $db->get("members", null, "id");
                                                                        echo $db->count;
                                                                        ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Applications/User/Profile3-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 order-lg-1 order-xl-1">
                                <!--begin:: Widgets/Activity-->
                                <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                                    <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                فعالیت ها
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <div class="kt-widget17">
                                            <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides"
                                                 style="background-color: #fd397a">
                                                <div class="kt-widget17__chart" style="height:320px;">
                                                    <canvas id="kt_chart_activities"></canvas>
                                                </div>
                                            </div>
                                            <div class="kt-widget17__stats">
                                                <div class="kt-widget17__items">
                                                    <a href="active_plan.php" class="kt-widget17__item">
																<span class="kt-widget17__icon">

																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect id="bound" x="0" y="0" width="24" height="24"/>
																			<path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" id="Combined-Shape-Copy" fill="#000000" opacity="0.3"
                                                                                  transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
																			<path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" id="Combined-Shape" fill="#000000"/>
																		</g>
																	</svg>
																</span>
                                                        <span class="kt-widget17__subtitle">
																	پلن های من
																</span>
                                                        <span class="kt-widget17__desc">
																	پلن های سرمایه گذاری
																</span>
                                                    </a>

                                                    <a href="pricing_plan.php" class="kt-widget17__item">
																<span class="kt-widget17__icon">
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                                                         class="kt-svg-icon kt-svg-icon--success">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<polygon id="Bound" points="0 0 24 0 24 24 0 24"/>
																			<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                                                  id="Shape" fill="#000000" fill-rule="nonzero"/>
																			<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                                                  id="Path" fill="#000000" opacity="0.3"/>
																		</g>
																	</svg>
																</span>
                                                        <span class="kt-widget17__subtitle">
																	سرمایه گذاری
																</span>
                                                        <span class="kt-widget17__desc">
																	پلن های سرمایه گذاری
																</span>
                                                    </a>
                                                </div>
                                                <div class="kt-widget17__items">
                                                    <a href="help_center.php" class="kt-widget17__item">
																<span class="kt-widget17__icon">

																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--warning">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect id="bound" x="0" y="0" width="24" height="24"/>
																			<path d="M3,10.0500091 L3,8 C3,7.44771525 3.44771525,7 4,7 L9,7 L9,9 C9,9.55228475 9.44771525,10 10,10 C10.5522847,10 11,9.55228475 11,9 L11,7 L21,7 C21.5522847,7 22,7.44771525 22,8 L22,10.0500091 C20.8588798,10.2816442 20,11.290521 20,12.5 C20,13.709479 20.8588798,14.7183558 22,14.9499909 L22,17 C22,17.5522847 21.5522847,18 21,18 L11,18 L11,16 C11,15.4477153 10.5522847,15 10,15 C9.44771525,15 9,15.4477153 9,16 L9,18 L4,18 C3.44771525,18 3,17.5522847 3,17 L3,14.9499909 C4.14112016,14.7183558 5,13.709479 5,12.5 C5,11.290521 4.14112016,10.2816442 3,10.0500091 Z M10,11 C9.44771525,11 9,11.4477153 9,12 L9,13 C9,13.5522847 9.44771525,14 10,14 C10.5522847,14 11,13.5522847 11,13 L11,12 C11,11.4477153 10.5522847,11 10,11 Z" id="Combined-Shape-Copy" fill="#000000" opacity="0.3" transform="translate(12.500000, 12.500000) rotate(-45.000000) translate(-12.500000, -12.500000) "/>
																		</g>
																	</svg>
																</span>
                                                        <span class="kt-widget17__subtitle">
																	تیکت
																</span>
                                                        <span class="kt-widget17__desc">
																	سیستم پرسش و پاسخ
																</span>
                                                    </a>

                                                    <a href="subincome.php" class="kt-widget17__item">
																<span class="kt-widget17__icon">
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--danger">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
																			<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" id="Mask-Copy" fill="#000000" fill-rule="nonzero"/>
																		</g>
																	</svg>
																</span>
                                                        <span class="kt-widget17__subtitle">
																	زیر مجموعه
																</span>
                                                        <span class="kt-widget17__desc">
																	سیستم زیر مجوعه گیری
																</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Activity-->    </div>



                            <div class="col-xl-4  col-lg-6 order-lg-1 order-xl-1">
                                <!--begin:: Packages-->
                                <div class="kt-portlet kt-portlet--skin-solid kt-portlet--solid-warning kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--height-fluid">
                                    <div class="kt-portlet__head kt-portlet__head--noborder">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title kt-font-light">
                                                پلن های فعال من
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body kt-margin-t-0 kt-padding-t-0">
                                        <!--begin::Widget 29-->
                                        <div class="kt-widget29">
                                            <?php
                                            mysqli_select_db($cn, $database_cn);
                                            
                                            $fetch_admin = $db->get("admin_login");
                                            
                                            if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                $query_active_investment_plan = sprintf("SELECT * FROM `active_investment_plan` WHERE member_id=".$fetch_admin[0]['admin_id']." AND `status` = '1' ORDER BY `time` DESC LIMIT 0,3");
                                            }else{
                                                $query_active_investment_plan = sprintf("SELECT * FROM `active_investment_plan` WHERE member_id=".$_SESSION['member_id']." AND `status` = '1' ORDER BY `time` DESC LIMIT 0,3");
                                            }
                                            
                                            $active_investment_plan= mysqli_query($cn, $query_active_investment_plan) or die(mysqli_error($cn));
                                            $row_active_investment_plan = mysqli_fetch_assoc($active_investment_plan);
                                            $totalRows_active_investment_plan = mysqli_num_rows($active_investment_plan);

                                            if($totalRows_active_investment_plan > 0) {
                                                do {
                                                    ?>
                                                    <div class="kt-widget29__content">
                                                        <h3 class="kt-widget29__title"><?php echo $row_active_investment_plan['title'];  ?> - <?php echo (is_null($row_active_investment_plan['type'])) ? "پلن دوج کوین" : 'پلن دلاری'; ?></h3>
                                                        <div class="kt-widget29__item">
                                                            <div class="kt-widget29__info">
                                                                <span class="kt-widget29__subtitle">قیمت پلن</span>
                                                                <span class="kt-widget29__stats kt-font-primary"><?php echo $row_active_investment_plan['price']; ?> <?php echo (is_null($row_active_investment_plan['type'])) ? "Doge" : 'Dollar'; ?></span>
                                                            </div>
                                                            <div class="kt-widget29__info">
                                                                <span class="kt-widget29__subtitle">سود دوره</span>
                                                                <span class="kt-widget29__stats kt-font-brand"><?php echo $row_active_investment_plan['interest_rate']; ?>%</span>
                                                            </div>
                                                            <div class="kt-widget29__info">
                                                                <span class="kt-widget29__subtitle">سود روزانه</span>
                                                                <span class="kt-widget29__stats kt-font-success"><?php echo $row_active_investment_plan['daily_profit']; ?> <?php echo (is_null($row_active_investment_plan['type'])) ? "Doge" : 'Dollar'; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } while ($row_active_investment_plan = mysqli_fetch_assoc($active_investment_plan));
                                                ?>
                                                <div class="kt-widget29__actions kt-align-right">
                                                    <a href="active_plan.php" class="btn btn-brand">مشاهده همه پلن
                                                        ها</a>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="tab-pane active" id="no_notifications_logs" role="tabpanel">
                                                    <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                                        <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                            <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                                کاربر گرامی!
                                                                <br>شما پلن فعال ندارید.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <!--end::Widget 29-->
                                    </div>
                                </div>
                                <!--end:: Packages-->
                            </div>
                            <div class="col-xl-4 col-lg-6 order-lg-1 order-xl-1">
                                <!--Begin::Portlet-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                فعالیت های اخیر
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__body">
                                        <!--Begin::Timeline 3 -->
                                        <div class="kt-timeline-v2">
                                            <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                                                <?php
                                                mysqli_select_db($cn_log, $log_database_cn);


                                                $fetch_admin = $db->get("admin_login");

                                                if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                    $query_member_activity= sprintf("SELECT * FROM `member_activity` WHERE `user_id`= %d ORDER BY `time` DESC LIMIT 0,10", $fetch_admin[0]['admin_id']);
                                                }else{
                                                    $query_member_activity= sprintf("SELECT * FROM `member_activity` WHERE `user_id`= %d ORDER BY `time` DESC LIMIT 0,10", $fetch_member['id']);
                                                }

                                                $member_activity = mysqli_query($cn_log, $query_member_activity) or die(mysqli_error($cn_log));
                                                $row_member_activity = mysqli_fetch_assoc($member_activity);
                                                $totalRows_member_activity = mysqli_num_rows($member_activity);

                                                if ($totalRows_member_activity > 0) {
                                                    do {
                                                        ?>
                                                        <div class="kt-timeline-v2__item">
                                                            <span class="kt-timeline-v2__item-time"><?php echo jdate("H:i", $row_member_activity['time']); ?></span>
                                                            <div class="kt-timeline-v2__item-cricle">
                                                                <i class="fa fa-genderless kt-font-<?php
                                                                switch ($row_member_activity['type']) {
                                                                    case 0:
                                                                        echo "dark";
                                                                        break;
                                                                    case 1:
                                                                        echo "primary";
                                                                        break;
                                                                    case 2:
                                                                        echo "success";
                                                                        break;
                                                                    case 3:
                                                                        echo "danger";
                                                                        break;
                                                                    default:
                                                                        echo "warning";
                                                                }
                                                                ?>"></i>
                                                            </div>
                                                            <div class="kt-timeline-v2__item-text  kt-padding-top-5">
                                                                <?php echo $row_member_activity['message']; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } while($row_member_activity = mysqli_fetch_assoc($member_activity));
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <!--End::Timeline 3 -->
                                    </div>
                                </div>

                                <!--End::Portlet-->
                            </div>

                        </div>
                        <!--End::Row-->

                        <!--End::Dashboard 5-->
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
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/dashboard.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){

        function counterPlan() {
            $.ajax({
                url: "api/active_plan_counter.php",
                method: "GET",
                success: function (t, s, r, a) {

                    if (r.status === 200) {
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
<!--end::Page Scripts -->
<script src="//code.tidio.co/jkbs20gair8smqmlrle4advklsnx7tkc.js" async></script>	</body>
<!-- end::Body -->

</html>