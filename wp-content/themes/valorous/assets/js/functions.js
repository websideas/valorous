
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
        init_VCLightBox();

        init_ProductQuickView();
        init_gridlistToggle();
        init_productcarouselwoo();
        init_kt_remove_cart();
        init_carouselwoo();
        
        woo_quantily();
        scrollsizebar();

        if($('#wpadminbar').length){
            $('body').addClass('admin-bar');
        }


        $('body').bind('wc_fragments_loaded wc_fragments_refreshed', function (){
            $('.mCustomScrollbar').mCustomScrollbar();
        });

        $( 'body' ).bind( 'added_to_cart', function( event, fragments, cart_hash ) {
            $('.mCustomScrollbar').mCustomScrollbar();
        });

        $('.player').each(function(){
            $(this).mb_YTPlayer();
        });
        
        
        $( '#menu-one-page-menu' ).onePageNav({
            currentClass: 'current-menu-item'
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
    
    function scrollsizebar(){
        var _window = $( window ),
            InitStr = _window.width(),
            $sidebar = $('.sidebar'),
            $sidebar_inner = $('.sidebar .sidebar-inner'),
            $primary = $('#main'),
            lastScrollTop = 0,
            currenttoppos = 0,
            top_pos  = $sidebar_inner.offset().top;
        
        if($sidebar.length > 0 && InitStr > 992){

            $(window).scroll(function(event){
                var $sidebar_offset = $sidebar.offset().top,
                    $sidebar_inner_height = $sidebar_inner.outerHeight(),
                    $footer_offset = $('#footer').offset().top,
                    $primary_height = $primary.outerHeight(),
                    $width = $sidebar.width(),
                    st = _window.scrollTop();
                    
                    if(currenttoppos < 0 ) currenttoppos = 0;
                    if(currenttoppos > ( $primary_height - $sidebar_inner_height )){ 
                        currenttoppos = $primary_height - $sidebar_inner_height;
                    }
                if (st > lastScrollTop){
                    /*
                    if($primary_height < $sidebar_inner_height){
                        $sidebar_inner.css({'position': 'static', 'bottom' : 'auto','width':'auto'});
                    }else if((st + _window.height()) > ($sidebar_offset + $sidebar_inner_height)){
                        $sidebar_inner.css({'position': 'fixed', 'bottom' : '0','width': $width});
                        var $margin_bottom = $sidebar_inner.css('margin-bottom');
                        if((st + _window.height()) > ($footer_offset)){
                            $sidebar.css({'height':$primary_height+'px'});
                            $sidebar_inner.css({'bottom':'0','position':'absolute'});
                        }
                    }else{
                        $sidebar_inner.css({'position': 'static', 'bottom' : 'auto','width':'auto'});
                    }
                    */
                    if(currenttoppos >= ($primary_height - $sidebar_inner_height) ) {
                        $sidebar_inner.css({
                            'position' : 'absolute',
                            'top': ( $primary_height - $sidebar_inner_height ),
                            'bottom' : 'auto',
                            'width': $width
                        });
                    } else if(st > ( currenttoppos + top_pos + $sidebar_inner_height - _window.height())) {
                        $sidebar_inner.css({
                            'position' : 'fixed',
                            'bottom': '0',
                            'top': 'auto',
                            'width': $width
                        });
                        currenttoppos = st + _window.height() - top_pos - $sidebar_inner_height;
                    } else {
                        $sidebar_inner.css({
                            'position' : 'absolute',
                            'top': ( currenttoppos ),
                            'bottom' : 'auto',
                            'width': $width
                        });
                    }
                }else{
                    if(currenttoppos <= 0) {
                        $sidebar_inner.css({
                            'position' : 'relative',
                            'top': '0',
                            'bottom' : 'auto'
                        });
                    } else if( st > ( currenttoppos + top_pos ) ) {
                        $sidebar_inner.css({
                            'position' : 'absolute',
                            'top': ( currenttoppos ),
                            'bottom' : 'auto',
                            'width': $width
                        });
                    } else {
                        $sidebar_inner.css({
                            'position' : 'fixed',
                            'top': '0',
                            'bottom' : 'auto',
                            'width': $width,
                        });
                        currenttoppos = st - top_pos;
                    }
                }
                lastScrollTop = st;
            });
        }else{
            $sidebar_inner.css({'position': 'static', 'bottom' : 'auto','width':'auto', });
        }            
    }
    /* ---------------------------------------------
     Woocommercer Quantily
     --------------------------------------------- */
     function woo_quantily(){
        $('body').on('click','.quantity .quantity-plus',function(){
            var obj_qty = $(this).closest('.quantity').find('input.qty'),
                val_qty = parseInt(obj_qty.val()),
                min_qty = parseInt(obj_qty.attr('min')),
                max_qty = parseInt(obj_qty.attr('max')),
                step_qty = parseInt(obj_qty.attr('step'));
            val_qty = val_qty + step_qty;
            if(max_qty && val_qty > max_qty){ val_qty = max_qty; }
            obj_qty.val(val_qty);
        });
        $('body').on('click','.quantity .quantity-minus',function(){
            var obj_qty = $(this).closest('.quantity').find('input.qty'), 
                val_qty = parseInt(obj_qty.val()),
                min_qty = parseInt(obj_qty.attr('min')),
                max_qty = parseInt(obj_qty.attr('max')),
                step_qty = parseInt(obj_qty.attr('step'));
            val_qty = val_qty - step_qty;
            if(min_qty && val_qty < min_qty){ val_qty = min_qty; }
            if(!min_qty && val_qty < 0){ val_qty = 0; }
            obj_qty.val(val_qty);
        });
     }
    

    /* ---------------------------------------------
     Masonry
     --------------------------------------------- */

    function init_masonry(){
        $(".blog-posts-masonry .row").waitForImages(function(){
            $(this).masonry();
        });
    }
    /* ---------------------------------------------
     VC Lightbox
     --------------------------------------------- */
    function init_VCLightBox(){
        $('.kt_lightbox').each(function(){

            var $type = $(this).data('type'),
                $effect = $(this).data('effect'),
                $removalDelay = 500;
            if(typeof $effect === "undefined"){
                $effect = '';
                $removalDelay = 0;
            }
            $(this).find('.vc_icon_element-link').magnificPopup({
                type: $type,
                mainClass: $effect,
                removalDelay: $removalDelay,
                midClick: true,
                fixedContentPos: false,
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
                }
            });
        });
    }


    /* ---------------------------------------------
     Search
     --------------------------------------------- */
    function init_SearchFull(){
        $('.mini-search a').magnificPopup({
            type: 'inline',
            mainClass : 'mfp-zoom-in',
            items: { src: '#search-fullwidth' },
            focus : 'input[name=s]',
            removalDelay: 200
        });
    }



    /* ---------------------------------------------
     VC PieChart
     --------------------------------------------- */
    function init_VCPieChart(){
        $('.kt_piechart').waypoint(function() {
            $(".chart").each(function() {
                var $chart = $(this);
                $(this).easyPieChart({
                    easing: 'easeInOutQuad',
                    barColor: $chart.attr('data-fgcolor'),
                    animate: 2000,
                    trackColor: $chart.attr('data-bgcolor'),
                    lineWidth: $chart.attr('data-linewidth'),
                    lineCap: $chart.attr('data-linecap'),
                    size: $chart.attr('data-size'),
                    scaleColor: false,
                    onStep: function(from, to, percent) {
                        $(this.el).find('.percent').text(Math.round(percent)+'%');
                    }
                });
            });
        }, { offset:'95%' });
    }
    /* ---------------------------------------------
     VC Coming Soon
     --------------------------------------------- */
    function init_VCComingSoon() {
        $('.coming-soon').each(function () {
            var date = $(this).data('date');
            $(this).countdown(date, function (event) {
                $(this).html(
                    event.strftime('<div class="wrap">' +
                    '<div class="value-time">%D</div>' +
                    '<div class="title">Days</div></div>' +
                    '<div class="wrap">' +
                    '<div class="value-time">%H</div>' +
                    '<div class="title">Hours</div></div>' +
                    '<div class="wrap">' +
                    '<div class="value-time">%M</div>' +
                    '<div class="title">Minutes</div></div>' +
                    '<div class="wrap">' +
                    '<div class="value-time">%S</div>' +
                    '<div class="title">Seconds</div></div>')
                );
            });
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
                $total = parseInt($posts.data('total')),
                $query_vars = $posts.data('queryvars');

            if(typeof $query_vars === "undefined"){ $query_vars = ajax_frontend.query_vars; }

            var data = {
                action: 'fronted_loadmore_archive',
                security : ajax_frontend.security,
                settings: $posts.data('settings'),
                queryvars: $query_vars,
                paged : $paged
            };

            console.log(data);

            $loading.addClass('fa-spin');
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                $loading.removeClass('fa-spin');
                $posts.attr('data-current', $paged);

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

                console.log(response);

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
                $this.html('<style>'+$this.data('css')+'</style>');
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
                var $skill_bar = jQuery(this).find('.kt-skill-bar');
                setTimeout(function () {
                    $skill_bar.css({"width": $skill_bar.data('percent') + '%'});
                }, 200);
            }, { offset:'95%' });
        }

        // Counter
        $('.kt-counter-wrapper').waypoint(function () {
            jQuery(this).find('.counter').countTo();
        }, { offset:'85%', triggerOnce:true });

        init_VCPieChart();
        init_VCComingSoon();
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
                owlItems = objCarousel.data('items'),
                owlPagination = objCarousel.data('dots'),
                owlNavigationIcon = objCarousel.data('navigation_icon'),
                owlAutoheight = objCarousel.data('autoheight'),
                owlNavigation = objCarousel.data('nav'),
                owlAutoPlay = objCarousel.data('autoplay'),
                owlTheme = objCarousel.data('theme'),
                owlitemsCustom = objCarousel.data('itemscustom'),
                owlSlideSpeed = objCarousel.data('slidespeed'),
                owlMousedrag = objCarousel.data('mousedrag'),

                owlDesktop = objCarousel.data('desktop'),
                owlTablet = objCarousel.data('tablet'),
                owlMobile = objCarousel.data('mobile'),

                func_cb = objCarousel.data('js-callback'),
                owlSingleItem = true;



            if(typeof owlDesktop === "undefined"){ owlDesktop = false; }
            if(typeof owlTablet === "undefined"){ owlTablet = false; }
            if(typeof owlMobile === "undefined"){ owlMobile = false; }

            if(typeof owlNavigation === "undefined"){ owlNavigation = true; }
            if(typeof owlAutoheight === "undefined"){ owlAutoheight = true; }
            if(typeof owlPagination === "undefined"){ owlPagination = true; }
            if(typeof owlAutoPlay === "undefined"){ owlAutoPlay = false; }
            if(typeof owlSlideSpeed === "undefined"){ owlSlideSpeed = '200'; }
            if(typeof owlTheme === "undefined"){ owlTheme = 'style-navigation-center'; }
            if(typeof owlMousedrag === "undefined"){owlMousedrag = true;}
            if(typeof owlNavigationIcon === "undefined"){owlNavigationIcon = 'fa fa-angle-left|fa fa-angle-right';}
            var owlNavigationIconArr = owlNavigationIcon.split('|', 2);


            if(typeof owlTablet !== "undefined"){
                owlSingleItem = false;
            }

            if(typeof owlItems === "undefined"){
                owlItems = owlDesktop;
            }else{
                owlItems = parseInt(owlItems, 10);
                owlSingleItem = false;
            }




            func_cb =  window[ func_cb ];

            var options = {
                items: owlItems,
                slideSpeed: owlSlideSpeed,
                singleItem: owlSingleItem,
                pagination: owlPagination,
                autoHeight: owlAutoheight,
                navigation: owlNavigation,
                navigationText : ["<i class='"+owlNavigationIconArr[0]+"'></i>", "<i class='"+owlNavigationIconArr[1]+"'></i>"],
                theme: owlTheme,
                autoPlay: owlAutoPlay,
                stopOnHover: true,
                addClassActive : true,
                mouseDrag : owlMousedrag,

                itemsDesktop: [1199, owlDesktop],
                itemsDesktopSmall: [979, owlDesktop],
                itemsTabletSmall: [768, owlTablet],
                itemsMobile: [480, owlMobile],

                afterInit : function(elem){

                    if(owlPagination && owlNavigation){
                        var that = this;
                        that.paginationWrapper.appendTo(objCarousel.closest('.owl-carousel-kt'));
                    }

                    if( typeof func_cb === 'function'){
                        func_cb( 'afterInit',   elem );
                    }
                },
                afterUpdate: function(elem) {
                    if( typeof func_cb === 'function'){
                        func_cb( 'afterUpdate',   elem );
                    }
                },
                afterMove : function ( elem ){
                    if( typeof func_cb === 'function'){
                        func_cb( 'afterUpdate',   elem );
                    }
                }
            };

            objCarousel.waitForImages(function() {
                objCarousel.owlCarousel(options);
            });


            
        });
    }


    /* ---------------------------------------------
     Product Quick View
     --------------------------------------------- */
    function init_ProductQuickView(){
        $('body').on('click', '.product-quick-view', function(e){
            e.preventDefault();
            var objProduct = $(this);
            objProduct.addClass('loading');
            var data = {
                action: 'frontend_product_quick_view',
                security : ajax_frontend.security,
                product_id: objProduct.data('id')
            };


            $.post(ajax_frontend.ajaxurl, data, function(response) {
                objProduct.removeClass('loading');
                $.magnificPopup.open({
                    mainClass : 'mfp-zoom-in',
                    removalDelay: 500,
                    items: {
                        src: '<div class="themedev-product-popup woocommerce mfp-with-anim">' + response + '</div>',
                        type: 'inline'
                    },
                    callbacks: {
                        open: function() {
                            $('.single-product-quickview-images').waitForImages(function() {
                                $(this).owlCarousel({
                                    items: 1,
                                    theme: 'carousel-navigation-center',
                                    autoHeight: true,
                                    navigation: true,
                                    navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                                    pagination: false
                                });
                            });
                            $('.themedev-product-popup form').wc_variation_form();

                        },
                        close: function(){
                            objProduct.closest('.functional-buttons').css('display','none');
                            setTimeout(function(){
                                objProduct.closest('.functional-buttons').removeAttr('style');
                            }, 50 );
                        },
                        change: function() {
                            $('.themedev-product-popup form').wc_variation_form();
                        }
                    }
                });
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
     Remove Cart Item
     --------------------------------------------- */
    function init_kt_remove_cart(){
        $( 'body' ).on('click','#header .bag-product a.remove',function(){
            var product_id = $(this).attr('data-id'),
                item_key = $(this).attr('data-itemkey');
            
            $('.mini-cart .shopping-bag').append('<span class="loading_overlay"><i class="fa fa-spinner fa-pulse"></i></span>');
            
            var data = {
        		action: 'fronted_remove_product',
        		security : ajax_frontend.security,
                product_id : product_id,
                item_key : item_key
        	};
            
        	$.post(ajax_frontend.ajaxurl, data, function(response) {
                $('.mini-cart').html(response.content_product);
                $('.mini-cart .loading_overlay').remove();
        	}, 'json');
            
            return false;
        });
    }



    /* ---------------------------------------------
     Grid list Toggle
     --------------------------------------------- */
    function init_gridlistToggle(){
        $('ul.gridlist-toggle a').on('click', function(e){
            e.preventDefault();
            var $this = $(this),
                $gridlist = $this.closest('.gridlist-toggle'),
                $products = $this.closest('#main').find('ul.products');

            $gridlist.find('a').removeClass('active');
            $this.addClass('active');
            $products
                .removeClass($this.data('remove'))
                .addClass($this.data('layout'));

        });
    }


    /* ---------------------------------------------
     Owl carousel woo
     --------------------------------------------- */
    function init_carouselwoo(){

        $('.woocommerce-carousel-wrapper').each(function(){
            var carouselWrapper = $(this),
                wooCarousel = $(this).find('ul.products'),
                wooCarouselTheme = carouselWrapper.data('theme'),
                wooAutoPlay = carouselWrapper.data('autoplay'),
                wooitemsCustom = carouselWrapper.data('itemscustom'),
                wooSlideSpeed = carouselWrapper.data('slidespeed'),
                wooNavigation = carouselWrapper.data('navigation'),
                wooPagination = carouselWrapper.data('pagination');

            if(typeof wooCarouselTheme === "undefined"){
                wooCarouselTheme = 'style-navigation-center';
            }
            if(typeof wooAutoPlay === "undefined"){
                wooAutoPlay = false;
            }
            if(typeof wooSlideSpeed === "undefined"){
                wooSlideSpeed = '200';
            }
            if(typeof wooPagination === "undefined"){
                wooPagination = true;
            }
            if(typeof wooNavigation === "undefined"){
                wooNavigation = true;
            }
            wooCarousel.waitForImages(function() {
                wooCarousel.owlCarousel({
                    theme: wooCarouselTheme,
                    items: 1,
                    autoPlay: wooAutoPlay,
                    itemsCustom: wooitemsCustom,
                    autoHeight: false,
                    navigation: true,
                    navigationText: false,
                    slideSpeed: wooSlideSpeed,
                    pagination: wooPagination,
                    afterInit: function (elem) {
                        if (wooCarouselTheme == 'style-navigation-top') {
                            var that = this;
                            that.owlControls.addClass('carousel-heading-top').prependTo(elem.closest('.carousel-wrapper-top'))
                        }
                    }
                });
            });
        });
    }


    var sync1 = $("#sync1");
    var sync2 = $("#sync2");

    function init_productcarouselwoo(){

        sync1.owlCarousel({
            singleItem : true,
            slideSpeed : 1000,
            items : 1,
            navigation: false,
            pagination: false,
            afterAction : syncPosition,
            responsiveRefreshRate : 200
        });

        sync2.owlCarousel({
            theme : 'woocommerce-thumbnails',
            items : 4,
            itemsCustom : [[992,4], [768, 3], [480, 2]],
            navigation: true,
            navigationText: false,
            pagination:false,
            responsiveRefreshRate : 100,
            afterInit : function(el){
                el.find(".owl-item").eq(0).addClass("synced");
            }
        });

        $("#sync2").on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });

    }
    function syncPosition(el){
        var current = this.currentItem;
        $("#sync2")
            .find(".owl-item")
            .removeClass("synced")
            .eq(current)
            .addClass("synced")
        if($("#sync2").data("KTowlCarousel") !== undefined){
            center(current)
        }
    }
    function center(number){
        var sync2visible = sync2.data("KTowlCarousel").owl.visibleItems;

        var num = number;
        var found = false;

        for(var i in sync2visible){
            if(num === sync2visible[i]){
                var found = true;
            }
        }

        if(found===false){
            if(num>sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", num - sync2visible.length+2)
            }else{
                if(num - 1 === -1){
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if(num === sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
            sync2.trigger("owl.goTo", num-1)
        }
    }


})(jQuery); // End of use strict

