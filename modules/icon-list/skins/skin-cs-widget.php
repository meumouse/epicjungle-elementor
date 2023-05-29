<?php

namespace EpicJungleElementor\Modules\IconList\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Skin_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;


class Skin_CS_Widget extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
    }

    public function get_id() {
        return 'cs-widget';
    }

    public function get_title() {
        return esc_html__( 'Widget CS', 'epicjungle-elementor' );
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/icon-list/section_icon/before_section_end', [ $this, 'register_icon_list_controls' ] );
        add_action( 'elementor/element/icon-list/section_icon_list/before_section_end', [ $this, 'register_list_style_controls' ], 20 );
        add_action( 'elementor/element/icon-list/section_icon_style/before_section_end', [ $this, 'register_icon_style_controls' ], 20 );
        add_action( 'elementor/element/icon-list/section_text_style/before_section_end', [ $this, 'register_text_style_controls' ], 20 );
        add_filter( 'epicjungle-elementor/widget/icon-list/print_template', array( $this, 'skin_print_template' ), 10, 2 );
    }

    public function register_icon_list_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;

        $this->add_control(
            'icon_title', [
                'label'        => esc_html__( 'Título da lista de ícones', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic'      => [
                    'active' => true,
                ],
                'default' => __( 'Título da lista de ícones', 'epicjungle-elementor' ),
                'description'  => esc_html__( 'Adicione o título do seu widget CS aqui.', 'epicjungle-elementor' ),
                'condition' => [ '_skin' => 'cs-widget' ],
            ],
            [
                'position' => [
                    'of' => '_skin'
                ]
            ]
        );

        $this->add_control(
            'widget_type',
            [
                'label' => __( 'Widget CS claro?', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Sim', 'epicjungle-elementor' ),
                'label_off' => __( 'Não', 'epicjungle-elementor' ),
                'default' => 'Sim',
            ],
            [
                'position' => [
                    'of' => '_skin'
                ]
            ]
        );
    }

    public function register_icon_style_controls( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;


        $widget->update_control( 'icon_color_hover', [
            'selectors' => [
                '{{WRAPPER}} .cs-widget-link:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
            ],
        ] );
    }

    public function register_list_style_controls( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;

        $this->add_control(
            'wrapper_css', [
                'label'        => esc_html__( 'Classes CSS de wrapper', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::TEXT,
                'dynamic'      => [
                    'active' => true,
                ],
                'description'  => esc_html__( 'Adicione a classe de preenchimento para CS Widget na tag <div> superior.', 'epicjungle-elementor' ),
                'condition' => [ '_skin' => 'cs-widget' ]

            ]
        );

        $widget->update_control( 'space_between', [
            'condition' => [ '_skin!' => 'cs-widget' ]
        ] );

        $widget->update_control( 'divider_style', [
            'condition' => [ '_skin!' => 'cs-widget' ]
        ] );

        $widget->update_control( 'divider', [
            'condition' => [ '_skin!' => 'cs-widget' ]
        ] );

        $widget->update_control( 'divider_weight', [
            'condition' => [ '_skin!' => 'cs-widget' ]
        ] );

        $widget->update_control( 'divider_width', [
            'condition' => [ '_skin!' => 'cs-widget' ]
        ] );

        $widget->update_control( 'divider_height', [
            'condition' => [ '_skin!' => 'cs-widget' ]
        ] );

        $widget->update_control( 'divider_color', [
            'condition' => [ '_skin!' => 'cs-widget' ]
        ] );

    }

    public function register_text_style_controls( Elementor\Widget_Base $widget ) {

        $widget->update_control(
            'text_color', [
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cs-widget-link' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'title_color', [
                'label' => __( 'Cor do título', 'epicjungle-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-widget-title' => 'color: {{VALUE}};'
                ],
            ]
        );

        $widget->update_control(
            'text_color_hover', [
                'selectors' => [
                    '{{WRAPPER}} .cs-widget-link:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );


        $widget->update_control(
            'text_indent', [
                'selectors' => [
                    '{{WRAPPER}} .cs-widget-link' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Title Typography', 'epicjungle-elementor' ),
                'selector' => '{{WRAPPER}} .cs-widget  .cs-widget-title',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $widget->update_control( 'icon_typography', [ 
            'condition' => [ '_skin!' => 'cs-widget' ],
        ] );
    }

    public function render() {
        $widget   = $this->parent;
        $settings = $widget->get_settings();

        $wrapper_css = $settings[ $this->get_control_id( 'wrapper_css' ) ];

        $widget_type  = $settings[  $this->get_control_id( 'widget_type') ] == 'yes' ? 'cs-widget-light' : '';


        $widget->add_render_attribute( 'wrapper', 'class',[
            'cs-widget',
            $widget_type,
            $wrapper_css 
        ] );

        $widget->add_render_attribute( 'link_css', 'class', [
            'cs-widget-link',
        ] );

        ?>
        <div <?php echo $widget->get_render_attribute_string( 'wrapper' ); ?>>
            <h4 class="cs-widget-title"><?php echo $settings[ $this->get_control_id( 'icon_title' ) ]; ?></h4>
            <ul>
                <?php foreach ( $settings['icon_list'] as $index => $item ) : ?>
                    <?php $migration_allowed = Icons_Manager::is_migration_allowed(); ?>
                    <li><?php
                            $link_key = 'link_' . $index;

                            $widget->add_link_attributes( $link_key, $item['link'] );

                            echo '<a ' . $widget->get_render_attribute_string( 'link_css' ). $widget->get_render_attribute_string( $link_key ) . '>';
                
                        // add old default
                        if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
                            $item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
                        }

                        $migrated = isset( $item['__fa4_migrated']['selected_icon'] );
                        $is_new = ! isset( $item['icon'] ) && $migration_allowed;
                        if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
                            ?>
                            <span class="elementor-icon-list-icon">
                                <?php
                                if ( $is_new || $migrated ) {
                                    Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                } else { ?>
                                        <i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
                                <?php } ?>
                            </span>
                        <?php endif; ?>

                        <?php echo $item['text']; ?>

                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
    }

    public function skin_print_template( $content, $widget ) {
        if( 'icon-list' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }
}