
(function($){
    "use strict"; // Start of use strict
    
    
    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */
    
    $(window).load(function(){
        
        // Page loader
        $(".page-loader div").delay(0).fadeOut();
        $(".page-loader").delay(200).fadeOut("slow");
        
        $(window).trigger("scroll");
        $(window).trigger("resize");
        init_ktCustomCss();
    });
    
    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        
        $(window).trigger("resize");
        init_shortcodes();
        init_carousel();
        init_backtotop();
        init_MainMenu();
        init_MobileMenu();
        init_timeline_animation();
        init_masonry();
        
        
        $('.kt_lightbox').each(function(){
            var type = $(this).attr('data-type');
            $(this).find('.vc_icon_element-link').magnificPopup({
                type: type
            });
        });
        
    });
    
    $(window).resize(function(){
        init_ktCustomCss();
        /**==============================
        ***  Sticky header
        ===============================**/
        $('#header.sticky-header').ktSticky();

        /**==============================
         ***  Fixed footer
         ===============================**/
        $('body.footer_fixed #footer').ktFooter();

        /**==============================
        ***  Equal height
        ===============================**/
        $('.equal_height').each(function(){
            var $equal = $(this),
                $equal_select;
            if($equal.hasClass('equal_height_column')){
                $equal_select = $equal.children('.wpb_column');
            }else{
                $equal_select = $equal.children('.wpb_column').find('.wpb_wrapper > div');
            }
            $equal_select.matchHeight({
                byRow: true
            });
        });
    });

    /* ---------------------------------------------
     Masonry
     --------------------------------------------- */

    function init_masonry(){
        (function($){

            $(".blog-posts-masonry .row").waitForImages(function(){
                $(this).masonry();
            });

        })(jQuery);
    }


    /* ---------------------------------------------
     KT custom css
     --------------------------------------------- */
    function init_ktCustomCss(){
        $('.kt_custom_css').each(function(){
            var $this = $(this);
            if(!$this.children('style').length){
                $this.html('<style>'+$this.html()+'</style>');
            }
        });
    }


    /* ---------------------------------------------
     Mobile Detection
     --------------------------------------------- */
    function isMobile(){
        return (
            (navigator.userAgent.match(/Android/i)) ||
    		(navigator.userAgent.match(/webOS/i)) ||
    		(navigator.userAgent.match(/iPhone/i)) ||
    		(navigator.userAgent.match(/iPod/i)) ||
    		(navigator.userAgent.match(/iPad/i)) ||
    		(navigator.userAgent.match(/BlackBerry/))
        );
    }

    /* ---------------------------------------------
     Shortcodes
     --------------------------------------------- */
    function init_shortcodes(){
        "use strict";
        
        // Tooltips (bootstrap plugin activated)
        $('[data-toggle="tooltip"]').tooltip();
        
        if (typeof jQuery.fn.fitVids !== 'undefined') {
            // Responsive video
            $(".video, .resp-media, .post-media").fitVids();
            $(".work-full-media").fitVids();
        }

        if( $.fn.mediaelementplayer ) {
            $('.post-media-video video').mediaelementplayer();
            // Responsive audio
            $('.post-media-audio audio').mediaelementplayer();
        }

        // Skill bar
        if (typeof jQuery.fn.waypoint !== 'undefined') {
            jQuery('.kt-skill-wrapper').waypoint(function () {

                var $skill_bar = jQuery(this).find('.kt-skill-bar'),
                    val = $skill_bar.data('percent');

                setTimeout(function () {
                    console.log(val);
                    $skill_bar.css({"width":val + '%'});
                }, 200);
            }, { offset:'95%' });
        }


        // Counter
        $('.kt-counter-wrapper').waypoint(function () {
            jQuery(this).find('.couter').countTo();
        }, { offset:'85%', triggerOnce:true });

    }

    /* ---------------------------------------------
     Main Menu
    --------------------------------------------- */
    function init_MainMenu(){
        $("nav#main-nav ul.menu").superfish({
            hoverClass: 'hovered',
            popUpSelector: 'ul.sub-menu-dropdown,.kt-megamenu-wrapper',
            animation: {},
    		animationOut: {}
        });
    }
    
    /* ---------------------------------------------
     Mobile Menu
    --------------------------------------------- */
    function init_MobileMenu(){
        $('ul.navigation-mobile ul.sub-menu-dropdown').each(function(){
            $(this).parent().children('a').prepend( '<span class="open-submenu"></span>' );
            $(this).parent().children('span.title-megamenu').prepend( '<span class="open-submenu"></span>' );
        });
        
        $('.open-submenu').on('click', function(e){
            e.stopPropagation();
            e.preventDefault();
            $( this ).closest('li').toggleClass('active-menu-item');
            $( this ).closest('li').children( '.sub-menu-dropdown, .menu-widget-container' ).toggle();
        });
        
        $('.mobile-nav-bar').on('click', function(e){
            e.preventDefault();
            $( this ).toggleClass('active');
            $('nav#main-nav-mobile').toggle();
        });
        
    }
    
    /* ---------------------------------------------
     Back to top
     --------------------------------------------- */
    function init_backtotop(){
        var bottom = $('footer#footer-bottom').outerHeight();
    	var backtotop = $('#backtotop').hide();
    	$(window).scroll(function() {
    		($(window).scrollTop() != 0) ? backtotop.css({'bottom':bottom+'px'}).fadeIn() : backtotop.fadeOut();  
    	});
    	backtotop.click(function(e) {
            e.preventDefault();
    		$('html, body').animate({scrollTop:0},500);
    	});
    }
    

    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.kt-owl-carousel').each(function(){

            var objCarousel = $(this),
                owlMargin = objCarousel.data('margin'),
                owlNavigationIcon = objCarousel.data('navigation_icon'),
                owlPagination = objCarousel.data('dots'),
                owlAutoheight = objCarousel.data('autoheight'),
                owlNavigation = objCarousel.data('nav'),
                owlAutoPlay = objCarousel.data('autoplay'),
                owlSlideSpeed = objCarousel.data('slidespeed'),
                owlLoop = objCarousel.data('loop'),
                owlMousedrag = objCarousel.data('mousedrag'),
                func_cb = objCarousel.data('js-callback');



            if(typeof owlMargin === "undefined"){
                owlMargin = 0;
            }
            if(typeof owlNavigationIcon === "undefined"){
                owlNavigationIcon = 'fa fa-angle-left|fa fa-angle-right';
            }
            var owlNavigationIconArr = owlNavigationIcon.split('|', 2);

            if(typeof owlNavigation === "undefined"){
                owlNavigation = true;
            }
            if(typeof owlAutoheight === "undefined"){
                owlAutoheight = true;
            }
            if(typeof owlPagination === "undefined"){
                owlPagination = true;
            }
            if(typeof owlAutoPlay === "undefined"){
                owlAutoPlay = false;
            }
            if(typeof owlSlideSpeed === "undefined"){
                owlSlideSpeed = '200';
            }
            if(typeof owlSlideSpeed === "undefined"){
                owlLoop = false;
            }
            if(typeof owlMousedrag === "undefined"){
                owlMousedrag = true;
            }


            var options = {
                slideSpeed: owlSlideSpeed,
                dots: owlPagination,
                margin: owlMargin,
                autoHeight: owlAutoheight,
                nav: owlNavigation,
                navText : ["<i class='"+owlNavigationIconArr[0]+"'></i>", "<i class='"+owlNavigationIconArr[1]+"'></i>"],
                loop: owlLoop,
                autoplay: owlAutoPlay,
                autoplayHoverPause: true,
                responsiveClass:true,
                responsive:{
                    0:{items:objCarousel.data('mobile')},768:{items:objCarousel.data('tablet'),},992:{items:objCarousel.data('desktop')}
                },
                mouseDrag : owlMousedrag,
                themeClass: 'owl-kttheme'

            };
            $(objCarousel).waitForImages(function() {
                objCarousel.owlCarousel(options);
            });

            
        });
    }
    
    
    /* ---------------------------------------------
     Timeline Animation
     --------------------------------------------- */
    function init_timeline_animation(){

        $('.kt-timeline-wrapper > ul').each(function(){
            var window_width = $(window).width(),
                $timeline_wrap = $(this),
                $class_animate = $timeline_wrap.attr('data-animation'),
                $timeline_item = $timeline_wrap.find('li.kt-timeline-item'),
                $count = 0;
            $timeline_item.each(function(i){
                var $timeline = $(this);
                
                var animation_delay = $count * 200;
                $count++;
                if (window_width > 991) {
					$timeline.css({
						"-webkit-animation-delay": animation_delay + "ms",
						"-moz-animation-delay": animation_delay + "ms",
						"-ms-animation-delay": animation_delay + "ms",
						"-o-animation-delay": animation_delay + "ms",
						"animation-delay": animation_delay + "ms"
					});
                    
                    $timeline.css({'opacity':'0'});
                    $timeline.waypoint(function() {
						$timeline.addClass("animated").addClass($class_animate);
                        $timeline.css({'opacity':'1'});
					}, {
						triggerOnce: true,
						offset: "90%"
					});
                    
				}else{
                    $timeline.addClass("no-effect");
                }
            });
        });
    }
    
})(jQuery); // End of use strict

