jQuery(document).ready(function($){
    if($( '.color-field' ).length > 0){
        $( '.color-field' ).wpColorPicker();
    }
});

jQuery(document).ready(function($){
    console.log('page loaded');
    $('#max-int-px-slider').slider({
        value : parseInt($( "#max-int-px" ).val()),
        min : 500,
        max : 1140,
        step : 10,
        slide : function(event, ui){
            $( "#max-int-px" ).val( ui.value + "px" );
        }
    });
    $( "#max-int-px" ).val( $( "#max-int-px-slider" ).slider( "value" ) + "px");

    $('#max-popup-px-slider').slider({
        value : parseInt($( "#max-popup-px" ).val()),
        min : 200,
        max : 1000,
        step : 10,
        slide : function(event, ui){
            $( "#max-popup-px" ).val( ui.value + "px" );
        }
    });
    $( "#max-popup-px" ).val( $( "#max-popup-px-slider" ).slider( "value" ) + "px");

    $('#popup-px-fromtop-slider').slider({
        value : parseInt($( "#popup-px-fromtop" ).val()),
        min : 50,
        max : 500,
        step : 10,
        slide : function(event, ui){
            $( "#popup-px-fromtop" ).val( ui.value + "px" );
        }
    });
    $( "#popup-px-fromtop" ).val( $( "#popup-px-fromtop-slider" ).slider( "value" ) + "px");
});

jQuery(document).ready(function($){

    var media_uploader = null;
    function open_media_uploader_image(e){
        var input_class = $(e.target).data('insert');
        media_uploader = wp.media({
            title:    "Choose a Background Image",
            button : {
                text : "Insert"
            },
            multiple: false
        });

        media_uploader.on("select", function(){
            var json = media_uploader.state().get("selection").first().toJSON();

            var image_url = json.url;
            var image_caption = json.caption;
            var image_title = json.title;

            $('.'+ input_class ).val(image_url);
        });

        media_uploader.open();
    }
    $('body').on('click', 'input#sc_int_ads_bg_button', function(e){
        open_media_uploader_image(e);
    });
});

// (function($){
//     var myTextArea = document.getElementById('interstitial_ads_css');
//     var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
//         lineNumbers : true,
//         mode : "css",
//         autoCloseBrackets: true,
//         tabSize : 2
//     });
// })(jQuery);
