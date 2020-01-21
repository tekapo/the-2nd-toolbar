<?php
/*
 * @todo
 *
 * add textbox:
 *
 * add top option:
 *
 * Choodse what you want to show in the 2nd toolbar
 * - free text
 * -
 *
 * - show free text
 *
 * add checkbox:
 *
 * - show Where Am I Now
 * - show WP_DEBUG
 * - show WP_LOCAL_DEV
 * - show time
 *
 * You wanna the 3rd and 4th toolbar?
 *
 *
 * How to sanitize radio value?
 *
 * how about specifing these?
 * field type = radio, text, checkbox
 *
 * at least I should make radio fields.
 *
 */

require_once( __DIR__ . '/class-options-parts.php' );

class Class_Options_Page {

	private $options;

	public const OPTION_NAME = 't2t_option_name';
	public const OPTION_GROUP = 't2t_option_group';
	public const PAGE_SLUG = 'the-2nd-toolbar-options';
	public const SETTING_SECTION_ID = 't2t_setting_section_id';
	public const OPTION_NAME_HEIGHT = 't2t_setting_name_height';
	public const SETTING_SECTION_ID_ONLY_LOGEDIN = 't2t_setting_section_id_only_logged_in';
	public const OPTION_NAME_ONLY_LOGGEDIN = 't2t_setting_name_only_logged_in';
	public const SETTING_SECTION_ID_GENERAL = 't2t_setting_section_id_general';
	public const OPTION_NAME_POSITION = 't2t_setting_name_position';
	public const SETTING_SECTION_ID_POSITION = 't2t_setting_section_id_position';
	public const OPTION_NAME_WAIN = 'where_am_i_now';
	public const SETTING_SECTION_ID_WAIN = 't2t_setting_section_id_wain';

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will be under "Settings"
		$setting_page_and_menu_title = __( 'The 2nd Toolbar', 'the-2nd-toolbar' );
		add_options_page(
				$setting_page_and_menu_title,
				$setting_page_and_menu_title,
				'manage_options',
				self::PAGE_SLUG, //	'the-2nd-toolbar-options',
				[ $this, 'create_admin_page' ]
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = get_option( self::OPTION_NAME );

		$page_title = __( 'The 2nd Toolbar Settings', 'the-2nd-toolbar' );

		$form = '
	        <div class="wrap">
	            <h1>%s</h1>
		        <form method="post" action="options.php">
			';

		echo sprintf( $form, $page_title );

		settings_fields( self::OPTION_GROUP );
		do_settings_sections( self::PAGE_SLUG );
		submit_button();

		echo '
				</form>
			</div>
			';
	}

	/**
	 * Register and add settings
	 */
	public function register_setting() {

//		$parts = new Class_Options_Parts();

		register_setting(
				self::OPTION_GROUP, // Option group
				self::OPTION_NAME, // Option name
//				[ $parts->the_2nd_toolbar_sanitize($input)]
				[ $this, 'the_2nd_toolbar_sanitize' ] // Sanitize
		);
	}

	public function add_setting_section() {
//		add_settings_section(
//				self::SETTING_SECTION_ID,
//				'My Custom Settings', // Title
//				array( $this, 'print_section_info' ), // Callback
//				self::PAGE_SLUG // Page
//		);
		add_settings_section(
				self::SETTING_SECTION_ID_GENERAL,
				'General Settings', // Title
				'',
//				array( $this, 'print_section_info' ), // Callback
				self::PAGE_SLUG // Page
		);
		add_settings_section(
				self::SETTING_SECTION_ID_WAIN,
				'Where Am I Now Settings', // Title
				'',
//				array( $this, 'print_section_info_wain' ), // Callback
				self::PAGE_SLUG // Page
		);
	}

