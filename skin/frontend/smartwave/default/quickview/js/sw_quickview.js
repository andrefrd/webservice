jQuery.noConflict();
jQuery(function($) {
        //insert quickview popup        
        $('.quickview-icon').fancybox({
            'type'              : 'ajax',            
            'autoSize'          : false,
            'titleShow'         : false,
            'autoScale'         : false,
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'scrolling'         : 'auto',
            'padding'           : 0,
            'margin'            : 0,                        
            'autoDimensions'    : false,
            'width'             : EM.Quickview.QS_FRM_WIDTH,
            'maxHeight'         : EM.Quickview.QS_FRM_HEIGHT,
            'centerOnScroll'    : true,            
            'height'            : 'auto',
            'beforeLoad'        : function() {
                
            },
            'afterLoad'        : function() {     
                $('#fancybox-content').height('auto');
                
            },
            'afterShow'        : function() {
                $(".qty_inc").unbind('click').click(function(){
                    $(this).parent().parent().children("input.qty").val((+$(this).parent().parent().children("input.qty").val()+1) || 0);
                    $(this).parent().parent().children("input.qty").focus();
                    $(this).focus();
                });
                $(".qty_dec").unbind('click').click(function(){
                    $(this).parent().parent().children("input.qty").val(($(this).parent().parent().children("input.qty").val()-1 > 0)?($(this).parent().parent().children("input.qty").val() - 1) : 0);
                    $(this).parent().parent().children("input.qty").focus();
                    $(this).focus();
                });
            },
            'helpers'             : {
                overlay : {
                    locked : false // try changing to true and scrolling around the page
                }
            }            
        });
});


