<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');



$id = decrypt($_GET['id'], session_id() . "inv");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_investment_plan = $db->getOne("`active_investment_plan`", $cols);
$fetch_investment_plan_count = $db->count;




$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
	$val->name('عنوان')->value($_POST['title'])->required();
	$val->name('شناسه پلن')->value($_POST['plan_id'])->required();
	$val->name('شناسه کاربر')->value($_POST['member_id'])->required();
	$val->name('سود روزانه')->value($_POST['daily_profit'])->required();
	$val->name('سود روز اول')->value($_POST['first_day_profit'])->required();
	$val->name('قیمت')->value($_POST['price'])->required();
	$val->name('واحد ارزی')->value($_POST['unit_id'])->required();
	$val->name('درصد بهره')->value($_POST['interest_rate'])->required();
	$val->name('دوره زمانی')->value($_POST['period'])->required();
	$val->name('توع دوره زمانی')->value($_POST['period_type'])->required();
	$val->name('وضعیت')->value($_POST['status'])->required();

	if ($val->isSuccess()) {


		$title = GetSQLValueString($_POST['title'], 'def');
		$plan_id = GetSQLValueString($_POST['plan_id'], 'int');
		$member_id = GetSQLValueString($_POST['member_id'], 'int');
		$daily_profit = GetSQLValueString($_POST['daily_profit'], 'def');
		$first_day_profit = GetSQLValueString($_POST['first_day_profit'], 'def');
		$price = GetSQLValueString($_POST['price'], 'int');
		$unit_id = GetSQLValueString($_POST['unit_id'], 'int');
		$interest_rate = GetSQLValueString($_POST['interest_rate'], 'def');
		$period = GetSQLValueString($_POST['period'], 'def');
		$period_type = GetSQLValueString($_POST['period_type'], 'def');
		$status = GetSQLValueString($_POST['status'], 'def');


		$db->where("id", $id);

		$insert_array = array(
			"title" => $title,
			"plan_id" => $plan_id,
			"member_id" => $member_id,
			"daily_profit" => $daily_profit,
			"first_day_profit" => $first_day_profit,
			"price" => $price,
			"unit_id" => $unit_id,
			"interest_rate" => $interest_rate,
			"period" => $period,
			"period_type" => $period_type,
			"modified_at" => jdate('Y/m/d H:i:s'),
			"status" => $status,
		);
		if ($db->update("active_investment_plan", $insert_array)) {
			header('Location: ' . $_POST['referurl'] . '');
			echo "<script>
	window.location= " . $_POST['referurl'] . ";
	</script>";
			exit;
		}
	} else {
		$hasError = 1;
	}
}

