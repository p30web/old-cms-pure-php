<?php

include("checklogin.php");
require_once('includes/classes/Validation.php');
require_once('includes/classes/upload/class.upload.php');


$id = decrypt($_GET['ticket'], session_id() . "tct");
$id = GetSQLValueString($id, 'int');

$db->where("ticket_id",$id);
$fetch_tickets = $db->getOne("tickets");


$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
	$val->name('شناسه تیکت')->value($_POST['ticket_id'])->required();
	$val->name('متن درخواست')->value($_POST['message'])->required();

	if ($val->isSuccess()) {



		$tickets_id = decrypt($_POST['ticket_id'], session_id() . "ntc");
		$tickets_id = GetSQLValueString($tickets_id, 'int');
		$message = GetSQLValueString($_POST['message'], "def");


		$db->where("ticket_id",$tickets_id);
		$tickets_update = array(
			"status_id" => 1,
			"modified_at" => jdate('Y/m/d H:i:s'),

		);
		if ($db->update("tickets", $tickets_update)) {
			$ticket_message_array = array(
				"ticket_id" => $tickets_id,
				"owner" => 1,
				"seen" => 0,
				"message" => $message,
				//                "attachments" => ,
				"created_at" => jdate('Y/m/d H:i:s'),
				"owner_id" => $_SESSION['member_id'],
				"owner_ip" => $_SERVER['REMOTE_ADDR'],
			);
			if ($ticket_message_id = $db->insert("ticket_message", $ticket_message_array)) {
				activity_log($_SESSION['member_id'], $_SERVER['REQUEST_URI'],21, "tickets,ticket_message", "ارسال پیام جدید به پشتیبانی");
				header('Location: ' . $_POST['referurl'] . '?add=1&ticket='.encrypt($tickets_id, session_id() . "tct"));
				echo "<script>
	window.location= " . $_POST['referurl'] . "'?add=1&ticket='".encrypt($tickets_id, session_id() . "tct").";
	</script>";
				exit;
			}else {
				$hasError = 1;
			}
		}
	} else {
		$hasError = 1;
	}
}


