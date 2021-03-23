<?php

include("checklogin.php");

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
}else{
    $db->where("id", $_SESSION['member_id']);
}

$db->where("id", $_SESSION['member_id']);
$fetch_member = $db->getOne("members");

$PlanType = "dog";

if(isset($_GET['type'])){
    if($_GET['type'] == "dollar"){
        $PlanType = "dollar";
    }
}

$apid = decrypt($_GET['id'], session_id()."acp");


$db->where("id", $apid);
$active_plane_det= $db->getOne("active_investment_plan");



?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
	<!-- begin::Head -->

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ایران دوج | جزئیات پلن</title>
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
											جزئیات پلن فعال
										</h3>

										<span class="kt-subheader__separator kt-hidden"></span>
										<div class="kt-subheader__breadcrumbs">
											<a href="#" class="kt-subheader__breadcrumbs-home">
												<i class="flaticon2-shelter"></i></a>
											<span class="kt-subheader__breadcrumbs-separator"></span>
											<a href="active_plan.php" class="kt-subheader__breadcrumbs-link">
												پلن های فعال
											</a>
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
								<div class="kt-portlet">
									<div class="kt-portlet__body  kt-portlet__body--fit">
										<div class="row row-no-padding row-col-separator-xl">

											<div class="col-md-12 col-lg-6 col-xl-3">
												<!--begin::Total Profit-->
												<div class="kt-widget24">
													<div class="kt-widget24__details">
														<div class="kt-widget24__info">
															<h4 class="kt-widget24__title">
																زمان باقی مانده:
															</h4>
															<span class="kt-widget24__desc p30web-time2">
																<?php


																$now = time();

																if($active_plane_det['period_type'] === "month"){
																	$endtime= $active_plane_det['time'] + $active_plane_det['period']*(30 * 24 * 60 * 60);
																}
                                                                elseif ($active_plane_det['period_type'] === "3month"){
                                                                    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(90 * 24 * 60 * 60);
                                                                }

																elseif ($active_plane_det['period_type'] === "6month"){
                                                                    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(180 * 24 * 60 * 60);
                                                                }

																elseif ($active_plane_det['period_type'] === "yearly"){
                                                                    $endtime= $active_plane_det['time'] + $active_plane_det['period']*(365 * 24 * 60 * 60);
                                                                }

																elseif ($active_plane_det['period_type'] === "day"){
																	$endtime= $active_plane_det['time'] + $active_plane_det['period']*(1 * 24 * 60 * 60);
																}
																$tfid =  abs($now - $endtime)/60/60/24;

																$sd = date("Y-m-d H:i:s", $now);
																$ed = date("Y-m-d H:i:s", $endtime);
																$start_date = new DateTime($sd);
																$since_start = $start_date->diff(new DateTime($ed));
																echo $since_start->m.' ماه ';
																echo $since_start->d.' روز ';
																echo $since_start->h.' ساعت ';
																echo $since_start->i.' دقیقه ';
																echo $since_start->s.' ثانیه ';

																?>
															</span>
														</div>
													</div>

                                                    <?php

                                                    $TodayTimestap = time();

                                                    if($active_plane_det['period_type'] === "month"){
                                                        $GetDBtime= $active_plane_det['time'] + $active_plane_det['period']*(30 * 24 * 60 * 60);
                                                    }
                                                    elseif ($active_plane_det['period_type'] === "3month"){
                                                        $GetDBtime= $active_plane_det['time'] + $active_plane_det['period']*(90 * 24 * 60 * 60);
                                                    }

                                                    elseif ($active_plane_det['period_type'] === "6month"){
                                                        $GetDBtime = $active_plane_det['time'] + $active_plane_det['period']*(180 * 24 * 60 * 60);
                                                    }

                                                    elseif ($active_plane_det['period_type'] === "yearly"){
                                                        $GetDBtime = $active_plane_det['time'] + $active_plane_det['period']*(365 * 24 * 60 * 60);
                                                    }

                                                    elseif ($active_plane_det['period_type'] === "day"){
                                                        $GetDBtime = $active_plane_det['time'] + $active_plane_det['period']*(1 * 24 * 60 * 60);
                                                    }

                                                    $FinalTime = $GetDBtime - $TodayTimestap;

                                                    $DayEndTime =  round($FinalTime / (24*60*60));

                                                    $EndTimeDarsad = 100 - round($DayEndTime / 100);


                                                    ?>

													<div class="progress progress--sm">
														<div class="progress-bar kt-bg-brand" role="progressbar" style="width: <?php echo $EndTimeDarsad; ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
													</div>

													<div class="kt-widget24__action">
														<span class="kt-widget24__change">
															باقیمانده
														</span>


														<span class="kt-widget24__number">
															<?php echo $EndTimeDarsad; ?>%
														</span>
													</div>
												</div>
												<!--end::Total Profit-->
											</div>

											<div class="col-md-12 col-lg-6 col-xl-3">
												<!--begin::New Feedbacks-->
												<div class="kt-widget24">
													<div class="kt-widget24__details">
														<div class="kt-widget24__info">
															<h4 class="kt-widget24__title">
																سود کل پلن
															</h4>
															<span class="kt-widget24__desc">
																درصد سود پلن در کل دوره: <?php echo $active_plane_det['interest_rate']; ?>%
															</span>
														</div>

														<span class="kt-widget24__stats kt-font-success">
															<?php echo $active_plane_det['price']*$active_plane_det['interest_rate']/100; ?>
														</span>
													</div>

													<div class="progress progress--sm">
														<div class="progress-bar kt-bg-success" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
													</div>

													<div class="kt-widget24__action">
														<span class="kt-widget24__change">
															باقیمانده
														</span>
														<span class="kt-widget24__number">
															84%
														</span>
													</div>
												</div>
												<!--end::New Feedbacks-->
											</div>

											<div class="col-md-12 col-lg-6 col-xl-3">
												<!--begin::New Orders-->
												<div class="kt-widget24">
													<div class="kt-widget24__details">
														<div class="kt-widget24__info col-md-6 p-0">
															<h4 class="kt-widget24__title">
																نوع دوره زمانی:
															</h4>
															<span class="kt-widget24__desc">
																<?php
																if($active_plane_det['period_type'] === "month"){
																	echo 'ماهانه';
																}

																else if($active_plane_det['period_type'] === "3month"){
																	echo 'سه ماه';
																}

																else if($active_plane_det['period_type'] === "6month"){
																	echo 'شش ماه';
																}

																else if($active_plane_det['period_type'] === "yearly"){
																	echo 'سالانه';
																}

																else if ( $active_plane_det['period_type'] === "day"){
																	echo 'روزانه';
																}
																?>
															</span>
														</div>
														<div class="kt-widget24__info col-md-6 p-0">
															<h4 class="kt-widget24__title">
																مدت دوره:
															</h4>
															<span class="kt-widget24__desc">
																<?php echo $active_plane_det['period']; ?>
															</span>
														</div>
													</div>
													<br>
													<div class="kt-widget24__details">
														<div class="kt-widget24__info col-md-6 p-0">
															<h4 class="kt-widget24__title">
																زمان شروع:
															</h4>
															<span class="kt-widget24__desc">
																<?php echo jdate("Y/m/d H:i:s", $active_plane_det['time']); ?>
															</span>
														</div>
														<div class="kt-widget24__info col-md-6 p-0 ml-2">
															<h4 class="kt-widget24__title">
																زمان پایان:
															</h4>
															<span class="kt-widget24__desc">
																<?php
																if($active_plane_det['period_type'] === "month"){
																	$endtime= $active_plane_det['time'] + $active_plane_det['period']*(30 * 24 * 60 * 60);
																	echo jdate("Y/m/d H:i:s", $endtime);
																}elseif ($active_plane_det['period_type'] === "day"){
																	$endtime= $active_plane_det['time'] + $active_plane_det['period']*(1 * 24 * 60 * 60);
																	echo jdate("Y/m/d H:i:s", $endtime);
																}elseif ($active_plane_det['period_type'] === "3month"){
																	$endtime= $active_plane_det['time'] + $active_plane_det['period']*(90 * 24 * 60 * 60);
																	echo jdate("Y/m/d H:i:s", $endtime);
																}elseif ($active_plane_det['period_type'] === "6month"){
																	$endtime= $active_plane_det['time'] + $active_plane_det['period']*(180 * 24 * 60 * 60);
																	echo jdate("Y/m/d H:i:s", $endtime);
																}elseif ($active_plane_det['period_type'] === "yearly"){
																	$endtime= $active_plane_det['time'] + $active_plane_det['period']*(365 * 24 * 60 * 60);
																	echo jdate("Y/m/d H:i:s", $endtime);
																}
																?>
															</span>
														</div>

													</div>

												</div>
												<!--end::New Orders-->
											</div>

											<div class="col-md-12 col-lg-6 col-xl-3">
												<!--begin::New Users-->
												<div class="kt-widget24">
													<div class="kt-widget24__details">
														<div class="kt-widget24__info col-md-6 p-0">
															<h4 class="kt-widget24__title">
																قیمت پلن
															</h4>
															<span class="kt-widget24__desc">
																<h4 class="kt-font-primary"><?php echo $active_plane_det['price']; ?></h4>
															</span>
														</div>
														<div class="kt-widget24__info col-md-6 p-0">
															<h4 class="kt-widget24__title">
																وضعیت پلن
															</h4>
															<span class="kt-widget24__desc">
																<h4 class="kt-font-primary"><?php echo active_plan_status($active_plane_det['status']); ?></h4>
															</span>
														</div>
													</div>
													<?php 
													/* if($active_plane_det['status'] == 1){ 
													//<div class="col-md-12 mt-4">
														//<button style="width: 40%" onclick="delPlan(<?php echo $active_plane_det['id']; ?>)" type="button" class="btn btn-danger btn-elevate">لغو پلن</button>
													//</div>
													//
													//
													 } */?>

												</div>
												<!--end::New Users-->
											</div>

										</div>
									</div>
								</div>
								<?php

                                if($PlanType == "dollar"){
                                    $db->where("id", $apid);
                                    $active_plane_det= $db->getOne("active_investment_plan");

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
                                }else{
//                                    $db->where("member_id", $fetch_member['id']);
//                                    $db->where("status", '1');
//                                    $fetch_active_plan = $db->get("active_investment_plan", null);
                                    $db->where("id", $apid);
                                    $active_plane_det= $db->getOne("active_investment_plan");

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
                                }



								?>
								<div class="row">
									<div class="col-lg-6">
										<div class="kt-portlet kt-callout kt-callout--success kt-callout--diagonal-bg">
											<div class="kt-portlet__body">
												<div class="kt-callout__body">
													<div class="kt-callout__content">
														<h3 class="kt-callout__title">
															درآمد کل این پلن
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
                                                            <?php echo ($PlanType == "dollar") ? "Dollar" : "DOGE"; ?></h3>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="kt-portlet kt-callout kt-callout--primary kt-callout--diagonal-bg">
											<div class="kt-portlet__body">
												<div class="kt-callout__body">
													<div class="kt-callout__content">
														<h3 class="kt-callout__title">
															درآمد امروز
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
                                                            <?php echo ($PlanType == "dollar") ? "Dollar" : "DOGE"; ?>
														</h3>
													</div>
												</div>
											</div>
										</div>
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
		<!--end::Page Scripts -->
		<script>
			function delPlan(i) {
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
						title: "لغو پلن شامل کسر 5% کارمزد می باشد.",
						text: "آیا میخواهید پلن مورد نظر را لغو کنید؟",
						type: "warning",
						showCancelButton: !0,
						cancelButtonText: "انصراف!",
						confirmButtonText: "بله، لغو شود"
					}).then(function (e) {
						e.value && $.ajax({
							type: "GET",
							url: "api/del_plan.php",
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

			$(document).ready(function(){


                <?php if($PlanType == "dollar") : ?>
                function DollarcounterPlan() {
                    $.ajax({
                        url: "api/dollar_active_plan_counter.php",
                        method: "GET",
                        success: function (t, s, r, a) {

                            if (r.status === 200) {
                                $('.kt-callout__desc').html('تا ساعت '+r.responseJSON.message);
                                $('#todayIncome').html(r.responseJSON.todayIncome+' Dollar');
                                $('#totalIncome').html(r.responseJSON.totalIncome+' Dollar');
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
                <? endif; ?>

                function EndTimeCounter() {
                    $.ajax({
                        url: "api/plan_details_counter1.php",
                        method: "POST",
                        type: 'POST',  // http method
                        data: { myData: "<?php echo  $apid ?>" },  // data to submit
                        success: function (t, s, r, a) {

                            if (r.status === 200) {
                                $('.p30web-time2').html(r.responseJSON.message);
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {

                        }
                    });
                    setTimeout(function(){
                        EndTimeCounter()
                    }, 1000);
                }
                
                EndTimeCounter();

                <?php if($PlanType != "dollar") : ?>
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
                <? endif; ?>

			});
		</script>
	</body>
	<!-- end::Body -->

</html>