<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://http://awebstar.com/
 * @since             1.0.0
 * @package           Admin_Panel
 *
 * @wordpress-plugin
 * Plugin Name:       Admin Panel
 * Plugin URI:        https://http://awebstar.com/
 * Description:       This is the admin panel
 * Version:           1.0.0
 * Author:            Nitika
 * Author URI:        https://http://awebstar.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       admin-panel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ADMIN_PANEL_VERSION', '1.0.0' );

if ( ! defined( 'PLUGIN_DIR_PATH' ) ) {
    define( 'PLUGIN_DIR_PATH', plugin_dir_path(__FILE__) );
}
if ( ! defined( 'PLUGIN_DIR_URL' ) ) {
    define( 'PLUGIN_DIR_URL', plugin_dir_url(__FILE__) );
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-admin-panel-activator.php
 */
function activate_admin_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-admin-panel-activator.php';
	Admin_Panel_Activator::activate();
}


function admin_panel_dashboard(){
    $icon_url = PLUGIN_DIR_URL . '/public/images/dashboard.png';
   
    add_menu_page('Dashboard', 'Admin Dashboard', 'manage_options', 'admin_dashboard', 'admin_dashboard',$icon_url,4);
    // add_submenu_page ( 'admin_dashboard', 'Import', 'Manage Warehouse owner', 'manage_options', 'admin_dashboard', 'admin_dashboard');
    add_submenu_page ( 'admin_dashboard', 'Generate', 'Manage Warehouse owner', 'manage_options', 'warehouse_owner', 'warehouse_owner'); 
     add_submenu_page ( 'admin_dashboard', 'Generate', 'Manage Listing of warehouse', 'manage_options', 'warehouse_listing', 'warehouse_listing');
     add_submenu_page ( 'admin_dashboard', 'Generate', 'New warehouse listing', 'manage_options', 'new_warehouse_listing', 'new_warehouse_listing');
    add_submenu_page ( 'admin_dashboard', 'Generate', 'Manage Payments', 'manage_options', 'warehouse_payments', 'warehouse_payments'); 
      add_submenu_page ( 'admin_dashboard', 'Generate', 'Manage Warehouse customer', 'manage_options', 'warehouse_customers', 'warehouse_customers'); 
    add_submenu_page ( 'admin_dashboard', 'Generate', 'Customer Warehouse Needs Post', 'manage_options', 'customer_posts', 'customer_posts'); 

}
add_action('admin_menu', 'admin_panel_dashboard');

function admin_dashboard(){
    require_once plugin_dir_path(__FILE__) . 'includes/admin_dashboard-view.php'; 
}
function warehouse_owner(){
    require_once plugin_dir_path(__FILE__) . 'includes/warehouse_owner-view.php'; 
}

function warehouse_listing(){
    require_once plugin_dir_path(__FILE__) . 'includes/warehouse_listing-view.php'; 
}
function new_warehouse_listing(){
      require_once plugin_dir_path(__FILE__) . 'includes/new_warehouse_listing-view.php'; 
}
function warehouse_payments(){
    require_once plugin_dir_path(__FILE__) . 'includes/warehouse_payments-view.php'; 
}
function warehouse_customers(){
    require_once plugin_dir_path(__FILE__) . 'includes/warehouse_customers-view.php'; 
}
function customer_posts(){
    require_once plugin_dir_path(__FILE__) . 'includes/customer_posts-view.php'; 
}



function custom_admin_datatable() {
    //echo '<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>';
    
     echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>';

   

}
add_action('admin_head', 'custom_admin_datatable');

function custom_admin_datatable_css() {
   echo '<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">';

     echo '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
      echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>';

}
add_action('admin_head', 'custom_admin_datatable_css');
function load_admin_things() {
    wp_enqueue_script('media-upload');
   wp_enqueue_script('thickbox');
     wp_enqueue_style('thickbox');
    

   }
  add_action( 'admin_enqueue_scripts', 'load_admin_things' );


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-admin-panel-deactivator.php
 */
function deactivate_admin_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-admin-panel-deactivator.php';
	Admin_Panel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_admin_panel' );
register_deactivation_hook( __FILE__, 'deactivate_admin_panel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-admin-panel.php';
require_once PLUGIN_DIR_PATH.'includes/functions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_admin_panel() {

	$plugin = new Admin_Panel();
	$plugin->run();

}
run_admin_panel();
