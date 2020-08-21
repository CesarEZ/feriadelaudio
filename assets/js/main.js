(function($){	"use strict";

	var window_width 	 = $(window).width(),
	window_height 		 = window.innerHeight,
	header_height 		 = $(".default-header").height(),
	header_height_static = $(".site-header.static").outerHeight(),
	fitscreen 			 = window_height - header_height;

	$(".fullscreen").css("height", window_height)
	$(".fitscreen").css("height", fitscreen); 

    $('.img-pop-up').magnificPopup({
        type: 'image',
        gallery:{
            enabled:true
        }
    });

    $('.play-btn').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
    
    /* Testimonials
    ========================================================================== */
    $("#testimonial-slider").owlCarousel({
        items:1,
        itemsDesktop:[1000,1],
        itemsDesktopSmall:[979,1],
        itemsTablet:[768,1],
        pagination:true,
        navigation:false,
        navigationText:["",""],
        slideSpeed:1000,
        singleItem:true,
        transitionStyle:"fade",
        autoPlay:true
    });

    /* 
   VIDEO POP-UP
   ========================================================================== */
   $('.video-popup').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false,
});

    // Initiate superfish on nav menu
    $('.nav-menu').superfish({
        animation: {
          opacity: 'show'
      },
      speed: 400
  });

    // Mobile Navigation
    if ($('#nav-menu-container').length) {
        var $mobile_nav = $('#nav-menu-container').clone().prop({
          id: 'mobile-nav'
      });
        $mobile_nav.find('> ul').attr({
          'class': '',
          'id': ''
      });

        $('body').append($mobile_nav);
        $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="lnr lnr-menu"></i></button>');
        $('body').append('<div id="mobile-body-overly"></div>');
        $('#mobile-nav').find('.menu-has-children').prepend('<i class="lnr lnr-chevron-down"></i>');

        $(document).on('click', '.menu-has-children i', function(e) {
          $(this).next().toggleClass('menu-item-active');
          $(this).nextAll('ul').eq(0).slideToggle();
          $(this).toggleClass("lnr-chevron-up lnr-chevron-down");
      });

        $(document).on('click', '#mobile-nav-toggle', function(e) {
          $('body').toggleClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('lnr-cross lnr-menu');
          $('#mobile-body-overly').toggle();
      });

        $(document).on('click', function(e) {
          var container = $("#mobile-nav, #mobile-nav-toggle");
          if (!container.is(e.target) && container.has(e.target).length === 0) {
            if ($('body').hasClass('mobile-nav-active')) {
              $('body').removeClass('mobile-nav-active');
              $('#mobile-nav-toggle i').toggleClass('lnr-cross lnr-menu');
              $('#mobile-body-overly').fadeOut();
          }
      }
  });
    } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
        $("#mobile-nav, #mobile-nav-toggle").hide();
    }

})(jQuery);


(function($){ 
    "use strict";

    $('html, body').hide();

    if (window.location.hash) {

        setTimeout(function() {

            $('html, body').scrollTop(0).show();

            $('html, body').animate({

                scrollTop: $(window.location.hash).offset().top

            }, 1000)

        }, 0);

    }

    else {

        $('html, body').show();

    }  

  // Header scroll class
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
  } else {
      $('#header').removeClass('header-scrolled');
  }
})


  $('.active-relatedjob-carusel').owlCarousel({
    items:1,
    autoplay:true,
    loop:true,
    margin:30,
    dots: true
});

  $('.active-review-carusel').owlCarousel({
    items:2,
    margin:30,
    autoplay:true,
    loop:true,
    dots: true,       
    responsive: {
        0: {
            items: 1
        },
        480: {
            items: 1,
        },
        768: {
            items: 2,
        }
    }
});

  $('.active-popular-post-carusel').owlCarousel({
    items:2,
    margin:30,
    autoplay:true,
    loop:true,
    dots: true,       
    responsive: {
        0: {
            items: 1
        },
        480: {
            items: 1,
        },
        768: {
            items: 1,
        },
        961: {
            items: 2,
        }
    }
});

})(jQuery);


(function ($) {
    "use strict";
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
       });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

})(jQuery);