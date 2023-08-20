<?php
// form-display.php
function db_bulk_manager_form_display() {
    // Displaying form
    echo '<form method="post" enctype="multipart/form-data">';
    wp_nonce_field('db_bulk_manager_action', 'db_bulk_manager_nonce');

    $field_groups = acf_get_field_groups();
    $all_acf_keys = [];
    foreach ($field_groups as $field_group) {
        $fields = acf_get_fields($field_group);
        foreach ($fields as $field) {
            if (in_array($field['type'], ['text', 'number'])) {
                $all_acf_keys[$field['key']] = $field;
            }
        }
    }

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'post'
    );
    $posts = get_posts($args);

    echo '<h2 class="page-title">Bulk Manager</h2>';

    // Open the wrapper div for the main table
    echo '<div id="tableWrap">';
    echo '<table id="bulk-list-table" class="widefat striped"><thead><tr>';
    echo '<th><span>Featured Image</span></th>';
    echo '<th><span>Title</span></th>';

    foreach ($all_acf_keys as $acf_key => $acf_field) {
        echo '<th><span>' . esc_html($acf_field['label']) . '</span></th>';
    }

    echo '<th><span>Actions</span></th>';
    echo '</tr></thead><tbody>';

    foreach ($posts as $post) {
        echo '<tr>';

        // Get the Featured Image URL
        $featured_image_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        echo '<td class="featuredImage">';
        if ($featured_image_url) {
            echo '<img src="' . esc_attr($featured_image_url) . '" style="max-width:60px; display:block;" class="featured-preview-' . $post->ID . '">';
            echo '<input type="hidden" name="featured_image[' . $post->ID . ']" class="featured-input-' . $post->ID . '" value="' . esc_attr($featured_image_url) . '">';
            echo '<button type="button" class="remove-image-button" data-post-id="' . $post->ID . '">Remove Image</button>';
        } 
        echo '<button type="button" class="upload-image-button" data-post-id="' . $post->ID . '">Upload Image</button>';
        echo '</td>';

        echo '<td><input type="text" name="post_titles[' . $post->ID . ']" value="' . esc_attr($post->post_title) . '" placeholder="• Empty Field"></td>';

        foreach ($all_acf_keys as $acf_key => $acf_field) {
            $value = get_field($acf_key, $post->ID);
            echo '<td><input type="' . $acf_field['type'] . '" name="acf[' . $post->ID . '][' . $acf_key . ']" value="' . esc_attr($value) . '" placeholder="• Empty Field"></td>';
        }

        echo '<td><button type="submit" name="delete_post_id" value="' . $post->ID . '" onclick="return confirm(\'Are you sure?\')">Delete</button></td>';
        echo '</tr>';
    }

    // Close the wrapper div for the main table
    echo '</tbody></table>';
    echo '</div>'; // End of tableWrap div

    // Begin newPostWrap for the Add New Post section
    echo '<h3>Add New Post</h3>';
    echo '<div id="newPostWrap">';


    echo '<table id="add-new-post-table" class="widefat striped"><thead><tr>';
    echo '<th><span>Featured Image</span></th>';
    echo '<th><span>Title</span></th>';

    foreach ($all_acf_keys as $acf_key => $acf_field) {
        echo '<th><span>' . esc_html($acf_field['label']) . '</span></th>';
    }

    echo '<th></th>';  // Empty header for the action column
    echo '</tr></thead><tbody>';

    // Add New Post section
    echo '<tr id="newPost">';
    echo '<td><button type="button" class="upload-image-button-new">Upload Image</button></td>';
    echo '<td><input type="text" name="new_post_title" placeholder="Enter new post title"></td>';
    foreach ($all_acf_keys as $acf_key => $acf_field) {
        echo '<td><input type="' . $acf_field['type'] . '" name="acf_new_post[' . $acf_key . ']" placeholder="' . esc_attr($acf_field['label']) . '"></td>';
    }
    echo '<td></td>';  // this cell remains empty because we don't need actions for a new post entry
    echo '</tr>';

    echo '</tbody></table>';

    // End newPostWrap div
    echo '</div>';

    echo '<br><input id="saveBTN" type="submit" name="db_bulk_update" value="Update">';

    echo '</form>';
}
?>
