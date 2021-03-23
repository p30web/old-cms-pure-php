<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');

$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
	$val->name('نام')->value($_POST['name'])->required();
	$val->name('نام انگلیسی')->value($_POST['en_name'])->required();
	$val->name('واحد ارزی')->value($_POST['unit_id'])->required();
	$val->name('نوع موجودی')->value($_POST['balance_type'])->required();
	$val->name('آدرس کیف پول')->value($_POST['ac_wallet'])->required();
	$val->name('مرتب سازی')->value($_POST['sort'])->required();
	$val->name('وضعیت')->value($_POST['status'])->required();

	if ($val->isSuccess()) {


		$imguploaded = 0;
		if($_FILES['logo']) {
			$imgName = 'wallet' . time();
			$handle = new upload($_FILES['logo']);
			if ($handle->uploaded) {
				$handle->file_new_name_body = $imgName;
				$handle->image_resize = false;
				$handle->image_ratio_crop = false;
				$handle->jpeg_quality = 200;
				$handle->image_ratio = false;
				$handle->dir_chmod = 0777;
				$handle->file_max_size = '5242880'; // 5mb
				$handle->allowed = array('image/*');
				$handle->image_convert = 'png';
				$handle->process('../../../Attachment/img/wallets/');
				if ($handle->processed) {
					//            $handle->clean();
					$imguploaded = 1;
					//image upload
					$handle2 = new upload($handle->file_dst_pathname);
					if ($handle2->uploaded) {
						$handle2->file_new_name_body = $imgName;
						$handle2->image_resize = true;
						$handle2->image_x = 30;
						$handle2->image_y = 30;
						$handle2->image_ratio_crop = true;
						$handle2->jpeg_quality = 200;
						$handle2->image_ratio = true;
						$handle2->dir_chmod = 0777;
						$handle2->file_max_size = '5242880'; // 5mb
						$handle2->allowed = array('image/*');
						$handle2->image_convert = 'jpg';
						$handle2->process('../../../Attachment/img/wallets/thumbs/');
						if ($handle2->processed) {
							//                    $handle2->clean();
							$imguploaded = 2;
						} else {
							echo 'error : ' . $handle2->error;
						}
					}

				} else {
					echo 'error : ' . $handle->error;
				}
			}
		}


		$logo = ($imguploaded > 0) ? $imgName . '.png' : null;

		$name = GetSQLValueString($_POST['name'], 'def');
		$en_name = GetSQLValueString($_POST['en_name'], 'def');
		$unit_id = GetSQLValueString($_POST['unit_id'], 'def');
		$description = GetSQLValueString($_POST['description'], 'def');
		$balance = GetSQLValueString($_POST['balance'], 'def');
		$sort = GetSQLValueString($_POST['sort'], 'def');
		$status = GetSQLValueString($_POST['status'], 'def');
		$balance_type = GetSQLValueString($_POST['balance_type'], 'def');


		$insert_array = array(
			"name" => $name,
			"en_name" => $en_name,
			"unit_id" => $unit_id,
			"description" => $description,
			"balance" => $balance,
			"sort	" => $sort,
			"balance_type	" => $balance_type,
			"ac_wallet	" => $ac_wallet,
			"logo" => $logo,
			"modified_at" => jdate('Y/m/d H:i:s'),
			"status" => $status,
		);
		if ($db->insert("wallets", $insert_array)) {
			header('Location: ' . $_POST['referurl'] . '?add=1');
			echo "<script>
	window.location= " . $_POST['referurl'] . "'?add=1';
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
		<title>Rahaaa | افزودن کیف پول جدید</title>
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
										افزودن کیف پول جدید </h3>

									<span class="kt-subheader__separator kt-hidden"></span>
									<div class="kt-subheader__breadcrumbs">
										<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
										<span class="kt-subheader__breadcrumbs-separator"></span>
										<a href="wallets.php" class="kt-subheader__breadcrumbs-link">
											مدیریت کیف پول </a>
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
													مشخصات کیف پول جدید
												</h3>
											</div>
										</div>
										<!--begin::Form-->
										<form class="kt-form kt-form--label-right" id="form_wallet_add" method="post"
											  action="wallet_add.php" enctype="multipart/form-data">
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
															رکورد شما با موفقیت ثبت شد.
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
													<div class="col-lg-4 form-group-sub">
														<label>نام کیف پول:</label>
														<input type="text" name="name" class="form-control"
															   placeholder="عنوان را وارد کنید">
													</div>
													<div class="col-lg-4 form-group-sub">
														<label class="">نام انگلیسی:</label>
														<input type="text" name="en_name" class="form-control"
															   placeholder="نام انگلیسی را وارد کنید">
													</div>
													<div class="col-lg-4 form-group-sub">
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
															<option value="<?php echo $row_rsunit['id']; ?>"><?php echo $row_rsunit['name_fa']; ?></option>
															<?php
																} while ($row_rsunit = mysqli_fetch_assoc($rssunit));
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-12">
														<label>توضیحات:</label>
														<div class="kt-input-icon">
															<textarea class="form-control" name="description" placeholder="توضیحات کیف پول" rows="8"></textarea>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-4 form-group-sub">
														<label>لوگو:</label>
														<div></div>
														<div class="custom-file">
															<input type="file" class="custom-file-input" id="logo" name="logo">
															<label class="custom-file-label" for="customFile">انتخاب کنید</label>
														</div>
													</div>
													<div class="col-lg-4 form-group-sub">
														<label class="">موجودی:</label>
														<input type="text" name="balance" class="form-control"
															   placeholder="موجودی را وارد کنید">
													</div>
													<div class="col-lg-4 form-group-sub">
														<label class="">آدرس کیف پول:</label>
														<input type="text" name="ac_wallet" class="form-control"
															   placeholder="آدرس کیف پول را وارد کنید">
													</div>
												</div>
												<div class="form-group form-group-last row">
													<div class="col-lg-4 form-group-sub">
														<label>نوع موجودی:</label>
														<div class="kt-radio-inline">
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="balance_type" checked value="1"> دستی
																<span></span>
															</label>
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="balance_type" value="0">اتوماتیک از Api
																<span></span>
															</label>
														</div>
													</div>
													<div class="col-lg-4 form-group-sub">
														<label>وضعیت:</label>
														<div class="kt-radio-inline">
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="status" checked value="1"> فعال
																<span></span>
															</label>
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="status" value="0"> غیر فعال
																<span></span>
															</label>
														</div>
													</div>
													<div class="col-lg-4 form-group-sub">
														<label>مرتب سازی:</label>
														<div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
															<input id="sort" type="text"
																   class="form-control bootstrap-touchspin-vertical-btn"
																   value="" name="sort" placeholder="0">
														</div>
													</div>
												</div>
											</div>
											<div class="kt-portlet__foot">
												<div class="kt-form__actions">
													<div class="row">
														<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">ثبت رکورد جدید
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

			var KTKBootstrapTouchspin = {
				init: function () {
					$("#sort").TouchSpin({
						buttondown_class: "btn btn-secondary",
						buttonup_class: "btn btn-secondary",
						verticalbuttons: !0,
						verticalup: '<i class="la la-plus"></i>',
						verticaldown: '<i class="la la-minus"></i>'
					})
				}
			};

			var KTSelect2 = {
				init: function () {
					$("#unit_id").select2({placeholder: "واحد ارزی را انتخاب کنید"})
				}
			};

			var KTFormControls = {
				init: function () {
					$("#form_wallet_add").validate({
						rules: {
							name: {required: !0},
							en_name: {required: !0},
							status: {required: !0},
							sort: {required: !0},
							balance_type: {required: !0},
							ac_wallet: {required: !0},
							unit_id: {required: !0},
							logo: {
								accept: "image/*",
							}

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
				KTKBootstrapTouchspin.init();
				KTFormControls.init();
				KTSelect2.init();

			});

		</script>
		<!--end::Global Theme Bundle -->


	</body>
	<!-- end::Body -->

</html>