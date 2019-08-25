<?php
/**
 * @todo
 *
 * Add some information about the current domain which helps for the user
 * to decide on what server WordPress is running now.
 *
 * Add the information of the top level domain.
 * Add the information whether is the current sub domain name includes some strings
 * like 'stg', 'staging'.
 *
 * $home_url = get_domain_name_from_home_url();
 * $site_url = get_domain_name_from_site_url();
 * $tld = get_top_level_domain( $home_url );
 * $bld = get_bottom_level_domain( $home_url );
 *
 * Add the information of the WP_LOCAL_DEV constant.
 * Add the information of the WP_DEBUG constant.
 *
 */


/**
 * Echo and output html and css.
 */
class Where_Am_I_Now_Output {

	function __construct() {
		add_action( 'init', [ $this, 'load_pulgin_init_function' ] );
	}

	public function load_pulgin_init_function() {
		if ( true === is_user_logged_in() ) {
			//	echo html
			add_action( 'wp_footer', [ $this, 'echo_where_am_i_now_html' ], 999, 1 );
			add_action( 'admin_footer', [ $this, 'echo_where_am_i_now_html' ], 999, 1 );
			//	output css
			add_action( 'wp_enqueue_scripts', [ $this, 'add_where_am_i_now_css' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'add_where_am_i_now_css' ] );
		}
	}

	public function echo_where_am_i_now_html() {
		echo $this->get_where_am_i_now_html();
	}

	public function get_where_am_i_now_html() {

		$options = get_option( 'where_am_i_now_option_name' );
		$what_server = $options[ 'where_am_i_now' ];
		$server_class = $what_server;

		$notice_txt_format = __( 'This site is on %s.', 'where-am-i-now' );
		$notice_span_format = '<span id="env-bold">%s</span>';
		$notice_server_format = __( '%s server', 'where-am-i-now' );

		$notice_str = $this->get_notice_str( $what_server );

		$notice_server_txt = sprintf( $notice_server_format, $notice_str );
		$notice_span_str = sprintf( $notice_span_format, $notice_server_txt );
		$notice_txt = sprintf( $notice_txt_format, $notice_span_str );

		$format = '<div class="notice-txt %1$s">%2$s</div>';
		$output_html = sprintf(
				$format,
				$server_class,
				$notice_txt,
		);

		return $output_html;
	}

	public function get_notice_str( $what_server ) {

		$notice_str_prod = __( 'the production', 'where-am-i-now' );
		$notice_str_staging = __( 'the staging', 'where-am-i-now' );
		$notice_str_dev = __( 'the development', 'where-am-i-now' );
		$notice_str_local = __( 'the local', 'where-am-i-now' );
		$notice_str_unknown = __( 'an unknown', 'where-am-i-now' );

		if ( 'production-site' === $what_server ) {
			$notice_str = $notice_str_prod;
		} elseif ( 'staging-site' === $what_server ) {
			$notice_str = $notice_str_staging;
		} elseif ( 'dev-site' === $what_server ) {
			$notice_str = $notice_str_dev;
		} elseif ( 'local-site' === $what_server ) {
			$notice_str = $notice_str_local;
		} else {
			$notice_str = $notice_str_unknown;
		}

		return $notice_str;
	}

	public function add_where_am_i_now_css() {

		$stylesheet_path = WP_WPWAIN_PLUGIN_DIR_URL . '/css/style.css';
		$css_file_ver = get_file_data( WP_WPWAIN_PLUGIN_FILE_PATH, array( 'Version' ) );

		wp_register_style( 'where-am-i-now-style', $stylesheet_path, [], $css_file_ver );
		wp_enqueue_style( 'where-am-i-now-style' );
	}

}
