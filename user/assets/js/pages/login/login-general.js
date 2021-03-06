"use strict";
var KTLoginGeneral = function () {
    var t = $("#kt_login"), i = function (t, i, e) {
        var n = $('<div class="kt-alert kt-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
        t.find(".alert").remove(), n.prependTo(t), KTUtil.animateClass(n[0], "fadeIn animated"), n.find("span").html(e)
    }, e = function () {
        t.removeClass("kt-login--forgot"), t.removeClass("kt-login--resetpass"), t.removeClass("kt-login--active"), t.removeClass("kt-login--signup"), t.addClass("kt-login--signin"), KTUtil.animateClass(t.find(".kt-login__signin")[0], "flipInX animated")
    }, n = function () {
        $("#kt_login_forgot").click(function (i) {
            i.preventDefault(), t.removeClass("kt-login--signin"), t.removeClass("kt-login--signup"), t.addClass("kt-login--forgot"), KTUtil.animateClass(t.find(".kt-login__forgot")[0], "flipInX animated")
        }), $("#kt_login_forgot_cancel").click(function (t) {
            t.preventDefault(), e()
        }), $("#kt_login_signup").click(function (i) {
            i.preventDefault(), t.removeClass("kt-login--forgot"), t.removeClass("kt-login--signin"), t.addClass("kt-login--signup"), KTUtil.animateClass(t.find(".kt-login__signup")[0], "flipInX animated")
        }), $("#kt_login_signup_cancel").click(function (t) {
            t.preventDefault(), e()
        }), $("#kt_login_active_cancel").click(function (t) {
            t.preventDefault(), e()
        }), $("#kt_login_resetpass_cancel").click(function (t) {
            t.preventDefault(), e()
        })
        //     , $("#kt_login_resetpass_submit").click(function (t) {
        //     t.preventDefault(), e()
        // })
    };
    return {
        init: function () {
            n(), $("#kt_login_signin_submit").click(function (t) {
                t.preventDefault();
                var e = $(this), n = $(this).closest("form");
                n.validate({
                    rules: {
                        email: {required: !0, email: !0},
                        password: {required: !0}
                    }
                }), n.valid() && (e.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), n.ajaxSubmit({
                    url: "api/login.php",
                    method: "POST",
                    success: function (t, s, r, a) {

                        if(r.status === 200){
                            if(r.responseJSON.two_step === 'on'){
                                i(n, r.responseJSON.type, r.responseJSON.message);
                                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1),
                                    setTimeout(function () {
                                        $('.user-box').html(( r.responseJSON.data.image != null ) ?  '<span class="kt-userpic kt-userpic--circle"><img src="../Attachment/img/members/'+r.responseJSON.data.image+' " alt="image"></span><h2>'+ r.responseJSON.data.email+'</h2>': '<span class="kt-userpic kt-userpic--circle kt-userpic--danger"><span>'+r.responseJSON.data.email.substring(0, 2)+'</span></span><h2>'+ r.responseJSON.data.email+'</h2>');
                                        $('.login__active--form').append('<input name="email" type="hidden" value="'+r.responseJSON.data.email+'" >');
                                        $('.login__active--form').append('<input name="action" type="hidden" value="two_step" >');
                                        /* grecaptcha.ready(function () {
                                            grecaptcha.execute('6LfEgMYUAAAAAAT7JsA-6lgFgo9IWdGRkWdd5tSn', {action: 'login'})
                                                .then(function (token) {
                                                    $('.login__active--form').append('<input name="ac-recaptcha-response" id="ac-recaptcha-response" type="hidden" value="'+token+'" >');
                                                });
                                        }); */
                                        var m = $("#kt_login"), ii = function (t, i, e) {
                                            var n = $('<div class="kt-alert kt-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
                                            t.find(".alert").remove(), n.prependTo(t), KTUtil.animateClass(n[0], "fadeIn animated"), n.find("span").html(e)
                                        };
                                        m.removeClass("kt-login--signin"), m.removeClass("kt-login--signup"), m.addClass("kt-login--active"), KTUtil.animateClass(m.find(".kt-login__active")[0], "flipInX animated");
                                        n.find(".alert").remove();
                                    }, 2e3);
                            }else if (r.responseJSON.two_step === 'off') {
                                i(n, r.responseJSON.type, r.responseJSON.message);
                                setTimeout(function () {
                                    // localStorage.setItem('_data', JSON.stringify(r.data));
                                    e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), window.location='index.php'
                                }, 2e3);
                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        if(xhr.status === 404){
                            setTimeout(function () {
                                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        }else{
                            setTimeout(function () {
                                e.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(n, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        }
                    }
                }))
            }), $("#kt_login_signup_submit").click(function (n) {
                n.preventDefault();
                var s = $(this), r = $(this).closest("form");
                var actionref = getUrlParameter('ref');
                if(actionref != ""){
                    $('input[name="ref"]').val(actionref);
                }
                r.validate({
                    rules: {
                        firstname: {required: !0},
                        lastname: {required: !0},
                        email: {required: !0, email: !0},
                        password: {required: !0},
                        rpassword: {required: !0, equalTo: "#password"},
                        agree: {required: !0}
                    }
                }), r.valid() && (s.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), r.ajaxSubmit({
                    url: "api/register.php",
                    method: "POST",
                    success: function (t, ss, re, a) {
                        // console.log(t);
                        // console.log(ss);
                        // console.log(re);
                        // console.log(a);
                        if(re.status === 200){
                            i(r, re.responseJSON.type, re.responseJSON.message);
                            setTimeout(function () {
                                // localStorage.setItem('_data', JSON.stringify(re.data));
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), window.location='index.php'
                            }, 2e3);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        if (xhr.status === 404) {
                            setTimeout(function () {
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        } else {
                            setTimeout(function () {
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        }
                    }
                }))
            }),

                $("#kt_login_resetpass_submit").click(function (n) {
                    n.preventDefault();
                    var s = $(this), r = $(this).closest("form");
                    var verfycode = getUrlParameter('verfycode');

                    if(verfycode == null){
                        $(".kt-form").html("<div class=\"kt-alert kt-alert--outline alert alert-danger alert-dismissible\" role=\"alert\">\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"></button>\t\t\t<span>???????? ?????????????? ?????? ???????? ???????? ?????? ????????.</span>\t\t</div>")
                    }

                    if(verfycode == ""){
                        $(".kt-form").html("<div class=\"kt-alert kt-alert--outline alert alert-danger alert-dismissible\" role=\"alert\">\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"></button>\t\t\t<span>???????? ?????????????? ?????? ???????? ???????? ?????? ????????.</span>\t\t</div>")
                    }else {
                        $('input[name="verfycode"]').val(verfycode);
                    }

                    r.validate({
                        rules: {
                            verfycode: {required: !0},
                            newpass: {required: !0},
                            confrimnewpass: {required: !0, equalTo: "#newpass"},
                        }
                    }), r.valid() && (s.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), r.ajaxSubmit({

                        url: "api/change_pass_email.php",
                        method: "POST",
                        success: function (m1, a, l, o) {
                            if(l.status === 200){

                                if(l.responseJSON.status === 404){
                                    i(r, "danger", l.responseJSON.message);
                                    s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1);
                                }else {
                                    setTimeout(function () {
                                        // localStorage.setItem('_data', JSON.stringify(re.data));

                                        s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), e();
                                        var n = t.find(".kt-login__signin form");
                                        n.clearForm(), n.validate().resetForm(), i(n, "success", "?????????????? ?????? ???? ???????????? ???????? ?????????? ?????? ???? ?????????? ???????????????? ???????? ????????")


                                    }, 2e3);
                                }

                            }
                        },

                        error: function (xhr, ajaxOptions, thrownError) {
                            if (xhr.status === 404) {
                                setTimeout(function () {
                                    s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                                }, 2e3);
                            } else {
                                setTimeout(function () {
                                    s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                                }, 2e3);
                            }
                        }

                    }))
                }),


                $("#kt_login_forgot_submit").click(function (n) {
                n.preventDefault();
                var s = $(this), r = $(this).closest("form");
                var verfycode = getUrlParameter('verfycode');
                if(verfycode != ""){
                    $('input[name="verfycode"]').val(verfycode);
                }
                r.validate({
                    rules: {
                        email: {required: !0, email: !0},
                    }
                }), r.valid() && (s.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), r.ajaxSubmit({

                    url: "api/reset_pass.php",
                    method: "POST",
                    success: function (m1, a, l, o) {
                         //console.log(n);
                         //console.log(a);
                         //console.log(l);
                         ///console.log(o);
                        if(l.status === 200){

                            if(l.responseJSON.status === 404){
                                i(r, "danger", l.responseJSON.message);
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1);
                            }else {
                                setTimeout(function () {
                                    // localStorage.setItem('_data', JSON.stringify(re.data));

                                    s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), e();
                                    var n = t.find(".kt-login__signin form");
                                    n.clearForm(), n.validate().resetForm(), i(n, "success", "?????????? ???????????????? ?????? ???????? ???????? ?????? ?????????? ?????? ?????????? ?????? ???? ???? ????????????")


                                }, 2e3);
                            }

                        }
                    },

                    error: function (xhr, ajaxOptions, thrownError) {
                        // console.log(xhr);
                        // console.log(ajaxOptions);
                        // console.log(thrownError);
                        if (xhr.status === 404) {
                            setTimeout(function () {
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        } else {
                            setTimeout(function () {
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        }
                    }

                }))
            }), $("#kt_login_active_submit").click(function (n) {
                n.preventDefault();
                var s = $(this), r = $(this).closest("form");
                r.validate({
                    rules: {
                        email: {
                            required: !0,
                            email: !0
                        },
                        activation_code: {required: true}
                    }
                }), r.valid() && (s.addClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !0), r.ajaxSubmit({
                    url: "api/two_step_login.php",
                    method: "POST",
                    success: function (n, a, l, o) {
                        if(l.status === 200){
                            i(r, l.responseJSON.type, l.responseJSON.message);
                            setTimeout(function () {
                                // localStorage.setItem('_data', JSON.stringify(r.data));
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), window.location='index.php'
                            }, 2e3);
                        }
                    }, error: function (xhr, ajaxOptions, thrownError) {
                        if(xhr.status === 404){
                            setTimeout(function () {
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        }else{
                            setTimeout(function () {
                                s.removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").attr("disabled", !1), i(r, "danger", xhr.responseJSON.message)
                            }, 2e3);
                        }
                    }
                }))
            })
        }
    }
}();
jQuery(document).ready(function () {
    KTLoginGeneral.init()
});