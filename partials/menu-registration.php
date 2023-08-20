<?php
global $db_bulk_manager_hook_suffix; // Declare it global so we can access it later

add_action('admin_menu', 'db_bulk_manager_menu');

function db_bulk_manager_menu() {
    global $db_bulk_manager_hook_suffix; // Access the global variable

    $db_bulk_manager_hook_suffix = add_submenu_page(
        'edit.php', 
        'Bulk Manager', 
        'Bulk Manager', 
        'manage_options', 
        'db-bulk-manager', 
        'db_bulk_manager_display'
    );
}
