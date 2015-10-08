/*
*
*	Admin $ Functions
*	------------------------------------------------
*
*/



(function($){
    $('document').ready(function() {
        $('body').kt_showhide();
    });
})(jQuery);

function kt_excertshow_blog_post(){
    var $, $masterEl, $content;
	$ = jQuery;
    $masterEl = $( '.wpb_vc_param_value[name=blog_type]', this.$content );
    $exerpt = $( '.wpb_vc_param_value[name=show_excerpt]', this.$content );
    $masterEl.on( 'change', function () {
        var masterValue;
		masterValue = $( this ).val();
        if( masterValue == 'justified' ){
            $exerpt.hide();
        }
    });
}