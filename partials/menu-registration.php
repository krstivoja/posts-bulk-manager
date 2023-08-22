<?php
global $db_bulk_manager_hook_suffixes; // Declare an array to store multiple hook_suffixes

add_action('admin_menu', 'db_bulk_manager_menu');

function db_bulk_manager_menu() {
    global $db_bulk_manager_hook_suffixes;

    $db_bulk_manager_hook_suffixes = [];

    $args = array(
        'public'   => true,
        '_builtin' => false
    );

    $output = 'names';
    $operator = 'and';
    $post_types = get_post_types($args, $output, $operator);

    // Iterate over each custom post type and add a submenu page
    foreach ($post_types as $post_type) {
        $db_bulk_manager_hook_suffixes[$post_type] = add_submenu_page(
            'edit.php?post_type=' . $post_type, 
            'Bulk Manager for ' . ucfirst($post_type), 
            'Bulk Manager', 
            'manage_options', 
            'db-bulk-manager-' . $post_type, 
            'db_bulk_manager_display'
        );
    }
}
