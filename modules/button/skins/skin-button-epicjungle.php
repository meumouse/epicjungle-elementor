<?php

namespace EpicJungleElementor\Modules\Button\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
/*use Elementor\Repeater;
use EpicJungleElementor\Plugin;*/

class Skin_Button_epicjungle extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
    }

    public function get_id() {
        return 'button-epicjungle';
    }

    public function get_title() {
        return esc_html__( 'EpicJungle', 'epicjungle-elementor' );
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/button/section_button/before_section_end', [ $this, 'register_section_button_controls'], 10 );
        add_action( 'elementor/element/button/section_style/before_section_end', [ $this, 'register_section_style_controls'], 10 );
        add_filter( 'epicjungle-elementor/widget/button/print_template', [ $this, 'print_template' ], 10 );
    }

    public function register_section_button_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;

        $this->parent->update_control(
            'button_type', [
                'condition' => [
                    '_skin' => ''
                ]
            ]
        );

        $this->parent->update_control(
            'size', [
                'condition' => [
                    '_skin' => ''
                ]
            ]
        );


        $this->add_control(
            'button_type',
            [
                'label'   => esc_html__( 'Tipo', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'primary',
                'options' => [
                    'primary'       => esc_html__( 'Primário', 'epicjungle-elementor' ),
                    'secondary'     => esc_html__( 'Secundário', 'epicjungle-elementor' ),
                    'success'       => esc_html__( 'Sucesso', 'epicjungle-elementor' ),
                    'danger'        => esc_html__( 'Perigo', 'epicjungle-elementor' ),
                    'warning'       => esc_html__( 'Aviso', 'epicjungle-elementor' ),
                    'info'          => esc_html__( 'Informação', 'epicjungle-elementor' ),
                    'dark'          => esc_html__( 'Escuro', 'epicjungle-elementor' ),
                    'link'          => esc_html__( 'Link', 'epicjungle-elementor' ),
                    'gradient'      => esc_html__( 'Degradê', 'epicjungle-elementor' ),
                    
                ],
            ],
            [
                'position' => [
                    'of' => '_skin'
                ]
            ]
        );

        $this->add_control(
            'button_variant',
            [
                'label'   => esc_html__( 'Variante', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''        => esc_html__( 'Padrão', 'epicjungle-elementor' ),
                    'outline' => esc_html__( 'Contorno', 'epicjungle-elementor' ),
                    'translucent'    => esc_html__( 'Translúcido', 'epicjungle-elementor' ),
                ]
            ],
            [
                'position' => [
                    'of' => 'button_type'
                ]
            ]
        );

        $this->add_control(
            'button_style',
            [
                'label'   => esc_html__( 'Estilo', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''               => esc_html__( 'Padrão', 'epicjungle-elementor' ),
                    'pill'           => esc_html__( 'Pílula', 'epicjungle-elementor' ),
                    'square'         => esc_html__( 'Quadrado', 'epicjungle-elementor' ),
                ]
            ],
            [
                'position' => [
                    'at' => 'before',
                    'of' => 'text'
                ]
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label'   => esc_html__( 'Tamanho', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'sm' => esc_html__( 'Pequeno', 'epicjungle-elementor' ),
                    ''   => esc_html__( 'Padrão', 'epicjungle-elementor' ),
                    'lg' => esc_html__( 'Grande', 'epicjungle-elementor' ),
                    'block' => esc_html__( 'Bloco', 'epicjungle-elementor' ),
                ]
            ],
            [
                'position' => [
                    'at' => 'before',
                    'of' => 'text'
                ]
            ]
        );

         $this->add_control( 'icon_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Adicionado à tag <i>', 'epicjungle-elementor' ),
        ], [
            'position'    => [
                'at' => 'after',
                'of' => 'icon_indent'
            ]
        ] );

        // $this->add_control(
        //     'enable_lift', [
        //         'label'        => esc_html__( 'Enable Lift?', 'epicjungle-elementor' ),
        //         'type'         => Controls_Manager::SWITCHER,
        //         'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
        //         'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
        //         'return_value' => 'yes',
        //         'default'      => 'no',
        //         'description'  => esc_html__( 'On enable, it adds a lift effect on hover', 'epicjungle-elementor' )
        //     ]
        // );

        // $this->add_control(
        //     'enable_shadow', [
        //         'label'        => esc_html__( 'Enable Shadow?', 'epicjungle-elementor' ),
        //         'type'         => Controls_Manager::SWITCHER,
        //         'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
        //         'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
        //         'return_value' => 'yes',
        //         'default'      => 'no',
        //         'description'  => esc_html__( 'On enable, it adds a shadow effect on hover', 'epicjungle-elementor' )
        //     ]
        // );

        $this->add_control(
            'enable_fancybox', [
                'label'        => esc_html__( 'Ativar Lightbox?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'description'  => esc_html__( 'Abre link em uma caixa de fantasia.', 'epicjungle-elementor' )
            ]
        );

        $this->add_control(
            'enable_smooth_scroll', [
                'label'        => esc_html__( 'Ativar rolagem suave?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'description'  => esc_html__( 'Ative a rolagem suave para links na página.', 'epicjungle-elementor' )
            ]
        );

        $this->add_control(
            'is_print_button', [
                'label'        => esc_html__( 'Botão de impressão?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->parent->update_control(
            'icon_indent', [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .btn .btn__icon--right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .btn .btn__icon--left'  => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }

    public function register_section_style_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;

        $this->parent->update_control(
            'button_text_color', [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .btn'              => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control( 'btn_txt_css', [
            'label'       => esc_html__( 'Classe CSS do texto', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Adicionado à tag .elementor-button-text', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'icon_wrapper_css', [
            'label'       => esc_html__( 'Icon Wrapper Classes', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Added to .elementor-button-icon', 'epicjungle-elementor' ),
        ] );

        $this->parent->update_control(
            'background_color', [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .btn'              => 'background-color: {{VALUE}};',
                ],
                'global' => [
                    'default' => '',
                ],
            ]
        );

        $this->parent->update_control(
            'hover_color',
            [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn:hover svg, {{WRAPPER}} .btn:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->parent->update_control(
            'button_background_hover_color',
            [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->parent->update_control(
            'button_hover_border_color',
            [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->parent->update_control(
            'border_radius',
            [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 
                    {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 
                    {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->parent->update_control(
            'text_padding',
            [
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // $this->parent->remove_control( 'typography_typography' );

        $this->parent->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'btn_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .elementor-button, {{WRAPPER}} .btn',
            ], [
                'position' => [
                    'type' => 'section',
                    'at'   => 'start',
                    'of'   => 'section_style',
                ]
            ]
        );

        $this->parent->remove_control( 'text_shadow' );

        $this->add_control( 'btn_css', [
            'label'       => esc_html__( 'CSS Classes', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Added to .btn tag', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'btn_content_wrapper_css', [
            'label'       => esc_html__( 'CSS Classes', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Added to .elementor-button-content-wrapper tag', 'epicjungle-elementor' ),
        ] );
    }

    public function print_template( $content ) {
        ob_start();
        $this->content_template( $content );
        return ob_get_clean();
    }

    public function render() {
        $widget   = $this->parent;

        $settings = $widget->get_settings_for_display();

        $widget->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

        $button_type          = $settings[ $this->get_control_id( 'button_type') ];
        $button_variant       = $settings[ $this->get_control_id( 'button_variant') ];
        $button_style         = $settings[ $this->get_control_id( 'button_style') ];
        $button_size          = $settings[ $this->get_control_id( 'button_size') ];
        //$enable_lift          = $settings[ $this->get_control_id( 'enable_lift' ) ];
        //$enable_shadow        = $settings[ $this->get_control_id( 'enable_shadow' ) ];
        $enable_fancybox      = $settings[ $this->get_control_id( 'enable_fancybox' ) ];
        $enable_smooth_scroll = $settings[ $this->get_control_id( 'enable_smooth_scroll' ) ];
        $is_print_button      = $settings[ $this->get_control_id( 'is_print_button' ) ];
        $btn_css              = $settings[ $this->get_control_id( 'btn_css' ) ];

        if ( ! empty( $settings['link']['url'] ) ) {
            $widget->add_link_attributes( 'button', $settings['link'] );
            $widget->add_render_attribute( 'button', 'class', 'elementor-button-link' );
        }

        $widget->add_render_attribute( 'button', 'class', 'btn' );
        $widget->add_render_attribute( 'button', 'role', 'button' );

        if ( ! empty( $settings['button_css_id'] ) ) {
            $widget->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
        }

        if ( 'outline' === $button_variant ) {
            $btn_class = 'btn-outline-' . $button_type;
        } elseif ( 'translucent' === $button_variant ) {
            $btn_class = 'btn-translucent-' . $button_type;
        } else {
            $btn_class = 'btn-' . $button_type;
        }
        $widget->add_render_attribute( 'button', 'class', $btn_class );

        if ( ! empty( $button_style ) ) {
            $widget->add_render_attribute( 'button', 'class', 'btn-' . $button_style );
        }

        if ( ! empty( $button_size ) ) {
            $widget->add_render_attribute( 'button', 'class', 'btn-' . $button_size );
        }

        // if ( 'yes' === $enable_lift ) {
        //     $widget->add_render_attribute( 'button', 'class', 'lift' );
        // }

        // if ( 'yes' === $enable_shadow ) {
        //     $widget->add_render_attribute( 'button', 'class', 'shadow' );
        // }

        if ( 'yes' === $enable_fancybox ) {
            $widget->add_render_attribute( 'button', 'data-fancybox', 'true' );
        }

        if ( 'yes' === $enable_smooth_scroll ) {
            $widget->add_render_attribute( 'button', 'data-toggle', 'smooth-scroll' );   
        }

        if  ( 'yes' === $is_print_button ) {
            $widget->add_render_attribute( 'button', 'onclick', 'window.print()' );
        }

        if ( $settings['hover_animation'] ) {
            $widget->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        if ( ! empty( $btn_css ) ) {
            $widget->add_render_attribute( 'button', 'class', $btn_css );
        }

        if ( ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) && empty( $settings['text'] ) ) {
            $widget->add_render_attribute( 'button', 'class', 'btn-icon' );
        }

        ?>
        <div <?php echo $widget->get_render_attribute_string( 'wrapper' ); ?>>
            <a <?php echo $widget->get_render_attribute_string( 'button' ); ?>>
                <?php $this->render_text(); ?>
            </a>
        </div>
        <?php
    }

    public function render_text() {
        $widget   = $this->parent;
        $settings = $widget->get_settings_for_display();

        $widget->add_render_attribute( [
            'content-wrapper' => [
                'class' => 'elementor-button-content-wrapper',
            ],
            'icon-align' => [
                'class' => [
                    'elementor-button-icon',
                    'btn__icon',
                    'btn__icon--' . $settings['icon_align'],
                ],
            ],
            'text' => [
                'class' => 'elementor-button-text',
            ],
        ] );

        if ( ! empty( $settings[ $this->get_control_id( 'btn_content_wrapper_css' ) ] ) ) {
            $widget->add_render_attribute( 'content-wrapper', 'class', $settings[ $this->get_control_id( 'btn_content_wrapper_css' ) ] );
        }

        if ( 'right' === $settings['icon_align'] ) {
            $widget->add_render_attribute( 'icon-align', 'class', 'order-2' );
            $widget->add_render_attribute( 'text', 'class', 'order-1' );
        }

        if ( ! empty( $settings[ $this->get_control_id( 'btn_txt_css' ) ] ) ) {
            $widget->add_render_attribute( 'text', 'class', $settings[ $this->get_control_id( 'btn_txt_css' ) ] );
        }

        if ( ! empty( $settings[ $this->get_control_id( 'icon_wrapper_css' ) ] ) ) {
            $widget->add_render_attribute( 'icon-align', 'class', $settings[ $this->get_control_id( 'icon_wrapper_css' ) ]);
        }

        //$widget->add_inline_editing_attributes( 'text', 'none' );
        ?>
        <span <?php echo $widget->get_render_attribute_string( 'content-wrapper' ); ?>>
            <?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
           <span <?php echo $widget->get_render_attribute_string( 'icon-align' ); ?>>
                    <?php 
                    $icon_atts = [ 'aria-hidden' => 'true' ];
                    if ( ! empty( $settings[ $this->get_control_id( 'icon_css' ) ] ) ) {
                        $icon_atts[ 'class' ] = $settings[ $this->get_control_id( 'icon_css' ) ];
                    }
                    Icons_Manager::render_icon( $settings['selected_icon'], $icon_atts ); ?>
            </span>
            <?php endif; ?>
            <?php if ( ! empty( $settings['text'] ) ) : ?>
            <span <?php echo $widget->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
            <?php endif; ?>
        </span>
        <?php
    }

    public function content_template( $content ) {
        ?>
        <# if ( 'button-epicjungle' === settings._skin ) { #>
            <#
            view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );
            view.addInlineEditingAttributes( 'text', 'none' );
            var iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
                migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );

            var button_type     = settings.button_epicjungle_button_type;
            var button_variant  = settings.button_epicjungle_button_variant;
            var button_style    = settings.button_epicjungle_button_style;
            var button_size     = settings.button_epicjungle_button_size;
            <!-- var enable_lift     = settings.button_epicjungle_enable_lift; -->
            <!-- var enable_shadow   = settings.button_epicjungle_enable_shadow; -->
            var enable_fancybox = settings.button_epicjungle_enable_fancybox;
            var btn_css         = settings.button_epicjungle_btn_css;
            var btn_class       = '';
            
            
            view.addRenderAttribute( 'button', 'class', 'btn' );

            view.addRenderAttribute( 'button', 'class', [
                'elementor-animation-' + settings.hover_animation,
            ] );
            
            view.addRenderAttribute( 'button', 'id', settings.button_css_id );
            view.addRenderAttribute( 'button', 'role', 'button' );
            view.addRenderAttribute( 'button', 'href', settings.link.url );

            if ( 'outline' === button_variant ) {
                btn_class = 'btn-outline-' + button_type;
            } else if ( 'translucent' === button_variant ) {
                btn_class = 'btn-translucent-' + button_type;
            } else {
                btn_class = 'btn-' + button_type;
            }

            view.addRenderAttribute( 'button', 'class', btn_class );

            if ( '' !== button_style ) {
                view.addRenderAttribute( 'button', 'class', 'btn-' + button_style );
            }

            if ( '' !== button_size ) {
                view.addRenderAttribute( 'button', 'class', 'btn-' + button_size );
            }

            

            if ( 'yes' == enable_fancybox ) {
                view.addRenderAttribute( 'button', 'data-fancybox', 'true' );
            }

            view.addRenderAttribute( 'icon', 'class', [
                'elementor-button-icon', 'btn__icon', 'btn__icon--' + settings.icon_align
            ] );

            if ( 'right' === settings.icon_align ) {
                view.addRenderAttribute( 'icon', 'class', 'order-2' );
                view.addRenderAttribute( 'text', 'class', 'order-1' );
            }

            if ( '' !== btn_css ) {
                view.addRenderAttribute( 'button', 'class', btn_css );
            }

            if ( '' == settings.text && ( settings.icon || settings.selected_icon ) ) {
                 view.addRenderAttribute( 'button', 'class', 'btn-icon' );
            }

            #>
            <div class="elementor-button-wrapper">
                <a {{{ view.getRenderAttributeString( 'button' ) }}}>
                    <span class="elementor-button-content-wrapper">
                        <# if ( settings.icon || settings.selected_icon ) { #>
                        <span {{{ view.getRenderAttributeString( 'icon' ) }}}>
                            <# if ( ( migrated || ! settings.icon ) && iconHTML.rendered ) { #>
                                {{{ iconHTML.value }}}
                            <# } else { #>
                                <i class="{{ settings.icon }}" aria-hidden="true"></i>
                            <# } #>
                        </span>
                        <# } #>
                        <# if ( '' != settings.text ) { #>
                        <span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
                        <# } #>
                    </span>
                </a>
            </div>
        <# } else { #>
            <?php echo $content; ?>
        <# } #>
        <?php
    }
}