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
			add_action( 'wp_footer', [ $this, 'echo_the_2nd_toolbar_outer_html' ], 999, 1 );
			add_action( 'admin_footer', [ $this, 'echo_the_2nd_toolbar_outer_html' ], 999, 1 );
			add_action('the_2nd_toolbar_innner_html', [$this, 'echo_where_am_i_now_html']);
			//	output css
			add_action( 'wp_enqueue_scripts', [ $this, 'add_the_2nd_toolbar_css' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'add_the_2nd_toolbar_css' ] );
		}
	}

	public function echo_the_2nd_toolbar_outer_html() {

		$notice_html = $this->get_where_am_i_now_html();
		$t2t_bar_color_css_name = $notice_html[0];
		$height_css_name = $this->get_height_css_class_name();
		
		$format = '<div class="t2t-outer %s %s">';
		$format_str = sprintf( 
				$format,
				$t2t_bar_color_css_name,
				$height_css_name
				);

		echo $format_str;

		do_action('the_2nd_toolbar_innner_html');

		echo '</div>';
		
	}
	
	public function get_height_option_value() {
		$t2t_options = get_option( self::OPTION_NAME );
		$t2t_height_value = $t2t_options['t2t_setting_name_height'];
        
//        var_dump($t2t_height_value);
		
		return $t2t_height_value;	
	}
	
	public function get_height_css_class_name() {
		$t2t_height_value = $this->get_height_option_value();
		
//		var_dump($t2t_height_value);
		
		if ( 32 === $t2t_height_value ) {
			$height_css_class_name = 'height_32px';
		} elseif ( 48 === $t2t_height_value ) {
			$height_css_class_name = 'height_48px';
		} elseif ( 64 === $t2t_height_value ) {
			$height_css_class_name = 'height_64px';
		} else {
			$height_css_class_name = 'someting-wrong-with-get_height_css_class_name-method';
		}
		
		return $height_css_class_name;
		
	}

	public function echo_where_am_i_now_html() {
		echo $this->get_where_am_i_now_html()[1];
	}

	/**
	 *
	 *
	 * @param none
	 *
	 * @return array
	 */
	public function get_where_am_i_now_html() {

		$t2t_options = get_option( self::OPTION_NAME );
		$what_server = $t2t_options[ self::OPTION_NAME_WAIN ];
        
//        var_dump($what_server);
        
        if ( is_null($what_server ) ) {
            $what_server = 'unknown-site';
        }

		$server_span_class = $what_server;

		$notice_txt_format = __( 'This site is on %s.', 'the-2nd-toolbar' );
		$notice_span_format = '<span id="env-bold">%s</span>';
		$notice_server_format = __( '%s server', 'the-2nd-toolbar' );

		$notice_str = $this->get_notice_str( $what_server );

		$notice_server_txt = sprintf( $notice_server_format, $notice_str );
		$notice_span_str = sprintf( $notice_span_format, $notice_server_txt );
		$notice_txt = sprintf( $notice_txt_format, $notice_span_str );

		return [$server_span_class, $notice_txt];
	}

	public function get_notice_str( $what_server ) {

		if ( 'production-site' === $what_server ) {
			$notice_str = __( 'the production', 'the-2nd-toolbar' );
		} elseif ( 'staging-site' === $what_server ) {
			$notice_str = __( 'the staging', 'the-2nd-toolbar' );
		} elseif ( 'development-site' === $what_server ) {
			$notice_str = __( 'the development', 'the-2nd-toolbar' );
		} elseif ( 'local-site' === $what_server ) {
			$notice_str = __( 'the local', 'the-2nd-toolbar' );
		} else {
			$notice_str = __( 'an unknown', 'the-2nd-toolbar' );
		}

		return $notice_str;
	}

	public function add_the_2nd_toolbar_css() {

		$stylesheet_path = WP_T2T_PLUGIN_DIR_URL . '/css/style.css';
		$css_file_ver = get_file_data( WP_T2T_PLUGIN_FILE_PATH, [ 'Version' ] );

		wp_register_style( 'the-2nd-toolbar-style', $stylesheet_path, [], $css_file_ver );
		wp_enqueue_style( 'the-2nd-toolbar-style' );
	}

}
