<?php
namespace EpicJungleElementor\Modules\QueryControl\Controls;

use Elementor\Control_Select2;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Query extends Control_Select2 {

	public function get_type() {
		return 'query';
	}

	/**
	 * 'query' can be used for passing query args in the structure and format used by WP_Query.
	 * @return array
	 */
	protected function get_default_settings() {
		return array_merge(
			parent::get_default_settings(), [
				'query' => '',
			]
		);
	}

	public function enqueue() {
	 	// script
	 	wp_register_script( 'ej-ajaxchoose-control',  EPICJUNGLE_ELEMENTOR_MODULES_URL . 'query-control/assets/js/ajaxchoose.js' );
	 	wp_enqueue_script( 'ej-ajaxchoose-control' );
	}

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<# 
					var multiple = ( data.multiple ) ? 'multiple' : '';
				#>
				<select id="<?php echo $control_uid; ?>" class="elementor-select2" data-autocomplete="{{ JSON.stringify( data.autocomplete ) }}" type="select2" {{ multiple }} data-setting="{{ data.name }}">
					<# _.each( data.options, function( option_title, option_value ) {
						var value = data.controlValue;
						if ( typeof value == 'string' ) {
							var selected = ( option_value === value ) ? 'selected' : '';
						} else if ( null !== value ) {
							var value = _.values( value );
							var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
						}
						#>
					<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}