<?php

include("checklogin.php");

$fetch_admin = $db->get("admin_login");

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
		<title>ایران دوج | داشبورد</title>
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
											درآمد کسب شده </h3>
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
								<div class="row">
									<div class="col-lg-4">
										<div class="kt-portlet kt-callout kt-callout--info">
											<div class="kt-portlet__body">
												<div class="kt-callout__body">
													<div class="kt-callout__content">
														<h3 class="kt-callout__title">
															دنبال کننده های شما
														</h3>
														<p class="kt-callout__desc">
															تا ساعت <?php echo jdate("H:i:s"); ?>
														</p>
													</div>
													<div class="kt-callout__action">
														<h3 class="kt-font-info">
															<?php
															$db->where("parent_id", $fetch_member['id']);
															$db->get("members", null, "id");
															echo $db->count;
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
															دنبال کننده های فعال
														</h3>
														<p class="kt-callout__desc">
															تا ساعت <?php echo jdate("H:i:s"); ?>
														</p>
													</div>
													<div class="kt-callout__action">
														<h3 class="kt-font-success">
															<?php
															$db->where("parent_id", $fetch_member['id']);
															$db->where("status", "1");
															$db->get("members", null, "id");
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
															دنبال کننده های غیرفعال
														</h3>
														<p class="kt-callout__desc">
															تا ساعت <?php echo jdate("H:i:s"); ?>
														</p>
													</div>
													<div class="kt-callout__action">
														<h3 class="kt-font-danger">
															<?php
															$db->where("parent_id", $fetch_member['id']);
															$db->where("status", "0");
															$db->get("members", null, "id");
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
									<div class="col-lg-6">
										<div class="kt-portlet kt-callout kt-callout--success kt-callout--diagonal-bg">
											<div class="kt-portlet__body">
												<div class="kt-callout__body">
													<div class="kt-callout__content">
														<h3 class="kt-callout__title">
															درآمد دعوت دوستان
														</h3>
														<p class="kt-callout__desc">
															تا ساعت <?php echo jdate("H:i:s"); ?>
														</p>
													</div>
													<div class="kt-callout__action">
														<h3 class="kt-font-success"><?php
															mysqli_select_db($cn, $database_cn);

                                                            $fetch_admin = $db->get("admin_login");

                                                            if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                                                $query_active_plan_sum = sprintf("SELECT SUM(refIncome) as total_refIncome FROM `members` WHERE parent_id=".$fetch_admin[0]['admin_id']." and status = '1' ");
                                                            }else{
                                                                $query_active_plan_sum = sprintf("SELECT SUM(refIncome) as total_refIncome FROM `members` WHERE parent_id=".$_SESSION['member_id']." and status = '1' ");
                                                            }
                                                            
															$active_plan_sum= mysqli_query($cn, $query_active_plan_sum) or die(mysqli_error($cn));
															$row_active_plan_sum= mysqli_fetch_assoc($active_plan_sum);
															echo ($row_active_plan_sum['total_refIncome'] != null) ? number_format((float)$row_active_plan_sum['total_refIncome'], 8, '.', '') : number_format((float)0, 8, '.', '');
															?> Ð</h3>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="kt-portlet kt-callout kt-callout--warning kt-callout--diagonal-bg">
											<div class="kt-portlet__body">
												<div class="kt-callout__body">
													<div class="kt-callout__content">
														<h3 class="kt-callout__title">
															پلن های زیرمجموعه
														</h3>
														<p class="kt-callout__desc">
															تا ساعت <?php echo jdate("H:i:s"); ?>
														</p>
													</div>
													<div class="kt-callout__action">
														<h3 class="kt-font-warning">0</h3>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-12">
										<div class="kt-portlet kt-portlet--mobile">
											<div class="kt-portlet__head kt-portlet__head--lg">
												<div class="kt-portlet__head-label">
													<span class="kt-portlet__head-icon">
														<i class="kt-font-brand flaticon-users-1"></i>
													</span>
													<h3 class="kt-portlet__head-title">
														کاربران زیر مجموعه
													</h3>
												</div>
											</div>

                                            <div class="kt-heading kt-heading--md" style="margin-bottom: -34px !important;width: 96%;margin: 0px auto;margin-top: 10px;">
                                                <div class="alert alert-dark" role="alert" style="background: #5867dd;border: 1px solid #5867dd;">
                                                    <div class="alert-text">از طریق این بخش میتوانید اطلاعات زیر مجموعه های خودتان را مشاهده نمایید، با کلیک روی نام زیر مجموعه میتوانید به صفحه جزئیات بیشتر بروید و جزئیات بیشتری از زیر مجموعه خودتان را مشاهده نمایید.</div>
                                                </div>
                                            </div>

											<div class="kt-portlet__body">
												<!--begin: Search Form -->
												<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
													<div class="row align-items-center">
														<div class="col-xl-8 order-2 order-xl-1">
															<div class="row align-items-center">
																<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
																	<div class="kt-input-icon kt-input-icon--left">
																		<input type="text" class="form-control" placeholder="جستجو..." id="generalSearch">
																		<span class="kt-input-icon__icon kt-input-icon__icon--left">
																			<span><i class="la la-search"></i></span>
																		</span>
																	</div>
																</div>
																<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
																	<div class="kt-form__group kt-form__group--inline">
																		<div class="kt-form__label">
																			<label>وضعیت:</label>
																		</div>
																		<div class="kt-form__control">
																			<select class="form-control bootstrap-select" id="kt_form_status">
																				<option value="">همه</option>
																				<option value="1">فعال</option>
																				<option value="0">غیر فعال</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>		<!--end: Search Form -->
											</div>
											<div class="kt-portlet__body kt-portlet__body--fit">
												<!--begin: Datatable -->
												<div class="sumembtable" id="ajax_data"></div>
												<!--end: Datatable -->
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
			var KTDatatableRemoteAjaxDemo = {
				init: function () {
					var t;
					t = $(".sumembtable").KTDatatable({
						data: {
							type: "remote",
							source: {
								read: {
									url: "api/get_subs.php",
									method: "GET",
									map: function (t) {
										var e = t;
										return void 0 !== t.data && (e = t.data), e
									}
								}
							},
							pageSize: 10,
							serverPaging: !0,
							serverFiltering: !0,
							serverSorting: !0
						},
						layout: {scroll: !1, footer: !1},
						sortable: {
							page: 1
						},
						pagination: !0,
						search: {input: $("#generalSearch")},
						columns: [
							{
								field: "AgentName", title: "کاربر", width: 200, template: function (t, e) {
									return t.img ? '<div class="kt-user-card-v2">\t\t\t\t\t\t\t\t' +
                                        '<div class="kt-user-card-v2__pic">\t\t\t\t\t\t\t\t\t' +
                                        '<img src="../Attachment/img/members/' + t.img + '" alt="photo">\t\t\t\t\t\t\t\t' +
                                        '</div>\t\t\t\t\t\t\t\t' +
                                        '<div class="kt-user-card-v2__details">\t\t\t\t\t\t\t\t\t<a href="https://www.irandogebank.com/user/subincome-userinfo.php?id=' + t.id  +'" class="kt-user-card-v2__name">' + t.firstname + ' ' + t.lastname + '</a>' +
                                        '\t\t\t\t\t\t\t\t\t' +
                                        '<span class="kt-user-card-v2__desc">' + t.email + "</span>" +
                                        "\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t</div>" : '' +
                                        '<div class="kt-user-card-v2">\t\t\t\t\t\t\t\t' +
                                        '<div class="kt-user-card-v2__pic">\t\t\t\t\t\t\t\t\t' +
                                        '<div class="kt-badge kt-badge--xl kt-badge--' + ["success", "brand", "danger", "success", "warning", "primary", "info"][KTUtil.getRandomInt(0, 6)] + '">' + t.firstname.substring(0, 2) + '</div>' +
                                        '\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t' +
                                        '<div class="kt-user-card-v2__details">\t\t\t\t\t\t\t\t\t' +
                                        '<a href="https://www.irandogebank.com/user/subincome-userinfo.php?id=' + t.id  +' " class="kt-user-card-v2__name">' + t.firstname + ' ' + t.lastname + '</a>\t\t\t\t\t\t\t\t\t<span class="kt-user-card-v2__desc">' + t.email + "</span>\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t</div>"
								}
							},
							{field: "create_at", title: "تاریخ عضویت"},
							{
								field: "status", title: "وضعیت", template: function (t) {
									var e = {
										'1': {title: "فعال", class: "kt-badge--success"},
										'0': {title: "غیر فعال", class: " kt-badge--warning"}
									};
									return '<span class="kt-badge ' + e[t.status].class + ' kt-badge--inline kt-badge--pill">' + e[t.status].title + "</span>"
								}
							},
							{field: "refIncome", title: "درآمد دوج کوین"},
							{field: "dollar_refIncome", title: "درآمد دلاری"},
							//     {
							//     field: "Actions",
							//     title: "Actions",
							//     sortable: !1,
							//     width: 110,
							//     overflow: "visible",
							//     autoHide: !1,
							//     template: function () {
							//         return '\t\t\t\t\t\t<div class="dropdown">\t\t\t\t\t\t\t<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" data-toggle="dropdown">                                <i class="flaticon2-gear"></i>                            </a>\t\t\t\t\t\t  \t<div class="dropdown-menu dropdown-menu-right">\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\t\t\t\t\t\t  \t</div>\t\t\t\t\t\t</div>\t\t\t\t\t\t<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Edit details">\t\t\t\t\t\t\t<i class="flaticon2-paper"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Delete">\t\t\t\t\t\t\t<i class="flaticon2-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t'
							//     }
							// }
						]
					}), $("#kt_form_status").on("change", function () {
						t.search($(this).val().toLowerCase(), "status")
					}), $("#kt_form_type").on("change", function () {
						t.search($(this).val().toLowerCase(), "Type")
					}), $("#kt_form_status,#kt_form_type").selectpicker()
				}
			};
			jQuery(document).ready(function () {
				KTDatatableRemoteAjaxDemo.init()
			});
		</script>
		<!--end::Page Scripts -->
	</body>
	<!-- end::Body -->

</html>