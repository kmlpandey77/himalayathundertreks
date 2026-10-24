$(function () {
    "use strict"; // Start of use strict

    const observer = lozad('img');
    observer.observe();

    const lozimage = lozad('.image');
    lozimage.observe();

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip()
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        onSelect: function (date) {

            var selectedDate = new Date(date);
            var msecsInADay = 86400000;
            var endDate = new Date(selectedDate.getTime() + msecsInADay);

            $(".deparute_date").datepicker("option", "minDate", endDate);
        }
    });

    $(".deparute_date").datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: 0,
    });

    $(document).on('click', '#search-btn > li > a', function () {
        $('#searchModal').modal('show');
    })

    //destination
    $(".dest-box").hover(function () {
        $(this).find('.text').addClass('dark').stop().animate({ 'padding-top': '50px' }, 1000);
    }, function () {
        $(this).find('.text').removeClass('dark').stop().animate({ 'padding-top': '230px' }, 1000);
    });

    //page sidebar
    $(".pagesidebar > .box").hover(function () {
        $(this).find('.text').stop(true, true).show("slide", { direction: "left" }, 1000);
    }, function () {
        $(this).find('.text').stop(true, true).hide("slide", { direction: "left" }, 1000);
    });

    // $('#inquiryModal').modal('show');
    $(document).on('click', '.pagesidebar > .sendinquiry > a', function () {
        $('#inquiryModal').modal('show');
    })

    // Smooth scrolling using jQuery easing in Packages
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
        if (
            location.pathname.replace(/^\//, "") ==
            this.pathname.replace(/^\//, "") &&
            location.hostname == this.hostname
        ) {
            var target = $(this.hash);
            target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");
            if (target.length) {
                $("html, body").animate(
                    {
                        scrollTop: target.offset().top - $('#main-menu').height() - $('#trip-nav').height()
                    },
                    1000,
                    "easeInOutExpo"
                );
                return false;
            }
        }
    });

    // Closes responsive menu when a scroll trigger link is clicked
    $(".js-scroll-trigger").click(function () {
        $(".navbar-collapse").collapse("hide");
    });

    // Activate scrollspy to add active class to navbar items on scroll
    $("body").scrollspy({
        target: "#trip-nav",
        offset: 160
    });
    $(window).on("activate.bs.scrollspy", function (e, obj) {
        $(".trip_nav_text").html(
            obj.relatedTarget
                .replace("#", "")
                .replace("_", " ")
                .replace("-", " ")
                .replace(/(?:^|\s)\w/g, function (match) {
                    return match.toUpperCase();
                })
        );
    });

    $(".expand-itinerary-all").on("click", function (e) {
        $("#itineray_accordion .collapse").collapse("show");
        $(this).hide();
        $(".collapse-itinerary-all").show();
    });
    $(".collapse-itinerary-all").on("click", function (e) {
        $("#itineray_accordion .collapse").collapse("hide");
        $(this).hide();
        $(".expand-itinerary-all").show();
    });

    //backtotop
    var _height = 3;
    $("#backtotop").css("bottom", $("#_f_menu").outerHeight() - _height);
    $(window).scroll(function () {
        var topPos = $(this).scrollTop();
        // console.log(topPos);
        if (topPos > 800) {
            $("#backtotop").show();
        } else {
            $("#backtotop").hide();
        }
    });
    $("#backtotop").click(function () {
        $("html, body").animate({
            scrollTop: 0
        },
            800
        );
        return false;
    });

}); // End of use strict


(function () {
    "use strict";
    window.addEventListener(
        "load",
        function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName("needs-validation");
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener(
                    "submit",
                    function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        },
        false
    );
});

$(document).on('click', '.js-modal-call', function (e) {
    e.preventDefault();
    $('#js-modal').modal('show');
    url = $(this).attr('href');
    $.ajax(url, {
        type: 'get',
        start: $('#js-modal').find('.modal-content').LoadingOverlay('show'),
        dataType: 'html',
        success: function (data) {
            $('#js-modal').find('.modal-content').html(data);
            $('#js-modal').find('.modal-content').LoadingOverlay('hide');
        }
    })
});

$("#reviews_box").owlCarousel({
    loop: false,
    rewind: true,
    nav: false,
    items: 1,
    dots: true,
    autoplay: true,
    addClassActive: true,
    responsive: {
      // breakpoint from 0 up
      0: {
        items: 1
      },
      // breakpoint from 768 up
      768: {
        items: 1
      }
    }
  });



////

$(document).ready(function () {
    owl = $("#homeslide").owlCarousel({
        loop: false,
        rewind: true,
        nav: false,
        items: 1,
        dots: false,
        autoplay: true,
        addClassActive: true,
    });
    owl.on('changed.owl.carousel', function (event) {
        var item = event.item.index - 2; // Position of the current item
        $('.caption').removeClass('animated slideInUp');
        $('.owl-item').not('.cloned').eq(item).find('.caption').addClass('animated slideInUp');
    });
});

$(document).ready(function () {
    owl = $(".testimonial-slide").owlCarousel({
        loop: false,
        rewind: true,
        nav: false,
        items: 3,
        dots: false,
        autoplay: true,
        addClassActive: true,
        responsive : {
            // breakpoint from 0 up
            0 : {
                items : 1,
            },
            // breakpoint from 768 up
            768 : {
                items : 3,
            }
        }
    });
});


$(document).ready(function () {
    // $('#tellafriendModal').modal('show');
    $("#innerslide").owlCarousel({
        loop: false,
        rewind: true,
        nav:true,
        navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
        ],
        items: 1,
        dots: false,
        autoplay: true,
    });

    var tl = $(".trip-left").outerHeight();
    var tr = $(".trip-right").outerHeight();
    if(tl>tr){
        $(".trip-right").css('min-height', tl);
    }


});