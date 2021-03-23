<?php
require_once('../../checklogin.php');
?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

	<!-- /Added by HTTrack -->
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php include($nav_path . "Modules-head.php"); ?>
		<title>Rahaaa | تیکت های پشتیباتی</title>

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
											لیست تیکت ها 
										</h3>
									</div>

								</div>

								<div class="kt-portlet__body">
									<!--begin: Datatable -->
									<table class="table table-striped- table-bordered table-hover table-checkable" id="message_table">
										<thead>
											<tr>
												<th>Record ID</th>
												<th>موضوع</th>
												<th>تاریخ</th>
												<th>نوع</th>
												<th>وضعیت</th>
												<th>عملیات</th>
											</tr>
										</thead>

										<tbody>
											<?php

											mysqli_select_db($cn, $database_cn);
											$query_message = sprintf("SELECT * FROM `tickets` ORDER BY status_id ASC, created_at DESC");
											$rsmessage = mysqli_query($cn, $query_message) or die(mysqli_error($cn));
											$row_rsmessage = mysqli_fetch_assoc($rsmessage);
											$totalRows_rsmessage = mysqli_num_rows($rsmessage);

											if ($totalRows_rsmessage > 0) {
												do {
											?>

											<tr>
												<td><?php echo $row_rsmessage['ticket_id']; ?></td>
												<td><?php echo $row_rsmessage['subject']; ?></td>

												<td><span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill"><?php echo $row_rsmessage['created_at']; ?></span></td>
												<td><?php
													if ($row_rsmessage['department_id'] === '1') {
														echo '<span class="kt-badge kt-badge--warning kt-badge--inline kt-badge--pill">پشتیبانی عمومی</span>';
													} elseif ($row_rsmessage['department_id'] === '2') {
														echo '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">پشتیبانی مالی</span>';
													} elseif ($row_rsmessage['department_id'] === '3') {
														echo '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">پشتیبانی فنی</span>';
													} else {
														echo '<span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill">نا مشخص</span>';
													}
													?>

												</td>
												<td><?php
													if ($row_rsmessage['status_id'] === '1') {
														echo '<span class="kt-badge kt-badge--warning kt-badge--inline kt-badge--pill">درحال بررسی</span>';
													} elseif ($row_rsmessage['status_id'] === '2') {
														echo '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">بسته</span>';
													} elseif ($row_rsmessage['status_id'] === '3') {
														echo '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">پاسخ داده شده</span>';
													} else {
														echo '<span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill">نا مشخص</span>';
													}
													?>

												</td>
												<td>
													<?php if (in_array("change_status", $privilegeslist)) { ?><a class="btn btn-sm btn-clean btn-icon btn-icon-md" href="change_read.php?id=<?php echo encrypt($row_rsmessage['ticket_id'], session_id() . "sts"); ?>">
													<i class="la la-toggle-on"></i>
													</a><?php } ?>
													<?php if (in_array("messages_det", $privilegeslist)) { ?>
													<a href="ticket_det.php?id=<?php echo encrypt($row_rsmessage['ticket_id'], session_id() . "msg"); ?>"
													   class="btn btn-sm btn-clean btn-icon btn-icon-md"
													   title="مشاهده">
														<i class="la la-search"></i>
													</a>
													<?php } ?>
												</td>
											</tr>
											<?php
												} while ($row_rsmessage = mysqli_fetch_assoc($rsmessage));
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