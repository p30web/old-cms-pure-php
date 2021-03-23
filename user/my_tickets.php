<?php

include("checklogin.php");
require_once('includes/classes/Validation.php');
require_once('includes/classes/upload/class.upload.php');

mysqli_select_db($cn, $database_cn);

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $query_tickets = sprintf("SELECT * FROM `tickets` WHERE `owner_id` = " . $fetch_admin[0]['admin_id'] . " and owner_type = 1 ORDER BY created_at DESC ");
}else{
    $query_tickets = sprintf("SELECT * FROM `tickets` WHERE `owner_id` = " . $_SESSION["member_id"] . " and owner_type = 1 ORDER BY created_at DESC ");
}

$tickets = mysqli_query($cn, $query_tickets) or die(mysqli_error($cn));
$row_tickets = mysqli_fetch_assoc($tickets);
$totalRows_tickets = mysqli_num_rows($tickets);

?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
	<!-- begin::Head -->

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ایران دوج | تیکت های من</title>
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
											تیکت های من </h3>
										<span class="kt-subheader__separator kt-hidden"></span>
										<div class="kt-subheader__breadcrumbs">
											<a href="#" class="kt-subheader__breadcrumbs-home">
												<i class="flaticon2-shelter"></i></a>
											<span class="kt-subheader__breadcrumbs-separator"></span>
											<a href="help_center.php" class="kt-subheader__breadcrumbs-link">
												مرکز پشتیبانی
											</a>
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
							<!-- begin:: hero -->
							<div class="kt-sc-license" style="background-image: url('media/bg/bg-8.jpg')">
								<div class="kt-container ">
									<div class="kt-sc__top">
										<h3 class="kt-sc__title">
											لیست تیکت های
										</h3>
										<div class="kt-sc__nav">
											<a href="help_center.php" class="kt-link kt-link--light kt-font-bold">مرکز پشتیبانی</a>
										</div>
									</div>
								</div>
							</div>
							<!-- end:: hero -->
							<div class="kt-negative-spacing--7"></div>
							<!-- begin:: infobox -->
							<div class="kt-grid__item">
								<div class="kt-container ">
									<div class="kt-portlet">
										<div class="kt-portlet__body">
											<div class="kt-infobox">
												<div class="kt-infobox__body">
													<div class="row">
														<div class="col-xl-12">
															<table class="table table-striped- table-bordered table-hover table-checkable"
																   id="kt_table_1">
																<thead>

																	<tr>
																		<th>شناسه</th>
																		<th>عنوان</th>
																		<th>بخش</th>
																		<th>تاریخ ثبت</th>
																		<th>وضعیت</th>
																		<th>عملیات</th>
																	</tr>
																</thead>

																<tbody>
																	<?php
																	if($totalRows_tickets > 0) {

																		do {
																	?>
																	<tr>
																		<td><?php echo $row_tickets['ticket_id']; ?></td>
																		<td><strong class="kt-font-primary"><?php echo $row_tickets['subject']; ?></strong></td>
																		<td><?php
																			mysqli_select_db($cn, $database_cn);
																			$query_departments = sprintf("SELECT `id`,`name` FROM `departments` WHERE id= %d", $row_tickets['department_id']);
																			$rsdepartments = mysqli_query($cn, $query_departments) or die(mysqli_error($cn));
																			$row_rsdepartments = mysqli_fetch_assoc($rsdepartments);
																			echo $row_rsdepartments['name'];
																			?></td>
																		<td>
																			<span style="width: 110px;"><span class="kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-danger"><?php echo $row_tickets['created_at']; ?></span></span>
																		</td>
																		<td>
																			<?php
																			

																			$status_style = "info";
																			switch ($row_tickets['status_id']) {
																				case 1:
																					$status_style = "warning";
																					$status_name = "درحال بررسی";
																					break;
																				case 2:
																					$status_style = "primary";
																					$status_name = "بسته";
																					break;
																				case 3:
																					$status_style = "success";
																					$status_name = "پاسخ داده شده";
																					break;
																				case 4:
																					$status_style = "danger";
																					$status_name = "نامشخص";

																					break;
																				default:
																					$status_style = "info";
																					$status_name = "نامشخص";

																			}

																			echo '<span style="width: 100px;"><span class="btn btn-bold btn-sm btn-font-sm  btn-label-'.$status_style.'">'.$status_name.'</span></span>';
																			?>
																		</td>
																		<td>
																			<a href="ticket_details.php?ticket=<?php echo encrypt($row_tickets['ticket_id'], session_id() . "tct"); ?>"
																			   class="btn btn-sm btn-clean btn-icon btn-icon-md  btn-label-primary"
																			   title="ویرایش">
																				<i class="la la-search"></i>
																			</a>
																		</td>
																	</tr>
																	<?php
																		} while($row_tickets = mysqli_fetch_assoc($tickets));
																	}
																	?>
																</tbody>

															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- end:: infobox -->

							<!-- end:: Content -->
						</div>
					</div>

					<!-- begin:: Footer -->
					<?php include("footer.php"); ?>
					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<?php include("footer-script.php"); ?>
		<script>
			"use strict";
			var KTDatatablesBasicHeaders = {
				init: function () {
					$("#kt_table_1").DataTable({
						responsive: !0
					})
				}
			};
			jQuery(document).ready(function () {
				KTDatatablesBasicHeaders.init()
			});
		</script>
		<!--end::Page Scripts -->
	</body>
	<!-- end::Body -->

</html>