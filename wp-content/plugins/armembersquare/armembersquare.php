<?php 
/*
  Plugin Name: ARMember - Square payment gateway Addon
  Description: Extension for ARMember plugin to accept payments using Square Payment Gateway.
  Version: 1.6
  Plugin URI: https://www.armemberplugin.com
  Author: Repute InfoSystems
  Author URI: https://www.armemberplugin.com
  Text Domain: ARM_SQUARE
 */

define('ARM_SQUARE_DIR_NAME', 'armembersquare');
define('ARM_SQUARE_DIR', WP_PLUGIN_DIR . '/' . ARM_SQUARE_DIR_NAME);

if(file_exists(ARM_SQUARE_DIR.'/autoload.php'))
{
    require_once ARM_SQUARE_DIR.'/autoload.php';
}

?>