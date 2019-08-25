<?php
/*
 * Any other options I should add?
 *
 * @todp
 *
 * Refactaring where_am_i_setting_callback_fnc() method.
 */

class Where_Am_I_Now_Options {

	private $where_am_i_now_options;

	function __construct() {
		add_action( 'admin_init', [ $this, 'add_settings_to_general_options' ] );
	}

	public function add_settings_to_general_options() {
		register_setting(
				'general',
				'where_am_i_now_option_name',
				array( $this, 'where_am_i_now_sanitize' ),
		);
		add_settings_field(
				'where_am_i_setting_id',
				__( 'Where Am I Now setting', 'where-am-i-now' ),
				array( $this, 'where_am_i_setting_callback_fnc' ),
				'general',
				'default',
				array( 'label_for' => 'where_am_i_setting_id' ),
		);
	}

	public function where_am_i_setting_callback_fnc( $args ) {

		$this->where_am_i_now_options = get_option( 'where_am_i_now_option_name' );

		$is_set_wain_option = isset( $this->where_am_i_now_options[ 'where_am_i_now' ] );

		if ( true === $is_set_wain_option ) {

			$production = '';
			$staging = '';
			$dev = '';
			$local = '';
			$unknown = '';

			$str = $this->where_am_i_now_options[ 'where_am_i_now' ];

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

		$input_name = 'where_am_i_now_option_name[where_am_i_now]';

		$prod_form = sprintf(
				$radio_button_form,
				'where_am_i_now-0',
				$input_name,
				'production-site',
				$production,
				__( 'The production server', 'where-am-i-now' ),
		);

		$staging_form = sprintf(
				$radio_button_form,
				'where_am_i_now-1',
				$input_name,
				'staging-site',
				$staging,
				__( 'The staging server', 'where-am-i-now' ),
		);

		$dev_form = sprintf(
				$radio_button_form,
				'where_am_i_now-2',
				$input_name,
				'dev-site',
				$dev,
				__( 'The development server', 'where-am-i-now' ),
		);

		$local_form = sprintf(
				$radio_button_form,
				'where_am_i_now-3',
				$input_name,
				'local-site',
				$local,
				__( 'The local server', 'where-am-i-now' ),
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
				__( 'Where Am I Now Setting', 'where-am-i-now' ),
				$prod_form,
				$staging_form,
				$dev_form,
				$local_form,
				__( 'Choose what server your WordPress running on.', 'where-am-i-now' ),
		);

		echo $fieldset_html;
	}

	public function where_am_i_now_sanitize( $input ) {
		$sanitary_values = array();
		if ( isset( $input[ 'where_am_i_now' ] ) ) {
			$sanitary_values[ 'where_am_i_now' ] = $input[ 'where_am_i_now' ];
		}

		return $sanitary_values;
	}

}
