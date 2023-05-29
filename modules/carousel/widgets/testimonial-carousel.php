<?php
namespace EpicJungleElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use EpicJungleElementor\Modules\Carousel\Skins;
use EpicJungleElementor\Core\Utils as EJ_Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Testimonial_Carousel extends Base {

    private $files_upload_handler = false;

    public function get_name() {
        return 'ej-testimonial-carousel';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de depoimentos', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_keywords() {
        return [ 'testimonial-carousel', 'testimonial', 'carousel', 'image' ];
    }

    protected function register_skins() {
        $this->add_skin( new Skins\Testimonial_Style_2( $this ) );
        $this->add_skin( new Skins\Testimonial_Style_3( $this ) );
        $this->add_skin( new Skins\Testimonial_Style_4( $this ) );
    }

    protected function register_controls() {
        parent::register_controls();



        $this->update_control( 'slides_per_view', [
            'condition' => [ '_skin' => 'skin-style-3' ]
        ] );

        $this->remove_control( 'pagination' );
        $this->remove_control( 'speed' );
        $this->remove_control( 'image_class' );
        $this->remove_responsive_control( 'gutter' );



        $this->start_controls_section(
            'section_heading_style', [
                'label' => esc_html__( 'Cabeçalho', 'epicjungle-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_title' => 'yes'],
            ]
        );


         $this->add_control( 'title_css', [
            'label'     => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'title'     => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. por exemplo: minha-classe', 'epicjungle-elementor' ),
            'default'   => 'pb-2 mb-4 text-center text-md-left',

        ] );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_content_style', [
                'label' => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control( 'content_css', [
            'label'     => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'title'     => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. por exemplo: minha-classe', 'epicjungle-elementor' ),

        ] );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_style_text', [
                'label' => esc_html__( 'Slides', 'epicjungle-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control( 'carousel_css', [
            'label'     => esc_html__( 'Classe CSS do carrossel', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'title'     => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. por exemplo: minha-classe', 'epicjungle-elementor' ),
            'description'     => esc_html__( 'Adicionar classe de preenchimento para div cs-carousel', 'epicjungle-elementor' ),

        ] );

        $this->add_control(
            'content_typo_style', [
                'type'  => Controls_Manager::HEADING,
                'label' => esc_html__( 'Estilos de texto de conteúdo', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'content_color', [
                'label'     => esc_html__( 'Cor do texto do conteúdo', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ej-testimonial-slide-content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .ej-testimonial-slide-content',
            ]
        );

        $this->add_control(
            'author_typo_style', [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Estilos de autor', 'epicjungle-elementor' ),
                'separator' => 'before',
            ]
        );

        // $this->add_responsive_control(
        //     'image_size',
        //     [
        //         'label' => __( 'Tamanho da imagem do autor', 'epicjungle-elementor' ),
        //         'type' => Controls_Manager::SLIDER,
        //         'range' => [
        //             'px' => [
        //                 'min' => 0,
        //                 'max' => 200,
        //             ],
        //         ],
               
        //         'selectors' => [
        //             '{{WRAPPER}} .cs-carousel .cs-carousel-inner .blockquote .testimonial-footer img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
        //         ],
        //          'default' => [
        //             'size' => 42,
        //         ],
        //     ]
        // );


        $this->add_control(
            'author_color', [
                'label'     => esc_html__( 'Cor do texto do autor', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ej-testimonial-slide-author' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'author_typography',
                'selector' => '{{WRAPPER}} .ej-testimonial-slide-author',
            ]
        );

         $this->add_control(
            'author_css_class', [
                'label'   => esc_html__( 'Classe CSS do autor', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para autor. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'text-heading font-size-md font-weight-medium'


            ]
        );

        $this->add_control(
            'video_css_class', [
                'label'   => esc_html__( 'Classe CSS de vídeo', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para vídeo. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'cs-video-btn cs-video-btn-sm my-4',
                'condition' => [
                    '_skin' => 'skin-style-2',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination_style', [
                'label'     => esc_html__( 'Paginação', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'logo_opacity',
            [
                'label'     => __( 'Opacidade', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-pager .cs-swap-image:not(.active) img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function add_repeater_controls( Repeater $repeater ) {
        $enabled = Files_Upload_Handler::is_enabled();


        $repeater->add_control(
            'bg_image', [
                'label' => esc_html__( 'Imagem de fundo', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
                'description' => esc_html__( 'Classe CSS adicional que você deseja aplicar à tag img', 'epicjungle-elementor' ),

            ]
        );

        $repeater->add_control(
            'content', [
                'label' => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'content_2', [
                'label' => esc_html__( 'Conteúdo 2', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'image', [
                'label' => esc_html__( 'Imagem do autor', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
            ]
        );


        $repeater->add_control(
            'name', [
                'label' => esc_html__( 'Nome do autor', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'link', [
                'label'       => esc_html__( 'Link do autor', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->add_control(
            'logo', [
                'label' => esc_html__( 'Logotipo de paginação', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
                'description' => esc_html__( 'O logotipo de paginação se aplica ao estilo 1', 'epicjungle-elementor' ),

            ]
        );

        $repeater->add_control(
            'video_link',
            [
                'label' => __( 'Link do vídeo', 'epicjungle-elementor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '#',
                ],
                'placeholder' => __( 'https://www.youtube.com/watch?v=PjNJfOrKT3I', 'epicjungle-elementor' ),
                'description' => esc_html__( 'Link de vídeo aplica-se apenas ao estilo 2', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'product_image', [
                'label' => esc_html__( 'Imagem do produto', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
                'description' => esc_html__( 'A imagem do produto aplica-se apenas ao estilo 3', 'epicjungle-elementor' ),
                'default'     => [ 'url' => Utils::get_placeholder_image_src() ]

            ]
        );

        $repeater->add_control(
            'product_title', [
                'label' => esc_html__( 'Título do produto', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::TEXT,
                'default' => 'Título do produto',
                'description' => esc_html__( 'Nome do título do produto aplica-se apenas ao estilo 3', 'epicjungle-elementor' ),
            ]
        );

         $repeater->add_control(
            'insta_image_link', [
                'label'       => esc_html__( 'Link da imagem do Instagram', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default'     => [
                    'url' => '#',
                ],
                'description' => esc_html__( 'Link da imagem do Instagram aplica-se apenas ao estilo 3', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'insta_author_image', [
                'label' => esc_html__( 'Imagem do autor do Instagram', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
                'description' => esc_html__( 'Imagem do autor do Instagram aplica-se apenas ao estilo 3', 'epicjungle-elementor' ),
            ]
        );


        $repeater->add_control(
            'insta_name', [
                'label' => esc_html__( 'Nome do autor do Instagram', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::TEXT,
                'default' => '@morni.janeffel',
                'description' => esc_html__( 'Nome do autor do Instagram aplica-se apenas ao estilo 3', 'epicjungle-elementor' ),
            ]
        );

        
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'logo', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default'   => 'custom',
                'description' => esc_html__( 'Tamanho do logotipo de paginação', 'epicjungle-elementor' ),
                //'separator' => 'none',
                
            ]
        );

        $this->start_injection( [
            'of' => 'slides',
        ] );


        $this->add_control( 'show_title', [
            'label'     => esc_html__( 'Título', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'condition'   => [
                '_skin' => '',
            ],
        ] );

        $this->add_control( 'title_tag', [
            'label'    => esc_html__( 'Tag HTML do título', 'epicjungle-elementor' ),
            'type'     => Controls_Manager::SELECT,
            'options'  => [
                'h1'   => 'H1',
                'h2'   => 'H2',
                'h3'   => 'H3',
                'h4'   => 'H4',
                'h5'   => 'H5',
                'h6'   => 'H6',
                'div'  => 'div',
                'span' => 'span',
                'p'    => 'p',
            ],
            'default'  => 'h2',
            'condition'   => [
                'show_title' => 'yes',
                '_skin' => '',
            ],
        ] );

        $this->add_control(
            'title', [
                'label'       => esc_html__( 'Título', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Depoimentos', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Título', 'epicjungle-elementor' ),
                'condition'   => [
                    'show_title' => 'yes',
                    '_skin' => '',
                ],
            ]
        );

        $this->add_control( 'show_author_image', [
            'label'     => esc_html__( 'Imagem do autor', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'condition'   => [
                '_skin' => '',
            ],
        ] );

        $this->add_control( 'show_blockquote', [
            'label'     => esc_html__( 'Bloco de citação', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'condition'   => [
                '_skin' => 'skin-style-3',
            ],
        ] );


        $this->add_control(
            'enable_pagination', [
                'label'     => esc_html__( 'Ativar paginação', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'condition'   => [
                    '_skin' => '',
                ],
            ]
        );

        $this->add_control(
            'pagination_position', [
                'label'     => esc_html__( 'Posição de paginação', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'condition' => [
                    '_skin' => '',

                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alinhamento do carrossel', 'epicjungle-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => __( 'Esquerda', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Centro', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Final', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel' => 'align-items:{{VALUE}};',
                ],
            ]
        );


        // $this->add_control(
        //     'video_link',
        //     [
        //         'label' => __( 'Link do vídeo', 'epicjungle-elementor' ),
        //         'type' => Controls_Manager::URL,
        //         'dynamic' => [
        //             'active' => true,
        //         ],
        //         'default' => [
        //             'url' => '#',
        //         ],
        //         'placeholder' => __( 'https://www.youtube.com/watch?v=PjNJfOrKT3I', 'epicjungle-elementor' ),
        //         'condition' => [
        //             '_skin' => 'skin-style-2',

        //         ],
        //     ]
        // );

       $this->end_injection();
    }

    protected function get_repeater_defaults() {
        $placeholder_image_src = Utils::get_placeholder_image_src();

        $defaults = [];
        $names    = [ 'Sarah Palson', 'Emma Brown', 'Tim Brooks', 'Sanomi Smith', 'Charlie Welch' ];
        $content  = [
            esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida dignissimos ducimus qui blanditiis praesentium voluptatum.', 'epicjungle-elementor' ),
            esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida dignissimos ducimus qui blanditiis praesentium voluptatum.', 'epicjungle-elementor' ),
            esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida dignissimos ducimus qui blanditiis praesentium voluptatum.', 'epicjungle-elementor' ),
            esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida dignissimos ducimus qui blanditiis praesentium voluptatum.', 'epicjungle-elementor' ),
            esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida dignissimos ducimus qui blanditiis praesentium voluptatum.', 'epicjungle-elementor' )
        ];

        foreach( $names as $key => $name ) {
            $defaults[] = [
                'content'           => $content[ $key ],
                'name'              => $name,
                'image'             => [ 'url' => $placeholder_image_src ],
                'insta_image'       => [ 'url' => $placeholder_image_src ],
                'insta_author_image'=> [ 'url' => $placeholder_image_src ],
                'logo'              => [ 'url' => $placeholder_image_src ],
                'video_link'        => '#',
                'link'              => '#'
                
            ];
        }

        return $defaults;
    }

    protected function print_slide( array $slide, array $settings, $element_key ) {

        if( empty( $slide['image']['url'] ) ) {
            $slide['image']['url'] = Utils::get_placeholder_image_src();
        }

        $author_css   = $settings['author_css_class' ];

        $this->add_render_attribute( $element_key . '-card-img', 'class', 'ej-testimonial-slide-author' );

        if ( ! empty( $author_css ) ) {
            $this->add_render_attribute( $element_key . '-card-img', 'class', $author_css );
        }

        $this->add_render_attribute( $element_key . '-card-img', 'href', $slide['link']['url'] );


        $this->add_render_attribute( 'blockquote', 'class', 'testimonial__title' );

        if ( ! empty( $settings['title_css'] ) ) {
            $this->add_render_attribute( 'title', 'class', $settings['title_css'] );
        }

        $this->add_render_attribute( 'content', 'class', 'ej-testimonial-slide-content' );


        if ( ! empty( $settings['content_css'] ) ) {
            $this->add_render_attribute( 'content', 'class', $settings['content_css'] );
        }
        
        ?><blockquote class="blockquote <?php echo esc_attr( $settings['pagination_position'] === 'yes' ) ? 'text-center': 'mt-3 mb-0'; ?>">

            <p <?php echo $this->get_render_attribute_string( 'content' ); ?>><?php echo $slide['content']; ?></p>
            <p <?php echo $this->get_render_attribute_string( 'content' ); ?>><?php echo $slide['content_2']; ?></p>

            <?php if ( ! empty( $slide['name'] ) ) : ?>
                <footer class="testimonial-footer media align-items-center">
                   <?php if (  $settings[ 'show_author_image' ] ) :
                        $this->add_render_attribute( $element_key . '-image', [
                            'src' => $slide['image']['url'],
                            'alt' => ! empty( $slide['name'] ) ? $slide['name'] : '',
                            'class' => 'rounded-circle',
                            'width'  => 42
                        ] );?>
                        <img <?php echo $this->get_render_attribute_string( $element_key . '-image' ); ?>>
                    <?php endif; ?>

                    <div class="media-body pl-2 ml-1">
                        <a <?php echo $this->get_render_attribute_string( $element_key . '-card-img' ); ?>>
                            <?php echo $slide['name']; ?>
                        </a>
                    </div>
                </footer>
            <?php endif; ?>
        </blockquote><?php

    }

    protected function print_pagination_slide( array $slide, array $settings, $element_key ) {
        $logo_html = Group_Control_Image_Size::get_attachment_image_html( $slide, 'logo' );

        $logo_classes = 'slider-logo img-fluid elementor-repeater-item-' . $slide['_id'];        

        if ( false === strpos( $logo_html, 'class="' ) ) {
            $logo_html = str_replace( '<img', '<img class="' . esc_attr( $logo_classes ) . '"', $logo_html );
        } else {
            $logo_html = str_replace( 'class="', 'class="' . esc_attr( $logo_classes ) .' ' , $logo_html );
        }

        echo $logo_html;


    }


    protected function render() {
        $uniqId   = 'testimoial-slider-' . $this->get_id();
        $settings = $this->get_settings_for_display();
        //echo '<pre>' . print_r( $settings, 1 ) . '</pre>';

        $default_control_args['controls'] = '';
        $default_nav_args['nav']          = '';

        $title             = $settings['title'];
        $title_tag         = $settings['title_tag'];
        $show_title        = $settings['show_title'];

        $this->add_render_attribute( 'title', 'class', 'testimonial__title' );

        if ( ! empty( $settings['title_css'] ) ) {
            $this->add_render_attribute( 'title', 'class', $settings['title_css'] );
        }

        $this->files_upload_handler = Files_Upload_Handler::is_enabled();


        $default_carousel_args = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'autoplay'          => isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ? true : false,
            'gutter'           => 20,
        ];

        $default_carousel_args = apply_filters( 'epicjungle_testimonial_carousel_slider_default_carousel_args', $default_carousel_args );

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $default_carousel_args['autoPlay']             = $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 1500;
            $default_carousel_args['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

        if( isset( $settings['controls'] ) && $settings['controls'] === 'yes' ) {
            $default_control_args['controls']     = $settings['controls_position'];
        }

        if( isset( $settings['nav'] ) && $settings['nav'] === 'yes' ) {
            $default_nav_args['nav']     =  isset( $settings['nav_position'] ) && $settings['nav_position'] ? 'cs-dots-inside' : '';
        }

        if( isset( $settings['nav'] ) && $settings['nav'] === 'yes' ) {
            $default_nav_args['nav']     .= isset( $settings['nav_skin'] ) && $settings['nav_skin'] ? ' cs-dots-light' : '';
        }

        if( $settings[ 'enable_pagination' ] === 'yes' ) {
            $column_class   = $settings['pagination_position'] ? '' : 'col-md-8';
        }else {
           $column_class   = 'col-md-12';
        }
        
        $this->add_render_attribute(
            'testimonial-carousel', [
                'class' => [
                    'cs-carousel', 'row', 
                    $settings['carousel_css'],
                    $default_control_args['controls'], $default_nav_args['nav'] ],
                ]
        ); 

        $this->add_render_attribute( 'column', 'class', $column_class );


        $this->add_render_attribute(
            'testimonial-carousel-inner', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $default_carousel_args ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 
        ?>
        <div <?php echo $this->get_render_attribute_string( 'testimonial-carousel' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'column' ); ?>>
                <?php if (  $show_title && ! empty( $title ) ): ?>
                    <<?php echo $title_tag . ' ' . $this->get_render_attribute_string( 'title' ); ?>>
                        <?php echo esc_html( $title ); ?>
                    </<?php echo $title_tag; ?>>
                <?php endif; ?>

                <div <?php echo $this->get_render_attribute_string( 'testimonial-carousel-inner' ); ?>>
                    <?php foreach ( $settings['slides'] as $slide ) :
                        $this->print_slide( $slide, $settings, 'image-slide-' . $slide['_id'] );
                    endforeach; ?>
                </div> 
            </div>
            <?php if ( $settings['enable_pagination'] === 'yes' ): ?>
                <?php if ( $settings['pagination_position'] !== 'yes' ): ?>
                    <div class="col-lg-3 col-md-4 offset-lg-1">
                <?php endif; ?>
                    <div class="cs-carousel-pager d-flex flex-wrap justify-content-center align-items-center <?php echo esc_attr( $settings['pagination_position'] === 'yes' ) ? 'pb-md-2': 'flex-md-column align-items-md-start border-left pt-4 mt-4 pl-md-3 pt-md-0 mt-md-0'; ?>">
                         <?php foreach ( $settings['slides'] as $key => $slide ) : 
                            if ( count( $settings['slides'] ) > 1 ) :
                                $index = $key+1; ?>
                                <a href="#" class="ej-pagination-logo mx-4 my-3 <?php echo esc_attr( $settings['pagination_position'] !== 'yes' ) ? 'my-md-4' : '' ?><?php if ( $index == 1 ) echo esc_attr( ' active' ); ?>" data-goto="<?php echo esc_attr ( $index );?>">
                                   <?php $this->print_pagination_slide( $slide, $settings, 'image-slide-' . $slide['_id'] ); ?>
                                </a><?php
                            endif;
                        endforeach; ?>
                    </div>
                <?php if ( $settings['pagination_position'] !== 'yes' ): ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php
    }
}