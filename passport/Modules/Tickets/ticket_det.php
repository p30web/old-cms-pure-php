<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once('../../checklogin.php');


$id = decrypt($_GET['id'], session_id() . "msg");
$id = GetSQLValueString($id, 'int');




$db->where("ticket_id", $id);
$cols1 = array("*");
$fetch_message1 = $db->getOne("tickets", $cols1);

$db->where("id", $fetch_message1['owner_id']);
$cols2 = array("*");
$fetch_message2 = $db->getOne("members", $cols2);

$hasError = 0;
if (!empty($_POST)) {


    $tickets_id = decrypt($_POST['ticket_id'], session_id() . "ntc");
    $tickets_id = GetSQLValueString($tickets_id, 'int');
    $message = GetSQLValueString($_POST['message'], "def");


    $db->where("ticket_id",$tickets_id);
    $tickets_update = array(
        "status_id" => 3,
        "modified_at" => jdate('Y/m/d H:i:s'),

    );
    if ($db->update("tickets", $tickets_update)) {
        $ticket_message_array = array(
            "ticket_id" => $tickets_id,
            "owner" => 0,
            "seen" => 1,
            "message" => $message,
            //                "attachments" => ,
            "created_at" => jdate('Y/m/d H:i:s'),
            "owner_id" => 00,
            "owner_ip" => 00,
        );
        if ($ticket_message_id = $db->insert("ticket_message", $ticket_message_array)) {
            $db->where("ticket_id", $tickets_id);
            $cols1 = array("*");
            $fetch_message4 = $db->getOne("tickets", $cols1);

            $to = $fetch_message4['owner_email'];
            $subject = "پاسخ : " .  $fetch_message4['subject'];
            $from = 'noreply@irandogebank.com';

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

            // Create email heaوders
            $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            //var_dump($fetch_message4['owner_email']);

            if($to != null){
                mail($to, $subject, $message, $headers);
            }


            //	activity_log($_SESSION['member_id'], $_SERVER['REQUEST_URI'],21, "tickets,ticket_message", "ارسال پیام جدید به پشتیبانی");
            header('Location: ' . $_POST['referurl'] . '?add=1&id='.encrypt($tickets_id, session_id() . "msg"));
            echo "<script>";
            echo "window.location= " . $_POST['referurl'] . "'?add=1&id='" . encrypt($tickets_id, session_id() . "msg"). "</script>";
            exit;
        }else {
            $hasError = 1;
        }
    }

}
?>
<!DOCTYPE html>

<html lang="en" direction="rtl" style="direction: rtl;">

<!-- /Added by HTTrack -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php include($nav_path . "Modules-head.php"); ?>
    <title>Rahaaa | جزئیات تیکت</title>

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
                                جزئیات پیام</h3>

                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="ticket.php" class="kt-subheader__breadcrumbs-link">
                                    تیکت ها </a>
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
                                    پیام <?php echo $fetch_message2['firstname']; ?> <?php echo $fetch_message2['lastname']; ?>
                                </h3>
                            </div>

                        </div>

                        <div class="kt-portlet__body">
                            <div class="kt-infobox">
                                <div class="kt-infobox__header">
                                    <h4 class="kt-infobox__title">عنوان درخواست: <span
                                                class="kt-font-primary"><?php echo $fetch_message1['subject']; ?></span>
                                    </h4>
                                </div>
                                <div class="kt-infobox__body">
                                    <div class="kt-infobox__section">
                                        <h3 class="kt-infobox__subtitle">متن درخواست:</h3>
                                        <?php


                                        mysqli_select_db($cn, $database_cn);
                                        $query_ticket_message= sprintf("SELECT * FROM `ticket_message` WHERE ticket_id= %d order by id ASC ", $id);
                                        $ticket_message= mysqli_query($cn, $query_ticket_message) or die(mysqli_error($cn));
                                        $row_ticket_message = mysqli_fetch_assoc($ticket_message);
                                        $totalRows_ticket_message = mysqli_num_rows($ticket_message);
                                        if($totalRows_ticket_message > 0) {
                                            do {
                                                ?>

                                                <div class="kt-infobox__content">
                                                    <?php if($row_ticket_message['owner'] == '0'){ echo '<div class="alert alert-info">پیام پشتیبانی: '; } echo $row_ticket_message['message']; if($row_ticket_message['owner'] == '0'){ echo '</div>'; } ?>
                                                </div>
                                                <?php
                                            } while($row_ticket_message = mysqli_fetch_assoc($ticket_message));
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        پاسخ
                                    </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">

                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <form class="kt-form kt-form--label-right" action="ticket_det.php" id="form_new_message" method="post">
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
                                                        پاسخ شما با موفقیت ثبت شد.
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
                                                <label class="col-lg-1 col-form-label">متن:</label>
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

                        </div>
                        <!--end::Portlet-->
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
            $("#message_table").DataTable({
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