?>
<!DOCTYPE html>
<html lang="en" direction="rtl" style="direction: rtl;">
	<!-- begin::Head -->

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php include($nav_path . "Modules-head.php"); ?>
		<title>Rahaaa | ویرایش پلن</title>
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
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
										ویرایش پلن <?php echo $fetch_investment_plan['title']; ?> </h3>

									<span class="kt-subheader__separator kt-hidden"></span>
									<div class="kt-subheader__breadcrumbs">
										<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
										<span class="kt-subheader__breadcrumbs-separator"></span>
										<a href="investment_plan.php" class="kt-subheader__breadcrumbs-link">
											پلن های سرمایه گذاری کاربران </a>
										<!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
									</div>
								</div>
							</div>
						</div>
						<!-- end:: Subheader -->
						<!-- begin:: Content -->
						<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
							<div class="row">
								<div class="col-lg-12">
									<!--begin::Portlet-->
									<div class="kt-portlet">
										<div class="kt-portlet__head">
											<div class="kt-portlet__head-label">
												<h3 class="kt-portlet__head-title">
													مشخصات پلن <?php echo $fetch_investment_plan['title']; ?>
												</h3>
											</div>
										</div>
										<!--begin::Form-->
										<form class="kt-form kt-form--label-right" id="form_investment_plan_edit" method="post"
											  action="investment_plan_edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
											<div class="kt-portlet__body">
												<?php
												if ($hasError === 1) {
												?>
												<div class="form-group form-group-last ">
													<div class="alert alert-danger" role="alert" id="kt_form_1_msg">
														<div class="alert-icon"><i class="flaticon-warning"></i></div>
														<div class="alert-text">
															<?php echo $val->displayErrors(); ?>
														</div>
														<div class="alert-close">
															<button type="button" class="close" data-dismiss="alert"
																	aria-label="Close">
																<span aria-hidden="true"><i
																							class="la la-close"></i></span>
															</button>
														</div>
													</div>
												</div>
												<?php
												}
												?>

												<div class="form-group row">
													<div class="col-lg-6 form-group-sub">
														<label>عنوان:</label>
														<input type="text" name="title" class="form-control"
															   value="<?php echo $fetch_investment_plan['title']; ?>"
															   placeholder="عنوان را وارد کنید">
													</div>
													<div class="col-lg-6 form-group-sub">
														<label class="">شناسه پلن:</label>
														<input type="text" name="plan_id" class="form-control"
															   value="<?php echo $fetch_investment_plan['plan_id']; ?>"
															   placeholder="شناسه پلن را وارد نمایید">
														
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-6 form-group-sub">
														<label class="">شناسه کاربر:</label>
														<input type="text" name="member_id" class="form-control"
															   value="<?php echo $fetch_investment_plan['member_id']; ?>"
															   placeholder="شناسه کاربر را وارد کنید">
													</div>
													<div class="col-lg-6 form-group-sub">
														<label class="">سود روزانه:</label>
														<input type="text" name="daily_profit" class="form-control"
															   value="<?php echo $fetch_investment_plan['daily_profit']; ?>"
															   placeholder="سود روزانه را وارد کنید">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-3 form-group-sub">
														<label>سود روز اول:</label>
														<input type="text" name="first_day_profit" class="form-control"
															   value="<?php echo $fetch_investment_plan['first_day_profit']; ?>"
															   placeholder="سود روز اول را وارد کنید">
													</div>
													<div class="col-lg-3 form-group-sub">
														<label class="">قیمت:</label>
														<input type="text" name="price" class="form-control"
															   value="<?php echo $fetch_investment_plan['price']; ?>"
															   placeholder="قیمت را وارد کنید">
													</div>
													<div class="col-lg-3 form-group-sub">
														<label class="">واحد ارزی:</label>
														<select class="form-control kt-select2" id="unit_id" name="unit_id">
															<option value="" selected>-- واحد ارزی را انتخاب کنید --</option>

															<?php
															mysqli_select_db($cn, $database_cn);
															$query_rsunit = sprintf("SELECT `id`,`name_fa` FROM `unit` ");
															$rssunit = mysqli_query($cn, $query_rsunit) or die(mysqli_error($cn));
															$row_rsunit= mysqli_fetch_assoc($rssunit);
															$totalRows_rsunit = mysqli_num_rows($rssunit);
															if ($totalRows_rsunit > 0) {

																do {
															?>
															<option value="<?php echo $row_rsunit['id']; ?>" <?php if ($row_rsunit['id'] == $fetch_investment_plan['unit_id']) { echo 'selected'; } ?>><?php echo $row_rsunit['name_fa']; ?></option>
															<?php
																} while ($row_rsunit = mysqli_fetch_assoc($rssunit));
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-6 form-group-sub">
														<label>درصد سود:</label>
														<input type="text" name="interest_rate" class="form-control"
															   value="<?php echo $fetch_investment_plan['interest_rate']; ?>"
															   placeholder="درصد سود را وارد کنید">
													</div>
													<div class="col-lg-6 form-group-sub">
														<label class="">دوره زمانی:</label>
														<input type="text" name="period" class="form-control"
															   value="<?php echo $fetch_investment_plan['period']; ?>"
															   placeholder="دوره زمانی را وارد کنید">
													</div>
												</div>
												
												<div class="form-group form-group-last row">

													<div class="col-lg-6 form-group-sub">
														<label>نوع دوره زمانی:</label>
                                                        <div class="kt-radio-inline">
                                                            <label class="kt-radio kt-radio--solid">
                                                                <input type="radio" name="period_type" <?php if ($fetch_investment_plan['period_type'] === 'day') echo 'checked'; ?> value="day">روزانه
                                                                <span></span>
                                                            </label>
                                                            <label class="kt-radio kt-radio--solid">
                                                                <input type="radio" name="period_type" <?php if ($fetch_investment_plan['period_type'] === 'month') echo 'checked'; ?> value="month"> ماهانه
                                                                <span></span>
                                                            </label>
                                                            <label class="kt-radio kt-radio--solid">
                                                                <input type="radio" <?php if ($fetch_investment_plan['period_type'] === '3month') echo 'checked'; ?> name="period_type" value="3month">سه ماه
                                                                <span></span>
                                                            </label>
                                                            <label class="kt-radio kt-radio--solid">
                                                                <input type="radio" <?php if ($fetch_investment_plan['period_type'] === '6month') echo 'checked'; ?> name="period_type" value="6month">شش ماه
                                                                <span></span>
                                                            </label>
                                                            <label class="kt-radio kt-radio--solid">
                                                                <input type="radio" <?php if ($fetch_investment_plan['period_type'] === 'yearly') echo 'checked'; ?> name="period_type" value="yearly">یکساله
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        
													</div>
													<div class="col-lg-6 form-group-sub">
														<label>وضعیت:</label>
														<div class="kt-radio-inline">
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="status" <?php if ($fetch_investment_plan['status'] === '1') echo 'checked'; ?> value="1"> فعال
																<span></span>
															</label>
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="status" <?php if ($fetch_investment_plan['status'] === '2') echo 'checked'; ?> value="1"> پایان
																<span></span>
															</label>
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="status" <?php if ($fetch_investment_plan['status'] === '3') echo 'checked'; ?> value="0"> غیر فعال
																<span></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<input type="hidden" name="referurl"
												   value="<?php echo $_SERVER['HTTP_REFERER']; ?> "/>
											<div class="kt-portlet__foot">
												<div class="kt-form__actions">
													<div class="row">
														<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">ویرایش رکورد
															</button>
														</div>
													</div>
												</div>
											</div>
										</form>
										<!--end::Form-->
									</div>
									<!--end::Portlet-->

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
		<!-- end::Quick Panel -->

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>

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
		<script src="<?php echo $nav_path; ?>assets/vendors/global/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?php echo $nav_path; ?>assets/js/scripts.bundle.js" type="text/javascript"></script>
		<script type="text/javascript">


			var KTSelect2 = {
				init: function () {
					$("#unit_id").select2({placeholder: "واحد ارزی را انتخاب کنید"})
				}
			};

			var KTFormControls = {
				init: function () {
					$("#form_investment_plan_edit").validate({
						rules: {
							title: {required: !0},
							plan_id: {required: !0},
							member_id: {required: !0},
							daily_profit: {required: !0},
							first_day_profit: {required: !0},
							price: {required: !0},
							unit_id: {required: !0},
							interest_rate: {required: !0},
							period: {required: !0},
							period_type: {required: !0},
							status: {required: !0},
							

						}, invalidHandler: function (e, r) {
							console.log(e);
							swal.fire({
								title: "",
								text: "در ارسال شما خطاهایی وجود دارد. لطفا آنها را اصلاح کنید",
								type: "error",
								confirmButtonClass: "btn btn-secondary",
								onClose: function (e) {
								}
							}), e.preventDefault()
						}
					})
				}
			};
			jQuery(document).ready(function () {
				KTFormControls.init();
				KTSelect2.init();

			});

		</script>
		<!--end::Global Theme Bundle -->


	</body>
	<!-- end::Body -->

</html>