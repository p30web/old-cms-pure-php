<?php
include("set.php");



$code = GetSQLValueString($_GET['page'], 'def');


$db->where("code", $code);
$db->where("status", '1');
$cols = array("*");
$fetch_pages= $db->getOne("`pages`", $cols);
$fetch_pages_count = $db->count;


?>
<!doctype html>
<html lang="fa">


<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>صفحه - <?php echo $fetch_pages['title']; ?></title>

    <?php include("seo.php"); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-155192660-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-155192660-1');
</script>

</head>

<body>
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
                <a class="logo" href="index.php"><img style="width: 100px;"
                                              src="Attachment/img/settings<?php echo $Site_Information['logo']; ?>"
                                              alt="<?php echo $Site_Information['site_name']; ?>"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"><i class="icofont-navigation-menu"></i></span>
                </button>
                <!-- navbar links -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">خانه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#core-feature-area">معرفی سامانه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages.php?page=privacy_policy" >قوانین و مقررات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#pricing-area">پلن های سرمایه گذاری</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#faq-area">سوالات متداول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#contact-area" >تماس با ما</a>
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
<!--start page content-->
<section id="page-cont">
    <div class="page-breadcrumb">
        <div class="container" dir="rtl">
            <div class="breadcrumb-cont">
                <h2><?php echo $fetch_pages['title']; ?></h2>
                <ul>
                    <li><a href="index.php"><i class="icofont-home"></i> خانه</a></li>
                    <li>
                        <small><i class="icofont-simple-left"></i></small>
                    </li>
                    <li><?php echo $fetch_pages['title']; ?></li>

                </ul>
            </div>
        </div>
    </div>
    <div class="blog-wrap">
        <div class="container" dir="rtl">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!--start blog single-->
                    <div class="blog-single">
                        <div class="post-cont single">
                            <h3><a href="#"><?php echo $fetch_pages['title']; ?></a></h3>
                            <div class="blog-inner-cont row">
                                <p><?php echo $fetch_pages['text']; ?></p>
                            </div>
                        </div>

                    </div>
                    <!--end blog single-->

                </div>

            </div>
        </div>
    </div>
</section>
<!--end page content-->
<!--start footer-->
<footer id="footer" class="bg-1">
    <div class="container" dir="rtl">
        <div class="footer-cont">
            <div class="row">
                <!--start footer widget single-->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3><?php echo $Site_Information['site_name']; ?></h3>
                        <ul>
                            <li><a href="index.php"><i class="icofont-long-arrow-left"></i>خانه</a></li>
                            <li><a href="index.php#core-feature-area"><i class="icofont-long-arrow-left"></i>معرفی سامانه</a></li>
                            <li><a href="pages.php?page=privacy_policy"><i class="icofont-long-arrow-left"></i>قوانین و مقررات</a></li>
                            <li><a href="index.php#pricing-area"><i class="icofont-long-arrow-left"></i>پلن های سرمایه گذاری</a></li>
                            <li><a href="index.php#contact-area"><i class="icofont-long-arrow-left"></i>تماس باما</a></li>
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
</body>


</html>