	public function add_settings_field() {

		$parts = new Class_Options_Parts();

//		foreach ( $array as $key => $value ) {
//
//		}
//		$parts->add_settings_field_template(
//				'id_number',
//				'ID Number',
//				array( $this, 'id_number_callback' ),
//				self::SETTING_SECTION_ID
//		);
//
//		$parts->add_settings_field_template(
//				'title',
//				'Title',
//				array( $this, 'title_callback' ),
//				self::SETTING_SECTION_ID
//		);

		$parts->add_settings_field_template(
				'show_only_logged_in',
				'Show only for logged in user',
				[ $this, 'show_only_logged_in_callback' ],
				self::SETTING_SECTION_ID_GENERAL
		);

		$parts->add_settings_field_template(
				'height',
				'Height',
				[ $this, 'height_options_callback' ],
				self::SETTING_SECTION_ID_GENERAL
		);

		$parts->add_settings_field_template(
				'position',
				'Position',
				[ $this, 'position_options_callback' ],
				self::SETTING_SECTION_ID_GENERAL
		);

		$parts->add_settings_field_template(
				'where_am_i_now_setting_id',
				__( 'Where Am I Now Setting', 'the-2nd-toolbar' ),
				[ $this, 'where_am_i_now_setting_callback' ],
				self::SETTING_SECTION_ID_WAIN, // Section
		);
	}

	public function page_init() {
		$this->register_setting();
		$this->add_setting_section();
		$this->add_settings_field();
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		print 'Enter your settings below:';
	}

	public function print_section_info_wain() {
		echo __( 'Where Am I Now', 'the-2nd-toolbar' );
	}
	public function print_section_info2() {
		return 'Enter your settings below:';
	}
	/**
	 * Get the settings option array and print one of its values
	 */
//	public function id_number_callback() {
//		printf(
//				'<input type="text" id="id_number" name="%s[id_number]" value="%s" />',
//				self::OPTION_NAME,
//				isset( $this->options[ 'id_number' ] ) ? esc_attr( $this->options[ 'id_number' ] ) : ''
//		);
//	}

	/**
	 * Get the settings option array and print one of its values
	 */
//	public function title_callback() {
//		printf(
//				'<input type="text" id="title" name="%s[title]" value="%s" />',
//				self::OPTION_NAME,
//				isset( $this->options[ 'title' ] ) ? esc_attr( $this->options[ 'title' ] ) : ''
//		);
//	}

	public function show_only_logged_in_callback() {

		$this->options = get_option( self::OPTION_NAME );

		$parts = new Class_Options_Parts();

		if ( isset( $this->options[ self::OPTION_NAME_ONLY_LOGGEDIN ] ) ) {
			$current = $this->options[ self::OPTION_NAME_ONLY_LOGGEDIN ];
			if ( 'on' === $current ) {
				$is_checked = 'checked';
			}
		} else {
			$is_checked = '';
		}

		$screen_reader_text = '';
		$label_name_id = self::OPTION_NAME . '[' . self::OPTION_NAME_ONLY_LOGGEDIN . ']';
		$description = 'Show the toolbar for only logged in users.';

		$fieldset_html = $parts->get_fieldset_html_checkbox_single(
				$screen_reader_text,
				$label_name_id,
				$is_checked,
				$description
		);

		echo $fieldset_html;
	}

	public function height_options_callback() {

		$parts = new Class_Options_Parts;

		$fieldset_html_form = $parts->get_fieldset_html_form_buttons( 3 );

		$what_height = $this->get_what_height_checked();

		$height_32_form = $this->get_height_radio_button_form(
				'height32px',
				'32',
				$what_height[ '32' ],
				'32px (same as the default toolbar)' );
		$height_48_form = $this->get_height_radio_button_form(
				'height48px',
				'48',
				$what_height[ '48' ],
				'48px (1.5 times as high as the default toolbar)' );
		$height_64_form = $this->get_height_radio_button_form(
				'height64px',
				'64',
				$what_height[ '64' ],
				'64px (2 times as high as the default toolbar)' );

		$fieldset_html = sprintf(
				$fieldset_html_form,
				__( 'Height of the toolbar.', 'the-2nd-toolbar' ),
				$height_32_form,
				$height_48_form,
				$height_64_form,
				__( 'Choose how high the toolbar is.', 'the-2nd-toolbar' ),
		);

		echo $fieldset_html;
	}

