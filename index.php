<?php
include("set.php");

if($_GET['referral'] != null){
	$referral = GetSQLValueString($_GET['referral'], "def");
	header("Location: user/login.php?action=signup&ref=".$referral);
}

date_default_timezone_set('Asia/Tehran');

$ip = $_SERVER["REMOTE_ADDR"];
// dailycounter
$date = jdate("Y/m/d");
if (isset($_SERVER['HTTP_REFERER'])) {
	$refer = $_SERVER['HTTP_REFERER'];
} else {
	$refer = "";
}
$date_time = jdate("Y/m/d H:i:s");
if (isset($_SESSION["name"])) {
	$type = $_SESSION["name"];
} else {
	$type = "ناشناس";
}

mysqli_select_db($cn, $database_cn);
$query_rscounter = "SELECT count(id) as countid FROM `counter` WHERE `ip`='" . $ip . "' and `date` like '" . $date . "%' ";
$rscounter = mysqli_query($cn, $query_rscounter) or die("invalid Parametr!");
$row_rscounter = mysqli_fetch_assoc($rscounter);
$row_rscounter['countid'];
if ($row_rscounter['countid'] == 0) {
	$update_quvisitcount = " , `visitcount`=visitcount+1 ";
}


$qsa = "INSERT INTO `counter`(`ip`, `refer`, `date`, `type`, `portalid`) VALUES
								('$ip','$refer','$date_time','$type','$portalid')";
mysqli_query($cn, $qsa);


mysqli_select_db($cn, $database_cn);
$query_rsdailycounter = "SELECT count(id) as countid  FROM `dailycounter` WHERE `date`='" . $date . "' ";
$rsdailycounter = mysqli_query($cn, $query_rsdailycounter) or die("invalid Parametr!");
$row_rsdailycounter = mysqli_fetch_assoc($rsdailycounter);
$totalRows_rsdailycounter = mysqli_fetch_assoc($rsdailycounter);
if ($row_rsdailycounter['countid'] > 0) {
	$update_qu = "UPDATE `dailycounter` SET `pagecount`=pagecount+1 $update_quvisitcount  WHERE `date`='" . $date . "' ";
	mysqli_query($cn, $update_qu);

} elseif ($totalRows_rsdailycounter == 0) {
	$ins_dayli = "INSERT INTO `dailycounter`(`date`, `visitcount`, `pagecount`) VALUES ('$date','1','1')";
	mysqli_query($cn, $ins_dayli);
}

mysqli_select_db($cn, $database_cn);
$query_settings = "SELECT `status` FROM `settings` WHERE `id`='0' ";
$settings = mysqli_query($cn, $query_settings) or die("invalid Parametr!");
$row_settings = mysqli_fetch_assoc($settings);
if($row_settings['status'] == 0){
	header('Location: access_denied.php');
	echo "<script> window.location= 'access_denied.php' </script>";
	exit;
	die;
}
?>
<!doctype html>
<html lang="fa">


	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
		<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WXL678V');</script>
