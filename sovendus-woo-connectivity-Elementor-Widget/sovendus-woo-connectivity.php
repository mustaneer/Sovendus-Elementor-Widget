<?php
/**
 *  Sovendus WooCommerce Connectivity
 *
 * Plugin Name: Sovendus WooCommerce Connectivity
 * Description: A plugin to connect sovendus script on thank you page.
 * Plugin URI:  https://mustaneerabdullah.com/
 * Version:	 1.0.0
 * Author:	  Mustaneer Abdullah
 * Author URI:  https://mustaneerabdullah.com/
 * Text Domain: sovendus-connectivity
 */
define( 'SOVENDUS_WOOCONNECT', __FILE__ );

/**
 * Include the Elementor_Sovendus class.
 */
require plugin_dir_path( SOVENDUS_WOOCONNECT ) . 'class-elementor-sovendus-connect.php';
