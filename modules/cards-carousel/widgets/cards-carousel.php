<?php
namespace EpicJungleElementor\Modules\CardsCarousel\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use EpicJungleElementor\Base\Base_Widget;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes;
use Elementor\Utils;



class Cards_Carousel extends Base_Widget {

    public function get_name() {
        return 'ej-cards-carousel';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de cartões', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_Cards', [
                'label' => esc_html__( 'Cartões', 'epicjungle-elementor' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Escolher imagem', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Título', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Título', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Link', 'epicjungle-elementor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '#',
                ],
                'placeholder' => __( 'https://seu-link.com.br', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'badge_text',
            [
                'label' => esc_html__( 'Texto do emblema', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Texto do emblema', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'badge_color',
            [
                'label' => __( 'Cor do emblema', 'epicjungle-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel', [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [
                        'title'         => esc_html__( 'Roupas', 'epicjungle-elementor' ),
                        'badge_text'    => esc_html__( 'A partir de RS19,90', 'epicjungle-elementor' ),
                        'badge_color' => '#16c995',
                    ],
                    [
                        'title'    => esc_html__( 'Eletrônicos', 'epicjungle-elementor' ),
                        'badge_text'    => esc_html__( 'A partir de RS19,90', 'epicjungle-elementor' ),
                        'badge_color' => '#6a9bf4',
                    ],
                    [
                        'title'    => esc_html__( 'Acessorios', 'epicjungle-elementor' ),
                        'badge_text'    => esc_html__( 'A partir de RS19,90', 'epicjungle-elementor' ),
                        'badge_color' => '#f74f78',
                    ],
                    [
                        'title'    => esc_html__( 'Kids', 'epicjungle-elementor' ),
                        'badge_text'    => esc_html__( 'A partir de RS19,90', 'epicjungle-elementor' ),
                        'badge_color' => '#ffb15c',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_responsive_control(
            'slides_per_view',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Slides por visualização', 'epicjungle-elementor' ),
                'options' => [
                    ''  => __( 'Padrão', 'epicjungle-elementor' ),
                    '1' => __( '1', 'epicjungle-elementor' ),
                    '2' => __( '2', 'epicjungle-elementor' ),
                    '3' => __( '3', 'epicjungle-elementor' ),
                    '4' => __( '4', 'epicjungle-elementor' ),
                    '6' => __( '6', 'epicjungle-elementor' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_options',
            [
                'label' => esc_html__( 'Opções adicionais', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'controls',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__( 'Setas', 'epicjungle-elementor' ),
                'default'      => 'false',
                'label_off'    => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'label_on'     => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'prefix_class' => 'elementor-arrows-',
                'render_type'  => 'template',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'nav',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__( 'Pontos', 'epicjungle-elementor' ),
                'default'      => 'yes',
                'label_off'    => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'label_on'     => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'prefix_class' => 'elementor-pagination-',
                'render_type'  => 'template',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'     => esc_html__( 'Reprodução automática', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no',
                'separator' => 'before',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => esc_html__( 'Velocidade de reprodução automática', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 1500,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'     => esc_html__( 'Pausar ao passar o mouse', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

    }

    
    /**
     * Render Dividers widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function print_slide( array $slide, array $settings, $element_key ) {

        if( empty( $slide['image']['url'] ) ) {
            $slide['image']['url'] = Utils::get_placeholder_image_src();
        }
    ?>
        <div class="pb-2 elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ) ?>">
            <a class="card card-category box-shadow mx-1" href="<?php echo esc_attr( $slide['link']['url'] ); ?>">
                <span class="badge badge-lg badge-floating badge-floating-right badge-success"><?php echo esc_attr( $slide['badge_text'] )?></span>
                <div class="card-img-top">
                    <img src=<?php echo esc_attr( $slide['image']['url'] ) ?> alt="<?php echo $slide['title']; ?>"/>
                </div>
                <div class="card-body">
                  <h4 class="card-title"><?php echo esc_attr( $slide['title'] ) ?></h4>
                </div>
            </a>
        </div>
    <?php

    }
  
    protected function render() {
        $settings = $this->get_settings_for_display();

        $slides = $settings[ 'carousel' ];

        if ( empty( $slides ) ) {
            return;
        }

        $column = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 2;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 3;
        $column_lg = ! empty( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 3;

        $default_carousel_args = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'autoplay'          => isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ? true : false,
            'items'             => 3,
            'gutter'           => 24,
            'responsive'        => array (
                '0'       => array( 'items'   => 1 ),
                '560'     => array( 'items'   => $column ),
                '850'     => array( 'items'   => $column_md ),
                '1100'    => array( 'items'   => $column_lg ),
            )
        ];

        
        $default_carousel_settings = apply_filters( 'epicjungle_browser_image_carousel_args', $default_carousel_args );

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $default_carousel_settings['autoPlay'] = $settings['autoplay_speed'] ? intval( $settings['autoplay_speed'] ) : 1500;
            $default_carousel_settings['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }
        
        $this->add_render_attribute(
            'carousel_wrap', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $default_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
               
            ]
        ); 

        ?>
            <div class="cs-carousel">
                <div <?php echo $this->get_render_attribute_string( 'carousel_wrap' ); ?>>
                <?php foreach ( $slides as $slide ) :
                    $this->print_slide( $slide, $settings, 'image-slide-' . $slide['_id'] );
                endforeach; ?>
                </div>
            </div>
        <?php

    }
}