<!-- End Google Tag Manager -->

		<title>صفحه اصلی - <?php echo $Site_Information['title']; ?></title>

		<?php include("seo.php"); ?>


	</head>

	<body class="version-drak">
	    


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WXL678V"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


		<!--Start Preloader-->
		<div class="preloader">
			<div class="d-table">
				<div class="d-table-cell align-middle">
					<div class="spinner">
						<div class="double-bounce1"></div>
						<div class="double-bounce2"></div>
					</div>
				</div>
			</div>
		</div>
		<!--End Preloader-->
		<!--start header-->
		<header id="header">
			<div class="container">
				<nav class="navbar navbar-expand-lg">
					<div class="container">
						<!-- Logo -->
						<a class="logo" href="index.php">
							<img style="width: 100px;" src="Attachment/img/settings<?php echo $Site_Information['logo']; ?>" alt="<?php echo $Site_Information['site_name']; ?>"></a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
								aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="icon-bar"><i class="icofont-navigation-menu"></i></span>
						</button>
						<!-- navbar links -->
						<div class="collapse navbar-collapse" id="navbarContent">
							<ul class="navbar-nav ml-auto">
								<li class="nav-item">
									<a class="nav-link active" href="#" data-scroll-nav="0">خانه</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#" data-scroll-nav="1">معرفی سامانه</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="pages.php?page=privacy_policy">قوانین و مقررات</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#" data-scroll-nav="3">پلن های سرمایه گذاری</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#" data-scroll-nav="6">سوالات متداول</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#" data-scroll-nav="7">تماس با ما</a>
								</li>
								<li class="nav-item download-btn">
									<a class="nav-link" href="user/login.php">ورود | ثبت نام</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</header>
		<!--end header-->

		<?php
		mysqli_select_db($cn, $database_cn);
		$query_social_sccounts = sprintf("SELECT * FROM `social_sccounts` WHERE status='1' AND `show_for`= 0 ORDER BY sort ASC");
		$rssocial_sccounts = mysqli_query($cn, $query_social_sccounts) or die(mysqli_error($cn));
		$row_social_sccounts = mysqli_fetch_assoc($rssocial_sccounts);
		$totalRows_social_sccountsh = mysqli_num_rows($rssocial_sccounts);

		if ($totalRows_social_sccountsh > 0) {
		?>

		<!--start social-->
		<nav class="social">
			<ul>
				<?php
			do {
				?>
				<li><a href="<?php echo $row_social_sccounts['link']; ?>"
					   target="_blank"><?php echo $row_social_sccounts['name']; ?>
					<i class="<?php echo $row_social_sccounts['icon']; ?>"></i></a></li>
				<?php
			} while ($row_social_sccounts = mysqli_fetch_assoc($rssocial_sccounts));
				?>
			</ul>
		</nav>
		<?php
		}
		?>
		<!--end social-->
		<!--start home area-->
		<section id="home-area" class="bg-1" data-scroll-index="0">
			<div class="home-bg-circle">
				<img class="circle1" src="assets/images/asset-4.png" alt="">
				<img class="circle2" src="assets/images/asset-5.png" alt="">
			</div>
			<div class="container">
				<div class="row" dir="rtl">
					<!--start caption-->
					<?php
					mysqli_select_db($cn, $database_cn);
					$query_rsslidesh = sprintf("SELECT * FROM slideshow WHERE status='1' and category='001' $condition_portal ORDER BY sort ASC LIMIT 0,1");
					$rsslidesh = mysqli_query($cn, $query_rsslidesh) or die(mysqli_error($cn));
					$row_rsslidesh = mysqli_fetch_assoc($rsslidesh);
					$totalRows_rsslidesh = mysqli_num_rows($rsslidesh);

					mysqli_select_db($cn, $database_cn);
					$query_rsslidecat = sprintf("SELECT style FROM slideshowcat WHERE status='1' and code='001' and `showinhome` = '1' ");
					$rsslidecat = mysqli_query($cn, $query_rsslidecat) or die(mysqli_error($cn));
					$row_rsslidecat = mysqli_fetch_assoc($rsslidecat);
					$totalRows_rsslidecat = mysqli_num_rows($rsslidecat);

					if ($totalRows_rsslidesh > 0) {
					?>
					<div class="col-lg-8">
						<div class="caption d-table">
							<div class="d-table-cell align-middle">
								<h1 class="text-white"><?php echo $row_rsslidesh['title']; ?></h1>
								<h4 class="text-light">
									<?php
						$dscrptn = str_replace('<p>', "", $row_rsslidesh['description']);
						$dscrptn = str_replace('</p>', "", $dscrptn);
						echo $dscrptn;
									?></h4>
								<div class="caption-btns">
									<a class="bg" href="user/login.php?action=signup">ثبت نام کنید و در آمد کسب کنید</a>
									<a
									   class="popup-video"
									   href="uploads/videos/irdbank.mp4"><i
																			class="icofont-ui-play"></i> پخش ویدئو</a>  
								</div>

							</div>
						</div>
					</div>
					<?php
					}
					?>
					<!--end caption-->
				</div>
			</div>
		</section>
		<!--start home area-->
		<!--start core feature area-->
		<section id="core-feature-area" class="bg-2" data-scroll-index="1">
			<div class="core-feature-circle">
				<img class="circle1" src="assets/images/asset-2.png" alt="">
				<img class="circle2" src="assets/images/asset-2.png" alt="">
				<img class="circle3" src="assets/images/asset-2.png" alt="">
			</div>
			<div class="container" dir="rtl">
				<?php
				mysqli_select_db($cn, $database_cn);
				$query_pages = sprintf("SELECT * FROM pages WHERE code= 'about_us' and status='1' ");
				$pages = mysqli_query($cn, $query_pages) or die(mysqli_error($cn));
				$row_pages = mysqli_fetch_assoc($pages);
				$totalRows_pages = mysqli_num_rows($pages);
				if ($totalRows_pages > 0) {

				?>
				<div class="row">
					<!--start section heading-->
					<div class="col-md-10 offset-md-1">
						<div class="section-heading text-center">
							<h5><?php echo $row_pages['title'] ?></h5>
							<?php echo $row_pages['index_text'] ?>
						</div>
					</div>
					<!--end section heading-->
				</div>
				<div class="row">
					<!--start core feature single-->
					<div class="col-lg-3 col-md-6">
						<div class="core-feature-single">
							<div class="core-feature-single-item text-center">
								<div class="icon">
									<i class="icon-gear"></i>
								</div>
								<h3>ثبت نام سریع</h3>
								<p>ثبت نام در سامانه بسیار سریع صورت میگیرد و فرایند کلی ثبت نام کاربران در سایت شاید کمتر
									از 1
									دقیقه باشد.</p>
							</div>
							<img class="hover-shape-1 hover-shape" src="assets/images/shape-one.svg" alt="Shape One">
							<img class="hover-shape-2 hover-shape" src="assets/images/shape-two.svg" alt="Shape Two">
							<img class="hover-shape-3 hover-shape" src="assets/images/shape-three.svg" alt="Shape Three">
							<img class="hover-shape-4 hover-shape" src="assets/images/shape-four.svg" alt="Shape Four">
							<img class="hover-shape-5 hover-shape" src="assets/images/shape-five.svg" alt="Shape Five">
						</div>
					</div>
					<!--end core feature single-->
					<!--start core feature single-->
					<div class="col-lg-3 col-md-6">
						<div class="core-feature-single">
							<div class="core-feature-single-item two text-center">
								<div class="icon">
									<i class="icon-web-design"></i>
								</div>
								<h3>ساده و روان</h3>
								<p>تمام بخش ها و خدمات ما ساده و بروز طراحی شده تا برای تمامی کاربران قابل اسنفاده باشد.</p>
							</div>
							<img class="hover-shape-1 hover-shape" src="assets/images/shape-one.svg" alt="Shape One">
							<img class="hover-shape-2 hover-shape" src="assets/images/shape-two.svg" alt="Shape Two">
							<img class="hover-shape-3 hover-shape" src="assets/images/shape-three.svg" alt="Shape Three">
							<img class="hover-shape-4 hover-shape" src="assets/images/shape-four.svg" alt="Shape Four">
							<img class="hover-shape-5 hover-shape" src="assets/images/shape-five.svg" alt="Shape Five">
						</div>
					</div>
					<!--end core feature single-->
					<!--start core feature single-->
					<div class="col-lg-3 col-md-6">
						<div class="core-feature-single">
							<div class="core-feature-single-item three text-center">
								<div class="icon three">
									<i class="icon-report"></i>
								</div>
								<h3>بهینه شده</h3>
								<p>سرویس های ما به صورت کاملا بهینه در اختیار کاربران قرار داده شده تا بهترین راندمان را
									بهره
									ببرند.</p>
							</div>
							<img class="hover-shape-1 hover-shape" src="assets/images/shape-one.svg" alt="Shape One">
							<img class="hover-shape-2 hover-shape" src="assets/images/shape-two.svg" alt="Shape Two">
							<img class="hover-shape-3 hover-shape" src="assets/images/shape-three.svg" alt="Shape Three">
							<img class="hover-shape-4 hover-shape" src="assets/images/shape-four.svg" alt="Shape Four">
							<img class="hover-shape-5 hover-shape" src="assets/images/shape-five.svg" alt="Shape Five">
						</div>
					</div>
					<!--end core feature single-->
					<!--start core feature single-->
					<div class="col-lg-3 col-md-6">
						<div class="core-feature-single">
							<div class="core-feature-single-item four text-center">
								<div class="icon four">
									<i class="icon-list"></i>
								</div>
								<h3>امنیت داده</h3>
								<p>با بهره بردن از تکنولوژی ها و سیستم های مدرن و تیم پشتبانی فنی داده های شما را تضمین
									میکنیم.</p>
							</div>
							<img class="hover-shape-1 hover-shape" src="assets/images/shape-one.svg" alt="Shape One">
							<img class="hover-shape-2 hover-shape" src="assets/images/shape-two.svg" alt="Shape Two">
							<img class="hover-shape-3 hover-shape" src="assets/images/shape-three.svg" alt="Shape Three">
							<img class="hover-shape-4 hover-shape" src="assets/images/shape-four.svg" alt="Shape Four">
							<img class="hover-shape-5 hover-shape" src="assets/images/shape-five.svg" alt="Shape Five">
						</div>
					</div>
					<!--end core feature single-->
				</div>
				<div class="row">
					<!--start read more button-->
					<div class="col-lg-12">
						<div class="load-more-btn text-center">
							<!--		<a href="pages.php?page=about_us">مطالعه بیشتر</a>-->
						</div>
					</div>
					<!--end read more button-->
				</div>
				<?php
				}
				?>
			</div>
		</section>
		<!--end core feature area-->
		<!--start pricing area-->
		<?php
		mysqli_select_db($cn, $database_cn);
		$query_investment_plan = sprintf("SELECT * FROM investment_plan WHERE status='1' ORDER BY id ASC");
		$investment_plan = mysqli_query($cn, $query_investment_plan) or die(mysqli_error($cn));
		$row_investment_plan = mysqli_fetch_assoc($investment_plan);
		$totalRows_investment_plan = mysqli_num_rows($investment_plan);


		?>
		<section id="pricing-area" class="bg-1 mt-5" data-scroll-index="3">
			<div class="container" dir="rtl">
				<div class="row">
					<!--start section heading-->
					<div class="col-lg-12">
						<div class="section-heading text-center">
							<h2 class="text-white">پلن های سرمایه گذاری</h2>
						</div>
					</div>
					<!--end section heading-->
				</div>
				<div class="row">
					<?php
					if ($totalRows_investment_plan > 0) {
						$i = 0;
						do {
					?>
					<div class="col-lg-3 col-md-4 mb-2">
						<div class="price-tbl-single v-dark highlighted">
							<div class="price-media">
								<img src="<?php
							if ($row_investment_plan['image']) {
								echo 'Attachment/img/invetplan/' . $row_investment_plan['image'];
							} else {
								echo 'Attachment/img/default.png';
							}
										  ?>" class="img-fluid" alt="">
							</div>
							<div class="table-inner text-center">
								<h4><?php echo $row_investment_plan['title']; ?></h4>
								<div class="price">
									<div class="price-bg"></div>
									<h2 class="text-white"><sup>Ð</sup><?php echo $row_investment_plan['price']; ?></h2>
								</div>
								<ul>
									<li><span>درصد سود:</span><strong><?php echo $row_investment_plan['interest_rate']; ?>
										%</strong></li>
									<li><span>سود در هر روز:</span><strong>
										<?php
							$d = $row_investment_plan['price'] * ($row_investment_plan['interest_rate'] / 100);
							if ($row_investment_plan['period_type'] === "month") {
								echo number_format((float)$d / 30, 2, '.', '');
							} else if ($row_investment_plan['period_type'] === "day") {
								echo number_format((float)$d, 2, '.', '');
							}
										?> Ð
										</strong></li>
									<li><span>سود در هر ماه:</span><strong>
										<?php
							$d = $row_investment_plan['price'] * ($row_investment_plan['interest_rate'] / 100);
							if ($row_investment_plan['period_type'] === "month") {
								echo $d;
							}
										?> Ð
										</strong></li>
									<li><span>دوره زمانی:</span><strong> <?php
							if ($row_investment_plan['period_type'] === "month") {
								echo $row_investment_plan['period'] . ' ماه';
							} else if ($row_investment_plan['period_type'] === "day") {
								echo $row_investment_plan['period'] . ' روز';
							}
										?>
										</strong></li>
								</ul>
								<a href="user/login.php">سفارش پلن</a>
							</div>
						</div>
					</div>

					<?php
							$i++;
						} while ($row_investment_plan = mysqli_fetch_assoc($investment_plan));
					?>

				</div>
			</div>
			</div>
		</section>
	<!--end pricing area-->
	<?php

					}
	?>
	<!--end custom plan area-->

	<section id="core-feature-area" class="bg-2 mt-5" data-scroll-index="1">
		<div class="core-feature-circle">
			<img class="circle1" src="assets/images/asset-2.png" alt="">
			<img class="circle2" src="assets/images/asset-2.png" alt="">
			<img class="circle3" src="assets/images/asset-2.png" alt="">
		</div>
		<div class="video-cont d-table text-center">
			<div class="d-table-cell align-middle">
				<div class="video-overlay"></div>
				<a class="popup-video" href="uploads/videos/irdbank.mp4"><i class="icofont-ui-play"></i></a>   

			</div>
		</div>
		<div class="container mb-30" dir="rtl">
			<div class="row">
				<div class="col-md-6">

					<div class="video title">
						<h2 class="text-white">اموزش ویدئویی </h2>
						<p class="text-light">کاربران گرامی ایران دوج، <br>برای آموزش نحوه استفاده از سامانه ایران دوج و
							همچنین آگاهی بیشتر در ارتباط با ویژگی های سامانه ما میتوانید ویدئو تهیه شده زیر را مشاهده کنید.
						</p>
					</div>

				</div>
			</div>
		</div>
	</section>

	<!--start video area-->
	<section id="video-area" class="bg-1" data-scroll-index="2">
		<div class="video-area-circle">
			<img class="circle1" src="assets/images/asset-4.png" alt="">
			<img class="circle2" src="assets/images/asset-4.png" alt="">
			<img class="circle3" src="assets/images/asset-4.png" alt="">
		</div>
		<div class="container" dir="rtl">
			<div class="row">
				<div class="col-lg-6 col-md-8">
					<div class="counter title">
						<h2 class="text-white">آمار</h2>
						<p> آمار های ایران دوج به صورت لحظه ای از پلن های موجود و وضعیت آن ها برای شما مخابره میشوند.
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<!--start counter single-->
				<div class="col-md-4 col-6">
					<div class="counter-single">
						<div class="icon">
							<img src="assets/images/icon/team.png" class="img-fluid" alt="">
						</div>
						<?php
						mysqli_select_db($cn, $database_cn);
						$query_investment_plan1 = sprintf("SELECT `id` FROM `members`");
						$investment_plan1 = mysqli_query($cn, $query_investment_plan1) or die(mysqli_error($cn));
						$totalRows_investment_plan1 = mysqli_num_rows($investment_plan1);


						?>
						<h2><?php echo $totalRows_investment_plan1; ?></h2>
						<p>تعداد کاربران</p>
					</div>
				</div>
				<!--end counter single-->
				<!--start counter single-->
				<div class="col-md-4 col-6">
					<div class="counter-single">
						<div class="icon">
							<img src="assets/images/icon/banknotes.png" class="img-fluid" alt="">
						</div>
						<?php
						mysqli_select_db($cn, $database_cn);
						$query_investment_plan3 = sprintf("SELECT `id`,`amount` FROM `block_transaction`");
						$investment_plan3 = mysqli_query($cn, $query_investment_plan3) or die(mysqli_error($cn));
						$totalRows_investment_plan3 = mysqli_num_rows($investment_plan3);
						if($totalRows_investment_plan3 > 0){

							$cashout2 = 0;
							while($row_investment_plan3 = mysqli_fetch_assoc($investment_plan3)){
								$cashout2 = $cashout2 + $row_investment_plan3['amount'];
							}
						}else{
							$cashout2 = 0;
						}

						?>
						<h2><?php echo number_format($cashout2+100000); ?></h2>
						<p>سپرده Ð</p>
					</div>
				</div>
				<!--end counter single-->
				<!--start counter single-->
				<div class="col-md-4 col-6">
					<div class="counter-single">
						<div class="icon">
							<img src="assets/images/icon/withdraw.png" class="img-fluid" alt="">
						</div>
						<?php
						mysqli_select_db($cn, $database_cn);
						$query_investment_plan2 = sprintf("SELECT `id`,`amount` FROM `withdraw`");
						$investment_plan2 = mysqli_query($cn, $query_investment_plan2) or die(mysqli_error($cn));
						$totalRows_investment_plan2 = mysqli_num_rows($investment_plan2);
						if($totalRows_investment_plan2 > 0){

							$cashout = 0;
							while($row_investment_plan2 = mysqli_fetch_assoc($investment_plan2)){
								$cashout = $cashout + $row_investment_plan2['amount'];
							}
						}else{
							$cashout = 0;
						}



						?>
						<h2><?php echo number_format($cashout); ?></h2>
						<p>برداشت Ð</p>
					</div>
				</div>
				<!--end counter single-->

			</div>
		</div>
	</section>
	<!--end video area-->

	<!--start how work area-->
	<section id="how-work-area" class="bg-2">
		<div class="container" dir="rtl">
			<div class="row">
				<!--start section heading-->
				<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
					<div class="section-heading text-center">
						<h5>گردش کاری</h5>
						<h2 class="text-white">نگاهی به گردش کاری</h2>
						<p class="text-light">در این قسمت خلاصه ای از قسمت های اصلی گردش سامانه ایران دوج را برای شما اماده
							کرده ایم.</p>
					</div>
				</div>
				<!--end section heading-->
			</div>
			<div class="row how-work-wrap">
				<div class="how-work-bg"></div>
				<!--start how work single-->
				<div class="col-lg-offset-1 col-lg-3 col-md-4">
					<div class="how-work-single dark">
						<div class="icon">
							<i class="icofont-user-alt-3"></i>
							<div class="number">01</div>
						</div>
						<h3 class="text-white">ثبت نام</h3>
						<p class="text-light">کاربران میتوانند با ثبت نام در کوتاه ترین زمان عضویت خود را در سامانه فعال
							کنند</p>
					</div>
				</div>
				<!--end how work single-->
				<!--start how work single-->
				<div class="col-lg-3 col-md-4">
					<div class="how-work-single dark two">
						<div class="icon">
							<i class="icofont-check-circled"></i>
							<div class="number">02</div>
						</div>
						<h3 class="text-white">فعال سازی پلن</h3>
						<p class="text-light">پلن سرمایه گذاری مورد نظر خود را انتخاب و پس از پرداخت هزینه آن پلن خود را
							فعال کنید</p>
					</div>
				</div>
				<!--end how work single-->
				<!--start how work single-->

				<div class="col-lg-3 col-md-4">
					<div class="how-work-single dark three">
						<div class="icon">
							<i class="icofont-money"></i>
							<div class="number">03</div>
						</div>
						<h3 class="text-white">کسب درآمد</h3>
						<p class="text-light">و در نهایت شما میتوانید درآمد لحظه ای خود را از پلن فعال شده مشاهده و ماهانه
							سود خود را دریافت کنید.</p>
					</div>
				</div>
				<!--end how work single-->

			</div>
		</div>
	</section>
	<!--end how work area-->
	<!--start newsletter area-->

	<section id="newsletter-area" class="bg-1">
		<div class="container" dir="rtl">
			<div class="row">
				<!--start section heading-->

				<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
					<div class="section-heading text-center">
						<h5>اولین نفر باشید که آگاه می شوید</h5>
						<h2 class="text-white">درباره ویژگی های جدید</h2>
						<p class="text-light">اگر می خواهید به روزرسانی های ماهانه را از ما دریافت کنید ، ایمیل خود را در
							ثبت کنید.</p>
					</div>
				</div>
				<!--end section heading-->

			</div>
			<div class="row">
				<!--start newsletter form-->

				<div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
					<div class="newsletter-form">
						<form id="mc-newsletter" action="api/newsletter.php" method="post">
							<div class="newsletter-input-bx">
								<input type="email" class="form-control" id="mc-email" name="mc-email"
									   placeholder="ایمیل خود را وارد کنید" required>
								<button type="submit">اشتراک در ایران دوج</button>
							</div>
						</form>
						<div id="response"></div>
					</div>
				</div>
				<!--end newsletter form-->

			</div>
		</div>
	</section>


	<!--end newsletter area-->
	<?php
	mysqli_select_db($cn, $database_cn);
	$query_post_category = sprintf("SELECT * FROM `post_category` WHERE status='1' and `code`='01' ");
	$post_category = mysqli_query($cn, $query_post_category) or die(mysqli_error($cn));
	$row_post_category = mysqli_fetch_assoc($post_category);
	$totalRows_post_category = mysqli_num_rows($post_category);
	if ($totalRows_post_category > 0) {

		$bi = 0;
	?>
	<!--blog area-->
	<section id="screenshot-area" class="bg-1" data-scroll-index="2">
		<div class="screenshot-area-img d-flex justify-content-end">
			<img src="assets/images/screen-bg-3.png" alt="">
		</div>
		<div class="container" dir="rtl">
			<div class="row">
				<!--start section heading-->
				<div class="col-md-8 offset-md-2">
					<div class="section-heading text-center">
						<h5>وبلاگ</h5>
						<h2 class="text-white">آخرین مطالب</h2>
						<p class="text-light">آخربن مطالب و اخبار زمینه ارز های دیجیتال ، ماینینگ و...</p>
					</div>
				</div>
				<!--end section heading-->
			</div>
			<div class="row">
				<?php
		mysqli_select_db($cn, $database_cn);
		$query_posts = sprintf("SELECT * FROM `posts` WHERE status='1' and `category`='01' LIMIT 0,3 ");
		$posts = mysqli_query($cn, $query_posts) or die(mysqli_error($cn));
		$row_posts = mysqli_fetch_assoc($posts);
		$totalRows_posts = mysqli_num_rows($posts);
		if ($totalRows_posts > 0) {

			$bi = 0;
			do {
				?>
				<div class="col-lg-4 col-md-6">
					<div class="blog-single">
						<div class="post-media">
							<div class="date"><?php echo substr($row_posts['modified_at'], 8, 2); ?>
								<span><?php echo monthname(substr($row_posts['modified_at'], 5, 2)); ?></span>
							</div>
							<a href="#"><img src="<?php
				if ($row_posts['image']) {
					echo 'Attachment/img/posts/' . $row_posts['image'];
				} else {
					echo 'Attachment/img/default.png';
				}
								?>" class="img-fluid" alt="<?php echo $row_posts['imagealt']; ?>"></a>
						</div>
						<div class="post-cont">
							<h3><a href="blog_single.php?post=<?php echo $row_posts['id']; ?>"><?php echo $row_posts['title']; ?></a></h3>

							<?php echo $row_posts['mintext']; ?>
						</div>
						<div class="post-btn text-center">
							<a href="blog_single.php?post=<?php echo $row_posts['id']; ?>">مطالعه بیشتر</a>
						</div>
					</div>
				</div>
				<?php
				$bi++;
			} while ($row_posts = mysqli_fetch_assoc($posts));
		}
				?>
			</div>
			<div class="row">
				<!--start read more button-->
				<div class="col-lg-12">
					<div class="load-more-btn text-center">
						<a href="blog.php">وبلاگ</a>
					</div>
				</div>
				<!--end read more button-->
			</div>
		</div>
	</section>
	<?php
	}
	?>
	<!--end blog area-->
	<?php
	mysqli_select_db($cn, $database_cn);
	$query_message = sprintf("SELECT * FROM `message` WHERE status='1' and portalid = 0 order by `created_at` DESC LIMIT 0, 7");
	$message = mysqli_query($cn, $query_message) or die(mysqli_error($cn));
	$row_message = mysqli_fetch_assoc($message);
	$totalRows_message = mysqli_num_rows($message);
	if ($totalRows_message > 0) {

		$mi = 0;
	?>
	<!--start testimonial area-->
	<section id="testimonial-area">
		<div class="container" dir="rtl">
			<div class="row">
				<!--start section heading-->
				<div class="col-md-8 offset-md-2">
					<div class="section-heading text-center">
						<h5>اعتماد و لطف مشتریانمان</h5>
						<h2 class="text-white">بخشی از نظرات و پبام های شما</h2>
						<p class="text-light">پیام های شما ما را سخت کوش تر و به تلاش بیشتر برای جلب رضایت شما سوق
							میدهد.</p>
					</div>
				</div>
				<!--end section heading-->
			</div>
			<div class="testi-wrap">
				<?php
		do {
				?>
				<!--start testimonial single-->
				<div class="client-single <?php if ($mi === 0) echo 'active'; else echo 'inactive'; ?> position-<?php echo $mi + 1; ?>"
					 data-position="position-<?php echo $mi + 1; ?>">
					<div class="client-img">
						<img src="assets/images/def-avatar.png" alt="">
					</div>
					<div class="client-comment">
						<h3 class="text-white"><?php echo $row_message['text']; ?></h3>
						<span><i class="icofont-quote-left"></i></span>
					</div>
					<div class="client-info">
						<h3 class="text-white"><?php echo $row_message['sender']; ?></h3>
						<p><?php echo $row_message['title']; ?></p>
					</div>
				</div>
				<!--end testimonial single-->
				<?php
			$mi++;
		} while ($row_message = mysqli_fetch_assoc($message));
				?>
			</div>
		</div>
	</section>
	<!--end testimonial area-->
	<?php
	}
	?>
	<!--start faq area-->
	<?php
	mysqli_select_db($cn, $database_cn);
	$query_faqcat = sprintf("SELECT * FROM `faqcat` WHERE status='1' and `code`= '1'");
	$faqcat = mysqli_query($cn, $query_faqcat) or die(mysqli_error($cn));
	$row_faqcat = mysqli_fetch_assoc($faqcat);
	$totalRows_faqcat = mysqli_num_rows($faqcat);
	if ($totalRows_faqcat > 0) {
	?>

	<section id="faq-area" class="bg bg-2" data-scroll-index="6">
		<div class="faq-area-img">
			<img src="assets/images/faq-bg-1.png" class="img-fluid" alt="">
		</div>
		<div class="container" dir="rtl">
			<div class="row">
				<!--start section heading-->
				<div class="col-md-8 offset-md-2">
					<div class="section-heading text-center">
						<h5>نگاهی بیندازید</h5>
						<h2 class="text-white"><?php echo $row_faqcat['name']; ?></h2>
						<p class="text-light"><?php echo $row_faqcat['description']; ?></p>
					</div>
				</div>
				<!--end section heading-->
			</div>
			<div class="row">
				<div class="col-md-7">
					<div id="accordion" role="tablist">

						<?php


		mysqli_select_db($cn, $database_cn);
		$query_faq = sprintf("SELECT * FROM `faq` WHERE status='1' and `category`= '1' LIMIT 0, 10");
		$faq = mysqli_query($cn, $query_faq) or die(mysqli_error($cn));
		$row_faq = mysqli_fetch_assoc($faq);
		$totalRows_faq = mysqli_num_rows($faq);
		if ($totalRows_faq > 0) {
			$fi = 0;
			do {
						?>
						<!--start faq single-->
						<div class="card v-dark">
							<div class="card-header <?php if ($fi === 0) echo 'active'; ?>" role="tab"
								 id="faq<?php echo $row_faq['id']; ?>">
								<h5 class="mb-0">
									<a data-toggle="collapse" href="#collapse<?php echo $row_faq['id']; ?>"
									   aria-expanded="true"
									   aria-controls="collapse<?php echo $row_faq['id']; ?>"><?php echo $row_faq['title']; ?></a>
								</h5>
							</div>
							<div id="collapse<?php echo $row_faq['id']; ?>"
								 class="collapse <?php if ($fi === 0) echo 'show'; ?>"
								 role="tabpanel" aria-labelledby="faq<?php echo $row_faq['id']; ?>"
								 data-parent="#accordion">
								<div class="card-body">
									<?php echo $row_faq['description']; ?>
								</div>
							</div>
						</div>
						<!--end faq single-->
						<?php
				$fi++;
			} while ($row_faq = mysqli_fetch_assoc($faq));
		}
						?>
					</div>
				</div>
				<div class="col-md-5">
					<div class="faq-img">
						<img src="assets/images/faq-img-1.png" class="img-fluid" alt="">
						<img src="assets/images/faq-img-2.png" class="img-icon" alt="">
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	}
	?>
	<!--end faq area-->
	<!--start contact area-->
	<section id="contact-area" class="bg-1" data-scroll-index="7">
		<div class="contact-area-circle">
			<img class="circle1" src="assets/images/asset-2.png" alt="">
		</div>
		<div class="container" dir="rtl">
			<div class="row">
				<!--start section heading-->
				<div class="col-lg-5 col-md-8">
					<div class="section-heading">
						<h5>تماس با ما</h5>
						<h2 class="text-white">با ما در تماس باشید</h2>
						<p class="text-light">اگر سؤالی دارید ، فقط فرم تماس را پر کنید ، و ما به زودی به شما پاسخ خواهیم
							داد.</p>
					</div>
				</div>
				<!--end section heading-->
			</div>
			<div class="row">
				<!--start contact form-->
				<div class="col-lg-5 col-md-7">
					<div class="contact-form v-dark">
						<form id="ajax-contact" action="api/contact.php" method="post">
							<div class="form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="نام*"
									   required="required" data-error="نام اجباری است.">
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="ایمیل*"
									   required="required" data-error="ایمیل اجباری است."">
																						  <div class="help-block with-errors"></div>
																															 </div>
																															 <div class="form-group">
																																					<input type="text" class="form-control" id="mobile" name="mobile" placeholder="موبایل*"
                                   required="required" data-error="موبایل اجباری است."">
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="subject" name="subject" placeholder="عنوان*"
									   required="required" data-error="عنوان اجباری است."">
																						  <div class="help-block with-errors"></div>
																															 </div>
																															 <div class="form-group">
																																					<textarea class="form-control" id="message" name="message" rows="10" placeholder="متن پیام*"
                                      required="required" data-error="متن پیام اجباری است.""></textarea>
							<div class="help-block with-errors"></div>
							</div>
						<button type="submit">ارسال</button>
						<div class="messages"></div>
						</form>
				</div>
			</div>
			<!--end contact form-->
		</div>
		</div>
	</section>