?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
	<!-- begin::Head -->

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ایران دوج | مشاهده تیکت</title>
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
											مشاهده تیکت </h3>
										<span class="kt-subheader__separator kt-hidden"></span>
										<div class="kt-subheader__breadcrumbs">
											<a href="#" class="kt-subheader__breadcrumbs-home">
												<i class="flaticon2-shelter"></i></a>
											<span class="kt-subheader__breadcrumbs-separator"></span>
											<a href="my_tickets.php" class="kt-subheader__breadcrumbs-link">
												تیکت های من
											</a>
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
							<div class="kt-container  kt-grid__item kt-grid__item--fluid">
								<div class="row">
									<div class="col-xl-4">
										<!--begin::Portlet-->
										<div class="kt-portlet">
											<div class="kt-portlet__head">
												<div class="kt-portlet__head-label">
													<h3 class="kt-portlet__head-title">
														اطلاعات تیکت
													</h3>
												</div>
											</div>
											<div class="kt-portlet__body">
												<!--begin::Preview-->
												<div class="kt-demo">
													<div class="kt-demo__preview">
														<div class="kt-list-timeline">
															<div class="kt-list-timeline__items">
																<div class="kt-list-timeline__item">
																	<span class="kt-list-timeline__badge kt-list-timeline__badge--danger"></span>
																	<span class="kt-list-timeline__icon flaticon2-back kt-font-danger"></span>
																	<span class="kt-list-timeline__text"><?php echo $fetch_tickets['subject']; ?></span>
																</div>
																<div class="kt-list-timeline__item">
																	<span class="kt-list-timeline__badge kt-list-timeline__badge--warning"></span>
																	<span class="kt-list-timeline__icon flaticon2-calendar kt-font-warning"></span>
																	<span class="kt-list-timeline__text"><?php echo $fetch_tickets['created_at']; ?></span>
																</div>
																<div class="kt-list-timeline__item">
																	<span class="kt-list-timeline__badge kt-list-timeline__badge--primary"></span>
																	<span class="kt-list-timeline__icon flaticon2-note kt-font-primary"></span>
																	<span class="kt-list-timeline__text"><?php echo $fetch_tickets['modified_at']; ?></span>
																</div>
																<div class="kt-list-timeline__item">
																	<span class="kt-list-timeline__badge kt-list-timeline__badge--brand"></span>
																	<span class="kt-list-timeline__icon flaticon2-group kt-font-brand"></span>
																	<span class="kt-list-timeline__text"><?php
																		mysqli_select_db($cn, $database_cn);
																		$query_departments = sprintf("SELECT `id`,`name` FROM `departments` WHERE id= %d", $fetch_tickets['department_id']);
																		$rsdepartments = mysqli_query($cn, $query_departments) or die(mysqli_error($cn));
																		$row_rsdepartments = mysqli_fetch_assoc($rsdepartments);
																		echo $row_rsdepartments['name'];
																		?></span>
																</div>
																<div class="kt-list-timeline__item">
																	<span class="kt-list-timeline__badge kt-list-timeline__badge--success"></span>
																	<span class="kt-list-timeline__icon flaticon2-hexagonal kt-font-success"></span>
																	<span class="kt-list-timeline__text"><?php


																		$status_style = "info";
																		switch ($fetch_tickets['status_id']) {
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
																		?></span>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--end::Preview-->

												<div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div>
											</div>
										</div>
										<!--end::Portlet-->
									</div>
									<div class="col-xl-8">
										<?php
										mysqli_select_db($cn, $database_cn);
										$query_ticket_message= sprintf("SELECT * FROM `ticket_message` WHERE ticket_id= %d order by id DESC ", $fetch_tickets['ticket_id']);
										$ticket_message= mysqli_query($cn, $query_ticket_message) or die(mysqli_error($cn));
										$row_ticket_message = mysqli_fetch_assoc($ticket_message);
										$totalRows_ticket_message = mysqli_num_rows($ticket_message);
										if($totalRows_ticket_message > 0) {
											do {



												if($row_ticket_message['owner'] == 1){
													$seen_message_array = array(
														"seen" => 1,
													);
													$db->where("id",$row_ticket_message['id']);
													$db->where("seen", 0);
													$db->update("ticket_message", $seen_message_array);
												}

										?>
										<div class="row">
											<div class="col-xl-12">
												<!--begin::Portlet-->
												<div
													 class="kt-portlet kt-portlet--solid-<?php
												if($row_ticket_message['owner'] == 1){
													echo 'light';
												}else{
													echo 'success';
												}
															?> kt-portlet--height-fluid">
													<div class="kt-portlet__head">
														<div class="kt-portlet__head-label">
															<span class="kt-portlet__head-icon"><i
																								   class="flaticon2-fast-back"></i></span>
															<h3 class="kt-portlet__head-title">
																<?php
												if($row_ticket_message['owner'] == 1){
													echo 'پیام شما';
												}else{
													echo 'پیام مرکز پشتیبانی';
												}
																?>
															</h3>
														</div>
														<div class="kt-portlet__head-toolbar">
															<?php echo $row_ticket_message['created_at']; ?>
														</div>
													</div>
													<div class="kt-portlet__body">
														<div class="kt-portlet__content">
															<?php echo $row_ticket_message['message']; ?>
														</div>
													</div>
													<div class="kt-portlet__foot kt-portlet__foot--sm kt-align-right">
														ارسال کننده:
														<?php
												if($row_ticket_message['owner'] == 1){
													$db->where("id", $row_ticket_message['owner_id']);
													$fetch_owner = $db->getOne("members", ["firstname", "lastname"]);
													echo $fetch_owner['firstname'].' '.$fetch_owner['lastname'];
												}else{
													//													$db->where("id", $row_ticket_message['owner_id']);
													//													$fetch_owner = $db->getOne("users", ["name"]);
													//													echo $fetch_owner['name'];
													echo 'پشتیبانی';
												}
														?>
													</div>
												</div>
												<!--end::Portlet-->
											</div>
										</div>
										<?php
											} while($row_ticket_message = mysqli_fetch_assoc($ticket_message));
										}
										?>
										<div class="row">
											<div class="col-xl-12">
												<!--begin::Portlet-->
												<div
													 class="kt-portlet kt-portlet--solid-light kt-portlet--height-fluid">
													<div class="kt-portlet__head">
														<div class="kt-portlet__head-label">
															<span class="kt-portlet__head-icon"><i
																								   class="flaticon2-fast-back"></i></span>
															<h3 class="kt-portlet__head-title">
																ارسال پیام
															</h3>
														</div>
														<div class="kt-portlet__head-toolbar">

														</div>
													</div>
													<div class="kt-portlet__body">
														<form class="kt-form kt-form--label-right" action="ticket_details.php" id="form_new_message" method="post">
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
																<?php
																if ($_GET['add'] == 1) {
																?>
																<div class="form-group form-group-last ">
																	<div class="alert alert-success" role="alert" id="kt_form_1_msg">
																		<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
																		<div class="alert-text">
																			درخواست شما با موفقیت ثبت شد.
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
																<div class="kt-portlet__content">
																	<div class="form-group row form-group-last">
																		<label class="col-lg-1 col-form-label">متن درخواست:</label>
																		<div class="col-lg-11">
																			<textarea class="form-control" name="message" rows="8"></textarea>
																		</div>
																	</div>
																</div>
															</div>
															<input type="hidden" value="<?php echo encrypt($id, session_id() . "ntc"); ?>" name="ticket_id">
															<div class="kt-form__actions">
																<div class="row">
																	<div class="col-lg-6">
																		<button type="submit" class="btn btn-primary">ارسال پیام</button>
																	</div>
																</div>
															</div>
														</form>
													</div>
													<div class="kt-portlet__foot kt-portlet__foot--sm kt-align-right">
														ارسال پیام به مرکز پشتیبانی
													</div>
												</div>
												<!--end::Portlet-->
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
		<script>
			"use strict";

			var KTFormControls = {
				init: function () {
					$("#form_new_message").validate({
						rules: {
							message: {required: !0}

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

			});
		</script>
		<!--end::Page Scripts -->
	</body>
	<!-- end::Body -->

</html>