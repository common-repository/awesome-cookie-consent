<?php 
/**
 * Plugin Name: Awesome GDPR Compliant Cookie Consent and Notice
 * Description: Awesome Cookie Consent plugin is one of the simplest, most popular and compatible to EU cookie law GDPR regulations out there.
 * Author: TechAstha
 * Author URI: https://techastha.com
 * Version: 3.0
 * Requires at least: 4.0
 * Tested up to: 5.8
 * Requires PHP: 5.6
 * Text Domain: gcccn
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Defines the current version of the plugin.
define( 'GCCCN_VERSION', '3.0' );

// Defines the name of the plugin.
define( 'GCCCN_NAME', 'Awesome GDPR Compliant Cookie Consent and Notice' );

// Defines the path to the main plugin file.
define( 'GCCCN_FILE', __FILE__ );

define( 'GCCCN_PLUGIN_BASENAME', plugin_basename( GCCCN_FILE ) );

// Defines the path to be used for includes.
define( 'GCCCN_DIR_PATH', plugin_dir_path( GCCCN_FILE ) );

// Defines the path for plugin directory.
define( 'GCCCN_PLUGINS_DIR_PATH', plugin_dir_path( __DIR__ ) );

// Defines the URL to the plugin.
define( 'GCCCN_URL', plugin_dir_url( GCCCN_FILE ) );

// Defines the path to be used for css/js/images include .
define( 'GCCCN_ASSETS_URL', GCCCN_URL.'assets/' );

// Defines environment. (i) P for "Production" (ii) D for "Development"
define( 'GCCCN_ENVIRONMENT', 'P' );

/**
 * Include core plugin classes.
 */
require GCCCN_DIR_PATH . 'classes/class-gcccn.php';
$gcccn = new GCCCN();
