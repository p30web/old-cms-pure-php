<?php

include("checklogin.php");
include("set.php");
require_once('includes/classes/Validation.php');

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}

$walletSelected = "dog";

if(isset($_GET['wallet'])){
    if($_GET['wallet'] == "dog"){
        $walletSelected = "dog";
    } elseif ($_GET['wallet'] == "dollar"){
        $walletSelected = "dollar";
    }
}

?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | برداشت</title>
    <?php include("root-head.php"); ?>
    <style>
        a.active-type {
            background: #3d94fb !important;
            color: #fff !important;
            border: 2px solid transparent !important;
        }
        .plan-t2{
            border-radius: 3px;
            width: 212px;
            display: inline-block;
            margin-left: 5px;
            font-size: 15px;
            text-align: center;
            padding: 7px 13px;
            background: transparent;
            color: #3d94fb;
            border: 2px solid #5867dd;
        }
        .selected-plan-form {
            background: #f9f9fc;
            width: 96%;
            margin: 0px auto;
            margin-top: 15px;
            border: 2px solid #b5bcdf;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        form#form_withdraw {
            border: 2px solid #b5bcdf;
            border-radius: 4px;
            width: 96%;
            margin: 0px auto;
            margin-top: 8px;
            margin-bottom: 2rem;
        }

        @media only screen and (max-width: 520px) {
            .plan-t2 {
                margin-bottom: 12px;
            }

            .select-plan-box {
                height: 177px;
            }

        }


    </style>
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
                                    برداشت</h3>
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
                            <div class="col-md-12">
                                <div class="kt-portlet">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                برداشت
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="base-content">

                                        <div class="kt-heading kt-heading--md" style="margin-bottom: 23px;width: 96%;margin: 0px auto;margin-top: 10px;">
                                            <div class="alert alert-dark" role="alert" style="background: #5867dd;border: 1px solid #5867dd;">
                                                <div class="alert-text">برای برداشت وجه ابتدا انتخاب نمایید، که مایل هستید از کدام کیف پول خود برداشت نمایید.</div>
                                            </div>
                                        </div>

                                        <div class="select-plan-box" style="border: 2px solid #b5bcdf;padding: 10px;margin: 7px;background: #f9f9fc;border-radius: 5px;width: 96%;margin: 0px auto;">
                                            <div class="p30web" style="font-size: 16px;padding-top: 5px;">کیف پول خود را انتخاب کنید : </div>
                                            <div class="box" style="height: 50px;margin-top: 17px;">
                                                <a href="https://www.irandogebank.com/user/withdraw.php?wallet=dog" class="plan-t2 <?php echo ($walletSelected == "dog") ? 'active-type' : ''; ?>">کیف پول دوج کوین</a>
                                                <a href="https://www.irandogebank.com/user/withdraw.php?wallet=dollar" class="plan-t2 <?php echo ($walletSelected == "dollar") ? 'active-type' : ''; ?>">کیف پول دلاری</a>
                                            </div>
                                        </div>


                                    </div>

                                    <?php if($walletSelected == "dollar"): ?>
                                        <!--begin::Form-->
                                        <form class="kt-form" id="form_withdraw">
                                            <div class="kt-portlet__body" style="padding: 0 !important;">
                                                <h3 class="kt-portlet__head-title" style="/* margin-top: 21px; */margin-bottom: 18px;padding-top: 20px;padding-right: 17px;border-bottom: 2px solid #b5bcdf;padding-bottom: 19px;background: #f9f9fc;">
                                                    درخواست برداشت از کیف پول : دلاری                                    </h3>
                                                <?php if ($hasError === 1) {?>
                                                    <div class="form-group form-group-last ">
                                                        <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                            <div class="alert-icon"><i class="flaticon-warning"></i>
                                                            </div>
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
                                                <?php } ?>


                                                <div class="kt-section kt-section--first">
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-md-2">موجودی:</label>
                                                        <span class="btn btn-label-info btn-pill"
                                                              id="cash"><?php echo $fetch_member['dollar_credit']; ?> Dollar</span>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-md-2">فی:</label>
                                                        <span class="btn btn-label-warning btn-pill"
                                                              id="feeamount">0 Dollar</span>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-md-2">مبلغ نهایی:</label>
                                                        <span class="btn btn-label-success btn-pill" id="fullwithfeeamount">0 Dollar</span>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>آدرس کیف پول:</label>
                                                        <div id="kt_clipboard_4"
                                                             style="border: 4px solid <?php echo ($fetch_member['dollar_wallet'] != null) ? 'rgba(29, 201, 183, .1)' : 'rgba(253, 39, 235, .1)'; ?>; padding: 10px;"><?php echo ($fetch_member['dollar_wallet'] != null) ? $fetch_member['dollar_wallet'] : 'کیف پول ثبت نشده است!'; ?></div>
                                                        <div class="kt-space-10"></div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>مبلغ:</label>
                                                        <input type="text" name="withdrawal_amount" id="dollar_withdrawal_amount"
                                                               class="form-control"
                                                               placeholder="00.0000 Dollar">
                                                        <span class="form-text text-muted">مبلغی را که میخواهید از کیف پول دلاری خود برداشت نمایید را وارد کنید</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__foot">
                                                <div class="kt-form__actions">
                                                    <button type="submit" id="dollar_withdraw_submit" class="btn btn-primary">ثبت
                                                        درخواست
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                        <!--end::Form-->
                                    <?php endif; ?>

                                    <?php if($walletSelected == "dog"): ?>
                                        <!--begin::Form-->
                                        <form class="kt-form" id="form_withdraw">
                                            <div class="kt-portlet__body" style="padding: 0 !important;">
                                                <h3 class="kt-portlet__head-title" style="/* margin-top: 21px; */margin-bottom: 18px;padding-top: 20px;padding-right: 17px;border-bottom: 2px solid #b5bcdf;padding-bottom: 19px;background: #f9f9fc;">
                                                    درخواست برداشت از کیف پول : دوج کوین                                    </h3>
                                                <?php if ($hasError === 1) {?>
                                                    <div class="form-group form-group-last ">
                                                        <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                                                            <div class="alert-icon"><i class="flaticon-warning"></i>
                                                            </div>
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
                                                <?php } ?>


                                                <div class="kt-section kt-section--first">
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-md-2">موجودی:</label>
                                                        <span class="btn btn-label-info btn-pill"
                                                              id="cash"><?php echo $fetch_member['cash']; ?> DOGE</span>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-md-2">فی:</label>
                                                        <span class="btn btn-label-warning btn-pill"
                                                              id="feeamount">0 DOGE</span>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="col-md-2">مبلغ نهایی:</label>
                                                        <span class="btn btn-label-success btn-pill" id="fullwithfeeamount">0 DOGE</span>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>آدرس کیف پول:</label>
                                                        <div id="kt_clipboard_4"
                                                             style="border: 4px solid <?php echo ($fetch_member['wallet'] != null) ? 'rgba(29, 201, 183, .1)' : 'rgba(253, 39, 235, .1)'; ?>; padding: 10px;"><?php echo ($fetch_member['wallet'] != null) ? $fetch_member['wallet'] : 'کیف پول ثبت نشده است!'; ?></div>
                                                        <div class="kt-space-10"></div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>مبلغ:</label>
                                                        <input type="text" name="withdrawal_amount" id="withdrawal_amount"
                                                               class="form-control"
                                                               placeholder="00.0000 DOGE">
                                                        <span class="form-text text-muted">مبلغی را که میخواهید از کیف پول دوج کوین خود برداشت نمایید را وارد کنید </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__foot">
                                                <div class="kt-form__actions">
                                                    <button type="submit" id="withdraw_submit" class="btn btn-primary">ثبت
                                                        درخواست
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                        <!--end::Form-->
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-container  kt-grid__item kt-grid__item--fluid">

                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
											<span class="kt-portlet__head-icon">
												<i class="kt-font-brand flaticon2-line-chart"></i>
											</span>
                                    <h3 class="kt-portlet__head-title">
                                        لیست برداشت های من
                                    </h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <!--begin: Datatable -->
                                <table class="table table-striped- table-bordered table-hover table-checkable"
                                       id="withdraw_table">
                                    <thead>
                                    <tr>
                                        <th>شناسه</th>
                                        <th>مبلغ</th>
                                        <th>تاریخ ثبت</th>
                                        <th>کد پرداخت</th>
                                        <th>وضعیت</th>
                                        <th>کیف پول</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    mysqli_select_db($cn, $database_cn);

                                    $fetch_admin = $db->get("admin_login");

                                    if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
                                        $query_withdraw= sprintf("SELECT * FROM `withdraw` where `member_id` = ".$fetch_admin[0]['admin_id']." ORDER BY id ASC");
                                    }else{
                                        $query_withdraw= sprintf("SELECT * FROM `withdraw` where `member_id` = ".$fetch_member['id']." ORDER BY id ASC");
                                    }

                                    $rswithdraw = mysqli_query($cn, $query_withdraw) or die(mysqli_error($cn));
                                    $row_rswithdraw = mysqli_fetch_assoc($rswithdraw);
                                    $totalRows_rswithdraw = mysqli_num_rows($rswithdraw);

                                    if ($totalRows_rswithdraw > 0) {
                                        do {
                                            ?>
                                            <tr>
                                                <td><?php echo $row_rswithdraw['id']; ?></td>
                                                <td><strong class="kt-font-bold kt-font-primary"><?php echo $row_rswithdraw['amount']; ?> <?php echo ($row_rswithdraw['type'] == null) ? "DOGE" : 'Dollar'; ?></strong></td>
                                                <td><span class="kt-badge  kt-badge--info kt-badge--inline kt-badge--pill kt-badge--md"><?php echo $row_rswithdraw['created_at']; ?></span></td>
                                                <td><?php echo ($row_rswithdraw['pay_code'] != null) ? $row_rswithdraw['pay_code'] : '#'; ?></td>
                                                <td><?php

                                                    switch ($row_rswithdraw['status']) {
                                                        case 0:
                                                            echo '<span class="btn btn-label-primary">در صف پرداخت</span>';
                                                            break;
                                                        case 1:
                                                            echo '<span class="btn btn-label-success">پرداخت شده</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="btn btn-label-danger">پرداخت نشده</span>';
                                                            break;
                                                        case 3:
                                                            echo '<span class="btn btn-label-warning">لغو شده</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="btn btn-label-info">نا مشخص</span>';
                                                    }

                                                    ?></td>
                                                <td><?php echo ($row_rswithdraw['type'] == null) ? "دوج کوین" : 'دلاری'; ?></td>
                                                <td>
                                                    <?php
                                                    
                                                    $TypeWith = "dog";
                                                    
                                                    if($row_rswithdraw['type'] == "dollar"){
                                                        $TypeWith = "dollar";
                                                    }else{
                                                        $TypeWith = "dog";
                                                    }
                                                    
                                                    if($row_rswithdraw['status'] == 0){
                                                        ?>
                                                        <a href="withdraw_cancel.php?type=<?php echo $TypeWith; ?>&id=<?php echo encrypt($row_rswithdraw['id'], session_id() . "wtd"); ?>"  onClick="return confirm('آیا مطمئنید می خواهید برداشت را لغو کنید ؟');" class="btn btn-sm btn-danger btn-icon btn-icon-md" title="لغو">
                                                            <i class="la la-close"></i>
                                                        </a>
                                                        <?php
                                                    }else{
                                                        echo '#';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        } while ($row_rswithdraw = mysqli_fetch_assoc($rswithdraw));
                                    }
                                    ?>
                                    </tbody>

                                </table>
                                <!--end: Datatable -->
                            </div>
                        </div>
                    </div>
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

    var KTFormControls = {
        init: function () {
            $("#form_my_wallet").validate({
                rules: {
                    wallet_addr: {required: !0}

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
    var KTDatatablewithdraw_table = {
        init: function () {
            $("#withdraw_table").DataTable({
                responsive: !0,
                pagingType: "full_numbers",
                columnDefs: []
            })
        }
    };
    jQuery(document).ready(function () {
        KTFormControls.init();
        KTDatatablewithdraw_table.init();

        var i = function (t, i, e) {
            var n = $('<div class="kt-alert kt-alert--outline alert alert-' + i + ' alert-dismissible m-3" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="la la-close"></i></button>\t\t\t<span></span>\t\t</div>');
            t.find(".alert").remove(), n.prependTo(t), KTUtil.animateClass(n[0], "fadeIn animated"), n.find("span").html(e)
        };
        $("#withdraw_submit").click(function (t) {
            t.preventDefault();
            var e = $(this), n = $(this).closest("form");
            // console.log(1);
            n.validate({
                rules: {
                    withdrawal_amount: {required: !0},

                }, invalidHandler: function (e, r) {
                    // console.log(e);
                    swal.fire({
                        title: "",
                        text: "در ارسال شما خطاهایی وجود دارد. لطفا آنها را اصلاح کنید",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary",
                        onClose: function (e) {
                        }
                    }), e.preventDefault()
                }
            }),
            n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                n.ajaxSubmit({
                    url: "api/withdraw.php",
                    method: "GET",
                    success: function (t, s, r, a) {

                        if (r.status === 200) {
                            i(n, r.responseJSON.type, r.responseJSON.message);
                            setTimeout(function () {
                                console.log(r);
                                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                            }, 2e3);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        setTimeout(function () {
                            e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", "درخواست با خطا مواجه شده است")
                        }, 2e3);
                    }
                }))
        });
        $("#dollar_withdraw_submit").click(function (t) {
            t.preventDefault();
            var e = $(this), n = $(this).closest("form");
            // console.log(1);
            n.validate({
                rules: {
                    withdrawal_amount: {required: !0},

                }, invalidHandler: function (e, r) {
                    // console.log(e);
                    swal.fire({
                        title: "",
                        text: "در ارسال شما خطاهایی وجود دارد. لطفا آنها را اصلاح کنید",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary",
                        onClose: function (e) {
                        }
                    }), e.preventDefault()
                }
            }),
            n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                n.ajaxSubmit({
                    url: "api/dollar_withdraw.php",
                    method: "GET",
                    success: function (t, s, r, a) {

                        if (r.status === 200) {
                            i(n, r.responseJSON.type, r.responseJSON.message);
                            setTimeout(function () {
                                console.log(r);
                                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                            }, 2e3);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        setTimeout(function () {
                            e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", "درخواست با خطا مواجه شده است")
                        }, 2e3);
                    }
                }))
        });


    });
</script>
<script>
    var transationfee_up5000 = parseFloat("0.005");
    var transationfee_up5darsad = parseFloat("0.5");

    $(document).ready(function () {
        $("#withdrawal_amount").keyup(function () {
            var amount = parseFloat($(this).val());
            if (!amount) amount = 0;
            var fee = 0;
            fee = (amount) * transationfee_up5000;
            var full = parseFloat(amount) + parseFloat(fee);
            $("#feeamount").html(fee + " DOGE");
            $("#fullwithfeeamount").html(full + " DOGE");
        });
        $("#dollar_withdrawal_amount").keyup(function () {
            var amount = parseFloat($(this).val());
            if (!amount) amount = 0;
            var fee = 0;
            fee = (amount * transationfee_up5darsad) / 100;
            var full = parseFloat(amount) + parseFloat(fee);
            $("#feeamount").html(fee + " Dollar");
            $("#fullwithfeeamount").html(full + " Dollar");
        });
    });
</script>

<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>