<?php

namespace EpicJungleElementor\Modules\Jarallax;

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
        return 'override-jarallax';
    }

    public function add_actions() {
        add_action( 'elementor/element/before_section_end', [ $this, 'set_jarallax_effects' ], 10, 3 );
        add_action( 'elementor/element/after_add_attributes', [ $this, 'jarallax_attributes' ], 10 );
    }

    public function set_jarallax_effects( $widget, $section_id, $args ) {
        if( $section_id == 'section_background' ) {

            $widget->add_control(
                '_enable_jarallax',
                [
                    'label'        => esc_html__( 'Enable Jarallax', 'epicjungle-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'description'  => esc_html__( 'Enable Jarallax option.', 'epicjungle-elementor' ),
                    'label_on'     => esc_html__( 'Yes', 'epicjungle-elementor' ),
                    'label_off'    => esc_html__( 'No', 'epicjungle-elementor' ),
                    'return_value' => 'yes',
                    'default'      => 'no',
                ]
            );

            $widget->add_control(
                '_jarallax_delay',
                [
                    'label'              => esc_html__( 'Speed', 'epicjungle-elementor' ) . ' (ms)',
                    'type'               => Controls_Manager::NUMBER,
                    'default'            => 0.8,
                    'min'                => 0,
                    'step'               => .1,
                    'render_type'        => 'none',
                    'frontend_available' => true,
                    'condition' => [
                        '_enable_jarallax'       => 'yes',
                    ],
                ]
            );
        }
    }

    public function jarallax_attributes( $element ) {
        $settings = $element->get_settings_for_display();

        if ( $element->get_settings( '_enable_jarallax' ) == 'yes') {
            $element->add_render_attribute( '_wrapper', 'class', $settings[ '_enable_jarallax' ] ? 'jarallax' : '' );
            $element->add_render_attribute( '_wrapper', 'data-jarallax' );
            $element->set_render_attribute( '_wrapper', 'data-speed', $settings['_jarallax_delay'] );
        }
    }
}