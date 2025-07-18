<?php
/**
 * Plugin Name: My API Plugin
 * Description: A plugin that sends a the user date to an external API.
 * Version: 1.0
 * Author: Divya Patil
 */

defined('ABSPATH') || exit;

// Include core classes
require_once plugin_dir_path(__FILE__) . 'includes/class-my-plugin-core.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-my-api-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-my-db-handler.php';

// Init plugin
function run_my_api_plugin() {
    $plugin = new My_Plugin_Core();
    $plugin->init();
}
run_my_api_plugin();

// Add settings link
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_settings_link' );
function my_plugin_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=my-api-plugin">Settings</a>';
    array_unshift( $links, $settings_link );
    return $links;
}

// Activation: Create DB table
register_activation_hook(__FILE__, ['My_DB_Handler', 'create_table']);

// Deactivation: Cleanup 
register_deactivation_hook(__FILE__, ['My_DB_Handler', 'on_deactivate']);
