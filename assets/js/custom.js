(function ($) {
    "use strict";

    $(document).ready(function () {

        /*---------------------------------------------------
            testimonial
        ----------------------------------------------------*/
        $('.client-single').on('click', function (event) {
            event.preventDefault();

            var active = $(this).hasClass('active');

            var parent = $(this).parents('.testi-wrap');

            if (!active) {
                var activeBlock = parent.find('.client-single.active');

                var currentPos = $(this).attr('data-position');

                var newPos = activeBlock.attr('data-position');

                activeBlock.removeClass('active').removeClass(newPos).addClass('inactive').addClass(currentPos);
                activeBlock.attr('data-position', currentPos);

                $(this).addClass('active').removeClass('inactive').removeClass(currentPos).addClass(newPos);
                $(this).attr('data-position', newPos);

            }
        });

        /*---------------------------------------------------
            pricing table
        ----------------------------------------------------*/
        var monthly_price_table = $('#pricing-wrap').find('.monthly');
        var yearly_price_table = $('#pricing-wrap').find('.yearly');

        $('.switch-toggles').find('.monthly').addClass('active');
        $('#pricing-wrap').find('.monthly').addClass('active');

        $('.switch-toggles').find('.monthly').on('click', function () {
            $(this).addClass('active');
            $(this).closest('.switch-toggles').removeClass('active');
            $(this).siblings().removeClass('active');
            monthly_price_table.addClass('active');
            yearly_price_table.removeClass('active');
        });

        $('.switch-toggles').find('.yearly').on('click', function () {
            $(this).addClass('active');
            $(this).closest('.switch-toggles').addClass('active');
            $(this).siblings().removeClass('active');
            yearly_price_table.addClass('active');
            monthly_price_table.removeClass('active');
        });

        /*---------------------------------------------------
            awesome feature carousel
        ----------------------------------------------------*/
        function a(e) {
            $featureLinks.removeClass("active"), e.addClass("active")
        }
        var $owlFeatures = $(".awesome-feat-carousel"),
            $featureLinks = $(".feature-link");
        $owlFeatures.owlCarousel({
                loop: !0,
                responsiveClass: !0,
                margin: 30,
                nav: true,
                dots: !1,
                navText: ['<i class="icon-left-arrow"></i>', '<i class="icon-arrow-pointing-to-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    991: {
                        items: 2
                    },
                    1200: {
                        items: 2
                    },
                    1920: {
                        items: 3
                    }
                }
            }),
            $owlFeatures.on("changed.owl.carousel", function (e) {
                var o = e.item.index + 1 - e.relatedTarget._clones.length / 2,
                    n = e.item.count;
                (o > n || 0 == o) && (o = n - o % n), o--;
                var t = $(".feature-link:nth(" + o + ")");
                a(t)
            }),
            $featureLinks.on("click", function () {
                var e = $(this).data("owl-item");
                $owlFeatures.trigger("to.owl.carousel", e), a($(this))
            });

        /*---------------------------------------------------
            screen carousel
        ----------------------------------------------------*/
        $('.screen-carousel').owlCarousel({
            loop: true,
            navText: ['<i class="icon-left-arrow"></i>', '<i class="icon-arrow-pointing-to-right"></i>'],
            nav: true,
            autoplay: true,
            dots: false,
            autoplayTimeout: 5000,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            smartSpeed: 450,
            margin: 30,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                },
                991: {
                    items: 3
                },
                1200: {
                    items: 3
                },
                1920: {
                    items: 4
                }
            }
        });

        /*---------------------------------------------------
            counter
        ----------------------------------------------------*/
        $('.counter-single h2').counterUp({
            delay: 10, // the delay time in ms
            time: 1000 // the speed time in ms
        });

        /*---------------------------------------------------
                magnific popUp
        ----------------------------------------------------*/

        $('.popup-video').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: true,
            fixedContentPos: false,
            disableOn: 300
        });

        /*---------------------------------------------------
            scrollIt plugin activation
        ----------------------------------------------------*/
        $.scrollIt();

    });

    /*---------------------------------------------------
        sticky header
    ----------------------------------------------------*/
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll < 100) {
            $("#header").removeClass("sticky");
        } else {
            $("#header").addClass("sticky");
        }
    });

    /*---------------------------------------------------
        accordian
    ----------------------------------------------------*/
    $('.collapse').on('shown.bs.collapse', function () {
        $(this).prev().addClass('active');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        $(this).prev().removeClass('active');
    });

    /*---------------------------------------------------
        preloader
    ----------------------------------------------------*/
    $(window).on('load', function () {
        $('.preloader').fadeOut(500);
    });


}(jQuery));
