<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           WP_Scoper_Demo
 *
 * @wordpress-plugin
 * Plugin Name:       WP Scoper Demo
 * Plugin URI:        https://github.com/mescalantea/wp-scoper-demo
 * Description:       A demo plugin to show how to use PHP Scoper
 * Version:           1.0.0
 * Author:            Michel Escalante
 * Author URI:        https://github.com/mescalantea
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-scoper-demo
 * Domain Path:       /languages
 * Requires PHP:      7.2
 * Requires at least: 5.7.0
 * Tested up to:      6.4.3
 * WC requires at least: 6.5.0
 * WC tested up to:   8.5.2
 */

/* If this file is called directly, abort. */
if ( ! defined( 'WPINC' ) ) {
	die;
}