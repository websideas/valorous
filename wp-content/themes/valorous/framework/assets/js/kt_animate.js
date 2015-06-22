(function($){
    $('document').ready(function() {
        $( 'select.kt_animation' ).change(function(){
            val = $(this).val();
            $(this).closest('.wrap-kt-animate').find( '.animationSandbox' ).addClass( 'animated '+val );
            
            setTimeout(function(){ 
                $('.wrap-kt-animate .animationSandbox' ).removeClass( 'animated '+val );
            }, 300);
        });
    });
})(jQuery);