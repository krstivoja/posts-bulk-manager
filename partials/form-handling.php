<?php
// form-handling.php

function db_bulk_manager_form_handling() {
    if (isset($_POST['db_bulk_update']) && wp_verify_nonce($_POST['db_bulk_manager_nonce'], 'db_bulk_manager_action')) {
        // Handle deletion of posts
        if (isset($_POST['delete_post_id'])) {
            wp_delete_post($_POST['delete_post_id'], true);
            echo '<div class="updated"><p>Post has been deleted!</p></div>';
        }

        // Handle updates to existing posts
        if (isset($_POST['post_titles']) && is_array($_POST['post_titles'])) {
            foreach ($_POST['post_titles'] as $post_id => $post_title) {
                wp_update_post(array('ID' => $post_id, 'post_title' => $post_title));
            }
        }

        // Handle updates to ACF fields for posts
        if (isset($_POST['acf']) && is_array($_POST['acf'])) {
            foreach ($_POST['acf'] as $post_id => $acf_fields) {
                foreach ($acf_fields as $key => $value) {
                    update_field($key, $value, $post_id);
                }
            }
        }

        // Handle new post creation
    if (!empty($_POST['new_post_title'])) {
        $new_post_id = wp_insert_post(array('post_title' => $_POST['new_post_title'], 'post_status' => 'publish'));
        if ($new_post_id && isset($_POST['acf_new_post']) && is_array($_POST['acf_new_post'])) {
            foreach ($_POST['acf_new_post'] as $key => $value) {
                update_field($key, $value, $new_post_id);
            }
        }
        // Handle the featured image for the new post
        if (!empty($_POST['featured_image_new'])) {
            db_bulk_manager_handle_featured_image($new_post_id, $_POST['featured_image_new']);
        }
        echo '<div class="updated"><p>New post created!</p></div>';
    }

        // Handle the featured image
        if (isset($_POST['featured_image']) && is_array($_POST['featured_image'])) {
            foreach ($_POST['featured_image'] as $post_id => $image_url) {
                db_bulk_manager_handle_featured_image($post_id, $image_url);
            }
        }

        echo '<div class="updated"><p>Changes have been saved!</p></div>';
    }
}
