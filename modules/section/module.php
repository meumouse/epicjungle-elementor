<?php

namespace EpicJungleElementor\Modules\Section;

use EpicJungleElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();

        $this->add_actions();
    }

    public function get_name() {
        return 'override-section';
    }

    public function add_actions() {
        add_action( 'elementor/frontend/section/after_render', [ $this, 'wrap_end' ], 20 );
        add_action( 'elementor/frontend/section/before_render', [ $this, 'before_render' ], 5 );
        add_action( 'elementor/element/section/section_advanced/before_section_end', [ $this, 'add_section_controls' ], 10, 2 );
        add_action( 'elementor/element/section/section_shape_divider/before_section_end', [ $this, 'shape_divider_controls' ], 10, 2 );
        add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'add_jarallax_controls' ], 10, 2 );
        
    }

    public function add_jarallax_controls( $element, $args ) {
        $element->start_controls_section(
            '_section_jarallax', [
                'label' => esc_html__( 'Jarallax', 'epicjungle-elementor' ),
                'tab'   => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control( 'enable_jarallax', [
            'label'   => esc_html__( 'Ativar Jarallax', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no'
        ] );

        $element->add_control( 'jarallax_bg', [
            'label'     => esc_html__( 'Fundo', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::MEDIA,
            'condition' => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'separate_wrapper', [
            'label'     => esc_html__( 'Wrapper separado para plano de fundo', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'no',
            'condition' => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'jarallax_speed', [
            'label'     => esc_html__( 'Velocidade', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => '',
            'min'       => 0,
            'step'      => 0.1,
            'condition' => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'data_type', [
            'label'     => esc_html__( 'Tipo de dados', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'no',
            'condition' => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'enable_jarallax_overlay', [
            'label'     => esc_html__( 'Ativar sobreposição', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'no',
            'condition' => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'section_overlay_opacity ', [
            'label' => __( 'Opacidade da sobreposição', 'epicjungle-elementor' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 1,
                    'min' => 0.10,
                    'step' => 0.01,
                ],
            ],
            'default' => [ 'size' => 0.85 ],
            'selectors' => [
                '.jarallax .section-overlay-opacity' => 'opacity: {{SIZE}};',
            ],
            'condition' => [ 'enable_jarallax_overlay' => 'yes' ]
        ] );

        $element->add_control( 'enable_jarallax_shape', [
            'label'     => esc_html__( 'Ativar forma', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'no',
            'condition' => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'jarallax_shape', [
            'label'     => __( 'Forma Jarallax', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'cs-shape-curve-side',
            'options'   => [
                'cs-shape-slant'        => esc_html__( 'Inclinação', 'epicjungle-elementor' ),
                'cs-shape-curve'        => esc_html__( 'Curva Inclinada', 'epicjungle-elementor' ),
                'cs-shape-curve-side'   => esc_html__( 'Lado da curva inclinada', 'epicjungle-elementor' ),
                'food-image'            => esc_html__( 'Imagem de comida', 'epicjungle-elementor' ),

            ],
            'condition' => [
                'enable_jarallax_shape' => 'yes'
            ]
        ] );

        $element->add_control( 'jarallax_style', [
            'label'       => esc_html__( 'Estilo', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXTAREA,
            'description' => esc_html__( 'Insira o estilo que você deseja que seja embutido no elemento .jarallax', 'epicjungle-elementor' ),
            'condition'   => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'jarallax_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Aplicado ao elemento .jarallax', 'epicjungle-elementor' ),
            'condition'   => [
                'enable_jarallax' => 'yes'
            ]
        ] );

        $element->add_control( 'wrapper_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Aplicado ao wrapper do elemento .jarallax', 'epicjungle-elementor' ),
            'condition'   => [
                'separate_wrapper' => 'yes'
            ]
        ] );

        $element->end_controls_section();
    }

    public function wrap_start( $section ) {
        $settings     = $section->get_settings_for_display();
        $has_jarallax = $settings['enable_jarallax'] === 'yes' ? true: false;

        if ( $has_jarallax ) :

            if ( $settings['separate_wrapper'] === 'yes' ) {
                
                $section->add_render_attribute( 'jarallax_wrapper', 'class', 'position-relative' );
                $section->add_render_attribute( 'jarallax_div', 'class', 'position-absolute' );
                
                if ( ! empty( $settings['wrapper_css'] ) ) {
                    $section->add_render_attribute( 'jarallax_wrapper', 'class', $settings['wrapper_css'] );
                }
                ?><div <?php $section->print_render_attribute_string( 'jarallax_wrapper' ); ?>><?php
            }
            
            $section->add_render_attribute( 'jarallax_div', 'class', 'jarallax' );

            if ( ! empty( $settings['jarallax_css'] ) ) {
                $section->add_render_attribute( 'jarallax_div', 'class', $settings['jarallax_css'] );
            }

            if ( ! empty( $settings['jarallax_speed'] ) ) {
                $section->add_render_attribute( 'jarallax_div', 'data-speed', $settings['jarallax_speed'] );
            }

            if ( ! empty( $settings['jarallax_style'] ) ) {
                $section->add_render_attribute( 'jarallax_div', 'style', $settings['jarallax_style'] );
            }

            if ( $settings['data_type'] === 'yes' ) {
                $section->add_render_attribute( 'jarallax_div', 'data-type', 'scale-opacity' );
            }

            ?><div <?php $section->print_render_attribute_string( 'jarallax_div' ); ?> data-jarallax ><?php
            if ( isset( $settings['jarallax_bg']['url'] ) && ! empty( $settings['jarallax_bg']['url'] ) ) {
                ?>
                
                <?php if ( $settings['enable_jarallax_overlay'] === 'yes' ): ?>
                    <span class="bg-overlay bg-gradient section-overlay-opacity"></span>
                <?php endif; ?>
                
                <div class="jarallax-img" style="background-image: url(<?php echo esc_attr( $settings['jarallax_bg']['url'] );?>);"></div>

                <?php 

                if ( $settings['enable_jarallax_shape'] === 'yes' ) {
                    $this->get_cs_shape( $section );
                }
            }

            if ( $settings['separate_wrapper'] === 'yes' ) {
                ?></div><!-- /.jarallax --><?php
            }

        endif;
    }


    public function get_cs_shape( $section ) {
        $settings     = $section->get_settings_for_display();


        if ( $settings['jarallax_shape'] === 'cs-shape-slant' ) {
            ?><div  class="cs-shape cs-shape-bottom bg-body cs-shape-slant">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 260">
                    <polygon fill="currentColor" points="0,257 0,260 3000,260 3000,0"></polygon>
                </svg>
            </div><?php
        }
        elseif ( $settings['jarallax_shape'] === 'cs-shape-curve-side' )  {
            ?><div  class="cs-shape cs-shape-bottom bg-body cs-shape-curve-side">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 250">
                    <path fill="currentColor" d="M3000,0v250H0v-51c572.7,34.3,1125.3,34.3,1657.8,0C2190.3,164.8,2637.7,98.4,3000,0z"></path>
                </svg>
            </div><?php
        }
        elseif ( $settings['jarallax_shape'] === 'cs-shape-curve' )  {
            ?><div  class="cs-shape cs-shape-bottom bg-body cs-shape-curve">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
                    <path fill="currentColor" d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
                </svg>
            </div><?php
        }
        elseif ( $settings['jarallax_shape'] === 'food-image' )  {
            ?><img class="d-lg-block d-none position-absolute mb-n5" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/demo/food-blog/hero/bg-shape.png' ); ?>" alt="Shape" style="bottom: 0; left: 0;" data-jarallax-element="25" data-disable-parallax-down="md" /><?php
        }
        
    }

    public function wrap_end( $section ) {
        $settings     = $section->get_settings_for_display();
        $has_jarallax = $settings['enable_jarallax'] === 'yes' ? true: false;

        if ( $has_jarallax ) :?>
            </div><!-- /.custom-wrap --><?php
        endif;
    }

    public function shape_divider_controls( $element, $args ) {
        $element->update_control(
            'shape_divider_top_color', [
                'selectors' => [
                    "{{WRAPPER}} > .elementor-shape-top .elementor-shape-fill" => 'fill: {{UNIT}};',
                    "{{WRAPPER}} > .elementor-shape-top" => 'color: {{UNIT}};',
                ],
            ]
        );
        $element->update_control(
            'shape_divider_bottom_color', [
                'selectors' => [
                    "{{WRAPPER}} > .elementor-shape-bottom .elementor-shape-fill" => 'fill: {{UNIT}};',
                    "{{WRAPPER}} > .elementor-shape-bottom" => 'color: {{UNIT}};',
                ],
            ]
        );
    }

    public function add_section_controls( $element, $args ) {
        $element->add_control( 'max_width', [
            'label'        => esc_html__( 'Max Width', 'epicjungle-elementor' ),
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
                '{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $element->add_control( 'container_class', [
            'label'        => esc_html__( 'Container Classes CSS', 'epicjungle-elementor' ),
            'label_block'  => true,
            'type'         => Controls_Manager::TEXT,
            'description'  => esc_html__( 'Aplicado ao elemento elementor-container. Você pode usar classes de utilitário de Bootstrap adicionais aqui.', 'epicjungle-elementor' ),
        ] );
    }

    public function before_render( $element ) {

        $settings        = $element->get_settings();
        $container_class = $settings['gap'];
        
        if ( 'no' === $settings['gap'] ) {
            $container_class = $settings['gap'] . ' no-gutters';
        }

        if ( isset( $settings['container_class'] ) && ! empty( $settings['container_class'] ) ) {
            $container_class .= ' ' . $settings['container_class'];
        }

        if ( ! empty( $container_class ) ) {
            $element->set_settings( 'gap', $container_class );           
        }

        if ( ( ( $settings['shape_divider_bottom'] ) == 'epicjungle-slant-bottom-right' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-bottom cs-shape-slant bg-body' );
        }

        if ( ( $settings['shape_divider_bottom'] == 'epicjungle-slant-bottom-left' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-bottom cs-shape-slant bg-body' );
        }

        if ( ( $settings['shape_divider_top'] == 'epicjungle-slant-top-right' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-top cs-shape-slant bg-body' );
        }

        if ( ( $settings['shape_divider_top'] == 'epicjungle-slant-top-left' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-top cs-shape-slant bg-body' );
        }

        if ( ( $settings['shape_divider_bottom'] == 'epicjungle-curve-bottom-center' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-bottom cs-shape-curve bg-body' );
        }

        if ( ( $settings['shape_divider_top'] == 'epicjungle-curve-top-center' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-top cs-shape-curve bg-body' );
        }

        if ( ( $settings['shape_divider_bottom'] == 'epicjungle-curve-bottom-right' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-bottom cs-shape-curve-side bg-body' );
        }

        if ( ( $settings['shape_divider_bottom'] == 'epicjungle-curve-bottom-left' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-bottom cs-shape-curve-side bg-body' );
        }

        if ( ( $settings['shape_divider_top'] == 'epicjungle-curve-top-right' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-top cs-shape-curve-side bg-body' );
        }

        if ( ( $settings['shape_divider_top'] == 'epicjungle-curve-top-left' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-top cs-shape-curve-side bg-body' );
        }

        if ( ( $settings['shape_divider_top'] == 'epicjungle-curve-right' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-right bg-body' );
        }

        if ( ( $settings['shape_divider_top'] == 'epicjungle-curve-left' ) ) {
            $element->add_render_attribute( '_wrapper', 'class', 'cs-shape cs-shape-left bg-body' );
        }

        $this->wrap_start( $element );
    }
}