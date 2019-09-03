<?php
/**
 * Plugin Name:     The 2nd toolbar
 * Plugin URI:      https://wp.tekapo.com/the-2nd-toobar/
 * Description:     A WordPress plugin that shows the 2nd toolbar just below the default toolbar.
 * Author:          JOTAKI, Taisuke
 * Author URI:      https://tekapo.com/
 * Text Domain:     the-2nd-toolbar
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Tne_2nd_Toolbar
 *
 * @todo
 *
 * Create the settings page, class-settings-page.php
 * Create the default settings like where am I now.
 * Change the file name, class-output-notice-msg.php to class-output-the-2nd-toolbar.php
 *
 *
 */
//require_once( __DIR__ . '/includes/class-settings.php' );
require_once( __DIR__ . '/includes/class-options-page.php' );
require_once( __DIR__ . '/includes/class-output-notice-msg.php' );

define( 'WP_T2T_PLUGIN_DIR_URL', plugins_url( '', __FILE__ ) );
define( 'WP_T2T_PLUGIN_DIR_PATH', __DIR__ );
define( 'WP_T2T_PLUGIN_FILE_PATH', __FILE__ );

load_plugin_textdomain(
		'the-2nd-toolbar',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
);

if ( is_admin() ) {
//	new The_2nd_Toolbar_Options();
	new Class_Options_Page();
}

new The_2nd_Toolbar_Output();
