(function($){
    $('document').ready(function() {
        $( 'body' ).on( 'click', '.kt_image_select_radio', function ( ){
            var $this = $(this),
                $parent = $this.closest('.edit_form_line'),
                $image = $this.val();
            $parent.find('.kt_image_select').val($image);
        });
    });
})(jQuery);