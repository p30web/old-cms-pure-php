<?php

include("checklogin.php");
require_once('includes/classes/Validation.php');

$fetch_admin = $db->get("admin_login");

if(in_array($_SESSION['member_id'],array(98,24)) && !is_null($fetch_admin) && count($fetch_admin[0]) != 0){
    $db->where("id", $fetch_admin[0]['admin_id']);
    $fetch_member = $db->getOne("members");
}else{
    exit("این بخش فقط برای مدیران سایت می باشد.");
}



$db->where("id", 2);
$fetch_wallets = $db->getOne("wallets");

?>
<!DOCTYPE html>

<html lang="fa" direction="rtl" style="direction: rtl;">
<!-- begin::Head -->

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ایران دوج | افزایش موجودی حساب</title>
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
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 order-lg-1 order-xl-1">
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                اطلاعات پرداخت
                                            </h3>
                                        </div>
                                    </div>
                                    <!--begin::Form-->
                                    <form class="kt-form" id="form_deposit" method="post">
                                        <div class="kt-portlet__body">
                                            <!--                                            <div class="kt-section kt-section--first">-->
                                            <!--                                                <div class="col-md-6 form-group">-->
                                            <!--                                                    <label>مبلغ پرداختی:</label>-->
                                            <!--                                                    <input type="text" name="amount" class="form-control"-->
                                            <!--                                                           placeholder="مبلغ را وارد کنید" autocomplete="off">-->
                                            <!--                                                </div>-->
                                            <!---->
                                            <!--                                            </div>-->
                                            <div class="kt-heading kt-heading--md" style="margin-top: 0;margin-bottom: 7px;">
                                                <div class="alert alert-danger" role="alert">
                                                    <div class="alert-text">اگر درهنگام افزایش موجودی به هر دلیلی با مشکل مواجه شده اید، و مبلغ پرداختی سایت را به کیف پول سایت واریز کرده اید اما موفق به ثبت taxid نشده اید میتوانید از این بخش استفاده نمایید</div>
                                                </div>
                                            </div>
                                            <div class="kt-section kt-section--last">
                                                <div class="col-md-12 form-group">
                                                    <label>کد تراکنش (TXID):</label>
                                                    <input type="text" name="txid" class="form-control"
                                                           placeholder="کد تراکنش"  autocomplete="off">
                                                    <span class="form-text text-muted">کد تراکنش را وارد کنید</span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <button type="submit" id="deposit_submit" class="btn btn-primary">ثبت و ارسال</button>
                                            </div>
                                        </div>

                                    </form>
                                    <!--end::Form-->

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
                            
                            <!--- sdsds -->
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
            }),
            n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                n.ajaxSubmit({
                    url: "api/paytaxid.php",
                    method: "POST",
                    success: function (t, s, r, a) {

                        if (r.status === 200) {
                            i(n, r.responseJSON.type, r.responseJSON.message);
                            setTimeout(function () {
                                if(r.responseJSON.action === "show_details"){
                                    n.find(".alert").remove();
                                    $('.modal-body').html(r.responseJSON.data);
                                    $('#transactionmodal').modal('show');
                                    e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)
                                }
                                if(r.responseJSON.action === "interval"){

                                    var aint = setInterval(function () {
                                        n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0),
                                            n.ajaxSubmit({
                                                url: "api/paytaxid.php",
                                                method: "POST",
                                                success: function (t, s, r, a) {

                                                    if (r.status === 200) {
                                                        i(n, r.responseJSON.type, r.responseJSON.message);
                                                        setTimeout(function () {
                                                            if(r.responseJSON.action === "show_details"){
                                                                n.find(".alert").remove();
                                                                $('.modal-body').html(r.responseJSON.data);
                                                                $('#transactionmodal').modal('show');
                                                            }
                                                            e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1)

                                                            if(r.responseJSON.action !== "interval"){
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

                                }else{
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

    });
</script>

<!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>