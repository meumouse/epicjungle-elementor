<?php
namespace EpicJungleElementor\Modules\ImageCarousel\Skins;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use Elementor\Skin_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Control_Media;
use Elementor\Plugin;
use EpicJungleElementor\Base\Base_Widget;
use Elementor;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Skin_Cs_Gallery extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        
        add_action( 'elementor/element/image-carousel/section_image_carousel/before_section_end', [ $this, 'section_image_carousel_controls' ] ); 
        add_action( 'elementor/element/image-carousel/section_additional_options/before_section_end', [ $this, 'section_additional_options_controls' ] ); 

        add_action( 'elementor/element/image-carousel/section_style_image/before_section_end', [ $this, 'section_image_controls' ] ); 

    }

    public function section_image_carousel_controls( $element ) {
        $this->parent = $element;

        $disable_controls = [
            'slides_to_scroll', 'image_stretch', 'open_lightbox'
        ];

        foreach ( $disable_controls as $control ) {
            $this->parent->update_control( $control, [
                'condition' => [
                    '_skin!' => 'cs-gallery'
                ]
            ] );
        }

        $element->add_control(
            'enable_dots_inside', [
                'label'        => esc_html__( 'Ativar pontos dentro', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'default'      => 'no',
                'condition'    => [
                  'navigation' => [ 'dots', 'both' ]
                ],
                'description'  => esc_html__( 'Exibe pontos absolutamente em cima do conteúdo do carrossel', 'epicjungle-elementor' )
            ],
            [
                'position' => [
                    'at'   => 'after',
                    'of'   => 'navigation',
                ]
            ]
        );

        $element->add_control(
            'enable_dots_light', [
                'label'        => esc_html__( 'Ativar pontos claros', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'default'      => 'no',
                'condition'    => [
                  'navigation' => [ 'dots', 'both' ]
                ],
                'description'  => esc_html__( 'Exibe estilo de pontos para versão clara', 'epicjungle-elementor' )
            ],
            [
                'position' => [
                    'at'   => 'after',
                    'of'   => 'navigation',
                ]
            ]
        );

        $element->add_control(
            'center_align', [
                'label'        => esc_html__( 'Alinhar ao centro', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'default'      => 'no',
                'condition'    => [
                  'navigation' => [ 'arrows', 'both' ]
                ],
                'description'  => esc_html__( 'Controles de alinhamento central (botões anterior/seguinte).', 'epicjungle-elementor' )
            ],
            [
                'position' => [
                    'at'   => 'after',
                    'of'   => 'navigation',
                ]
            ]
        );

        $element->add_control(
            'left_align', [
                'label'        => esc_html__( 'Alinhar à esquerda', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'default'      => 'no',
                'condition'    => [
                  'navigation' => [ 'arrows', 'both' ]
                ],
                'description'  => esc_html__( 'Controles de alinhamento à esquerda (botões anterior/próximo).', 'epicjungle-elementor' )
            ],
            [
                'position' => [
                    'at'   => 'after',
                    'of'   => 'navigation',
                ]
            ]
        );

        $element->add_control(
            'inside_align', [
                'label'        => esc_html__( 'Carrossel interno', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'default'      => 'no',
                'condition'    => [
                  'navigation' => [ 'arrows', 'both' ]
                ],
                'description'  => esc_html__( 'Controles de posição (botões anterior/seguinte) absolutamente em cima do conteúdo do carrossel (nas laterais)', 'epicjungle-elementor' )
            ],
            [
                'position' => [
                    'at'   => 'after',
                    'of'   => 'center_align',
                ]
            ]
        );

        $element->add_control(
            'on_hover', [
                'label'        => esc_html__( 'Ativar controle ao passar o mouse?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'default'      => 'no',
                'condition'    => [       
                'inside_align' => 'yes', 
                'navigation'   => [ 'arrows', 'both' ]
            ],
                'description'  => esc_html__( 'Mostrar controles (botões anterior/próximo) somente quando o usuário passa o mouse sobre o carrossel', 'epicjungle-elementor' )
            ],
            [
                'position' => [
                    'at'   => 'after',
                    'of'   => 'inside_align',
                ]
            ]
        );

    }

    public function section_additional_options_controls( $element ) {
        $this->parent = $element;

        $disable_controls = [
            'pause_on_hover', 'pause_on_interaction', 'open_lightbox'
        ];

        foreach ( $disable_controls as $control ) {
            $this->parent->update_control( $control, [
                'condition' => [
                    '_skin!' => 'cs-gallery'
                ]
            ] );
        }
    }

    public function section_image_controls( $element ) {
        $this->parent = $element;

        $element->update_control(
            'image_border_radius',
            [
                'label' => __( 'Raio da borda', 'epicjungle-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }


    public function get_id() {
        return 'cs-gallery';
    }

    public function get_title() {
        return esc_html__( 'Galeria CS', 'epicjungle-elementor' );
    }

    public function render() {
        $settings = $this->parent->get_settings_for_display();
        
        if ( empty( $settings['carousel'] ) ) {
            return;
        }

        $items        = ! empty( $settings['slides_to_show'] ) ? intval( $settings['slides_to_show'] ) : 2; 
        $items_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? intval( $settings['slides_to_show_tablet'] ) : 2; 
        $items_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? intval( $settings['slides_to_show_mobile'] ) : 1; 

        $slides = [];

        foreach ( $settings['carousel'] as $index => $attachment ) {
            
            $image_url     = isset( $attachment['url'] ) ? $attachment['url'] : Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );
            $image_html    = '<img src="' . esc_attr( $image_url ) . '" alt="' . esc_attr( Control_Media::get_image_alt( $attachment ) ) . '" />';
            $image_caption = $this->get_image_caption( $attachment );

            $link_tag = '';

            $link = $this->get_link_url( $attachment, $settings );

            if ( $link ) {
                $link_key = 'link_' . $index;

                $this->parent->add_render_attribute( $link_key, [
                    'class'         => array( 'cs-gallery-item', 'rounded-lg' ),
                    'data-sub-html' => '&lt;h6 class=&quot;font-size-sm text-light&quot;&gt;' . $image_caption . '&lt;/h6&gt;'
                ] );

                $this->parent->add_link_attributes( $link_key, $link );

                $link_tag = '<a ' . $this->parent->get_render_attribute_string( $link_key ) . '>';
            }

            $slide_html = '<div>' . $link_tag . $image_html;

            if ( ! empty( $image_caption ) ) {
                $slide_html .= '<span class="cs-gallery-caption">' . $image_caption . '</span>';
            }

            if ( $link ) {
                $slide_html .= '</a>';
            }

            $slide_html .= '</div>';

            $slides[] = $slide_html;

        }

        if ( empty( $slides ) ) {
            return;
        }


         
        $show_dots       = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
        $show_arrows     = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );
        $enable_autoplay = $settings['autoplay'] === 'yes';

        $carousel_options = [
            'infinite'   => isset( $settings['infinite'] ) && $settings['infinite'] === 'yes' ? true : false,
            'items'      => $items,
            'controls'   => $show_arrows,
            'nav'        => $show_dots,
            'autoplay'   => isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ? true : false,
            'responsive' => [
                '0'   => [
                    'items'  => $items_mobile,
                    'gutter' => 20,
                ],
                '500' => [
                    'items'  => $items_tablet,
                    'gutter' => 20,
                ],
                '700' => [
                    'items'  => $items,
                    'gutter' => 30,
                ]
            ]
        ];

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $carousel_options['autoplayTimeout'] = $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 6000;
            $carousel_options['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }


        $this->parent->add_render_attribute( [
            'carousel' => [
                'class' => 'cs-carousel',
                //'data-carousel-options' => htmlspecialchars( json_encode( $carousel_options ), ENT_QUOTES, 'UTF-8' ),
            ]
        ] );

        $slides_count = count( $settings['carousel'] );

        if ( $settings['enable_dots_light'] == 'yes' ) {
            $this->parent->add_render_attribute( 'carousel', 'class', 'cs-dots-light' );
        }
        
        if ( $settings['enable_dots_inside'] == 'yes' ) {
            $this->parent->add_render_attribute( 'carousel','class','cs-dots-inside' );
        }
        
        if ( $settings['center_align'] == 'yes' ) {
            $this->parent->add_render_attribute( 'carousel','class','cs-controls-center' );
        }

        if ( $settings['left_align'] == 'yes' ) {
            $this->parent->add_render_attribute( 'carousel','class','cs-controls-left' );
        }
        
        if ( $settings['inside_align'] == 'yes' ) {
            $this->parent->add_render_attribute( 'carousel','class','cs-controls-inside' );
        }

        if ( $settings['on_hover'] == 'yes' ) {
            $this->parent->add_render_attribute( 'carousel','class','cs-controls-onhover' );
        } ?>

        <div <?php echo $this->parent->get_render_attribute_string( 'carousel' ); ?>>
            <div class="cs-carousel-inner" data-carousel-options="<?php echo esc_attr( json_encode( $carousel_options ) ); ?>" data-aos-id="carousel:in" data-aos="true">
                 <?php echo implode( '', $slides ); ?>
            </div>
        </div><?php
    
}

    /**
     * Retrieve image carousel link URL.
     *
     * @since 1.0.0
     * @access private
     *
     * @param array $attachment
     * @param object $instance
     *
     * @return array|string|false An array/string containing the attachment URL, or false if no link.
     */
    private function get_link_url( $attachment, $instance ) {
        if ( 'none' === $instance['link_to'] ) {
            return false;
        }

        if ( 'custom' === $instance['link_to'] ) {
            if ( empty( $instance['link']['url'] ) ) {
                return false;
            }

            return $instance['link'];
        }

        return [
            'url' => wp_get_attachment_url( $attachment['id'] ),
        ];
    }

    /**
     * Retrieve image carousel caption.
     *
     * @since 1.2.0
     * @access private
     *
     * @param array $attachment
     *
     * @return string The caption of the image.
     */
    private function get_image_caption( $attachment ) {
        $caption_type = $this->parent->get_settings_for_display( 'caption_type' );

        if ( empty( $caption_type ) ) {
            return '';
        }

        $attachment_post = get_post( $attachment['id'] );

        if ( 'caption' === $caption_type && isset( $attachment_post->post_excerpt ) ) {
            return $attachment_post->post_excerpt;
        }

        if ( 'title' === $caption_type && isset( $attachment_post->post_title ) ) {
            return $attachment_post->post_title;
        }

        $caption = isset( $attachment_post->post_content ) ? $attachment_post->post_content: '';

        return $caption;
    }
}