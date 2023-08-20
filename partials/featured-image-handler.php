<?php
// featured-image-handler.php
function db_bulk_manager_handle_featured_image($post_id, $image_url) {
    if (!empty($image_url)) {
        $attachment_id = attachment_url_to_postid($image_url);
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
}

