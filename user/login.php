<?php 
include("../set.php");
?><!DOCTYPE html>
<html lang="fa" direction="rtl" style="direction: rtl;">
	<!-- begin::Head -->

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>ورود - <?php echo $Site_Information['title']; ?></title>
		<?php 
		include("root-head.php");
		?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WXL678V');</script>
<!-- End Google Tag Manager -->
	</head>
	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page--loading-enabled kt-page--loading kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin::Page loader -->

		<!-- end::Page Loader -->
		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
					 style="background-image: url(media/bg/bg-1.jpg);">
					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__logo">
								<a href="/">
									<img width="100px" src="/Attachment/img/settings<?php echo $Site_Information['logo']; ?>">
								</a>
							</div>
							<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">ورود به داشبورد کاربران</h3>
								</div>
								<form class="kt-form" action="#">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="ایمیل" name="email"
											   autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="رمز عبور" name="password">
									</div>
									<div class="row kt-login__extra">
										<div class="col">
											<label class="kt-checkbox">
												<input type="checkbox" name="remember"> به خاطر سپردن
												<span></span>
											</label>
										</div>
										<div class="col kt-align-right">
											<a href="javascript:;" id="kt_login_forgot" class="kt-login__link">فراموش کرده اید
												؟</a>
										</div>
									</div>
									<input type="hidden" name="action" value="login">
									<div class="kt-login__actions">
										<button id="kt_login_signin_submit"
												class="btn btn-brand btn-pill kt-login__btn-primary">ورود
										</button>
									</div>
								</form>
							</div>
							<div class="kt-login__signup" id="user-signup">
								<div class="kt-login__head">
									<h3 class="kt-login__title">ثبت نام</h3>
									<div class="kt-login__desc">اطلاعات زیر را برای ساخت حساب کاربری تکمیل کنید:</div>
								</div>
								<form class="kt-form" action="#">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="نام" name="firstname"
											   autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="text" placeholder="نام خانوادگی" name="lastname"
											   autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="text" placeholder="ایمیل" name="email"
											   autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="رمز عبور" name="password"
											   id="password">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="تایید رمز عبور"
											   name="rpassword">
									</div>
									<input class="form-control" type="hidden" name="ref"
										   id="ref">
									<input type="hidden" name="action" value="register">
									<div class="row kt-login__extra">
										<div class="col kt-align-left">
											<label class="kt-checkbox">
												<input type="checkbox" name="agree"><a href="#"
																					   class="kt-link kt-login__link kt-font-bold">
												قوانین و مقررات</a> را مطالعه کردم و قبول دارم
												<span></span>
											</label>
											<span class="form-text text-muted"></span>
										</div>
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_signup_submit"
												class="btn btn-brand btn-pill kt-login__btn-primary">ثبت نام
										</button>&nbsp;&nbsp;
										<button id="kt_login_signup_cancel"
												class="btn btn-secondary btn-pill kt-login__btn-secondary">لغو
										</button>
									</div>
								</form>
							</div>
							<div class="kt-login__forgot">
								<div class="kt-login__head">
									<h3 class="kt-login__title">فراموش کرده اید ؟</h3>
									<div class="kt-login__desc">برای تغییر رمز عبور آدرس ایمیل خود را وارد کنید:</div>
								</div>
								<form class="kt-form" action="#">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="ایمیل" name="email" id="kt_email"
											   autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_forgot_submit"
												class="btn btn-brand btn-pill kt-login__btn-primary">درخواست
										</button>&nbsp;&nbsp;
										<button id="kt_login_forgot_cancel"
												class="btn btn-secondary btn-pill kt-login__btn-secondary">لغو
										</button>
									</div>
								</form>
							</div>
							<div class="kt-login__active">
								<div class="kt-login__head">
									<h3 class="kt-login__title">تائید دو مرحله ای حساب!</h3>
									<div class="kt-login__desc">کد ارسال شده در ایمیل خود را وارد کنید</div>
								</div>
								<form class="kt-form login__active--form" action="#">
									<div class="user-box">
									</div>
									<div class="input-group">
										<input class="form-control" type="text" placeholder="کد ارسالی" name="activation_code"
											   id="activation_code"
											   autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_active_submit"
												class="btn btn-brand btn-pill kt-login__btn-primary">ثبت و ارسال
										</button>&nbsp;&nbsp;
										<button id="kt_login_active_cancel"
												class="btn btn-secondary btn-pill kt-login__btn-secondary">لغو
										</button>
									</div>
								</form>
							</div>
							<div class="kt-login__resetpass">
								<div class="kt-login__head">
									<h3 class="kt-login__title">تغییر رمز عبور!</h3>
									<div class="kt-login__desc">اعمال رمز عبور جدید برای حساب کاربری خود</div>
								</div>
								<form class="kt-form" action="#">
									<div class="input-group">
										<input class="form-control" type="password" placeholder="رمز عبور جدید" name="newpass"
											   id="newpass"
											   autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="تکرار رمز عبور جدید"
											   name="confrimnewpass" id="confrimnewpass"
											   autocomplete="off">
									</div>
                                    <div class="input-group">
										<input class="form-control" type="hidden"
											   name="verfycode" id="verfycode"
											   autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_resetpass_submit"
												class="btn btn-brand btn-pill kt-login__btn-primary">تغییر رمز عبور
										</button>&nbsp;&nbsp;
										<button id="kt_login_resetpass_cancel"
												class="btn btn-secondary btn-pill kt-login__btn-secondary">لغو
										</button>
									</div>
								</form>
							</div>
							<div class="kt-login__account">
								<span class="kt-login__account-msg">
									حساب کاربری ندارید؟
								</span>
								&nbsp;&nbsp;
								<a href="javascript:;" id="kt_login_signup"
								   class="kt-link kt-link--light kt-login__account-link">ثبت نام!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->


		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#3d94fb",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#3d94fb",
						"warning": "#ffb822",
						"danger": "#fd27eb"
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
		<script src="assets/js/pages/dashboard.js" type="text/javascript"></script>


		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/login/login-general.js" type="text/javascript"></script>
<!--		<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"-->
<!--    async defer>-->
<!--</script>-->

		<script>
			var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = window.location.search.substring(1),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
					}
				}
			};
			var action = getUrlParameter('action');
			jQuery(document).ready(function () {
				if (action === 'signup') {
					var t = $("#kt_login");
					t.removeClass("kt-login--forgot"), t.removeClass("kt-login--signin"), t.removeClass("kt-login--active"), t.removeClass("kt-login--resetpass"), t.addClass("kt-login--signup"), KTUtil.animateClass(t.find(".kt-login__signup")[0], "flipInX animated")
				} else if (action === 'resetpass') {
					var t = $("#kt_login");
					t.removeClass("kt-login--forgot"), t.removeClass("kt-login--active"), t.removeClass("kt-login--signup"), t.removeClass("kt-login--signin"), t.addClass("kt-login--resetpass"), KTUtil.animateClass(t.find(".kt-login__signup")[0], "flipInX animated")
				}

			});
		</script>

		<!--?>-->
		<!--end::Page Scripts -->
	</body>
	<!-- end::Body -->

</html>