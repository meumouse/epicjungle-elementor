<?php
namespace EpicJungleElementor\Modules\Heading;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Core\Controls_Manager as EJ_Controls_Manager;
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
        return 'override-heading';
    }

    public function add_actions() {
        add_action( 'elementor/element/heading/section_title_style/before_section_end', [ $this, 'add_css_classes_controls' ], 10 );
        add_action( 'elementor/element/heading/section_title/before_section_end', [ $this, 'update_size_control' ], 10 );
        add_action( 'epicjungle-elementor/widget/heading/before_render_content', [ $this, 'before_render' ], 10 );
    }

    public function update_size_control( $element ) {
        $element->update_control( 'size', [
            'type' => EJ_Controls_Manager::FONT_SIZE,
        ] );
    }

    public function add_css_classes_controls( $element ) {
        $element->add_control(
            'heading_css_classes',
            [
                'label'     => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $element->add_control(
            'title_css_class',
            [
                'label' => esc_html__( 'Classe CSS do cabeçalho', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::TEXT,
                'title' => esc_html__( 'Adicione sua classe personalizada para o título do título sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            ]
        );
    }

    public function before_render( $element ) {

        $element->add_render_attribute( 'title', 'class', 'epicjungle-elementor-heading__title' );

        if ( ! empty( $element->get_settings( 'title_css_class' ) ) ) {
            $element->add_render_attribute( 'title', 'class', $element->get_settings( 'title_css_class' ) );    
        }
        if ( ! empty( $element->get_settings( 'size' ) ) ) {
            $element->add_render_attribute( 'title', 'class', $element->get_settings( 'size' ) );
        }
    }
}
