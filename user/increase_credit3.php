<?php

include("checklogin.php");
require_once('includes/classes/Validation.php');

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}

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
                                    <div class="kt-grid__item">

                                        <!--begin: Form Wizard Nav -->
                                        <div class="kt-wizard-v1__nav">

                                            <!--doc: Remove "kt-wizard-v1__nav-items--clickable" class and also set 'clickableSteps: false' in the JS init to disable manually clicking step titles -->
                                            <div class="kt-wizard-v1__nav-items kt-wizard-v1__nav-items--clickable">
                                                <div class="kt-wizard-v1__nav-item wizard_step1" data-ktwizard-type="step" data-ktwizard-state="current">
                                                    <div class="kt-wizard-v1__nav-body">
                                                        <div class="kt-wizard-v1__nav-icon">
                                                            <i class="flaticon2-add"></i>
                                                        </div>
                                                        <div class="kt-wizard-v1__nav-label">
                                                            1. انتخاب مقدار ارز
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__nav-item wizard_step2" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v1__nav-body">
                                                        <div class="kt-wizard-v1__nav-icon">
                                                            <i class="flaticon2-list-3"></i>
                                                        </div>
                                                        <div class="kt-wizard-v1__nav-label">
                                                            2. واریز مبلغ
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__nav-item wizard_step3" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v1__nav-body">
                                                        <div class="kt-wizard-v1__nav-icon">
                                                            <i class="flaticon-list"></i>
                                                        </div>
                                                        <div class="kt-wizard-v1__nav-label">
                                                            3. تایید تراکنش
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Nav -->
                                    </div>
                                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">

                                        <!--begin: Form Wizard Form-->

                                        <!--begin: Form Wizard Step 1-->
                                        <div class="kt-wizard-v1__content wizard_content1" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                            <div class="kt-heading kt-heading--md">
                                                <div class="alert alert-dark" role="alert">
                                                    <div class="alert-text">مبلغی را که میخواهید به اعتبار خودتان اضافه کنید را وارد کنید</div>
                                                </div>
                                            </div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v1__form">
                                                    <div class="kt-portlet__body">
                                                        <form class="kt-new-form1" method="post">
                                                            <div class="col-md-12 form-group">
                                                                <label>مبلغ : </label>
                                                                <input type="number" class="form-control" name="mablagh" placeholder="مبلغ مورد نظر خود را وارد کنید" autocomplete="off">
                                                                <span class="form-text text-muted">تعداد دوج کوینی که قصد سپرده گذاری آن را دارید را وارد نمایید</span>
                                                            </div>
                                                            <input class="hidden" type="hidden" name="final_mablagh">
                                                        </form>
                                                    </div>

                                                    <div class="kt-portlet__foot">
                                                        <div class="p30web-ok">
                                                            <button type="submit" id="amount_send" class="btn btn-primary">مرحله بعدی</button>
                                                            <a href="taxid_payment.php" class="btn btn-brand">پرداخت با taxid</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Step 1-->

                                        <!--begin: Form Wizard Step 2-->
                                        <div class="kt-wizard-v1__content wizard_content2" data-ktwizard-type="step-content">
                                            <div class="kt-heading kt-heading--md">
                                                <div class="alert alert-danger" role="alert">
                                                    <div class="alert-text">لطفا تعداد دوج کوین محاسبه شده را با تمامی اعداد اعشاری آن و با دقت واریز نمایید در غیر این صورت واریز شما تایید نخواهد شد</div>
                                                </div>
                                            </div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v1__form">
                                                    <div class="kt-portlet__body">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 order-lg-1 order-xl-1">
                                                                <div class="box-p30web">
                                                                    <div class="kt-portlet__head">
                                                                        <div class="kt-portlet__head-label">
                                                                            <h3 class="kt-portlet__head-title">1) آدرس کیف پول ایران دوج</h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="wallet_address">
                                                                            <img src="https://dogechain.info/api/v1/address/qrcode/9tiYCRCeWFhoYaKSsoW2fNMrGpPeiq28BZ">
                                                                            <p>
                                                                            </p>
                                                                            <h3><a id="wallet_add">9tiYCRCeWFhoYaKSsoW2fNMrGpPeiq28BZ</a><button type="button" data-clipboard="true" data-clipboard-target="#wallet_add" class="btn btn-info btn-icon btn-circle"><i class="flaticon2-copy"></i></button></h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 order-lg-1 order-xl-1">
                                                                <div class="box-p30web">
                                                                    <div class="kt-portlet__head">
                                                                        <div class="kt-portlet__head-label">
                                                                            <h3 class="kt-portlet__head-title">2) تعداد دوج کوین محاسبه شده</h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-portlet__body">
                                                                        <div class="form-group form-group-last">
                                                                            <div class="alert alert-secondary" role="alert">
                                                                                <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                                                                <div class="alert-text">
                                                                                    شما باید این مقدار ارز را به آدرس کیف پول سایت واریز کرده و شناسه واریز را دریافت نمایید و در مرحله بعدی وارد نمایید تا تراکنش تایید شود.</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="alert alert-outline-dark fade show" role="alert">
                                                                            <div class="alert-text">
                                                                                <a id="amount_get">1000.00192</a>
                                                                                <button type="button" data-clipboard="true" data-clipboard-target="#amount_get" class="btn btn-info btn-icon">
                                                                                    <i class="flaticon2-copy"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="kt-portlet__foot">
                                                        <div class="p30web-ok2">
                                                            <button type="submit" id="vrify_payment" class="btn btn-primary">مبلغ را واریز کردم، مرحله بعد</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Step 2-->

                                        <!--begin: Form Wizard Step 3-->
                                        <div class="kt-wizard-v1__content wizard_content3" data-ktwizard-type="step-content">
                                            <div class="kt-heading kt-heading--md">
                                                <div class="alert alert-primary" role="alert">
                                                    <div class="alert-text">کد تراکنش (TXID) را در زیر وارد نمایید و منتظر تایید باشید</div>
                                                </div>
                                            </div>
                                           <p style="font-size: 16px"> کد تراکنش را به صورت تیکت برای ما ارسال نمایید تا درخواست افزایش موجودی شما تایید شود.</p>
                                        </div>

                                        <!--end: Form Wizard Step 3-->

                                        <!--begin: Form Actions -->
                                        <!--                                            <div class="kt-form__actions">-->
                                        <!--                                                <button class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">-->
                                        <!--                                                    مرحله قبلی-->
                                        <!--                                                </button>-->
                                        <!--                                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">-->
                                        <!--                                                   ثبت اطلاعات-->
                                        <!--                                                </button>-->
                                        <!--                                                <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">-->
                                        <!--                                                    مرحله بعدی-->
                                        <!--                                                </button>-->
                                        <!--                                            </div>-->

                                        <!--end: Form Actions -->


                                        <!--end: Form Wizard Form-->
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
                                                        }, 30000);
                                                    }
                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    setTimeout(function () {
                                                        e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", "درخواست با خطا مواجه شده است")
                                                    }, 30000);
                                                }
                                            }))
                                    }, 30000);

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
                                                    }, 30000);
                                                }
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                setTimeout(function () {
                                                    get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(get_vrifyform, "danger", "درخواست با خطا مواجه شده است")
                                                }, 30000);
                                            }
                                        });
                                    }, 30000);

                                } else if(r.responseJSON.action === "show_details"){
                                    get_vrifyform.find(".alert").remove();
                                    $('.modal-body').html(r.responseJSON.data);
                                    $('#transactionmodal').modal('show');

                                }


                                else {
                                    get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                                }

                            }, 5000);
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