	public function get_what_height_checked() {

		$this->options = get_option( self::OPTION_NAME );

		if ( true === isset( $this->options[ self::OPTION_NAME_HEIGHT ] ) ) {
			$num = ( int ) $this->options[ self::OPTION_NAME_HEIGHT ];
		} else {
			$num = 404;
		}

		$keys = [ '32', '48', '64', 'unknown' ];
		$height = array_fill_keys( $keys, '' );

		if ( 32 === $num ) {
			$height[ '32' ] = 'checked';
		} elseif ( 48 === $num ) {
			$height[ '48' ] = 'checked';
		} elseif ( 64 === $num ) {
			$height[ '64' ] = 'checked';
		} else {
			$height[ 'unknown' ] = $num;
		}

		return $height;
	}

	public function get_height_radio_button_form(
			$radio_button_label_and_name,
			$radio_button_value,
			$is_checked,
			$radio_button_txt ) {

		$parts = new Class_Options_Parts();

		$radio_button_form = $parts->get_radio_button_form_template();

		$input_name = self::OPTION_NAME . '[' . self::OPTION_NAME_HEIGHT . ']';

		$form_output = sprintf(
				$radio_button_form,
				$radio_button_label_and_name,
				$input_name,
				$radio_button_value,
				$is_checked,
				$radio_button_txt,
		);
		return $form_output;
	}

	public function position_options_callback() {

		$parts = new Class_Options_Parts();

		$fieldset_html_form = $parts->get_fieldset_html_form_buttons( 4 );

		$what_position = $this->get_what_position_checked();

		$position_top_form = $this->get_what_position_button_form( 'top', $what_position );
		$position_bottom_form = $this->get_what_position_button_form( 'bottom', $what_position );
		$position_left_form = $this->get_what_position_button_form( 'left', $what_position );
		$position_right_form = $this->get_what_position_button_form( 'right', $what_position );

		$fieldset_html = sprintf(
				$fieldset_html_form,
				__( 'Position Setting', 'the-2nd-toolbar' ),
				$position_top_form,
				$position_bottom_form,
				$position_left_form,
				$position_right_form,
				__( 'Choose what position the toolbar appear.', 'the-2nd-toolbar' ),
		);

		echo $fieldset_html;
	}

	public function get_what_position_button_form( $label_and_name, $what_position ) {
		$what_position_key = array_search( 'checked', $what_position );

		$is_checked = '';

		if ( $label_and_name === $what_position_key ) {
			$is_checked = 'checked';
		}

		$input_name = self::OPTION_NAME . '[' . self::OPTION_NAME_POSITION . ']';

		$parts = new Class_Options_Parts();

		$form_output = sprintf(
				$parts->get_radio_button_form_template(),
				$label_and_name,
				$input_name,
				$label_and_name,
				$is_checked,
				$label_and_name,
		);

		return $form_output;
	}

	public function get_what_position_checked() {
		$this->options = get_option( self::OPTION_NAME );

		if ( true === isset( $this->options[ self::OPTION_NAME_POSITION ] ) ) {
			$str = $this->options[ self::OPTION_NAME_POSITION ];
			$what_position_checked = $this->decide_what_position_checked( $str );
		}

		return $what_position_checked;
	}

	public function decide_what_position_checked( $str ) {

		$keys = [ 'top', 'bottom', 'left', 'right', 'unknown' ];
		$what_site = array_fill_keys( $keys, '' );

		if ( 'top' === $str ) {
			$what_site[ 'top' ] = 'checked';
		} elseif ( 'bottom' === $str ) {
			$what_site[ 'bottom' ] = 'checked';
		} elseif ( 'left' === $str ) {
			$what_site[ 'left' ] = 'checked';
		} elseif ( 'right' === $str ) {
			$what_site[ 'right' ] = 'checked';
		} else {
			$what_site[ 'unknown' ] = $str;
		}

		return $what_site;
	}

	public function decide_what_site_checked( $str ) {

		$keys = [ 'production', 'staging', 'development', 'local', 'unknown' ];
		$what_site = array_fill_keys( $keys, '' );

		if ( 'production-site' === $str ) {
			$what_site[ 'production' ] = 'checked';
		} elseif ( 'staging-site' === $str ) {
			$what_site[ 'staging' ] = 'checked';
		} elseif ( 'development-site' === $str ) {
			$what_site[ 'development' ] = 'checked';
		} elseif ( 'local-site' === $str ) {
			$what_site[ 'local' ] = 'checked';
		} else {
			$what_site[ 'unknown' ] = $str;
		}

		return $what_site;
	}

