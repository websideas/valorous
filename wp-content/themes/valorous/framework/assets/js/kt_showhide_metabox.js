(function($){
	$.fn.extend({ 
		kt_showhide: function(options) {   
            var defaults = {
				parent: '.rwmb-field'
            }
            var o = $.extend(defaults,options);
    		return this.each(function() {
                var obj = $(this);
                $('[data-id]').each(function(){
                    var id = $(this).data('id');
                    if( $('[name="'+id+'"]').is(':radio') ){
                        if( $('[name="'+id+'"]:checked').val() != $(this).data('value') ){
                            $(this).closest(o.parent).hide();
                        } 
                    }else{
                        if( $(this).data('value') != $('#'+$(this).data('id')).val() ){
                            $(this).closest(o.parent).hide();
                        }
                    }
                });
                
                $('select').change(function(){
                    var id = $(this).attr('id'),
                        val = $(this).val();
                    $('[data-id="'+id+'"]').each(function(){
                        var val_item = $(this).data('value');
                        if( val == val_item ){
                            $(this).closest(o.parent).show();
                        }else{
                            $(this).closest(o.parent).hide();
                        }
                    });
                });
                
                
                $('[type="checkbox"]').each(function(){
                    var id = $(this).attr('id');
                    if( $(this).is(':checked') ){
                        $('[data-id="'+id+'"]').closest(o.parent).show();
                    }                    
                });
                
                $('[type="checkbox"]').click(function(){
                    var id = $(this).attr('id');
                    if( $(this).is(':checked') ){
                        $('[data-id="'+id+'"]').closest(o.parent).show();
                    }else{
                        $('[data-id="'+id+'"]').closest(o.parent).hide();
                    }
                });
                
                $('[type="radio"]').change(function(){
                    var id = $(this).attr('name'),
                        val = $(this).val();
                    $('[data-id="'+id+'"]').each(function(){
                        var val_item = $(this).data('value');
                        if( val_item == val ){
                            $(this).closest(o.parent).show();
                        }else{
                            $(this).closest(o.parent).hide();
                        }
                    });
                });
    		});
    	}
	});
})(jQuery);