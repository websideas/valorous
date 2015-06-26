
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
        init_masonry();
        init_kt_image();
        init_SearchFull();
        init_kt_animation();
        init_loadmore();

        if($('#wpadminbar').length){
            $('body').addClass('admin-bar');
        }

        $('.kt_lightbox').each(function(){
            var $type = $(this).data('type'),
                $effect = $(this).data('effect');
            if(typeof $effect === "undefined"){
                $effect = 'mfp-zoom-in';
            }

            $(this).find('.vc_icon_element-link').magnificPopup({
                type: $type,
                mainClass: $effect,
                midClick: true,
                callbacks: {
                    beforeOpen: function() {
                       if($type == 'image'){
                           this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                           this.st.mainClass = $effect;
                       }else if($type == 'iframe'){
                           this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
                           this.st.mainClass = $effect;
                       }
                    }
                },
            });
        });
        
        
        $('.kt_piechart').waypoint(function() {
        	$(".chart").each(function() {
            	var size = $(this).attr('data-size');
            	var fgcolor = $(this).attr('data-fgcolor');
            	var bgcolor = $(this).attr('data-bgcolor');
            	var linewidth = $(this).attr('data-linewidth');
            	var _lineCap = $(this).attr('data-linecap');
        		$(this).easyPieChart({
        			easing: 'easeInOutQuad',
        			barColor: fgcolor,
        			animate: 2000,
        			trackColor: bgcolor,
        			lineWidth: linewidth,
        			lineCap: _lineCap,
        			size: size,
        			scaleColor: false,
        			onStep: function(from, to, percent) {
        				$(this.el).find('.percent').text(Math.round(percent)+'%');
        			}
        		});
       		});
        }, { offset:'95%' });


        $('.player').each(function(){
            $(this).mb_YTPlayer();
        });
        
        
        $( '#menu-one-page-menu' ).onePageNav({
            currentClass: 'current-menu-item'
        });
        
        $('.coming-soon').each(function(){
            var date = $(this).data('date');
            $(this).countdown(date, function(event) {
                $(this).html(
                    event.strftime('<div class="wrap">'+
                                    '<div class="value-time">%D</div>'+
                                        '<div class="title">Days</div></div>'+
                                    '<div class="wrap">'+
                                        '<div class="value-time">%H</div>'+
                                        '<div class="title">Hours</div></div>'+
                                    '<div class="wrap">'+
                                        '<div class="value-time">%M</div>'+
                                        '<div class="title">Minutes</div></div>'+
                                    '<div class="wrap">'+
                                        '<div class="value-time">%S</div>'+
                                        '<div class="title">Seconds</div></div>')
                );
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
            $(this).children('.wpb_column').matchHeight({
                byRow: true
            });
        });







    });

    /* ---------------------------------------------
     Masonry
     --------------------------------------------- */

    function init_masonry(){
        $(".blog-posts-masonry .row").waitForImages(function(){
            $(this).masonry();
        });
    }


    /* ---------------------------------------------
     Blog loadmore
     --------------------------------------------- */
    function init_loadmore(){
        $('body').on('click','.blog-loadmore-button',function(e){
            e.preventDefault();
            var $loadmore = $(this),
                $loading = $loadmore.find('span'),
                $posts = $loadmore.closest('.blog-posts'),
                $content = $posts.children('.blog-posts-content'),
                $type = $posts.data('type'),
                $current = parseInt($posts.attr('data-current')),
                $paged = $current + 1,
                $total = parseInt($posts.data('total'));

            var data = {
                action: 'fronted_loadmore_blog',
                security : ajax_frontend.security,
                settings: $posts.data('settings'),
                paged : $paged
            };

            $loading.addClass('fa-spin');

            $.post(ajax_frontend.ajaxurl, data, function(response) {
                $loading.removeClass('fa-spin');
                $posts.attr('data-current', $paged) ;


                if($paged == $total){
                    $loadmore.closest('.blog-posts-loadmore').hide();
                }

                if($type == 'grid' || $type == 'masonry'){
                    var $row = $content.children('.row');
                    if($type == 'masonry'){
                        var $elems = $(response.html);
                        $row.append($elems);
                        loadmore_append();
                        $row.waitForImages(function() {
                            $row.masonry( 'appended', $elems, true );
                        });
                    }else{
                        $row.append(response.html);
                        loadmore_append();
                    }
                }else{
                    $content.append(response.html);
                    loadmore_append();
                }




                $content.find('.post-item').removeClass('loadmore-item');

            }, 'json');

        });
    }


    /* ---------------------------------------------
     Loadmore append
     --------------------------------------------- */
    function loadmore_append(){
        $('[data-toggle="tooltip"]').tooltip();
        $('.loadmore-item .wp-audio-shortcode, .loadmore-item .wp-video-shortcode').mediaelementplayer( );
        init_carousel();

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

        $("ul#main-navigation").superfish({
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
     Kt Animation
     --------------------------------------------- */
    function init_kt_animation(){

        $('.animation-effect').each(function(){
            var window_width = $(window).width(),
                $animate_wrap = $(this),
                $class_animate = $animate_wrap.attr('data-animation'),
                $animate_item = $animate_wrap.find('.animation-effect-item'),
                $time = $animate_wrap.attr('data-timeeffect'),
                $count = 0;
            $animate_item.each(function(i){
                var $animate = $(this);
                
                if($animate.hasClass('first')){
                    $count = 0;
                }
                
                var animation_delay = $count * $time;
                $count++;
                if (window_width > 991) {
					$animate.css({
						"-webkit-animation-delay": animation_delay + "ms",
						"-moz-animation-delay": animation_delay + "ms",
						"-ms-animation-delay": animation_delay + "ms",
						"-o-animation-delay": animation_delay + "ms",
						"animation-delay": animation_delay + "ms"
					});
                    
                    $animate.css({'opacity':'0'});
                    $animate.waypoint(function() {
						$animate.addClass("animated").addClass($class_animate);
                        $animate.css({'opacity':'1'});
					}, {
						triggerOnce: true,
						offset: "90%"
					});
                    
				}else{
                    $animate.addClass("no-effect");
                }
            });
        });
    }

    /* ---------------------------------------------
     KT Image animation
     --------------------------------------------- */
    function init_kt_image() {
        // Image
        $('.kt-image-animation').each(function(){
            var $this = $(this);
            $this.css({'opacity':'0'});
            $this.waypoint(function () {
                $this.addClass("animated").addClass($this.data('animation'));
                $this.css({'opacity':'1'});
            }, { offset:'85%', triggerOnce:true });
        });
    }

    /* ---------------------------------------------
     Search
     --------------------------------------------- */
    function init_SearchFull(){
        $('.mini-search a').magnificPopup({
            items: {
                src: '#search-fullwidth',
                type: 'inline'
            },
            //overflowY : 'scroll',
            focus : 'input.search',
            callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = this.st.el.attr('data-effect');
                }
            }
        });
    }

    
})(jQuery); // End of use strict

