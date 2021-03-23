<?php

require_once('../../checklogin.php');
require_once('../../includes/classes/Validation.php');
require_once('../../includes/classes/upload/class.upload.php');


$id = decrypt($_GET['id'], session_id() . "mem");
$id = GetSQLValueString($id, 'int');


$db->where("id", $id);
$cols = array("*");
$fetch_members = $db->getOne("`members`", $cols);
$fetch_members_count = $db->count;


$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
	$val->name('ایمیل')->value($_POST['email'])->required();
	$val->name('وضعیت')->value($_POST['status'])->required();

	if ($val->isSuccess()) {
		$imguploaded = 0;

		if ($_FILES['image']) {
			$imgName = 'avatar' . time();
			$handle = new upload($_FILES['image']);
			if ($handle->uploaded) {
				$handle->file_new_name_body = $imgName;
				$handle->image_resize = true;
				$handle->image_x = 170;
				$handle->image_y = 170;
				$handle->image_ratio_crop = true;
				$handle->jpeg_quality = 200;
				$handle->image_ratio = true;
				$handle->dir_chmod = 0777;
				$handle->file_max_size = '5242880'; // 5mb
				$handle->allowed = array('image/*');
				$handle->image_convert = 'jpg';
				$handle->process('../../../Attachment/img/members/');
				if ($handle->processed) {
					//            $handle->clean();
					$imguploaded = 1;
					//image upload
					$handle2 = new upload($handle->file_dst_pathname);
					if ($handle2->uploaded) {
						$handle2->file_new_name_body = $imgName;
						$handle2->image_resize = true;
						$handle2->image_x = 50;
						$handle2->image_y = 50;
						$handle2->image_ratio_crop = true;
						$handle2->jpeg_quality = 200;
						$handle2->image_ratio = true;
						$handle2->dir_chmod = 0777;
						$handle2->file_max_size = '5242880'; // 5mb
						$handle2->allowed = array('image/*');
						$handle2->image_convert = 'jpg';
						$handle2->process('../../../Attachment/img/members/thumbs/');
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

		$email = GetSQLValueString($_POST['email'], 'def');
		$firstname = GetSQLValueString($_POST['firstname'], 'def');
		$lastname = GetSQLValueString($_POST['lastname'], 'def');
		$cash = GetSQLValueString($_POST['cash'], 'def');
		$dollar_credit = GetSQLValueString($_POST['dollar_credit'], 'def');
		$wallet = GetSQLValueString($_POST['wallet'], 'def');
		$gender = GetSQLValueString($_POST['gender'], 'def');
		$cellphone = GetSQLValueString($_POST['cellphone'], 'def');
		$img = ($imguploaded > 0) ? $imgName . '.jpg' : $fetch_members['img'];
		$country_code = GetSQLValueString($_POST['country'], 'def');
		$state_code = GetSQLValueString($_POST['state'], 'def');
		$city_code = GetSQLValueString($_POST['city'], 'def');
		$address = GetSQLValueString($_POST['address'], 'def');
		$status = GetSQLValueString($_POST['status'], 'def');

		$db->where("id", $id);

		$insert_array = array(
			"email" => $email,
			"firstname" => $firstname,
			"lastname" => $lastname,
			"gender" => $gender,
			"cellphone" => $cellphone,
			"img" => $img,
			"cash" => $cash,
			"dollar_credit" => $dollar_credit,
			"wallet" => $wallet,
			"country_code" => $country_code,
			"state_code" => $state_code,
			"city_code" => $city_code,
			"address" => $address,
			"modified_at" => jdate('Y/m/d H:i:s'),
			"status" => $status,
		);
		//		echo '<pre>';
		//		print_r($insert_array);echo '</pre>';
		//		die;
		if ($db->update("members", $insert_array)) {

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
		<title>Rahaaa | ویرایش اعضاء</title>
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
										ویرایش اعضاء </h3>

									<span class="kt-subheader__separator kt-hidden"></span>
									<div class="kt-subheader__breadcrumbs">
										<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
										<span class="kt-subheader__breadcrumbs-separator"></span>
										<a href="members.php" class="kt-subheader__breadcrumbs-link">
											مدیریت اعضاء </a>
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
													مشخصات <?php echo $fetch_members['firstname'] . ' ' . $fetch_members['lastname']; ?>
												</h3>
											</div>
										</div>
										<!--begin::Form-->
										<form class="kt-form kt-form--label-right" id="form_mem_add" method="post"
											  action="member_edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
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
														<label>ایمیل:</label>
														<input type="text" name="email" class="form-control"
															   value="<?php echo $fetch_members['email']; ?>"
															   placeholder="ایمیل را وارد کنید">
													</div>
													<div class="col-lg-6 form-group-sub">
														<label class="">تلفن همراه:</label>
														<input type="text" name="cellphone" class="form-control"
															   value="<?php echo $fetch_members['cellphone']; ?>"
															   placeholder="تلفن همراه را وارد کنید">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-6 form-group-sub">
														<label class="">نام:</label>
														<input type="text" name="firstname" class="form-control"
															   value="<?php echo $fetch_members['firstname']; ?>"
															   placeholder="نام را وارد کنید">
													</div>
													<div class="col-lg-6 form-group-sub">
														<label>نام خانوادگی:</label>
														<input type="text" name="lastname" class="form-control"
															   value="<?php echo $fetch_members['lastname']; ?>"
															   placeholder="نام خانوادگی را وارد کنید">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-6 form-group-sub">
														<label class="">موجودی:</label>
														<input type="text" name="cash" class="form-control" value="<?php echo $fetch_members['cash']; ?>" placeholder="موجودی را وارد کنید">
													</div>
													<div class="col-lg-6 form-group-sub">
														<label>کیف پول:</label>
														<input type="text" name="wallet" class="form-control" value="<?php echo $fetch_members['wallet']; ?>" placeholder="کیف پول را وارد کنید">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-6 form-group-sub">
														<label class="">موجودی دلاری:</label>
														<input type="text" name="dollar_credit" class="form-control" value="<?php echo $fetch_members['dollar_credit']; ?>" placeholder="موجودی دلاری را وارد کنید">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-4 form-group-sub">
														<label class="">کشور:</label>
														<select class="form-control kt-select2" id="country" name="country">
															<option value="IR" <?php if ($fetch_members['country_code'] == null) echo 'selected'; ?>>
																--کشور را انتخاب کنید--
															</option>

															<?php
															mysqli_select_db($cn, $database_cn);
															$query_rscountry = sprintf("SELECT `id`,`name`,`code` FROM `country` WHERE status='1'");
															$rscountry = mysqli_query($cn, $query_rscountry) or die(mysqli_error($cn));
															$row_rscountry = mysqli_fetch_assoc($rscountry);
															$totalRows_rscountry = mysqli_num_rows($rscountry);
															if ($totalRows_rscountry > 0) {

																do {
															?>
															<option value="<?php echo $row_rscountry['code']; ?>" <?php if ($row_rscountry['code'] === $fetch_members['country_code']) echo 'selected'; ?>><?php echo $row_rscountry['name']; ?></option>
															<?php
																} while ($row_rscountry = mysqli_fetch_assoc($rscountry));
															}
															?>
														</select>
													</div>
													<div class="col-lg-4 form-group-sub">
														<label class="">استان:</label>
														<select class="form-control kt-select2" id="state" name="state">
															<option value="19" <?php if ($fetch_members['state_code'] == null) echo 'selected'; ?>>
																--استان را انتخاب کنید--
															</option>
															<?php

															mysqli_select_db($cn, $database_cn);
															$query_rsstate = sprintf("SELECT `id`,`name`,`code` FROM `state` WHERE status='1' AND `country_code` = 'IR' ");
															$rsstate = mysqli_query($cn, $query_rsstate) or die(mysqli_error($cn));
															$row_rsstate = mysqli_fetch_assoc($rsstate);
															$totalRows_rsstate = mysqli_num_rows($rsstate);
															if ($totalRows_rsstate > 0) {
																do {
															?>
															<option value="<?php echo $row_rsstate['code']; ?>" <?php if ($row_rsstate['code'] === $fetch_members['state_code']) echo 'selected'; ?>><?php echo $row_rsstate['name']; ?></option>
															<?php
																} while ($row_rsstate = mysqli_fetch_assoc($rsstate));
															}
															?>
														</select>
													</div>
													<div class="col-lg-4 form-group-sub">
														<label class="">شهر:</label>
														<select class="form-control kt-select2" id="city" name="city">
															<option value="1905" <?php if ($fetch_members['city_code'] == null) echo 'selected'; ?>>
																--شهر را انتخاب کنید--
															</option>
															<?php
															mysqli_select_db($cn, $database_cn);
															$query_rscity = sprintf("SELECT `id`,`name`,`code` FROM `city` WHERE status='1' AND `state_code`= '".$fetch_members['state_code']."' ");
															$rscity = mysqli_query($cn, $query_rscity) or die(mysqli_error($cn));
															$row_rscity = mysqli_fetch_assoc($rscity);
															$totalRows_rscity = mysqli_num_rows($rscity);
															if ($totalRows_rscity > 0) {
																do {
															?>
															<option value="<?php echo $row_rscity['code']; ?>" <?php if ($row_rscity['code'] === $fetch_members['city_code']) echo 'selected'; ?>><?php echo $row_rscity['name']; ?></option>
															<?php
																} while ($row_rscity = mysqli_fetch_assoc($rscity));
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-12">
														<label>آدرس:</label>
														<div class="kt-input-icon">
															<input class="form-control" type="text" name="address" value="<?php echo $fetch_members['address']; ?>" placeholder="آدرس را وارد کنید">
															<span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i
																																  class="la la-map-marker"></i></span></span>
														</div>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-12">
														<label>عکس:</label>
														<div class="kt-avatar kt-avatar--outline kt-avatar--circle-"
															 id="kt_apps_user_add_avatar">
															<div class="kt-avatar__holder"
																 style="background-image: url(<?php echo '../../../Attachment/img/members/' . $fetch_members['img']; ?>); background-size: cover;"></div>
															<label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
																   data-original-title="تغییر عکس">
																<i class="fa fa-pen"></i>
																<input type="file" name="image" id="image"
																	   accept=".png, .jpg, .jpeg">
															</label>
															<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
																  data-original-title="Cancel avatar">
																<i class="fa fa-times"></i>
															</span>
														</div>
													</div>
												</div>
												<div class="form-group form-group-last row">
													<div class="col-lg-4 form-group-sub">
														<label>جنسیت:</label>
														<div class="kt-radio-inline">
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="gender" <?php if ($fetch_members['gender'] === 'male') echo 'checked'; ?> value="male">
																مرد
																<span></span>
															</label>
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="gender" <?php if ($fetch_members['gender'] === 'female') echo 'checked'; ?> value="female"> زن
																<span></span>
															</label>
														</div>
													</div>
													<div class="col-lg-4 form-group-sub">
														<label>وضعیت:</label>
														<div class="kt-radio-inline">
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="status" <?php if ($fetch_members['status'] === '1') echo 'checked'; ?> value="1"> فعال
																<span></span>
															</label>
															<label class="kt-radio kt-radio--solid">
																<input type="radio" name="status" <?php if ($fetch_members['status'] === '0') echo 'checked'; ?> value="0"> غیر فعال
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
						<!-- end:: Content -->                </div>

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
		<script src="assets/js/members.js" type="text/javascript"></script>
		<script type="text/javascript">


			var KTFormControls = {
				init: function () {
					$("#form_mem_add").validate({
						rules: {
							email: {required: !0, email: !0},
							image: {
								accept: "image/*",
							}
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