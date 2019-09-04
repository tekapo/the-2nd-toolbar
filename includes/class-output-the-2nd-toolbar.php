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
class Output_The_2nd_Toolbar {

	public const OPTION_NAME = 't2t_option_name';
	public const OPTION_NAME_WAIN = 'where_am_i_now';

	function __construct() {
		add_action( 'init', [ $this, 'load_pulgin_init_function' ] );
	}

	public function load_pulgin_init_function() {
		if ( true === is_user_logged_in() ) {
			//	echo html
			add_action( 'wp_footer', [ $this, 'echo_the_2nd_toolbar_html' ], 999, 1 );
			add_action( 'admin_footer', [ $this, 'echo_the_2nd_toolbar_html' ], 999, 1 );
			//	output css
			add_action( 'wp_enqueue_scripts', [ $this, 'add_the_2nd_toolbar_css' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'add_the_2nd_toolbar_css' ] );
		}
	}

	public function echo_the_2nd_toolbar_html() {
		echo $this->get_the_2nd_toolbar_wrap_html();
	}

	public function get_the_2nd_toolbar_wrap_html() {

		$t2t_options = get_option( self::OPTION_NAME );

		$what_server = $t2t_options[ self::OPTION_NAME_WAIN ];
		$server_class = $what_server;

		$notice_txt_format = __( 'This site is on %s.', 'the-2nd-toolbar' );
		$notice_span_format = '<span id="env-bold">%s</span>';
		$notice_server_format = __( '%s server', 'the-2nd-toolbar' );

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

	public function get_where_am_i_now_html( $what_server ) {

	}

	public function get_notice_str( $what_server ) {

		$notice_str_prod = __( 'the production', 'the-2nd-toolbar' );
		$notice_str_staging = __( 'the staging', 'the-2nd-toolbar' );
		$notice_str_dev = __( 'the development', 'the-2nd-toolbar' );
		$notice_str_local = __( 'the local', 'the-2nd-toolbar' );
		$notice_str_unknown = __( 'an unknown', 'the-2nd-toolbar' );

		if ( 'production-site' === $what_server ) {
			$notice_str = $notice_str_prod;
		} elseif ( 'staging-site' === $what_server ) {
			$notice_str = $notice_str_staging;
		} elseif ( 'development-site' === $what_server ) {
			$notice_str = $notice_str_dev;
		} elseif ( 'local-site' === $what_server ) {
			$notice_str = $notice_str_local;
		} else {
			$notice_str = $notice_str_unknown;
		}

		return $notice_str;
	}

	public function add_the_2nd_toolbar_css() {

		$stylesheet_path = WP_T2T_PLUGIN_DIR_URL . '/css/style.css';
		$css_file_ver = get_file_data( WP_T2T_PLUGIN_FILE_PATH, array( 'Version' ) );

		wp_register_style( 'the-2nd-toolbar-style', $stylesheet_path, [], $css_file_ver );
		wp_enqueue_style( 'the-2nd-toolbar-style' );
	}

}
