<?php

namespace EpicJungleElementor\Modules\Column;

use EpicJungleElementor\Base\Module_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();

        $this->add_actions();
    }

    public function get_name() {
        return 'override-column';
    }

    public function add_actions() {
        add_action( 'elementor/element/column/layout/before_section_start', [ $this, 'add_column_controls' ], 10 );
        add_action( 'elementor/element/column/section_advanced/before_section_end', [ $this, 'add_widget_wrap_controls' ] );
        add_action( 'elementor/element/after_add_attributes', [ $this, 'modify_attributes' ], 20 );
    }

    public function add_widget_wrap_controls( $element ) {
        $element->add_control( 'widget_wrap_heading', [
            'label'     => esc_html__( 'Invólucro de widgets', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $element->add_control( 'widget_wrap_max_width', [
            'label'        => esc_html__( 'Largura máxima', 'epicjungle-elementor' ),
            'type'         => Controls_Manager::SLIDER,
            'default'      => [ 'unit' => 'px' ],
            'size_units'   => [ '%', 'px' ],
            'range'        => [
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ] );
        
        $element->add_control( 'widget_wrapper_css', [
            'label'        => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'label_block'  => true,
            'type'         => Controls_Manager::TEXT,
            'description'  => esc_html__( 'Aplicado ao elemento elementor-widget-wrap.', 'epicjungle-elementor' ),
        ] );
    }

    public function add_column_controls( $element ) {}

    public function modify_attributes( $element ) {
        if ( $element->get_name() == 'column' ) {
            $settings = $element->get_settings_for_display();
            
            if ( ! empty( $settings[ 'widget_wrapper_css' ] ) ) {
                $element->add_render_attribute( '_widget_wrapper', 'class', $settings[ 'widget_wrapper_css' ] );
            }
        }
    }
}