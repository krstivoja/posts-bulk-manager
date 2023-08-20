<?php
/*
 * Plugin Name:       Bulk Post Types Manager
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Manage Titles, Features images, ACF and Matabox Fields
 * Version:           0.0.1
 * Requires at least: 6.3
 * Requires PHP:      7.2
 * Author:            DPlugins
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       dp-buld-post-types-manager
 * Domain Path:       /languages
 */

// Include partials
include(plugin_dir_path(__FILE__) . 'partials/menu-registration.php');
include(plugin_dir_path(__FILE__) . 'partials/form-handling.php');
include(plugin_dir_path(__FILE__) . 'partials/form-display.php');
include(plugin_dir_path(__FILE__) . 'partials/featured-image-handler.php');

// Main Display Function (combines the handling and display functions)
function db_bulk_manager_display() {
    db_bulk_manager_form_handling();  // Call the form handling function
    db_bulk_manager_form_display();   // Call the form display function
}

// Register the stylesheet
function db_bulk_manager_register_styles() {
    wp_register_style('db_bulk_manager_css', plugin_dir_url(__FILE__) . 'css/db_bulk_manager.css', [], '1.0.0');
}

add_action('admin_init', 'db_bulk_manager_register_styles');

// Enqueue the stylesheet only on our specific admin page
function db_bulk_manager_enqueue_styles($hook_suffix) {
    global $db_bulk_manager_hook_suffix; // Access the global variable

    if ($hook_suffix == $db_bulk_manager_hook_suffix) {
        wp_enqueue_style('db_bulk_manager_css');
    }
}

add_action('admin_enqueue_scripts', 'db_bulk_manager_enqueue_styles');


function db_enqueue_media_uploader() {
    wp_enqueue_media();
    wp_enqueue_script('db-media-uploader', plugin_dir_url(__FILE__) . 'db-media-uploader.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'db_enqueue_media_uploader');