	public function get_what_site_checked() {
		$this->options = get_option( self::OPTION_NAME );

		if ( true === isset( $this->options[ self::OPTION_NAME_WAIN ] ) ) {
			$str = $this->options[ self::OPTION_NAME_WAIN ];
			$what_site_checked = $this->decide_what_site_checked( $str );
		}

		return $what_site_checked;
	}

	public function get_id_num( $site_env_type ) {
		if ( 'production' === $site_env_type ) {
			$id_num = 0;
		} elseif ( 'staging' === $site_env_type ) {
			$id_num = 1;
		} elseif ( 'development' === $site_env_type ) {
			$id_num = 2;
		} elseif ( 'local' === $site_env_type ) {
			$id_num = 3;
		} elseif ( 'unknown' === $site_env_type ) {
			$id_num = 4;
		}

		return $id_num;
	}

	public function get_what_site_button_form( $site_env_type, $what_site ) {

		$what_site_key = array_search( 'checked', $what_site );

		$is_checked = '';

		if ( $site_env_type === $what_site_key ) {
			$is_checked = 'checked';
		}

		$input_name = self::OPTION_NAME . '[' . self::OPTION_NAME_WAIN . ']';

		$id_num = $this->get_id_num( $site_env_type );

		$parts = new Class_Options_Parts();

		$form_output = sprintf(
				$parts->get_radio_button_form_template(),
				'the_2nd_toolbar-' . ( string ) $id_num,
				$input_name,
				$site_env_type . '-site',
				$is_checked,
				'The ' . $site_env_type . ' server.',
		);

		return $form_output;
	}

	public function where_am_i_now_setting_callback() {

		$parts = new Class_Options_Parts();

		$fieldset_html_form = $parts->get_fieldset_html_form_buttons( 4 );

		$what_site = $this->get_what_site_checked();

		$prod_form = $this->get_what_site_button_form( 'production', $what_site );
		$stg_form = $this->get_what_site_button_form( 'staging', $what_site );
		$dev_form = $this->get_what_site_button_form( 'development', $what_site );
		$local_form = $this->get_what_site_button_form( 'local', $what_site );

		$fieldset_html = sprintf(
				$fieldset_html_form,
				__( 'Where Am I Now Setting', 'the-2nd-toolbar' ),
				$prod_form,
				$stg_form,
				$dev_form,
				$local_form,
				__( 'Choose what server your WordPress running on.', 'the-2nd-toolbar' ),
		);

		echo $fieldset_html;
	}

	public function the_2nd_toolbar_sanitize( $input ) {
		$sanitized_values = [];

		if ( isset( $input[ 'id_number' ] ) ) {
			$sanitized_values[ 'id_number' ] = absint( $input[ 'id_number' ] );
		}
		if ( isset( $input[ 'title' ] ) ) {
			$sanitized_values[ 'title' ] = sanitize_text_field( $input[ 'title' ] );
		}
		if ( isset( $input[ self::OPTION_NAME_WAIN ] ) ) {
			if ( preg_match( '#[A-Za-z]#', $input[ self::OPTION_NAME_WAIN ] ) ) {
				$sanitized_values[ self::OPTION_NAME_WAIN ] = $input[ self::OPTION_NAME_WAIN ];
			}
		}
		if ( isset( $input[ self::OPTION_NAME_ONLY_LOGGEDIN ] ) ) {
			if ( 'on' === $input[ self::OPTION_NAME_ONLY_LOGGEDIN ] ) {
				$sanitized_values[ self::OPTION_NAME_ONLY_LOGGEDIN ] = $input[ self::OPTION_NAME_ONLY_LOGGEDIN ];
			}
		}
		if ( isset( $input[ self::OPTION_NAME_HEIGHT ] ) ) {
			$sanitized_values[ self::OPTION_NAME_HEIGHT ] = absint( $input[ self::OPTION_NAME_HEIGHT ] );
		}
		if ( isset( $input[ self::OPTION_NAME_POSITION ] ) ) {
			if ( preg_match( '#[A-Za-z]#', $input[ self::OPTION_NAME_POSITION ] ) ) {
				$sanitized_values[ self::OPTION_NAME_POSITION ] = $input[ self::OPTION_NAME_POSITION ];
			}
		}

		return $sanitized_values;
	}

}
