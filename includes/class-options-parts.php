<?php
/*
 * @todo
 *
 * How to sanitize radio value?
 */

class Class_Options_Parts {

	public const PAGE_SLUG = 'the-2nd-toolbar-options';

	public static function add_settings_field_template(
			$id,
			$title,
			$callback,
			$setting_section_id
	) {

		add_settings_field(
				$id, // ID
				$title, // Title
				$callback, // Callback
				self::PAGE_SLUG, // Page
				$setting_section_id, // Section
				[ 'label_for' => $id ],
		);
	}

	/**
	 * Print the Section text
	 */
	public static function print_section_info() {
		print 'Enter your settings below:';
	}

	public static function get_height_radio_button_form(
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

	public static function get_radio_button_form_template() {
		$radio_button_form_template = '
			<label for="%1$s">
				<input type="radio" name="%2$s" id="%1$s" value="%3$s" %4$s>%5$s
			</label>
			';

		return $radio_button_form_template;
	}

	public static function get_fieldset_html_form_buttons( $num_of_buttons ) {

		$str = '
			%s
			<br>';

		$r = str_repeat( $str, $num_of_buttons );

		$fieldset_html_form = "
				<fieldset>
					<legend class='screen-reader-text'>
						<span>
						%s
						</span>
					</legend>
					{$r}
				</fieldset>
				<p class='t2t-description'>
					%s
				</p>
				";
		return $fieldset_html_form;
	}

	public static function get_fieldset_html_checkbox_single(
			$screen_reader_text,
			$label_name_id,
			$is_checked,
			$description
	) {

		$fieldset_html_checkbox_single = "
		<fieldset>
		<legend class='screen-reader-text'><span>{$screen_reader_text}</span></legend>
		<label for='{$label_name_id}'>
		<input name='{$label_name_id}' type='checkbox' id='{$label_name_id}' {$is_checked}>
		{$description}
		</label>
		</fieldset>
";

		return $fieldset_html_checkbox_single;
	}

	public static function the_2nd_toolbar_sanitize( $input ) {
		$sanitized_values = [];

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
		if ( isset( $input[ self::OPTION_NAME_POSITION ] ) ) {
			$sanitized_values[ self::OPTION_NAME_POSITION ] = $input[ self::OPTION_NAME_POSITION ];
		}

		return $sanitized_values;
	}

}
