<?php
require_once('checklogin_root.php');
?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php include("root-head.php"); ?>
		<title>Rahaaa | داشبورد</title>

	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">


		<!-- begin:: Page -->
		<!-- begin:: Header Mobile -->
		<?php include("Components/mobile-header.php"); ?>
		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<!-- begin:: Aside -->
				<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>

				<?php include("Components/main-sidebar.php"); ?>
				<!-- end:: Aside -->
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
					<!-- begin:: Header -->
					<?php include("Components/toolbar.php"); ?>
					<!-- end:: Header -->
					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

						<!-- begin:: Subheader -->
						<div class="kt-subheader   kt-grid__item" id="kt_subheader">
							<div class="kt-container  kt-container--fluid ">
								<div class="kt-subheader__main">

									<h3 class="kt-subheader__title">
										داشبورد </h3>

									<span class="kt-subheader__separator kt-hidden"></span>
									<div class="kt-subheader__breadcrumbs">
										<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
										<span class="kt-subheader__breadcrumbs-separator"></span>
										<a href="" class="kt-subheader__breadcrumbs-link">
											عمومی </a>
										<span class="kt-subheader__breadcrumbs-separator"></span>
										<a href="" class="kt-subheader__breadcrumbs-link">
											داشبورد </a>
										<!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
									</div>

								</div>
							</div>
						</div>
						<!-- end:: Subheader -->
						<!-- begin:: Content -->

						<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
							<?php
							$cnt=30;
							$response_array = [];
							for($i=0;$i<=$cnt;$i++)
							{
								$cdate=jdate('Y/m/d',strtotime('-'.$i.' days'));

								mysqli_select_db($cn,$database_cn);
								$query_Recordsetcntr = "SELECT * FROM dailycounter WHERE date='$cdate'";
								$Recordsetcntr = mysqli_query($cn,$query_Recordsetcntr) or die(mysqli_error($cn));
								$row_Recordsetcntr = mysqli_fetch_assoc($Recordsetcntr);
								$totalRows_Recordsetcntr = mysqli_num_rows($Recordsetcntr);

								$visitcount=$row_Recordsetcntr['visitcount'];
								$pagecount=$row_Recordsetcntr['pagecount'];

								if($visitcount=='') $visitcount=0;
								if($pagecount=='') $pagecount=0;
								$cdate = str_replace('/', "-", $cdate);
								$array = array(
									"date"=> $cdate,
									"value"=> $visitcount,
									"value2"=> $pagecount,
								);
								array_push($response_array, $array );

							}

							file_put_contents('data/counter_chart.json',json_encode($response_array));
							?>
							<div class="row">
								<div class="col-lg-12">
									<!--begin::Portlet-->
									<div class="kt-portlet kt-portlet--tab">
										<div class="kt-portlet__head">
											<div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon kt-hidden">
													<i class="la la-gear"></i>
												</span>
												<h3 class="kt-portlet__head-title">
													نمودار بازدید سایت
												</h3>
											</div>
										</div>
										<div class="kt-portlet__body">
											<div id="view_count" style="height:300px;"></div>
										</div>
									</div>
									<!--end::Portlet-->
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<!--begin::Portlet-->
									<div class="kt-portlet kt-portlet--tab">
										<div class="kt-portlet__head">
											<div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon kt-hidden">
													<i class="la la-gear"></i>
												</span>
												<h3 class="kt-portlet__head-title">
													امور مالی
												</h3>
											</div>
										</div>
										<?php

										mysqli_select_db($cn, $database_cn);
										$query_income_sum = sprintf("SELECT SUM(price) as total_price FROM `block_transaction` WHERE status = '1' ");
										$income_sum= mysqli_query($cn, $query_income_sum) or die(mysqli_error($cn));
										$row_income_sum= mysqli_fetch_assoc($income_sum);

										$query_withdraw_sum = sprintf("SELECT SUM(amount) as total_amount, SUM(member_fee) as total_fee FROM `withdraw` WHERE 1 ");
										$withdraw_sum= mysqli_query($cn, $query_withdraw_sum) or die(mysqli_error($cn));
										$row_withdraw_sum= mysqli_fetch_assoc($withdraw_sum);

										$query_ref_sum = sprintf("SELECT SUM(refIncome) as total_ref FROM `members` WHERE parent_id > 0 ");
										$ref_sum= mysqli_query($cn, $query_ref_sum) or die(mysqli_error($cn));
										$row_ref_sum= mysqli_fetch_assoc($ref_sum);
										
										$query_ref_sum1 = sprintf("SELECT SUM(profit) as total_profit FROM `members` WHERE status = 1 ");
										$ref_sum1= mysqli_query($cn, $query_ref_sum1) or die(mysqli_error($cn));
										$row_ref_sum1= mysqli_fetch_assoc($ref_sum1);

										$query_plan_sum = sprintf("SELECT SUM(price) as total_plan FROM `active_investment_plan` WHERE status = '1' ");
										$plan_sum= mysqli_query($cn, $query_plan_sum) or die(mysqli_error($cn));
										$row_plan_sum= mysqli_fetch_assoc($plan_sum);


										?>
										<div class="kt-portlet__body">
											<div class="row">
												<div class="col-lg-4">
													<b>کل واریزی ها:</b> <?php echo number_format((float)$row_income_sum['total_price'], 8, '.', ''); ?>
												</div>
												<div class="col-lg-4">
													<b>کل برداشت ها:</b> <?php echo number_format((float)$row_withdraw_sum['total_amount'], 8, '.', ''); ?>
												</div>
												<div class="col-lg-4">
													<b>سرمایه درگردش:</b> <?php echo number_format((float)$row_plan_sum['total_plan'], 8, '.', ''); ?>
												</div>
											</div>
											<div class="row mt-5">
												<div class="col-lg-4">
													<b>کل پاداش زیرمجموعه ها:</b> <?php echo number_format((float)$row_ref_sum['total_ref'], 8, '.', ''); ?>
												</div>
												<div class="col-lg-4">
													<b>سود پرداختی به کابران:</b> <?php echo number_format((float)$row_ref_sum1['total_profit'], 8, '.', ''); ?>
												</div>
												<div class="col-lg-4">
													<b>کارمزد برداشت کاربران:</b> <?php echo number_format((float)$row_withdraw_sum['total_fee'], 8, '.', ''); ?>
												</div>

											</div>
											<div class="row mt-5">
                                                <div class="col-lg-4">
                                                    <b>تعداد کل پلن ها : </b> <?php
                                                    
                                                    $all_plan = count($db->get("active_investment_plan"));
                                                    echo $all_plan;
                                                    ?>
                                                </div>
												<div class="col-lg-4">
                                                    <b>تعداد سپرده های دلاری : </b> <?php

                                                    $db->where("type", "dollar");
                                                    $dolar = count($db->get("active_investment_plan"));
                                                    echo $dolar;
                                                    
                                                    ?>
												</div>
												<div class="col-lg-4">
                                                    <b>تعداد سپرده های دوج : </b> <?php
                                                    
                                                    echo $all_plan - $dolar;
                                                    ?>
                                                </div>

											</div>
										</div>
									</div>
									<!--end::Portlet-->
								</div>
							</div>
						</div>
						<!-- end:: Content -->
					</div>
					<!-- begin:: Footer -->
					<?php include("Components/footer.php"); ?>
					<!-- end:: Footer -->            </div>
			</div>
		</div>

		<!-- end:: Page -->


		<!-- begin::Quick Panel -->
		<?php include("Components/quick-panel-sidebar.php"); ?>
		<!-- end::Quick Panel -->

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>
		<!-- end::Scrolltop -->
		<!-- begin::Sticky Toolbar -->


		<!-- begin::Global Config(global config for global JS sciprts) -->
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
		<script src="assets/vendors/global/vendors.bundle.js" type="text/javascript"></script>
		<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->


		<!--begin::Page Vendors(used by this page) -->
		<script src="assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

		<!--end::Page Vendors -->


		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/dashboard.js" type="text/javascript"></script>
		<!--end::Page Scripts -->
		<script>
			var DashboardINIT = {
				init: function () {
					$.getJSON( "data/counter_chart.json", function( data ) {
						// console.log(data);
						new Morris.Line({
							element: "view_count",
							data:  data,
							xkey: "date",
							ykeys: ["value", "value2"],
							labels: ["بازدید کننده", "بازدید"],
							lineColors: ["#6e4ff5", "#f6aa33"]
						})
					})
				}
			}
			jQuery(document).ready(function () {
				DashboardINIT.init()
			});
		</script>
	</body>
	<!-- end::Body -->

</html>