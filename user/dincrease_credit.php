<?php

include("checklogin.php");
require_once('includes/classes/Validation.php');

$db->where("id", $_SESSION['member_id']);
$fetch_member = $db->getOne("members");

$db->where("id", 2);
$fetch_wallets = $db->getOne("wallets");



?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | افزایش موجودی حساب</title>
    <!--begin::Page Custom Styles(used by this page) -->
    <link href="assets/css/pages/wizard/wizard-1.css" rel="stylesheet" type="text/css" />
    <?php include("root-head.php"); ?>
    <style>
        .kt-wizard-v1 .kt-wizard-v1__wrapper .kt-form {
            width: 80%;
            padding: 0 0 5rem;
        }
        .box-p30web {
            border: 1px solid #ebedf2;
        }

        #amount_get{
            padding: 6px 3rem 6px 3rem;
            border: 2px dashed #5d78ff;
        }
        .kt-wizard-v1 .kt-wizard-v1__wrapper .kt-wizard-v1__content{
            width: 80%;
            padding: 0 0 5rem;
        }

        .base-content {
            width: 90%;
            margin-bottom: 2rem;
        }

        .select-type {
            width: 50%;
            margin: 0px auto;
            margin-bottom: 28px;
        }

        .select-type a {
            font-size: 17px;
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
                                    افزایش موجودی حساب</h3>
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
                        <div class="kt-portlet">
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <div class="kt-grid kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1" data-ktwizard-state="step-first">

                                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">

                                        <div class="base-content">

                                            <div class="kt-heading kt-heading--md">
                                                <div class="alert alert-dark" role="alert">
                                                    <div class="alert-text">برای افزایش موجودی مبلغ مورد نظر خود را به دلار در بخش زیر وارد نمایید</div>
                                                </div>
                                            </div>
                                            <?php


                                            //$payment_log = array(
                                            //    "destination_wallet"=> "not_entered",
                                            //    "description"=> 'پرداخت لغو شده است',
                                            //    "member_id"=> $fetch_member['id'],
                                            //    "invoice_type"=> 1,
                                            //    "created_at"=> jdate('Y-m-d H:i:s'),
                                            //    "modified_at"=> jdate('Y-m-d H:i:s'),
                                            //    "status"=> '1',
                                            //    "time"=> time(),
                                            //    "pay_code"=> $pay_Code,
                                            //    "trans_id"=> $result['data']['txid'],
                                            //    //"amount"=> $tx_det['value'],
                                            //    //"price"=> $tx_det['value'],
                                            //);
                                            //
                                            //if($db->insert("payment_log" , $payment_log)){
                                            //
                                            //}



                                            ?>
                                            <?php if(! isset($_POST['pay_ok'])): ?>
                                                <form method="post">
                                                    <div class="col-md-12 form-group">
                                                        <label>مبلغ : </label>
                                                        <input type="number" class="form-control" name="PAYMENT_AMOUNT" placeholder="مبلغ مورد نظر خود را وارد کنید" autocomplete="off">
                                                        <span class="form-text text-muted">میزان دلاری که قصد سپرده گذاری آن را دارید را وارد نمایید</span>
                                                        <input type="hidden" name="pay_ok" value="12">
                                                        <input type="submit" class="btn btn-primary" name="PAYMENT_METHOD" value="پرداخت">
                                                    </div>
                                                </form>
                                            <?php endif; ?>

                                            <?php if(isset($_POST['pay_ok']) && $_POST['pay_ok'] == "12"): ?>
                                                <?php

                                                $orderID = rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9);
                                                $trans_id = "PW" . $orderID . "OR" . rand(1,9);

                                                $productinfo = "Order $orderID";

                                                $payment_log = array(
                                                    "amount"=> $_POST['PAYMENT_AMOUNT'],
                                                    "order_id"=> $orderID,
                                                    "member_id"=> $fetch_member['id'],
                                                    "trans_id"=> $trans_id,
                                                    "created_at"=> jdate('Y-m-d H:i:s'),
                                                    "description"=> "درخواست پرداخت",
                                                );

                                                if($db->insert("payment_log" , $payment_log)){

                                                }else {
                                                    echo "خطا در پرداخت";
                                                    exit();
                                                }

                                                ?>

                                                <img src="https://www.irandogebank.com/assets/pw-ajax-loader.gif" alt="Redirecting…" style="width: 90%;margin: 0px auto;margin-top: -65px;margin-bottom: -46px;" />

                                                <form action="https://perfectmoney.is/api/step1.asp" id="perfect_mony" method="post">
                                                    <input type="hidden" name="PAYEE_ACCOUNT" value="U19711632">
                                                    <input type="hidden" name="PAYEE_NAME" value="irandogebank">
                                                    <input type="hidden" name="PAYMENT_ID" value="<?php echo $orderID; ?>"><BR>
                                                    <input type="hidden" name="PAYMENT_AMOUNT" value="<?php echo $_POST['PAYMENT_AMOUNT']; ?>" >
                                                    <input type="hidden" name="PAYMENT_UNITS" value="USD">
                                                    <input type="hidden" name="STATUS_URL" value="https://www.irandogebank.com/status_cheek.php">
                                                    <input type="hidden" name="PAYMENT_URL" value="https://www.irandogebank.com/user/verify_payment.php?id=<?php echo $orderID ?>">
                                                    <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK">
                                                    <input type="hidden" name="NOPAYMENT_URL" value="https://www.irandogebank.com/user/dincrease_cancel.php?id=<?php echo $orderID ?>">
                                                    <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
                                                    <input type="hidden" name="SUGGESTED_MEMO" value="<?php echo $productinfo?>">
                                                    <input type="hidden" name="BAGGAGE_FIELDS" value="">
                                                    <input type="submit" class="btn btn-primary" name="PAYMENT_METHOD" value="رفتن به مرحله پرداخت">
                                                </form>
                                                <script type="text/javascript">
                                                    document.getElementById('perfect_mony').submit(); // SUBMIT FORM
                                                </script>
                                            <?php endif; ?>


                                        </div>

                                    </div>
                                </div>
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
    var KTClipboardDemo = {
        init: function () {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            new ClipboardJS("[data-clipboard=true]").on("success", function (e) {
                e.clearSelection(), toastr.success("کپی شد!");
            })
        }
    };

    jQuery(document).ready(function () {
        KTClipboardDemo.init();

        var i = function (t, i, e) {
            var n = $('<div class="kt-alert kt-alert--outline alert alert-' + i + ' alert-dismissible m-3" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="la la-close"></i></button>\t\t\t<span></span>\t\t</div>');
            t.find(".alert").remove(), n.prependTo(t), KTUtil.animateClass(n[0], "fadeIn animated"), n.find("span").html(e)
        };

        $("#deposit_submit").click(function (t) {
            t.preventDefault();
            var e = $(this), n = $(this).closest("form");
            // console.log(1);
            n.validate({
                rules: {
                    txid: {required: !0}

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
            }), n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                n.ajaxSubmit({
                    url: "api/deposit.php",
                    method: "GET",
                    success: function (t, s, r, a) {

                        if (r.status === 200) {
                            i(n, r.responseJSON.type, r.responseJSON.message);
                            setTimeout(function () {
                                if (r.responseJSON.action === "show_details") {
                                    n.find(".alert").remove();
                                    $('.modal-body').html(r.responseJSON.data);
                                    $('#transactionmodal').modal('show');
                                    e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                                }
                                if (r.responseJSON.action === "interval") {

                                    var aint = setInterval(function () {
                                        n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                                            n.ajaxSubmit({
                                                url: "api/deposit.php",
                                                method: "GET",
                                                success: function (t, s, r, a) {

                                                    if (r.status === 200) {
                                                        i(n, r.responseJSON.type, r.responseJSON.message);
                                                        setTimeout(function () {
                                                            if (r.responseJSON.action === "show_details") {
                                                                n.find(".alert").remove();
                                                                $('.modal-body').html(r.responseJSON.data);
                                                                $('#transactionmodal').modal('show');
                                                            }
                                                            e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)

                                                            if (r.responseJSON.action !== "interval") {
                                                                clearInterval(aint);
                                                            }
                                                        }, 2e3);
                                                    }
                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    setTimeout(function () {
                                                        e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", "درخواست با خطا مواجه شده است")
                                                    }, 2e3);
                                                }
                                            }))
                                    }, 5000);

                                } else {
                                    e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                                }

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

        $("#amount_send").on("click", function (f) {
            f.preventDefault();

            var get_this = $(this);
            var get_form = $("form.kt-new-form1");
            var amunt_input = $("input[name='mablagh']").val();
            var input_ok = 0;

            // if (amunt_input.length >= 2) {
            //
            // } else {
            //     swal.fire({
            //         title: "",
            //         text: "میزان دوج کوین وارد شده کمتر از حداقل میزان ممکن می باشد",
            //         type: "error",
            //         confirmButtonClass: "btn btn-secondary",
            //         onClose: function (e) {
            //         }
            //     });
            // }


            if ($.isNumeric(amunt_input)) {
                if (amunt_input <= 0) {
                    swal.fire({
                        title: "",
                        text: "میزان دوج کوین نمی تواند منفی باشد",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary",
                        onClose: function (e) {
                        }
                    });
                } else {
                    input_ok = 1;
                }
            } else {
                swal.fire({
                    title: "",
                    text: "میزان دوج کوین باید به صورت عددی باشد",
                    type: "error",
                    confirmButtonClass: "btn btn-secondary",
                    onClose: function (e) {
                    }
                });
            }

            if (input_ok === 1) {
                get_this.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0)
                get_form.ajaxSubmit({
                    url: "api/increase_credit.php",
                    method: "POST",
                    success: function (t, s, r, a) {
                        console.log(r);
                        console.log(t);
                        console.log(s);
                        if (r.status === 200) {
                            console.log(t.token);
                            $('input[name="token"]').val(t.token);
                            $('input[name="final_mablagh"]').val(t.final_mablagh);
                            $("#amount_get").text(t.final_mablagh);

                            $(".wizard_step1").attr("data-ktwizard-state", "done");
                            $(".wizard_step2").attr("data-ktwizard-state", "current");
                            $(".wizard_content1").attr("data-ktwizard-state", " ");
                            $(".wizard_content2").attr("data-ktwizard-state", "current");
                        }
                    }, error: function (xhr, ajaxOptions, thrownError) {
                        setTimeout(function () {
                            get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(get_form, "danger", "درخواست با خطا مواجه شده است")
                        }, 2e3);
                    }
                });
            }


            // console.log( get_this );
            // console.log( n );
            // $(".wizard_step1").attr("data-ktwizard-state","done");
            // $(".wizard_step2").attr("data-ktwizard-state","current");
            // $(".wizard_content1").attr("data-ktwizard-state"," ");
            // $(".wizard_content2").attr("data-ktwizard-state","current");
        });

        $("#vrify_payment").on("click", function (f) {
            f.preventDefault();
            $(".wizard_step2").attr("data-ktwizard-state", "done");
            $(".wizard_step3").attr("data-ktwizard-state", "current");
            $(".wizard_content2").attr("data-ktwizard-state", " ");
            $(".wizard_content3").attr("data-ktwizard-state", "current");
        });

        $("#finalv_submit").on("click", function (f) {
            f.preventDefault();
            var get_this = $(this);
            var get_vrifyform = $("form.final_submit");
            var taxid_input = $("input[name='taxid']").val();
            var vrify_ok = 0;
            if (taxid_input.length > 3) {
                vrify_ok = 1;
            } else {
                swal.fire({
                    title: "",
                    text: "مقدار وارد شده صحیح نمی باشد",
                    type: "error",
                    confirmButtonClass: "btn btn-secondary",
                    onClose: function (e) {
                    }
                });
            }

            if (vrify_ok === 1) {
                get_this.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0);
                get_vrifyform.ajaxSubmit({
                    url: "api/credit_charge.php",
                    method: "POST",
                    success: function (t, s, r, a) {
                        console.log(r);
                        console.log(t);
                        console.log(s);
                        if (r.status === 200) {
                            i(get_vrifyform, r.responseJSON.type, r.responseJSON.message);
                            setTimeout(function () {
                                if (r.responseJSON.action === "show_details") {
                                    get_vrifyform.find(".alert").remove();
                                    $('.modal-body').html(r.responseJSON.data);
                                    $('#transactionmodal').modal('show');
                                    get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                                }
                                if (r.responseJSON.action === "interval") {

                                    var aint = setInterval(function () {
                                        get_this.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0);
                                        get_vrifyform.ajaxSubmit({
                                            url: "api/credit_charge.php",
                                            method: "POST",
                                            success: function (t, s, r, a) {

                                                if (r.status === 200) {
                                                    i(get_vrifyform, r.responseJSON.type, r.responseJSON.message);
                                                    setTimeout(function () {
                                                        if (r.responseJSON.action === "show_details") {
                                                            get_vrifyform.find(".alert").remove();
                                                            $('.modal-body').html(r.responseJSON.data);
                                                            $('#transactionmodal').modal('show');
                                                        }
                                                        get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)

                                                        if (r.responseJSON.action !== "interval") {
                                                            clearInterval(aint);
                                                        }
                                                    }, 2e3);
                                                }
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                setTimeout(function () {
                                                    get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(get_vrifyform, "danger", "درخواست با خطا مواجه شده است")
                                                }, 2e3);
                                            }
                                        });
                                    }, 5000);

                                } else if(r.responseJSON.action === "show_details"){
                                    get_vrifyform.find(".alert").remove();
                                    $('.modal-body').html(r.responseJSON.data);
                                    $('#transactionmodal').modal('show');

                                }


                                else {
                                    get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                                }

                            }, 2e3);
                        }
                    }, error: function (xhr, ajaxOptions, thrownError) {
                        setTimeout(function () {
                            get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(get_vrifyform, "danger", "درخواست با خطا مواجه شده است")
                        }, 2e3);
                    }
                });
            }


        });

    });
</script>

<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/pages/custom/wizard/wizard-1.js" type="text/javascript"></script>

<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>