<!--end contact area-->
<!--start footer-->
<footer id="footer" class="bg-1">
	<div class="container" dir="rtl">
		<div class="get-started">
			<div class="row">
				<div class="col-lg-6 col-md-8">
					<h2>برای کسب در آمد آماده ای؟</h2>
					<p class="text-light">با خیالی آسوده و به صورت دوره از طریق سرمایه گذاری کسب درآمد کنید.</p>
				</div>
				<div class="col-lg-6 col-md-4">
					<a href="user/login.php?action=signup">ساخت حساب کاربری</a>
				</div>
			</div>
		</div>
		<div class="footer-cont">
			<div class="row">
				<!--start footer widget single-->
				<div class="col-lg-3 col-md-6">
					<div class="footer-widget">
						<h3><?php echo $Site_Information['site_name']; ?></h3>
						<ul>
							<li><a href="#" data-scroll-nav="0"><i class="icofont-long-arrow-left"></i>خانه</a></li>
							<li><a href="#" data-scroll-nav="1"><i class="icofont-long-arrow-left"></i>معرفی سامانه</a>
							</li>
							<li><a href="pages.php?page=privacy_policy"><i class="icofont-long-arrow-left"></i>قوانین و
								مقررات</a></li>
							<li><a href="#" data-scroll-nav="3"><i class="icofont-long-arrow-left"></i>پلن های سرمایه
								گذاری</a></li>
							<li><a href="#" data-scroll-nav="7"><i class="icofont-long-arrow-left"></i>تماس باما</a>
							</li>
							<li><a href="blog.php"><i class="icofont-long-arrow-left"></i>وبلاگ</a></li>
						</ul>
					</div>
				</div>
				<!--end footer widget single-->
				<!--start footer widget single-->
				<div class="col-lg-3 col-md-6">
					<div class="footer-widget contactinfo">
						<h3><?php echo $Site_Information['site_name']; ?></h3>
						<ul>
							<?php
							if ($Site_Information['tel'] != null) {
								echo ' <li><a href="#"><i class="icofont-telephone"></i>' . $Site_Information['tel'] . '</a></li>';
							}
							if ($Site_Information['fax'] != null) {
								echo ' <li><a href="#"><i class="icofont-fax"></i>' . $Site_Information['fax'] . '</a></li>';
							}
							if ($Site_Information['email'] != null) {
								echo ' <li><a href="#"><i class="icofont-email"></i>' . $Site_Information['email'] . '</a></li>';
							}

							mysqli_select_db($cn, $database_cn);
							$query_social_sccounts = sprintf("SELECT * FROM `social_sccounts` WHERE status='1' AND `show_for`= 0 ORDER BY sort ASC");
							$rssocial_sccounts = mysqli_query($cn, $query_social_sccounts) or die(mysqli_error($cn));
							$row_social_sccounts = mysqli_fetch_assoc($rssocial_sccounts);
							$totalRows_social_sccountsh = mysqli_num_rows($rssocial_sccounts);

							if ($totalRows_social_sccountsh > 0) {
							?>

							<?php
								do {
							?>
							<li><a href="<?php echo $row_social_sccounts['link']; ?>"
								   target="_blank"><i class="<?php echo $row_social_sccounts['icon']; ?>"></i><?php echo $row_social_sccounts['name']; ?></a></li>
							<?php
								} while ($row_social_sccounts = mysqli_fetch_assoc($rssocial_sccounts));
							?>

							<?php
							}
							?>
						</ul>
					</div>
				</div>
				<!--end footer widget single-->

			</div>
		</div>
		<div class="footer-copyright">
			<div class="row">
				<div class="col-lg-6 col-md-7">
					<p><?php echo $Site_Information['copyright'] ?></p>
				</div>
			</div>
		</div>
	</div>
</footer>
<!--end footer-->
<?php include("footer_script.php"); ?>

<script src="//code.tidio.co/jkbs20gair8smqmlrle4advklsnx7tkc.js" async></script>
</body>


</html>
