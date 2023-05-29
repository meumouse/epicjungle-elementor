<?php

namespace EpicJungleElementor\Modules\Image;

use EpicJungleElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use Elementor\Core\Schemes;
use Elementor\Utils;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();

        $this->add_actions();
    }

    public function add_actions() {
        add_action( 'elementor/element/image/section_image/before_section_end', [ $this, 'add_css_classes_controls' ], 10 );
        add_filter( 'elementor/image_size/get_attachment_image_html', [ $this, 'image_html' ], 10, 4 ); 
    }


    public function get_name() {
        return 'override-image';
    }

    public function add_css_classes_controls( $element ) {

        // $element->add_control(
        //     'image',
        //     [
        //         'label' => __( 'Choose Image', 'elementor' ),
        //         'type' => Controls_Manager::MEDIA,
        //         'dynamic' => [
        //             'active' => true,
        //         ],
        //         'default' => [
        //             'url' => Utils::get_placeholder_image_src(),
        //         ],
        //     ]
        // );
        
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

        $enabled = Files_Upload_Handler::is_enabled();

        if ( $enabled ) {
            $element->add_control(
                'inline_svg',
                [
                   'label'         => esc_html__( 'SVG Inline', 'epicjungle-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'title'        => esc_html__( 'Se você estiver carregando um arquivo SVG, pode ser útil incorporar os arquivos SVG. Não inline, se o seu arquivo SVG for de fontes desconhecidas.', 'epicjungle-elementor' ),
                    'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                    'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                    'return_value' => 'yes',
                    'default'      => 'no',
                ]
            );

            $element->add_control(
                'color',
                [
                    'label'        => esc_html__( 'Cor', 'epicjungle-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .epicjungle-elementor-svg-wrapper' => 'color: {{VALUE}};',
                    ],
                ]
            );
        }
    }

    public function image_html( $html, $settings, $image_size_key, $image_key  ) {
        $enabled = Files_Upload_Handler::is_enabled();

        if ( $enabled && isset( $settings['inline_svg'] ) && 'yes' === $settings['inline_svg'] && isset( $settings['image']['url'] ) ) {

            if ( isset( $settings['image_class'] ) && ! empty( $settings['image_class'] ) ) {
                $html = '<div class="epicjungle-elementor-svg-wrapper ' . esc_attr( $settings['image_class'] ) . '">';
            } else {
                $html = '<div class="epicjungle-elementor-svg-wrapper">';
            }
            
            $html .= file_get_contents( $settings['image']['url'] );
            $html .= '</div>';

        } else {

            if ( isset( $settings['image_class'] ) && ! empty( $settings['image_class'] ) ) {
            
                if ( strpos( $html, 'class="') !== false ) {
                    $html = str_replace( 'class="', 'class="' . esc_attr( $settings['image_class'] ) . ' ', $html );
                } else {
                    $html = str_replace( '<img', '<img class="' . esc_attr( $settings['image_class'] ) . '"', $html );
                }                
            }
        }

        return $html;
    }
}