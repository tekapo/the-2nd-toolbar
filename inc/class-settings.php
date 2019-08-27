<?php
/*
 * Any other options I should add?
 *
 * @todp
 *
 * Refactaring the_2nd_toolbar_setting_callback_fnc() method.
 */

class The_2nd_Toolbar_Options {

	private $the_2nd_toolbar_options;

	function __construct() {
		add_action( 'admin_init', [ $this, 'add_settings_to_general_options' ] );
	}

	public function add_settings_to_general_options() {
		register_setting(
				'general',
				'the_2nd_toolbar_option_name',
				array( $this, 'the_2nd_toolbar_sanitize' ),
		);
		add_settings_field(
				'the_2nd_toolbar_setting_id',
				__( 'The 2nd Toolbar setting', 'the-2nd-toolbar' ),
				array( $this, 'the_2nd_toolbar_setting_callback_fnc' ),
				'general',
				'default',
				array( 'label_for' => 'the_2nd_toolbar_setting_id' ),
		);
	}

	public function the_2nd_toolbar_setting_callback_fnc( $args ) {

		$this->the_2nd_toolbar_options = get_option( 'the_2nd_toolbar_option_name' );

		$is_set_t2t_option = isset( $this->the_2nd_toolbar_options[ 'the_2nd_toolbar' ] );

		if ( true === $is_set_t2t_option ) {

			$production = '';
			$staging = '';
			$dev = '';
			$local = '';
			$unknown = '';

			$str = $this->the_2nd_toolbar_options[ 'the_2nd_toolbar' ];

			if ( 'production-site' === $str ) {
				$production = 'checked';
			} elseif ( 'staging-site' === $str ) {
				$staging = 'checked';
			} elseif ( 'dev-site' === $str ) {
				$dev = 'checked';
			} elseif ( 'local-site' === $str ) {
				$local = 'checked';
			} else {
				$unknown = $str;
			}
		}

		$radio_button_form = '
			<label for="%1$s">
				<input type="radio" name="%2$s" id="%1$s" value="%3$s" %4$s>%5$s
			</label>
			';

		$input_name = 'the_2nd_toolbar_option_name[the_2nd_toolbar]';

		$prod_form = sprintf(
				$radio_button_form,
				'the_2nd_toolbar-0',
				$input_name,
				'production-site',
				$production,
				__( 'The production server', 'the-2nd-toolbar' ),
		);

		$staging_form = sprintf(
				$radio_button_form,
				'the_2nd_toolbar-1',
				$input_name,
				'staging-site',
				$staging,
				__( 'The staging server', 'the-2nd-toolbar' ),
		);

		$dev_form = sprintf(
				$radio_button_form,
				'the_2nd_toolbar-2',
				$input_name,
				'dev-site',
				$dev,
				__( 'The development server', 'the-2nd-toolbar' ),
		);

		$local_form = sprintf(
				$radio_button_form,
				'the_2nd_toolbar-3',
				$input_name,
				'local-site',
				$local,
				__( 'The local server', 'the-2nd-toolbar' ),
		);

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
				<p class="where-am-i-description">
					%6$s
				</p>
				';

		$fieldset_html = sprintf(
				$fieldset_html_form,
				__( 'Where Am I Now Setting', 'the-2nd-toolbar' ),
				$prod_form,
				$staging_form,
				$dev_form,
				$local_form,
				__( 'Choose what server your WordPress running on.', 'the-2nd-toolbar' ),
		);

		echo $fieldset_html;
	}

	public function the_2nd_toolbar_sanitize( $input ) {
		$sanitary_values = array();
		if ( isset( $input[ 'the_2nd_toolbar' ] ) ) {
			$sanitary_values[ 'the_2nd_toolbar' ] = $input[ 'the_2nd_toolbar' ];
		}

		return $sanitary_values;
	}

}
