$(document).ready(function () {
    if ($(".bbb_deals_slider").length) {
        var e = $(".bbb_deals_slider");
        e.owlCarousel({
            items: 1,
            loop: !1,
            navClass: ["bbb_deals_slider_prev", "bbb_deals_slider_next"],
            nav: !1,
            dots: !1,
            smartSpeed: 1200,
            margin: 30,
            autoplay: !1,
            autoplayTimeout: 5e3,
        }),
            $(".bbb_deals_slider_prev").length &&
                $(".bbb_deals_slider_prev").on("click", function () {
                    e.trigger("prev.owl.carousel");
                }),
            $(".bbb_deals_slider_next").length &&
                $(".bbb_deals_slider_next").on("click", function () {
                    e.trigger("next.owl.carousel");
                });
    }

    $("#back-btn").on("click", () => {
        window.history.back();
    });
    
});
