<?php
require_once('../../checklogin.php');
?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

	<!-- /Added by HTTrack -->
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<?php include($nav_path . "Modules-head.php"); ?>
		<title>Rahaaa | مدیریت پرتال</title>

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
										مدیریت پرتال </h3>

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
											مدیریت پرتال
										</h3>
									</div>
									<div class="kt-portlet__head-toolbar">
										<div class="kt-portlet__head-wrapper">
											<div class="kt-portlet__head-actions">
												<?php
												if (in_array("portal_add", $privilegeslist)) echo '<a href="portal_add.php" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i>رکورد جدید</a>';
												?>
											</div>
										</div>
									</div>
								</div>

								<div class="kt-portlet__body">
									<!--begin: Datatable -->
									<table class="table table-striped- table-bordered table-hover table-checkable"
										   id="mem_table">
										<thead>
											<tr>
												<th>Record ID</th>
												<th>نام</th>
												<th>دامنه</th>
												<th>عنوان</th>
												<th>وضعیت</th>
												<th>عملیات</th>
											</tr>
										</thead>

										<tbody>
											<?php

											mysqli_select_db($cn, $database_cn);
											$query_rssettings = sprintf("SELECT * FROM `settings` ORDER BY id ASC");
											$rssettings = mysqli_query($cn, $query_rssettings) or die(mysqli_error($cn));
											$totalRows_rssettings = mysqli_num_rows($rssettings);

											if ($totalRows_rssettings > 0) {
												do {
											?>

											<tr>
												<td><?php echo $row_rssettings['id']; ?></td>
												<td><?php echo $row_rssettings['name']; ?></td>
												<td><?php echo $row_rssettings['domain']; ?></td>
												<td><?php echo $row_rssettings['title']; ?></td>

												<td><?php
													if ($row_rssettings['status'] == '1') {
														echo '<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">فعال</span>';
													} elseif ($row_rssettings['status'] == '0') {
														echo '<span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill">غیر فعال</span>';
													} else {
														echo '<span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill">نا مشخص</span>';
													}
													?></td>
												<td>
													<span class="dropdown">
														<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md"
														   data-toggle="dropdown" aria-expanded="true">
															<i class="la la-ellipsis-h"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right">
															<?php if (in_array("change_status", $privilegeslist)) { ?><a
																														 class="dropdown-item"
																														 href="<?php ?>../../change_status.php?table=<?php echo encrypt('settings', session_id() . "sts"); ?>&field=<?php echo encrypt('status', session_id() . "sts"); ?>&id=<?php echo encrypt($row_rssettings['id'], session_id() . "sts"); ?>">
															<i class="la la-toggle-on"></i> تغییر وضعیت
															</a><?php } ?>

														</div>
													</span>
													<?php if (in_array("user_edit", $privilegeslist)) { ?>
													<a href="portal_edit.php?id=<?php echo encrypt($row_rssettings['id'], session_id() . "prt"); ?>"
													   class="btn btn-sm btn-clean btn-icon btn-icon-md"
													   title="ویرایش">
														<i class="la la-edit"></i>
													</a>
													<?php } ?>
												</td>
											</tr>
											<?php
												} while ($row_rssettings = mysqli_fetch_assoc($rssettings));
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
					$("#mem_table").DataTable({
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