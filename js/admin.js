jQuery(document).ready(function($) {

    $('#cloner-01').cloner({
        afterToggle: function ($clone, i, self) {
            $clone.find('img').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
            $clone.find('input, textarea').val('');
        }
    }).find('.clonable-button-destroy-all').on('click', function (e) {
        $('#cloner-01').find('.clonable').each(function () {
            if ('1' != $(this).data('clone-number')) {
                $(this).remove();
            } else {
                $(this).find('input, textarea').val('');
                $(this).find('img').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
            }
        });
    });
    if ($('#cloner-01 .clonable').length != 1) {
        $('#cloner-01 .clonable').each(function (e) {
            $(this).find('.clonable-button-close').show();
        });
        var f = $('#cloner-01 .clonable:first');
        f.find('.clonable-button-close').hide();
    }

    // Carousel
    $(document).on('click', '.photogal .button-media', function (e) {
        e.preventDefault();
        var _this   = $(this).attr("id");
        var _target = $("#"+_this).attr("data-target");
        var _input  = $("#"+_this).attr("data-input");

        //If the uploader object has already been created, reopen the dialog
        // if (typeof custom_uploader !== 'undefined') {
        //     custom_uploader.open();
        //     return;
        // }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = new wp.media({
            title: 'Choose Image',
            button: {
                text: "Set as Slide Image"
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $(_target).attr('src', attachment.url);
            $(_input).val(attachment.url);
            console.log(_target, _input);
        });

        //Open the uploader dialog
        custom_uploader.open();

        return false;

    });

    $(document).on('click', '.button-destroy-all.carousel', function(){
        $('.carousel .carousel-item').each(function(){
            if( 'carousel_item_0' != $(this).attr('id') )
            {
                $(this).remove();
            } else {
                $(this).find('input, textarea').val('');
                $(this).find('img').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
            }
        });
    });
});