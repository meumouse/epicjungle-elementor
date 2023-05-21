<?php
namespace EpicJungleElementor\Includes\Controls;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Base_Data_Control;

class Control_Font_Size extends Base_Data_Control {

    public function get_type() {
        return 'font_size';
    }

    public static function get_sizes() {
        
        $font_sizes = [
            'default'      => esc_html__( 'Padrão', 'epicjungle-elementor' ),
            'display-1'    => esc_html__( 'Exibir 1', 'epicjungle-elementor' ),
            'display-2'    => esc_html__( 'Exibir 2', 'epicjungle-elementor' ),
            'display-3'    => esc_html__( 'Exibir 3', 'epicjungle-elementor' ),
            'display-4'    => esc_html__( 'Exibir 4', 'epicjungle-elementor' ),
            'lead'         => esc_html__( 'Lead', 'epicjungle-elementor' ),
            'font-size-lg' => esc_html__( 'Tamanho da fonte lg', 'epicjungle-elementor' ),
            'font-size-sm' => esc_html__( 'Tamanho da fonte sm', 'epicjungle-elementor' ),
            'h1'           => esc_html__( 'h1', 'epicjungle-elementor' ),
            'h2'           => esc_html__( 'h2', 'epicjungle-elementor' ),
            'h3'           => esc_html__( 'h3', 'epicjungle-elementor' ),
            'h4'           => esc_html__( 'h4', 'epicjungle-elementor' ),
            'h5'           => esc_html__( 'h5', 'epicjungle-elementor' ),
            'h6'           => esc_html__( 'h6', 'epicjungle-elementor' ),
        ];

        $additional_sizes = apply_filters( 'epicjungle-elementor/controls/lk-font-size/font_size_options', [] );

        return array_merge( $font_sizes, $additional_sizes );
    }

    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <select id="<?php echo $control_uid; ?>" data-setting="{{ data.name }}">
                    <?php foreach ( static::get_sizes() as $key => $size ) : ?>
                    <option value="<?php echo $key; ?>"><?php echo $size; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}