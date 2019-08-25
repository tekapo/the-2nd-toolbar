<?php
/**
 * Plugin Name:     Where Am I Now
 * Plugin URI:      https://wp.tekapo.com/where-am-i-now/
 * Description:     A WordPress plugin that shows what environment (a production site, a staging site or so on) you are browsing now.
 * Author:          JOTAKI, Taisuke
 * Author URI:      https://tekapo.com/
 * Text Domain:     where-am-i-now
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Where_Am_I_Now
 *
 * @todo
 *
 *
 */
require_once( __DIR__ . '/inc/class-settings.php' );
require_once( __DIR__ . '/inc/class-output-notice-msg.php' );

define( 'WP_WPWAIN_PLUGIN_DIR_URL', plugins_url( '', __FILE__ ) );
define( 'WP_WPWAIN_PLUGIN_DIR_PATH', __DIR__ );
define( 'WP_WPWAIN_PLUGIN_FILE_PATH', __FILE__ );

load_plugin_textdomain(
		'where-am-i-now',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
);

if ( is_admin() ) {
	new Where_Am_I_Now_Options();
}

new Where_Am_I_Now_Output();



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

//new Where_Am_I_Now_Settings();

//new Where_Am_I_Now();






//new Shifter_GH_Installer($work_dir);