</html><?php

include("checklogin.php");
require_once('includes/classes/Validation.php');

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    $db->where("id", $_SESSION['member_id']);
    $fetch_member = $db->getOne("members");
}

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
                                    <div class="kt-grid__item">

                                        <!--begin: Form Wizard Nav -->
                                        <div class="kt-wizard-v1__nav">

                                            <!--doc: Remove "kt-wizard-v1__nav-items--clickable" class and also set 'clickableSteps: false' in the JS init to disable manually clicking step titles -->
                                            <div class="kt-wizard-v1__nav-items kt-wizard-v1__nav-items--clickable">
                                                <div class="kt-wizard-v1__nav-item wizard_step1" data-ktwizard-type="step" data-ktwizard-state="current">
                                                    <div class="kt-wizard-v1__nav-body">
                                                        <div class="kt-wizard-v1__nav-icon">
                                                            <i class="flaticon2-add"></i>
                                                        </div>
                                                        <div class="kt-wizard-v1__nav-label">
                                                            1. انتخاب مقدار ارز
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__nav-item wizard_step2" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v1__nav-body">
                                                        <div class="kt-wizard-v1__nav-icon">
                                                            <i class="flaticon2-list-3"></i>
                                                        </div>
                                                        <div class="kt-wizard-v1__nav-label">
                                                            2. واریز مبلغ
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kt-wizard-v1__nav-item wizard_step3" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v1__nav-body">
                                                        <div class="kt-wizard-v1__nav-icon">
                                                            <i class="flaticon-list"></i>
                                                        </div>
                                                        <div class="kt-wizard-v1__nav-label">
                                                            3. تایید تراکنش
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Nav -->
                                    </div>
                                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">

                                        <!--begin: Form Wizard Form-->

                                        <!--begin: Form Wizard Step 1-->
                                        <div class="kt-wizard-v1__content wizard_content1" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                            <div class="kt-heading kt-heading--md">
                                                <div class="alert alert-dark" role="alert">
                                                    <div class="alert-text">مبلغی را که میخواهید به اعتبار خودتان اضافه کنید را وارد کنید</div>
                                                </div>
                                            </div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v1__form">
                                                    <div class="kt-portlet__body">
                                                        <form class="kt-new-form1" method="post">
                                                            <div class="col-md-12 form-group">
                                                                <label>مبلغ : </label>
                                                                <input type="number" class="form-control" name="mablagh" placeholder="مبلغ مورد نظر خود را وارد کنید" autocomplete="off">
                                                                <span class="form-text text-muted">تعداد دوج کوینی که قصد سپرده گذاری آن را دارید را وارد نمایید</span>
                                                            </div>
                                                            <input class="hidden" type="hidden" name="final_mablagh">
                                                        </form>
                                                    </div>

                                                    <div class="kt-portlet__foot">
                                                        <div class="p30web-ok">
                                                            <button type="submit" id="amount_send" class="btn btn-primary">مرحله بعدی</button>
                                                            <a href="taxid_payment.php" class="btn btn-brand">پرداخت با taxid</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Step 1-->

                                        <!--begin: Form Wizard Step 2-->
                                        <div class="kt-wizard-v1__content wizard_content2" data-ktwizard-type="step-content">
                                            <div class="kt-heading kt-heading--md">
                                                <div class="alert alert-danger" role="alert">
                                                    <div class="alert-text">لطفا تعداد دوج کوین محاسبه شده را با تمامی اعداد اعشاری آن و با دقت واریز نمایید در غیر این صورت واریز شما تایید نخواهد شد</div>
                                                </div>
                                            </div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v1__form">
                                                    <div class="kt-portlet__body">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 order-lg-1 order-xl-1">
                                                                <div class="box-p30web">
                                                                    <div class="kt-portlet__head">
                                                                        <div class="kt-portlet__head-label">
                                                                            <h3 class="kt-portlet__head-title">1) آدرس کیف پول ایران دوج</h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="wallet_address">
                                                                            <img src="https://dogechain.info/api/v1/address/qrcode/9tiYCRCeWFhoYaKSsoW2fNMrGpPeiq28BZ">
                                                                            <p>
                                                                            </p>
                                                                            <h3><a id="wallet_add">9tiYCRCeWFhoYaKSsoW2fNMrGpPeiq28BZ</a><button type="button" data-clipboard="true" data-clipboard-target="#wallet_add" class="btn btn-info btn-icon btn-circle"><i class="flaticon2-copy"></i></button></h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 order-lg-1 order-xl-1">
                                                                <div class="box-p30web">
                                                                    <div class="kt-portlet__head">
                                                                        <div class="kt-portlet__head-label">
                                                                            <h3 class="kt-portlet__head-title">2) تعداد دوج کوین محاسبه شده</h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="kt-portlet__body">
                                                                        <div class="form-group form-group-last">
                                                                            <div class="alert alert-secondary" role="alert">
                                                                                <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                                                                <div class="alert-text">
                                                                                    شما باید این مقدار ارز را به آدرس کیف پول سایت واریز کرده و شناسه واریز را دریافت نمایید و در مرحله بعدی وارد نمایید تا تراکنش تایید شود.</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="alert alert-outline-dark fade show" role="alert">
                                                                            <div class="alert-text">
                                                                                <a id="amount_get">1000.00192</a>
                                                                                <button type="button" data-clipboard="true" data-clipboard-target="#amount_get" class="btn btn-info btn-icon">
                                                                                    <i class="flaticon2-copy"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="kt-portlet__foot">
                                                        <div class="p30web-ok2">
                                                            <button type="submit" id="vrify_payment" class="btn btn-primary">مبلغ را واریز کردم، مرحله بعد</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Step 2-->

                                        <!--begin: Form Wizard Step 3-->
                                        <div class="kt-wizard-v1__content wizard_content3" data-ktwizard-type="step-content">
                                            <div class="kt-heading kt-heading--md">
                                                <div class="alert alert-primary" role="alert">
                                                    <div class="alert-text">کد تراکنش (TXID) را در زیر وارد نمایید و منتظر تایید باشید</div>
                                                </div>
                                            </div>
                                            <div class="kt-form__section kt-form__section--first">
                                                <div class="kt-wizard-v1__review">
                                                    <div class="kt-portlet__body">
                                                        <div class="p30web-box-final">
                                                            <form class="final_submit" method="post">
                                                                <div class="form-group">
                                                                    <label>کد تراکنش (TXID): </label>
                                                                    <input type="text" class="form-control" name="taxid" placeholder="کدتراکنش" autocomplete="off">
                                                                    <span class="form-text text-muted">کد تراکنش را در باکس بالا وارد کنید</span>
                                                                    <input class="hidden" type="hidden" name="token">
                                                                </div>
                                                            </form>
                                                        </div>


                                                        <div class="modal fade" id="transactionmodal" tabindex="-1" role="dialog" aria-labelledby="نمایش جزئیات تراکنش" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">نمایش جزئیات تراکنش</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="kt-portlet__foot">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Step 3-->

                                        <!--begin: Form Actions -->
                                        <!--                                            <div class="kt-form__actions">-->
                                        <!--                                                <button class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">-->
                                        <!--                                                    مرحله قبلی-->
                                        <!--                                                </button>-->
                                        <!--                                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">-->
                                        <!--                                                   ثبت اطلاعات-->
                                        <!--                                                </button>-->
                                        <!--                                                <button class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">-->
                                        <!--                                                    مرحله بعدی-->
                                        <!--                                                </button>-->
                                        <!--                                            </div>-->

                                        <!--end: Form Actions -->


                                        <!--end: Form Wizard Form-->
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
                                                        }, 30000);
                                                    }
                                                },
                                                error: function (xhr, ajaxOptions, thrownError) {
                                                    setTimeout(function () {
                                                        e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", "درخواست با خطا مواجه شده است")
                                                    }, 30000);
                                                }
                                            }))
                                    }, 30000);

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
                                                    }, 30000);
                                                }
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                setTimeout(function () {
                                                    get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(get_vrifyform, "danger", "درخواست با خطا مواجه شده است")
                                                }, 30000);
                                            }
                                        });
                                    }, 30000);

                                } else if(r.responseJSON.action === "show_details"){
                                    get_vrifyform.find(".alert").remove();
                                    $('.modal-body').html(r.responseJSON.data);
                                    $('#transactionmodal').modal('show');

                                }


                                else {
                                    get_this.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                                }

                            }, 5000);
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