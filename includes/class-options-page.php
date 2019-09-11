<?php
/*
 * @todo
 *
 * How to sanitize radio value?
 */

class Class_Options_Page {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	public const OPTION_NAME = 't2t_option_name';
	public const OPTION_GROUP = 't2t_option_group';
	public const PAGE_SLUG = 'the-2nd-toolbar-options';
	public const SETTING_SECTION_ID = 't2t_setting_section_id';
	public const OPTION_NAME_GENERAL = 't2t_setting_name_general';
	public const SETTING_SECTION_ID_GENERAL = 't2t_setting_section_id_general';
	public const OPTION_NAME_WAIN = 'where_am_i_now';
	public const SETTING_SECTION_ID_WAIN = 't2t_setting_section_id_wain';

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
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
				array( $this, 'create_admin_page' )
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
		register_setting(
				self::OPTION_GROUP, // Option group
				self::OPTION_NAME, // Option name
				array( $this, 'the_2nd_toolbar_sanitize' ) // Sanitize
		);
	}

	public function add_setting_section() {
		add_settings_section(
				self::SETTING_SECTION_ID,
				'My Custom Settings', // Title
				array( $this, 'print_section_info' ), // Callback
				self::PAGE_SLUG // Page
		);
		add_settings_section(
				self::SETTING_SECTION_ID_GENERAL,
				'General Settings', // Title
				array( $this, 'print_section_info' ), // Callback
				self::PAGE_SLUG // Page
		);
		add_settings_section(
				self::SETTING_SECTION_ID_WAIN,
				'Where AM I Now Settings', // Title
				array( $this, 'print_section_info_wain' ), // Callback
				self::PAGE_SLUG // Page
		);
	}

	public function add_settings_field_template(
			$id,
			$title,
			$callback,
			$setting_section_id
	) {

		add_settings_field(
				$id, // ID
				$title, // Title
				array( $this, $callback ), // Callback
				self::PAGE_SLUG, // Page
				$setting_section_id, // Section
				array( 'label_for' => $id ),
		);
	}

	public function add_settings_field() {

		$this->add_settings_field_template(
				'id_number',
				'ID Number',
				'id_number_callback',
				self::SETTING_SECTION_ID
		);

		$this->add_settings_field_template(
				'title',
				'Title',
				'title_callback',
				self::SETTING_SECTION_ID
		);


		$this->add_settings_field_template(
				'height',
				'Height',
				'height_options_callback',
				self::SETTING_SECTION_ID_GENERAL
		);

		$this->add_settings_field_template(
				'position',
				'Position',
				'position_options_callback',
				self::SETTING_SECTION_ID_GENERAL
		);

		$this->add_settings_field_template(
				'where_am_i_now_setting_id',
				__( 'Where Am I Now Setting', 'the-2nd-toolbar' ),
				'where_am_i_now_setting_callback',
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

	/**
	 * Get the settings option array and print one of its values
	 */
	public function id_number_callback() {
		printf(
				'<input type="text" id="id_number" name="%s[id_number]" value="%s" />',
				self::OPTION_NAME,
				isset( $this->options[ 'id_number' ] ) ? esc_attr( $this->options[ 'id_number' ] ) : ''
		);
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function title_callback() {
		printf(
				'<input type="text" id="title" name="%s[title]" value="%s" />',
				self::OPTION_NAME,
				isset( $this->options[ 'title' ] ) ? esc_attr( $this->options[ 'title' ] ) : ''
		);
	}

	public function height_options_callback() {

		$fieldset_html_form = '
				<fieldset>
					<legend class="screen-reader-text">
						<span>
						%1$s
						</span>
					</legend>
					%2$s
					<br>
					%3$s
					<br>
					%4$s
				</fieldset>
				<p class="t2t-description">
					%5$s
				</p>
				';

		$what_height = $this->get_what_height_checked();

		$height_32_form = $this->get_height_radio_button_form( 'height32px', 'height32px', $what_height['32'], '32px (same as the default toolbar)' );
		$height_48_form = $this->get_height_radio_button_form( 'height48px', 'height48px', $what_height['48'], '48px (1.5 times as high as the default toolbar)' );
		$height_64_form = $this->get_height_radio_button_form( 'height64px', 'height64px', $what_height['64'], '64px (2 times as high as the default toolbar)' );

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

		$str = '';

		if ( true === isset( $this->options[ self::OPTION_NAME_GENERAL ] ) ) {
			$str = $this->options[ self::OPTION_NAME_GENERAL ];
		}

		$height = array(
			'32' => '',
			'48' => '',
			'64' => '',
			'unknown' => '',
		);

		if ( 'height32px' === $str ) {
			$height[ '32' ] = 'checked';
		} elseif ( 'height48px' === $str ) {
			$height[ '48' ] = 'checked';
		} elseif ( 'height64px' === $str ) {
			$height[ '64' ] = 'checked';
		} else {
			$height[ 'unknown' ] = $str;
		}

		return $height;
	}

	public function get_height_radio_button_form(
			$radio_button_label_and_name,
			$radio_button_value,
			$is_checked,
			$radio_button_txt ) {

		$radio_button_form = $this->get_radio_button_form();

		$input_name = self::OPTION_NAME . '[' . self::OPTION_NAME_GENERAL . ']';

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

	}

	public function decide_what_site_checked( $str ) {
		$what_site = array(
			'production' => '',
			'staging' => '',
			'development' => '',
			'local' => '',
			'unknown' => '',
		);

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

	public function get_radio_button_form() {
		$radio_button_form = '
			<label for="%1$s">
				<input type="radio" name="%2$s" id="%1$s" value="%3$s" %4$s>%5$s
			</label>
			';

		return $radio_button_form;
	}

	public function get_what_site_button_form( $site_env_type, $what_site ) {

//		var_dump($site_env_type);
//		var_dump($what_site);

		$what_site_key = array_search( 'checked', $what_site );

		$is_checked = '';

		if ( $site_env_type === $what_site_key ) {
			$is_checked = 'checked';
		}

		$input_name = self::OPTION_NAME . '[' . self::OPTION_NAME_WAIN . ']';

		$id_num = $this->get_id_num( $site_env_type );

		$form_output = sprintf(
				$this->get_radio_button_form(),
				'the_2nd_toolbar-' . ( string ) $id_num,
				$input_name,
				$site_env_type . '-site',
				$is_checked,
				'The ' . $site_env_type . ' server.',
		);

		return $form_output;
	}

	public function get_fieldset_html_form() {

		/**
		 * %1$s screen reader text
		 * %2$s button 1
		 * %3$s button 2
		 * %4$s button 3
		 * %5$s button 4
		 * %6$s description text
		 */
		$fieldset_html_form = '
				<fieldset>
					<legend class="screen-reader-text">
						<span>
						%1$s
						</span>
					</legend>
					%2$s
					<br>
					%3$s
					<br>
					%4$s
					<br>
					%5$s
				</fieldset>
				<p class="t2t-description">
					%6$s
				</p>
				';

		return $fieldset_html_form;
	}

	public function where_am_i_now_setting_callback() {

		$fieldset_html_form = $this->get_fieldset_html_form();

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
		$sanitized_values = array();

		if ( isset( $input[ 'id_number' ] ) ) {
			$sanitized_values[ 'id_number' ] = absint( $input[ 'id_number' ] );
		}
		if ( isset( $input[ 'title' ] ) ) {
			$sanitized_values[ 'title' ] = sanitize_text_field( $input[ 'title' ] );
		}
		if ( isset( $input[ self::OPTION_NAME_WAIN ] ) ) {
			$sanitized_values[ self::OPTION_NAME_WAIN ] = $input[ self::OPTION_NAME_WAIN ];
		}
		if ( isset( $input[ self::OPTION_NAME_GENERAL ] ) ) {
			$sanitized_values[ self::OPTION_NAME_GENERAL ] = $input[ self::OPTION_NAME_GENERAL ];
		}

		return $sanitized_values;
	}

}
