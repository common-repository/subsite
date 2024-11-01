(function ($) {
  $(document).ready(
    function() {
      $('body').on('click', '#subsite_logo_upload_button', function(e){
        e.preventDefault();
        let uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            let attachment = uploader.state().get('selection').first().toJSON();
            $('#subsite_logo_img').attr('src', attachment.url);
            $('#subsite_logo_img').show();
            $('#subsite_logo').val(attachment.id);
        })
        .open();
    });
    }
  )

})(jQuery);