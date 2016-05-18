jQuery(document).ready(function($){
    // Add Color Picker to all inputs that have 'color-field' class
    $( '.color-field' ).wpColorPicker();
});

jQuery(document).ready(function($){
	// Uploading files
	var file_frame;

	  jQuery('.accordion-item .button').live('click', function( event ){

	    event.preventDefault();

	    // If the media frame already exists, reopen it.
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    // Create the media frame.
	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: jQuery( this ).data( 'uploader_title' ),
	      button: {
	        text: jQuery( this ).data( 'uploader_button_text' ),
	      },
	      multiple: false  // Set to true to allow multiple files to be selected
	    });

	    // When an image is selected, run a callback.
	    file_frame.on( 'select', function() {
	      // We set multiple to false so only get one image from the uploader
	      attachment = file_frame.state().get('selection').first().toJSON();

	      // Do something with attachment.id and/or attachment.url here
	      $('input.img_url').val(attachment.url);
	      // console.log(attachment.url);
	    });

	    // Finally, open the modal
	    file_frame.open();
	  });
});

(function($){
	var myTextArea = document.getElementById('interstitial_ads_css');
	var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
		lineNumbers : true,
		mode : "css"
	});
})(jQuery);