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
 *
 */
require_once( __DIR__ . '/inc/class-settings.php' );
require_once( __DIR__ . '/inc/class-output-notice-msg.php' );

define( 'WP_T2T_PLUGIN_DIR_URL', plugins_url( '', __FILE__ ) );
define( 'WP_T2T_PLUGIN_DIR_PATH', __DIR__ );
define( 'WP_T2T_PLUGIN_FILE_PATH', __FILE__ );

load_plugin_textdomain(
		'the-2nd-toolbar',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
);

if ( is_admin() ) {
	new The_2nd_Toolbar_Options();
}

new The_2nd_Toolbar_Output();



/**
 * The constant WHAT_ENV_SITE should be one of them:
 * 'production_site'
 * 'staging_site'
 * 'dev_site'
 * 'local_site'
 * 'unknown_site'
 *  */
//if ( true === defined( 'WP_LOCAL_DEV' ) ) {
//	if ( true === WP_LOCAL_DEV ) {
//		define( 'WHAT_ENV_SITE', 'local_site' );
//	} elseif ( false === WP_LOCAL_DEV ) {
//		define( 'WHAT_ENV_SITE', 'production_site' );
//	}
//} elseif ( false === defined( 'WP_LOCAL_DEV' ) ) {
//	define( 'WHAT_ENV_SITE', 'unknown_site' );
//}

//new WhereAmINow();

//new The_2nd_Toolbar_Settings();

//new The_2nd_Toolbar();






//new Shifter_GH_Installer($work_dir);
