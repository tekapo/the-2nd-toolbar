<?php

/**
 * Plugin Name:     Where Am I Now
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     where-am-i-now
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Where_Am_I_Now
 */
//if (!is_user_logged_in()) {
//	return;
//}

add_action('wp_footer', 'echo_where_am_i_now_html');
add_action('wp_enqueue_scripts', 'add_where_i_am_now_stylesheet');

function echo_where_am_i_now_html() {
	$warning_txt = 'これはテスト環境です';
	$format = '<div class="warning_txt">%s</div>';
	$output_html = sprintf($format, $warning_txt);
	echo $output_html;
}

function add_where_i_am_now_stylesheet() {
	$stylesheet_path = plugins_url('css/style' . '.css', __FILE__);
	wp_register_style('current-template-style', $stylesheet_path);
	wp_enqueue_style('current-template-style');
}
