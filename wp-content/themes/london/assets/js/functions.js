
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
        
    });
    
    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        
        $(window).trigger("resize");
        
        init_shortcodes();
        init_popup();
        init_carousel();
        init_backtotop();
        init_MainMenu();
        init_MobileMenu();
        init_ProductQuickView();
        init_SaleCountDown();
        init_gridlistToggle();
        init_carouselwoo();
        init_productcarouselwoo();
        init_woocategories_products();
        init_wooanimation_products();
        
        $('body.footer_fixed #footer').ktFooter();
        
        var $easyzoom = $('.easyzoom').easyZoom();
        woo_quantily();

        if( typeof ( $.mCustomScrollbar ) !== undefined ){
            $(window).bind('wc_fragments_loaded wc_fragments_refreshed', function (){
                $('.mCustomScrollbar').mCustomScrollbar();
            });
        }

        $( 'body' ).on( 'woof_products_added', function(){
            init_gridlistToggle();
            init_wooanimation_products();
            $('form.woocommerce-ordering .orderby').on('change', function(){
                $(this).parents('form').submit();
            });
        } );
        
        
        $( 'body' ).bind( 'added_to_cart', function() {
            $('#woocommerce-nav .checkout-link').show();
            $('#woocommerce-nav .shop-link').hide();
        });
        
        $( 'body' ).bind( 'added_to_wishlist', function() {
            var data = {
        		action: 'fronted_get_wishlist',
        		security : ajax_frontend.security
        	};
        	$.post(ajax_frontend.ajaxurl, data, function(response) {
                $('#woocommerce-nav .wishlist-link span').html('('+response.count+')')
        	}, 'json');
            
        });
        
        $('.sidebar .widget_product_categories ul.product-categories li ul.children').parent().append('<span class="button-toggle"></span>');
        $('.sidebar .widget_product_categories ul.product-categories li.current-cat ul.children').show();
        $('.sidebar .widget_product_categories ul.product-categories li.current-cat-parent ul.children').show();
        $('body').on('click','.sidebar .widget_product_categories ul.product-categories li .button-toggle',function(){
            $(this).prev('ul.children').slideToggle();
            $(this).toggleClass('current');            
        });
    });
    
    $(window).resize(function(){
        
        /**==============================
        ***  Sticky header
        ===============================**/
        $('#header.sticky-header').ktSticky();
        
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
     Sale Count Down
     --------------------------------------------- */
    function init_SaleCountDown(){
        $('.woocommerce-countdown').each(function(){
            var $this = $(this), 
                finalDate = $(this).data('time');

            $this.countdown({
                until: new Date( finalDate ),
                format: 'dHMS',
                compact: true,
                padZeroes: true,
                serverSync: new Date( ajax_frontend.current_date ),
               // until: shortly,
                //onExpiry: liftOff,
                layout: '<div><span>{dnn}</span> days</div><div><span>{hn}</span> hr</div><div><span>{mn}</span> min</div><div><span>{sn}</span> sec</div>'
            });


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
     Popup content 
     --------------------------------------------- */
    function init_popup(){
        if($('#popup-wrap').length > 0){
            var $disable_mobile = $('#popup-wrap').data('mobile'),
                time_show = $('#popup-wrap').data('timeshow');
            
                if(!isMobile() || (isMobile() && $disable_mobile == 0)){
                    setTimeout(function(){
                        $.magnificPopup.open({
                            items: { src: '#popup-wrap' },
                            type: 'inline',
                            callbacks: {
                                beforeClose: function() {
                                    var data = {
                                        action: 'fronted_popup',
                                        security : ajax_frontend.security,
                                    };
                                    $.post(ajax_frontend.ajaxurl, data, function(response) { }, 'json');
                                }
                            }
                        });
                    }, time_show*1000);
                }
        }
    }
    
    /* ---------------------------------------------
     Shortcodes
     --------------------------------------------- */
    function init_shortcodes(){
        "use strict";
        
        // Tooltips (bootstrap plugin activated)
        $('[data-toggle="tooltip"]').tooltip();
        
        if ($.fn.fitVids) {
            // Responsive video
            $(".video, .resp-media, .post-media").fitVids();
            $(".work-full-media").fitVids();
        }

        if( $.fn.mediaelementplayer ) {
            $('.post-media-video video').mediaelementplayer();
            // Responsive audio
            $('.post-media-audio audio').mediaelementplayer();
        }
        
        $( ".category-products-tab-wrapper" ).tabs();
        
        $( ".categories-top-sellers-wrapper" ).tabs();
        
    }
    
    /* ---------------------------------------------
     Woo categories products
     --------------------------------------------- */
     

    function init_woocategories_products(){

        jQuery('.categories-products-lists').each(function(){
            var p = jQuery(this);
            var ajax_request;
            $(' ul li a', p).on('click',function(e){
                e.preventDefault();
                var obj = $(this),
                    objul = obj.closest('ul'),
                    $wrapper = obj.closest('.categories-products-wrapper'),
                    $carousel = $wrapper.find('ul.products'),
                    $carouselData = $carousel.data('KTowlCarousel');


                if(ajax_request && ajax_request.readystate != 4){
                    ajax_request.abort();
                    obj.closest('.categories-products-lists').find('a').removeClass('loading');
                }

                obj.addClass('loading');
                objul.find('li').removeClass('active');
                obj.closest('li').addClass('active');

                var data = {
                    action: 'fronted_woocategories_products',
                    security : ajax_frontend.security,
                    cat_id: obj.data('id'),
                    per_page : objul.data('per_page'),
                    orderby: objul.data('orderby'),
                    order: objul.data('order'),
                    columns: objul.data('columns')
                };

                ajax_request = $.post(ajax_frontend.ajaxurl, data, function(response) {
                    obj.removeClass('loading');
                    for (var i = $carouselData.itemsAmount-1 ; i >= 0; i--) {
                        $carouselData.removeItem(i);
                    }
                    $.each( response, function( i, val ) {
                        $carouselData.addItem(val);
                    });
                    
                    init_wooanimation_products();
                    
                                        
                }, 'json');

                return false;
            });

        });

    }
    
    /* ---------------------------------------------
     Woo Animation Products
     --------------------------------------------- */
    function init_wooanimation_products(){
        

        
        $('.woocommerce ul.products').each(function(){
            var window_width = $(window).width(),
                $products = $(this),
                $products_item = $products.find('li.product'),
                $products_multi = $products.find('li.product.in-multi-columns'),
                $count = 0;
            if($products_multi.length > 0){
                $products_item.each(function(i){
                    var $product = $(this);
                       
                    if($product.hasClass('first')){
                        $count = 0;
                    }
                    
                    var animation_delay = $count * 200;
                    $count++;
                    if (window_width > 991) {
    					$product.css({
    						"-webkit-animation-delay": animation_delay + "ms",
    						"-moz-animation-delay": animation_delay + "ms",
    						"-ms-animation-delay": animation_delay + "ms",
    						"-o-animation-delay": animation_delay + "ms",
    						"animation-delay": animation_delay + "ms"
    					});
                        
                        $product.waypoint(function() {
    						$product.addClass("animated").addClass("fadeInUp");
    					}, {
    						triggerOnce: true,
    						offset: "90%"
    					});
                        
    				}
                });
            }
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
    				items: {
    					src: '<div class="themedev-product-popup woocommerce">' + response + '</div>',
    					type: 'inline'
    				},
                    callbacks: {
    	        		open: function() {
    	        		     $('.single-product-quickview-images').KTowlCarousel({
            					theme: "style-navigation-center",
            					singleItem: true,
            					autoHeight: true,
            					navigation: true,
            					navigationText: false,
            					pagination: false
            				});
    	        			$('.themedev-product-popup form').wc_variation_form();
    	        		},
    	        		change: function() {	        			
    	        			$('.themedev-product-popup form').wc_variation_form();
    	        		}
    	        	},
    			});
            });
        });
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
            
            wooCarousel.KTowlCarousel({
    			theme: wooCarouselTheme,
    			items : 1,
                autoPlay: wooAutoPlay,
                itemsCustom: wooitemsCustom,
    			autoHeight: false,
    			navigation: true,
    			navigationText: false,
                slideSpeed: wooSlideSpeed,
    			pagination: wooPagination,
                afterInit : function(elem){
                    if(wooCarouselTheme == 'style-navigation-top'){
                        var that = this;
                        that.owlControls.addClass('carousel-heading-top').prependTo(elem.closest('.carousel-wrapper-top'))
                    }
                }
    		});
        });
    }
    
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    
    function init_productcarouselwoo(){
         
        sync1.KTowlCarousel({
            singleItem : true,
            slideSpeed : 1000,
            items : 1,
            navigation: false,
            pagination: false,
            afterAction : syncPosition,
            responsiveRefreshRate : 200,
        });
        
        sync2.KTowlCarousel({
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


    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.kt-owl-carousel').each(function(){

            var objCarousel = $(this),
                owlItems = objCarousel.data('items'),
                owlPagination = objCarousel.data('pagination'),
                owlAutoheight = objCarousel.data('autoheight'),
                owlNavigation = objCarousel.data('navigation'),
                owlAutoPlay = objCarousel.data('autoplay'),
                owlTheme = objCarousel.data('theme'),
                owlitemsCustom = objCarousel.data('itemscustom'),
                owlSlideSpeed = objCarousel.data('slidespeed'),
                func_cb = objCarousel.data('js-callback'),
                owlSingleItem = true;



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
            if(typeof owlitemsCustom === "undefined"){
                owlitemsCustom = false;
            }else{
                owlSingleItem = false;
            }
            if(typeof owlTheme === "undefined"){
                owlTheme = 'style-navigation-center';
            }


            if(typeof owlItems === "undefined"){
                owlItems = 1;
            }else{
                owlItems = parseInt(owlItems, 10);
                owlSingleItem = false;
            }

            //owlSingleItem = true;
            //owlItems = 6;
           // owlitemsCustom = false;

            func_cb =  window[ func_cb ];

            var options = {
                items: owlItems,
                slideSpeed: owlSlideSpeed,
                singleItem: owlSingleItem,
                pagination: owlPagination,
                autoHeight: owlAutoheight,
                navigation: owlNavigation,
                navigationText : ["", ""],
                theme: owlTheme,
                autoPlay: owlAutoPlay,
                stopOnHover: true,
                addClassActive : true,
                itemsCustom: owlitemsCustom,
                afterInit : function(elem){ 
                    if(owlTheme == 'style-navigation-top' && owlNavigation){
                        var that = this;
                        that.owlControls.addClass('carousel-heading-top').prependTo(elem.closest('.carousel-wrapper-top'));
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
            //console.debug( options );
            objCarousel.KTowlCarousel(options);
            
        });
    }
    
})(jQuery); // End of use strict


/* ---------------------------------------------
 Designer collection callback
 --------------------------------------------- */

function designer_carousel_cb( _type, elem ){
    "use strict"; // Start of use strict
    var id = elem.attr('id');
    var pwid=  jQuery('#'+id+'-products');

    if( _type === 'afterInit' ){
        var id_designer =  jQuery('.owl-item.active').eq(0).find('.designer-collection-item').data('id');
        jQuery('.designer-products', pwid).not( jQuery(  '.designer-id-'+id_designer , pwid)  ) .hide();
    }

    if( _type === 'afterUpdate' ){
        var id_designer =  jQuery('.owl-item.active').eq(0).find('.designer-collection-item').data('id');
        pwid.css({
            'height': pwid.height()+'px',
            'overflow': 'hidden',
            'display' : 'block'
        });
        jQuery('.designer-products', pwid).hide(0);

        jQuery(  '.designer-id-'+id_designer , pwid). fadeIn (500, function (){
            pwid.removeAttr('style');
        });
    }
}

function designer_widget_cb( _type, elem ){

    "use strict"; // Start of use strict
    var id = elem.attr('id');
    var pwid=  jQuery('#widget-'+id );

    if( _type === 'afterInit' ){
        var id_designer =  jQuery('.owl-item.active', elem ).eq(0).find('.designer-items-ins').data('did');
        jQuery('div', pwid).not( jQuery(  '.designer-id-'+id_designer , pwid)  ) .hide();
        jQuery(  '.designer-id-'+id_designer , pwid).show();
    }

    if( _type === 'afterUpdate' ){
        var id_designer =  jQuery('.owl-item.active', elem ).eq(0).find('.designer-items-ins').data('did');
        jQuery('div', pwid).hide(0);
        jQuery(  '.designer-id-'+id_designer , pwid).show(0);
    }

}