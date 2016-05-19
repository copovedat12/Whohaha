jQuery(document).ready(function($){
    // Add Color Picker to all inputs that have 'color-field' class
    $( '.color-field' ).wpColorPicker();
});

jQuery(document).ready(function($){

    var media_uploader = null;
    function open_media_uploader_image(e){
        var input_class = $(e.target).data('insert');
        media_uploader = wp.media({
            frame:    "post",
            state:    "insert",
            title: 'asdfasdf',
            button : {
                text : "Insert"
            },
            multiple: false
        });

        media_uploader.on("insert", function(){
            var json = media_uploader.state().get("selection").first().toJSON();

            var image_url = json.url;
            var image_caption = json.caption;
            var image_title = json.title;

            $('.'+ input_class ).val(image_url);
        });

        media_uploader.open();
    }
    $('body').on('click', 'input#interstitial_ads_bg_button, input#interstitial_ads_bg_button', function(e){
        open_media_uploader_image(e);
    });
});

(function($){
    var myTextArea = document.getElementById('interstitial_ads_css');
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers : true,
        mode : "css",
        autoCloseBrackets: true,
        tabSize : 2
    });
})(jQuery);
