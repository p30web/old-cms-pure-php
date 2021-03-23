<?php

include("checklogin.php");
require_once('includes/classes/Validation.php');
require_once('includes/classes/upload/class.upload.php');

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}


$val = new Validation;
$hasError = 0;
if (!empty($_POST)) {
    $val->name('بخش')->value($_POST['department'])->required();
    $val->name('عنوان')->value($_POST['title'])->required();
    $val->name('الویت')->value($_POST['priority'])->required();
    $val->name('متن درخواست')->value($_POST['message'])->required();

    if ($val->isSuccess()) {



        $title = GetSQLValueString($_POST['title'], "def");
        $department = GetSQLValueString($_POST['department'], "int");
        $priority = GetSQLValueString($_POST['priority'], "def");
        $message = GetSQLValueString($_POST['message'], "def");


        $tickets_array = array(
            "subject" => $title,
            "created_at" => jdate('Y/m/d H:i:s'),
            "status_id" => 1,
            "priority" => $priority,
            "owner_id" => $fetch_member['id'],
            "department_id" => $department,
            "owner_type" => 1,
            "modified_at" => jdate('Y/m/d H:i:s'),
            "owner_ip" => $_SERVER['REMOTE_ADDR'],
        );
        if ($tickets_id = $db->insert("tickets", $tickets_array)) {
            $ticket_message_array = array(
                "ticket_id" => $tickets_id,
                "owner" => 1,
                "seen" => 0,
                "message" => $message,
//                "attachments" => ,
                "created_at" => jdate('Y/m/d H:i:s'),
                "owner_id" => $fetch_member['id'],
                "owner_ip" => $_SERVER['REMOTE_ADDR'],
            );
            if ($ticket_message_id = $db->insert("ticket_message", $ticket_message_array)) {
                activity_log($fetch_member['id'], $_SERVER['REQUEST_URI'],1, "tickets,ticket_message", "ثبت درخواست پشتیبانی جدید");
                header('Location: ' . $_POST['referurl'] . '?add=1');
                echo "<script>
	window.location= " . $_POST['referurl'] . "'?add=1';
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

<head>
    <title>ایران دوج | ارسال تیکت جدید</title>
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
                                    تیکت جدید </h3>
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
                                    ارسال تیکت جدید
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
                                                    <form class="kt-form kt-form--label-right" action="new_ticket.php" method="post" id="form_new_ticket">
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
                                                            <div class="form-group row">
                                                                <label class="col-lg-1 col-form-label">نام:</label>
                                                                <div class="col-lg-5">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
                                                                        <input type="text" class="form-control" disabled readonly value="<?php echo $fetch_member['firstname'].' '.$fetch_member['lastname']; ?>">
                                                                    </div>
                                                                </div>
                                                                <label class="col-lg-1 col-form-label">ایمیل:</label>
                                                                <div class="col-lg-5">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                                         <input type="email" class="form-control" disabled readonly value="<?php echo $fetch_member['email']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-1 col-form-label">بخش:</label>
                                                                <div class="col-lg-5">
                                                                    <select class="form-control kt-select2" id="department" name="department">
                                                                        <?php
                                                                        mysqli_select_db($cn, $database_cn);
                                                                        $query_departments = sprintf("SELECT `id`,`name` FROM `departments` WHERE status=1");
                                                                        $rsdepartments = mysqli_query($cn, $query_departments) or die(mysqli_error($cn));
                                                                        $row_rsdepartments = mysqli_fetch_assoc($rsdepartments);
                                                                        $totalRows_rsdepartments = mysqli_num_rows($rsdepartments);
                                                                        if ($totalRows_rsdepartments > 0) {

                                                                            do {
                                                                                ?>
                                                                                <option value="<?php echo $row_rsdepartments['id']; ?>"><?php echo $row_rsdepartments['name']; ?></option>
                                                                                <?php
                                                                            } while ($row_rsdepartments = mysqli_fetch_assoc($rsdepartments));
                                                                        }
                                                                        ?>
                                                                    </select>

                                                                    <span class="form-text text-muted">انتخاب بخش مربوطه</span>
                                                                </div>
                                                                <label class="col-lg-1 col-form-label">الویت:</label>
                                                                <div class="col-lg-5">
                                                                    <select class="form-control kt-select2" id="priority" name="priority">

                                                                        <option value="1">کم</option>
                                                                        <option value="1">متوسط</option>
                                                                        <option value="1">زیاد</option>
                                                                        <option value="1">فوری</option>

                                                                    </select>
                                                                    <span class="form-text text-muted">میزان الویت درخواست شما</span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-1 col-form-label">عنوان:</label>
                                                                <div class="col-lg-11">
                                                                    <input type="text" name="title" class="form-control" placeholder="موضوع خود را بنویسید">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row form-group-last">
                                                                <label class="col-lg-1 col-form-label">متن درخواست:</label>
                                                                <div class="col-lg-11">
                                                                    <textarea class="form-control" name="message" rows="8"></textarea>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                        <div class="kt-portlet__foot">
                                                            <div class="kt-form__actions">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <button type="submit" class="btn btn-primary">ارسال تیکت</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
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
    var KTSelect2 = {
        init: function () {
            $("#department").select2({placeholder: "بخش را انتخاب کنید"}),
                $("#priority").select2({placeholder: "الویت را انتخاب کنید"})
        }
    };

    var KTFormControls = {
        init: function () {
            $("#form_new_ticket").validate({
                rules: {
                    title: {required: !0},
                    department: {required: !0},
                    message: {required: !0},
                    priority: {required: !0},

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
        KTSelect2.init();
        KTFormControls.init();

    });
</script>
<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>