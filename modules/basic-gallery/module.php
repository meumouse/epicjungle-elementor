<?php

namespace EpicJungleElementor\Modules\BasicGallery;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Modules\BasicGallery\Skins;
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
        return 'ej-basic-gallery';
    }

    public function add_actions() {
        add_action( 'elementor/widget/image-gallery/skins_init', [ $this, 'init_skins' ], 10 );
        add_action( 'elementor/element/image-gallery/section_caption/before_section_end', [ $this, 'update_caption_control' ], 10 );
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Light_Gallery( $widget ) );
        $widget->add_skin( new Skins\Skin_Epicjungle_Gallery( $widget ) );
    }

    public function update_caption_control( $element ) {

        $element->update_control(
            'gallery_display_caption',
            [
                'label' => __( 'Display', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __( 'Show', 'epicjungle-elementor' ),
                    'none' => __( 'Hide', 'epicjungle-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .cs_gallery-item .gallery-caption' => 'display: {{VALUE}};',
                ],
            ]
        );

      $element->add_control(
            'gallery_caption',
            [
                'label' => __( 'Display Text', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__( 'Text to be displayed on hover','epicjungle-elementor' )
                
                
            ]
        );
        $element->update_control(
            'align',
            [
                'label' => __( 'Alignment', 'epicjungle-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .cs_gallery-item .gallery-caption' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'gallery_display_caption' => '',
                ],
            ]
        );

        $element->update_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'epicjungle-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cs_gallery-item .gallery-caption' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gallery_display_caption' => '',
                ],
            ]
        );

        // Remove the group control
    // $element->remove_control( 'typography_typography' );
    }

}