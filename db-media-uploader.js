jQuery(document).ready(function($) {
    var mediaUploader;

    $('.upload-image-button').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var postID = button.data('post-id');

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('.featured-input-' + postID).val(attachment.url);
            $('.featured-preview-' + postID).attr('src', attachment.url);
        });

        mediaUploader.open();
    });
});
