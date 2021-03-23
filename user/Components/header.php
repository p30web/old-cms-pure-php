<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
    <div class="kt-header__top">
        <div class="kt-container ">
            <!-- begin:: Brand -->
            <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
                <div class="kt-header__brand-logo">
                    <a href="index.php">
                        <img alt="Logo" width="85px" src="/Attachment/img/settingslogo1565647848.png">
                    </a>
                </div>
            </div>
            <!-- end:: Brand -->            <!-- begin:: Header Topbar -->
            <div class="kt-header__topbar">
                <!--begin: Search -->
                <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown kt-hidden-desktop"
                     id="kt_quick_search_toggle">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
						<span class="kt-header__topbar-icon">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                 height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--info">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect id="bound" x="0" y="0" width="24" height="24"/>
									<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                          id="Path-2" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
									<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                          id="Path" fill="#000000" fill-rule="nonzero"/>
								</g>
							</svg>                <!--<i class="flaticon2-search-1"></i>-->
						</span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                        <div class="kt-quick-search kt-quick-search--inline" id="kt_quick_search_inline">
                            <form method="get" class="kt-quick-search__form">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="flaticon2-search-1"></i></span></div>
                                    <input type="text" class="form-control kt-quick-search__input"
                                           placeholder="جستجو...">
                                    <div class="input-group-append"><span class="input-group-text"><i
                                                    class="la la-close kt-quick-search__close"></i></span>
                                    </div>
                                </div>
                            </form>
                            <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true"
                                 data-height="300" data-mobile-height="200">
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Search -->

                <div class="kt-header__topbar-item">
					<span class="btn btn-label-danger">موجودی: <strong><?php


                            $fetch_admin = $db->get("admin_login");

                            if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                $db->where("id", $fetch_admin[0]['admin_id']);
                            }else{
                                $db->where("id", $_SESSION['member_id']);
                            }
                            
                            $fetch_member1 = $db->getOne("members");
                            echo  number_format((float)$fetch_member1['cash'],8, '.', ''); ?> DOGE</strong></span>
                </div>
                <div class="kt-header__topbar-item">
					<span class="btn btn-label-danger" style="background: #fd27eb;color: #fff;">موجودی دلاری : <strong><?php

                            $fetch_admin = $db->get("admin_login");

                            if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                $db->where("id", $fetch_admin[0]['admin_id']);
                            }else{
                                $db->where("id", $_SESSION['member_id']);
                            }
                            
                            $fetch_member1 = $db->getOne("members");
                            echo  number_format((float)$fetch_member1['dollar_credit'],8, '.', ''); ?></strong></span>
                </div>
                <!--begin: Notifications -->
                <div class="kt-header__topbar-item dropdown">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
						<span class="kt-header__topbar-icon kt-header__topbar-icon--success">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                 height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect id="bound" x="0" y="0" width="24" height="24"/>
									<path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z"
                                          id="Combined-Shape" fill="#000000"/>
									<circle id="Oval" fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5"/>
								</g>
							</svg>                <!--<i class="flaticon2-bell-alarm-symbol"></i>-->
						</span>
                        <span class="kt-hidden kt-badge kt-badge--danger"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                        <form>
                            <!--begin: Head -->
                            <div class="kt-head kt-head--skin-light kt-head--fit-x kt-head--fit-b">
                                <h3 class="kt-head__title">
                                    رویداد های کاربر
                                    &nbsp;
                                    <?php
                                    mysqli_select_db($cn, $database_cn);
                                    $query_notification_COUNT= sprintf("SELECT COUNT(id) FROM `notification_queue` WHERE notification_queue.target_id = %d and notification_queue.status = 0", $fetch_member['id']);
                                    $notification_COUNT= mysqli_query($cn, $query_notification_COUNT) or die(mysqli_error($cn));
                                    $row_notification_COUNT = mysqli_fetch_assoc($notification_COUNT);
                                    ?>
                                    <span class="btn btn-label-primary btn-sm btn-bold btn-font-md"><?php echo $row_notification_COUNT['COUNT(id)']; ?> جدید</span>
                                </h3>
                                <?php
                                mysqli_select_db($cn, $database_cn);
                                $query_notification_type= sprintf("SELECT notification_type.id, notification_type.name FROM `notification_queue` INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d ", $fetch_member['id']);
                                $notification_type= mysqli_query($cn, $query_notification_type) or die(mysqli_error($cn));
                                $row_notification_type = mysqli_fetch_assoc($notification_type);
                                $totalRows_notification_type = mysqli_num_rows($notification_type);

                                if($totalRows_notification_type > 0) {
                                    ?>
                                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x"
                                        role="tablist">
                                        <?php
                                        $i=0;
                                        do {

                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?php if($i === 0 ) echo 'active show'; ?>" data-toggle="tab"
                                                   href="#ra-notification-<?php echo $row_notification_type['id']; ?>-tb" role="tab">
                                                    <?php echo $row_notification_type['name']; ?>
                                                </a>
                                            </li>
                                            <?php
                                            $i++;
                                        } while($row_notification_type = mysqli_fetch_assoc($notification_type));
                                        ?>
                                    </ul>
                                    <?php
                                }else{
                                    ?>
                                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active show" data-toggle="tab"
                                               href="#no_notifications_logs" role="tab">
                                                رویداد ها
                                            </a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--end: Head -->

                            <div class="tab-content">
                                <?php
                                mysqli_select_db($cn, $database_cn);
                                $query_notification_type= sprintf("SELECT notification_type.id, notification_type.name FROM `notification_queue` INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d ", $_SESSION['member_id']);
                                $notification_type= mysqli_query($cn, $query_notification_type) or die(mysqli_error($cn));
                                $row_notification_type = mysqli_fetch_assoc($notification_type);
                                $totalRows_notification_type = mysqli_num_rows($notification_type);

                                if($totalRows_notification_type > 0) {
                                    $i = 0;
                                    do{
                                        ?>
                                        <div class="tab-pane <?php if($i === 0 ) echo 'active show'; ?> " id="ra-notification-<?php echo $row_notification_type['id']; ?>-tb"
                                             role="tabpanel">
                                            <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll"
                                                 data-scroll="true" data-height="300" data-mobile-height="200">
                                                <?php
                                                mysqli_select_db($cn, $database_cn);
                                                $query_notification= sprintf("SELECT notification_queue.id AS notification_id, notification_queue.time, notification_queue.icon, notification_queue.status, notification_queue.notification_type_id, notification_type.name AS notification_type_name, notification_message.title FROM `notification_queue` INNER JOIN notification_message ON notification_queue.id = notification_message.notification_id INNER JOIN notification_type ON notification_queue.notification_type_id = notification_type.id WHERE notification_queue.target_id = %d and notification_queue.notification_type_id=%d", $_SESSION['member_id'], $row_notification_type['id']);
                                                $notification = mysqli_query($cn, $query_notification) or die(mysqli_error($cn));
                                                $row_notification = mysqli_fetch_assoc($notification);
                                                $totalRows_notification = mysqli_num_rows($notification);

                                                if($totalRows_notification > 0){

                                                    do{
                                                        ?>
                                                        <a href="#" class="kt-notification__item">
                                                            <div class="kt-notification__item-icon">
                                                                <?php echo $row_notification['icon']; ?>
                                                            </div>
                                                            <div class="kt-notification__item-details">
                                                                <div class="kt-notification__item-title">
                                                                    <?php echo $row_notification['title']; ?>
                                                                </div>
                                                                <div class="kt-notification__item-time">
                                                                    <?php
                                                                    echo ago_time($row_notification['time']);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <?php
                                                    } while($row_notification = mysqli_fetch_assoc($notification));
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    } while($row_notification_type = mysqli_fetch_assoc($notification_type));
                                }else {
                                    ?>
                                    <div class="tab-pane active show" id="no_notifications_logs" role="tabpanel">
                                        <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                                            <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                                <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                                    کاربر گرامی!
                                                    <br>رویدادی برای شما وجود ندارد
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end: Notifications -->


                <!--begin: Language bar -->
                <div class="kt-header__topbar-item kt-header__topbar-item--langs">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
						<span class="kt-header__topbar-icon kt-header__topbar-icon--brand">
							<img class="" src="media/flags/ir.svg" alt=""/>
						</span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim">
                        <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                            <li class="kt-nav__item kt-nav__item--active">
                                <a href="#" class="kt-nav__link">
                                    <span class="kt-nav__link-icon"><img src="media/flags/ir.svg" alt=""/></span>
                                    <span class="kt-nav__link-text">فارسی</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--end: Language bar -->
                <!--begin: User bar -->
                <div class="kt-header__topbar-item kt-header__topbar-item--user">
                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
                        <span class="kt-hidden kt-header__topbar-welcome">سلام,</span>
                        <span class="kt-hidden kt-header__topbar-username"><?php echo $_SESSION["member_name"]; ?></span>
                        <?php if ($user_image != null) {
                            echo '<img class="" alt="Pic" src="../Attachment/img/members/' . $user_image . '"/>';
                        } else {

                            echo '<span class="kt-header__topbar-icon kt-header__topbar-icon--brand"><img src="/assets/images/avatar-icon-images-4.jpg
" alt="' . $fetch_member['firstname'] . '"></span>';
                        } ?>
                    </div>
                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                        <!--begin: Head -->
                        <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                            <div class="kt-user-card__avatar">
                                <?php if ($user_image != null) {
                                    echo '<img class="" alt="Pic" src="../Attachment/img/members/' . $user_image . '"/>';
                                } else {

                                    echo '<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><img src="/assets/images/avatar-icon-images-4.jpg
" alt="' . $fetch_member['firstname'] . '"></span>';
                                } ?>
                            </div>
                            <div class="kt-user-card__name">
                                <?php echo $_SESSION["member_name"] . ' ' . $_SESSION["member_lastname"]; ?>
                            </div>
                            <div class="kt-user-card__badge">
                                <?php
                                mysqli_select_db($cn, $database_cn);
                                $query_member_messages= sprintf("SELECT COUNT(id) FROM `member_messages` WHERE member_messages.member_id = %d and member_messages.seen = 0", $_SESSION['member_id']);
                                $member_messages= mysqli_query($cn, $query_member_messages) or die(mysqli_error($cn));
                                $row_member_messages = mysqli_fetch_assoc($member_messages);
                                ?>
                                <span class="btn btn-label-primary btn-sm btn-bold btn-font-md"><?php echo $row_member_messages['COUNT(id)']; ?> پیام</span>
                            </div>
                        </div>
                        <!--end: Head -->

                        <!--begin: Navigation -->
                        <div class="kt-notification">
                            <a href="my_profile.php" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-calendar-3 kt-font-success"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        پروفایل من
                                    </div>
                                    <div class="kt-notification__item-time">
                                        تنظیمات حساب کاربر
                                    </div>
                                </div>
                            </a>
                            <a href="msg_inbox.php" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-mail kt-font-warning"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        پیام ها
                                    </div>
                                    <div class="kt-notification__item-time">
                                        صندوق دریافت و ارسال
                                    </div>
                                </div>
                            </a>
                            <a href="my_activity.php" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <i class="flaticon2-rocket-1 kt-font-danger"></i>
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title kt-font-bold">
                                        فعالیت های من
                                    </div>
                                    <div class="kt-notification__item-time">
                                        لاگ و رویداد ها
                                    </div>
                                </div>
                            </a>

                            <div class="kt-notification__custom kt-space-between">
                                <a href="logout.php"
                                   class="btn btn-label btn-label-brand btn-sm btn-bold">خروج</a>

                                <!--                                <a href="custom/user/login-v2.html" target="_blank"-->
                                <!--                                   class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a>-->
                            </div>
                        </div>
                        <!--end: Navigation -->
                    </div>
                </div>
                <!--end: User bar -->

            </div>
            <!-- end:: Header Topbar -->
        </div>
    </div>
    <div class="kt-header__bottom">
        <div class="kt-container ">
            <!-- begin: Header Menu -->
            <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                        class="la la-close"></i></button>
            <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                    <ul class="kt-menu__nav ">
                        <li class="kt-menu__item  kt-menu__item--rel">
                            <a href="index.php" class="kt-menu__link">
                                <i class="fa fa-th-large kt-menu__link-icon"></i>
                                <span class="kt-menu__link-text">داشبورد</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--rel ">
                            <a href="active_plan.php" class="kt-menu__link">
                                <i class="fa fa-check-circle kt-menu__link-icon"></i>
                                <span class="kt-menu__link-text">پلن های فعال</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--rel ">
                            <a href="pricing_plan.php" class="kt-menu__link">
                                <i class="fa fa-donate kt-menu__link-icon"></i>
                                <span class="kt-menu__link-text">پلن های سرمایه گذاری</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"
                            data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="fa fa-money-bill kt-menu__link-icon"></i>
                                <span class="kt-menu__link-text">حسابداری</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="withdraw.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">برداشت وجه</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="https://irandogebank.com/user/increase_credit-type.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">افزایش موجودی حساب</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="my_transaction.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">گردش حساب</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="my_wallet.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">مدیریت حساب ها</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel "
                            data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="fa fa-handshake kt-menu__link-icon"></i>
                                <span class="kt-menu__link-text">کسب درآمد بیشتر</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="ge_invite_link.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">دریافت لینک</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="subincome.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">درآمد کسب شده</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"
                            data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                <i class="fa fa-headset kt-menu__link-icon"></i>
                                <span class="kt-menu__link-text">پشتیبانی</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="new_ticket.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">تیکت جدید</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="my_tickets.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">تیکت های من</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="help_center.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">مرکز پشتیبانی</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item " aria-haspopup="true">
                                        <a href="faq.php" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="kt-menu__link-text">سوالات متداول</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php $fetch_admin = $db->get("admin_login");
                        if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0): ?>
                            <li class="kt-menu__item  kt-menu__item--rel">
                                <a href="admin-logoup.php?a=p30u<?php echo $fetch_admin[0]['admin_id']; ?>" class="kt-menu__link">
                                    <i class="fa fa-th-large kt-menu__link-icon"></i>
                                    <span class="kt-menu__link-text">خروج از حساب کاربر</span>
                                    <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="kt-header-toolbar">
                    <div class="kt-quick-search" id="kt_quick_search_default">
                        <form method="get" class="kt-quick-search__form">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="flaticon2-search-1"></i></span></div>
                                <input type="text" class="form-control kt-quick-search__input"
                                       placeholder="جستجو...">
                                <div class="input-group-append"><span class="input-group-text"><i
                                                class="la la-close kt-quick-search__close"></i></span></div>
                            </div>
                        </form>
                        <div id="kt_quick_search_toggle" data-toggle="dropdown"
                             data-offset="0px,10px"></div>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                            <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true"
                                 data-height="300" data-mobile-height="200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Header Menu -->
        </div>
    </div>
</div>
<!-- end:: Header -->

<?php

$db->where("status",1);
$db->orderBy("id","Desc");
$fetch_notice = $db->getOne("p30web_notic");

if($db->count != 0) { ?>

    <div class="mtsnb mtsnb-sp-right mtsnb-button mtsnb-bottom mtsnb-fixed mtsnb-shown" id="mtsnb-22" data-mtsnb-id="22" data-bar-animation="" data-bar-content-animation="mtsnb-zoomIn" data-sp-selector="">
        <div class="mtsnb-container-outer">
            <div class="mtsnb-container mtsnb-clearfix" style="padding-top: 10px;padding-bottom: 10px;text-align: center;">
                <div class="mtsnb-button-type mtsnb-content mtsnb-animated mtsnb-zoomIn" data-mtsnb-variation="none">
                    <span class="mtsnb-text"> <?php echo $fetch_notice['title'] ?></span>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

