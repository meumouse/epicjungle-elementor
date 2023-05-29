<?php

namespace EpicJungleElementor\Modules\ImageBox;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Modules\ImageBox\Skins;
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
        return 'ej-image-box';
    }

    public function add_actions() {
        add_action( 'elementor/widget/image-box/skins_init', [ $this, 'init_skins' ], 10 );
        add_action( 'elementor/element/image-box/section_style_image/before_section_end', [ $this, 'style_image_controls' ], 10 );
        add_action( 'elementor/element/image-box/section_style_content/before_section_end', [ $this, 'style_content_controls' ], 10 );

        add_action( 'epicjungle-elementor/widget/image-box/before_render_content', [ $this, 'before_render' ], 10 );
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Image_Box_Card( $widget ) );
        $widget->add_skin( new Skins\Skin_Image_Box_Case_Studies( $widget ) );
    }

    public function style_image_controls( $element ) {
        $element->add_control(
            'image_class',
            [
               'label'        => esc_html__( 'Classe CSS da imagem', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'title'       => esc_html__( 'Adicione sua classe personalizada para a tag <img> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'default'     => 'img-fluid',
                'label_block' => true,
                'description' => esc_html__( 'Classe CSS adicional que você deseja aplicar à tag img', 'epicjungle-elementor' ),
            ]
        );

        $element->add_control(
            'image_box_wrapper_class',
            [
               'label'        => esc_html__( 'Classe de invólucro de caixa de imagem', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'title'       => esc_html__( 'Adicione sua classe personalizada para a tag <div> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'label_block' => true,
                'description' => esc_html__( 'Classe CSS adicional que você deseja aplicar para o wrapper de widget', 'epicjungle-elementor' ),
            ]
        );
    }


    public function style_content_controls( $element ) {
        
        $element->add_control( 'title_css', [
            'label'    => esc_html__( 'Classe CSS do título', 'epicjungle-elementor' ),
            'type'     => Controls_Manager::TEXT,
            'title'    => esc_html__( 'Adicione sua classe personalizada para o título sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
        ], [
            'position' => [
                'at' => 'before',
                'of' => 'heading_description'
            ]
        ] );

        $element->add_control( 'desc_css', [
            'label'    => esc_html__( 'Classe CSS da descrição', 'epicjungle-elementor' ),
            'type'     => Controls_Manager::TEXT,
            'title'    => esc_html__( 'Adicione sua classe personalizada para texto SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );
    }

    public function before_render( $element ) {
   
        $element->add_render_attribute( 'title_text', 'class', 'elementor-image-box-title' );

        if ( ! empty( $element->get_settings( 'title_css' ) ) ) {
            $element->add_render_attribute( 'title_text', 'class', $element->get_settings( 'title_css' ) );    
        }

        $element->add_render_attribute( 'description_text', 'class', 'elementor-image-box-description' );

        if ( ! empty( $element->get_settings( 'desc_css' ) ) ) {
            $element->add_render_attribute( 'description_text', 'class', $element->get_settings( 'desc_css' ) );    
        }

        $element->add_render_attribute( 'wrapper', 'class', 'elementor-image-box-wrapper' );

        if ( ! empty( $element->get_settings( 'image_box_wrapper_class' ) ) ) {
            $element->add_render_attribute( 'wrapper', 'class', $element->get_settings( 'image_box_wrapper_class' ) );    
        }
    }

    public function image_html( $html, $settings, $image_size_key, $image_key  ) {
        $enabled = Files_Upload_Handler::is_enabled();

            if ( isset( $settings['image_class'] ) && ! empty( $settings['image_class'] ) ) {
            
                if ( strpos( $html, 'class="') !== false ) {
                    $html = str_replace( 'class="', 'class="' . esc_attr( $settings['image_class'] ) . ' ', $html );
                } else {
                    $html = str_replace( '<img', '<img class="' . esc_attr( $settings['image_class'] ) . '"', $html );
                }                
            }
        
            return $html;
        }
}
