/* =================================
------------------------------------
	EndGam - Gaming Magazine Template
	Version: 1.0
 ------------------------------------
 ====================================*/


'use strict';


$(window).on('load', function() {
	/*------------------
		Preloder
	--------------------*/
	$(".loader").fadeOut();
	$("#preloder").delay(400).fadeOut("slow");

});

(function($) {

    $(document).ready(function() {
        $("#content-slider").lightSlider({
            loop:true,
            keyPress:true
        });
        $('#image-gallery').lightSlider({
            gallery:true,
            item:1,
            thumbItem:9,
            slideMargin: 0,
            speed:500,
            auto:false,
            loop:true,
            onSliderLoad: function() {
                $('#image-gallery').removeClass('cS-hidden');
            }
        });
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            let ele = $(this);
            let prodId = $('.remove-from-cart').attr('data-id');
            let csrf = $('meta[name="_token"]').attr('content');

            console.log(csrf);

            $.ajax({
                url: '/remove-from-cart/',
                method: "DELETE",
                data: {
                    _token: csrf,
                    id: prodId
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });
    });

	/*------------------
		Navigation
	--------------------*/
	$('.primary-menu').slicknav({
		appendTo:'.header-warp',
		closedSymbol: '<i class="fa fa-angle-down"></i>',
		openedSymbol: '<i class="fa fa-angle-up"></i>'
	});


	/*------------------
		Background Set
	--------------------*/
	$('.set-bg').each(function() {
		var bg = $(this).data('setbg');
		$(this).css('background-image', 'url(' + bg + ')');
	});



	/*------------------
		Hero Slider
	--------------------*/
	$('.hero-slider').owlCarousel({
		loop: true,
		nav: true,
		dots: true,
		navText: ['', ''],
		mouseDrag: false,
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		items: 1,
		autoplay: true,
		autoplayTimeout: 10000,
	});

	var dot = $('.hero-slider .owl-dot');
	dot.each(function() {
		var index = $(this).index() + 1;
		if(index < 10){
			$(this).html('0').append(index + '.');
		}else{
			$(this).html(index + '.');
		}
	});



	/*------------------
		Video Popup
	--------------------*/
	$('.video-popup').magnificPopup({
  		type: 'iframe'
	});

	$('#stickySidebar').stickySidebar({
	    topSpacing: 60,
	    bottomSpacing: 60
	});

    var $L = 1200,
        $menu_navigation = $('#main-nav'),
        $cart_trigger = $('.tg-cart-trigger'),
        $hamburger_icon = $('#tg-hamburger-menu'),
        $lateral_cart = $('#tg-cart'),
        $shadow_layer = $('#tg-shadow-layer');

    $cart_trigger.on('click', function(event){
        event.preventDefault();
        //close lateral menu (if it's open)
        $menu_navigation.removeClass('speed-in');
        toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
    });

    $shadow_layer.on('click', function(){
        $shadow_layer.removeClass('is-visible');
        // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
        if( $lateral_cart.hasClass('speed-in') ) {
            $lateral_cart.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
                $('body').removeClass('overflow-hidden');
            });
            $menu_navigation.removeClass('speed-in');
        } else {
            $menu_navigation.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
                $('body').removeClass('overflow-hidden');
            });
            $lateral_cart.removeClass('speed-in');
        }
    });

    $(document).ready(function () {
        var previousActiveTabIndex = 0;

        $(".tab-switcher").on('click keypress', function (event) {
            // event.which === 13 means the "Enter" key is pressed

            if ((event.type === "keypress" && event.which === 13) || event.type === "click") {

                var tabClicked = $(this).data("tab-index");
                $(this).addClass("tab-switcher-active");
                $('.tab-switcher').not(this).removeClass('tab-switcher-active');

                if(tabClicked != previousActiveTabIndex) {
                    $("#allTabsContainer .tab-container").each(function () {
                        if($(this).data("tab-index") == tabClicked) {
                            $(".tab-container").hide();
                            $(this).show();
                            previousActiveTabIndex = $(this).data("tab-index");
                            return;
                        }
                    });
                }
            }
        });
    });

    $('li.menu').on('click', function() {
        $('#mySidenav').toggle();
    });

    $('#mobile-toggle').on('click', function() {
        $('#mySidenav').toggle();
    });

    $('.closeMenuBtn').on('click', function() {
        $('#mySidenav').hide();
    });

    $(document).ready(function(){
        $(".searchBtn").click(function(e){
            e.preventDefault();
            $("#searchModal").modal();
        });
    });

    $("#site-search").keyup(function() {
        let searchLength = $("#site-search").val().length;
        let searchVal = $("#site-search").val();

        let prevSearchVal = "";
        let rootUrl = window.location.origin;
        let url = rootUrl + "/autocomplete/?query=" + searchVal;

        if(searchLength >= 3) {
            if(searchVal != prevSearchVal) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function (data) {
                        $("#search-results").html(`
                                <p class="search-text">Produktförslag</p>
                        `);
                        $.each(data, function(index) {
                            $("#search-results").append(`
                            <div class="card mb-2">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <img src="` + data[index].image + `" class="img-fluid" alt="">
                                    </div>
                                    <div class="col pt-3">
                                        <a href="/product/` + data[index].slug + `">
                                            <div class="card-block px-2">
                                                <h6 class="card-title">` + data[index].name + `</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            `);
                        });
                        $.each(data, function(index) {
                            if(data[index].item_count > 5) {
                                $("#search-show-more").show();
                            } else {
                                $("#search-show-more").hide();
                            }
                        });
                    }
                });
            }
            prevSearchVal = searchVal;
        }
    });

    $('.dropbtn').on('click', function() {
        $('.dropdown-content').toggle();
    });

    $('.parentMenuOpen').on('click', function(e) {
        e.preventDefault();
        $('.parentMenuOpen span').toggleClass('fa-plus').toggleClass('fa-minus');

        let id = $(this).attr('data-id');
        $('.'+ id).toggle();
    });

})(jQuery);

function toggle_panel_visibility ($lateral_panel, $background_layer, $body) {
    if( $lateral_panel.hasClass('speed-in') ) {
        // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
        $lateral_panel.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
            $body.removeClass('overflow-hidden');
        });
        $background_layer.removeClass('is-visible');

    } else {
        $lateral_panel.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
            $body.addClass('overflow-hidden');
        });
        $background_layer.addClass('is-visible');
    }
}

/*var countDownDate = new Date("May 5, 2023 23:00:00").getTime();
var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("tg-countdown").innerHTML = "Sidan öppnar om <br/>" + hours + " timmar, "
        + minutes + " min & " + seconds + " sek";

    // If the count down is over, write some text
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 1000);*/
