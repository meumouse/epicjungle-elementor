<?php

namespace EpicJungleElementor\Modules\IconBox;

use EpicJungleElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;
use EpicJungleElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();

        $this->add_actions();
    }

    public function get_name() {
        return 'override-icon-box';
    }

    public function add_actions() {
        add_action( 'elementor/element/icon-box/section_style_icon/before_section_end', [ $this, 'register_style_icon_controls' ] );
        add_action( 'elementor/element/icon-box/section_style_content/before_section_end', [ $this, 'register_style_content_controls' ], 10 );
        add_filter( 'epicjungle-elementor/widget/icon-box/render_content', [ $this, 'render_content' ], 10, 2 );
        add_filter( 'epicjungle-elementor/widget/icon-box/print_template', [ $this, 'print_template' ], 10 );
    }

    public function register_style_icon_controls( $widget ) {
        $widget->add_control(
            'icon_css', [
                'label'       => esc_html__( 'Classe CSS da imagem', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description' => esc_html__( 'Aplicado ao wrapper de ícone', 'epicjungle-elementor' ),
                'classes'     => 'elementor-control-direction-ltr',
            ]
        );
    }

    public function register_style_content_controls( $widget ) {
        $widget->add_control( 'wrap_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Aplicado ao wrapper da caixa de ícone', 'epicjungle-elementor' ),
            'classes'     => 'elementor-control-direction-ltr',
        ], [
            'position' => [
                'at' => 'after',
                'of' => 'content_vertical_alignment',
            ]
        ] );

        $widget->add_control( 'title_css', [
            'label'       => esc_html__( 'Classes CSS do título', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Aplicado ao wrapper do título', 'epicjungle-elementor' ),
            'classes'     => 'elementor-control-direction-ltr',
        ], [
            'position' => [
                'at' => 'before',
                'of' => 'heading_description',
            ]
        ] );

        $widget->add_control( 'description_css', [
            'label'       => esc_html__( 'Classe CSS da descrição', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Aplicado ao wrapper de descrição', 'epicjungle-elementor' ),
            'classes'     => 'elementor-control-direction-ltr',
        ] );

        $widget->add_control( 'link_css', [
            'label'       => esc_html__( 'Classe CSS do link', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Aplicado ao wrapper de link', 'epicjungle-elementor' ),
        ] );
    }

    public function render_content( $content, $widget ) {
        $settings = $widget->get_settings_for_display();

        $icon_tag = 'span';

        if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['icon'] = 'fa fa-star';
        }

        $has_icon = ! empty( $settings['icon'] );

        if ( ! empty( $settings['link']['url'] ) ) {
            $icon_tag = 'a';
            $widget->add_render_attribute( 'link', 'class', [ 'stretched-link', 'text-decoration-none' ] );
        }

        if ( ! empty( $settings['icon_css'] ) ) {
            $widget->add_render_attribute( 'icon', 'class', $settings['icon_css'] );
        }

        if ( ! empty( $settings['link_css'] ) ) {
            $widget->add_render_attribute( 'link', 'class', $settings['link_css'] );
        }

        $icon_attributes = $widget->get_render_attribute_string( 'icon' );
        $link_attributes = $widget->get_render_attribute_string( 'link' );

        if ( ! empty( $settings['description_css'] ) ) {
            $widget->add_render_attribute( 'description_text', 'class', $settings['description_css'] );            
        }

        Plugin::instance()->modules_manager->add_inline_editing_attributes( $widget, 'title_text', 'none' );
        Plugin::instance()->modules_manager->add_inline_editing_attributes( $widget, 'description_text', 'none' );
       
        if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
            $has_icon = true;
        }
        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        $widget->add_render_attribute( 'title', 'class', 'elementor-icon-box-title' );

        if ( ! empty( $settings['title_css'] ) ) {
            $widget->add_render_attribute( 'title', 'class', $settings['title_css'] );            
        }

        $widget->add_render_attribute( 'wrapper', 'class', 'elementor-icon-box-wrapper' );

        if ( ! empty( $settings['wrap_css'] ) ) {
            $widget->add_render_attribute( 'wrapper', 'class', $settings['wrap_css'] );            
        }

        ob_start();
        ?>
        <div <?php echo $widget->get_render_attribute_string( 'wrapper' ); ?>>
            <?php if ( $has_icon ) : ?>
            <div class="elementor-icon-box-icon">
                <<?php echo implode( ' ', [ 'span', $icon_attributes ] ); ?>>
                <?php
                if ( $is_new || $migrated ) {
                    Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                } elseif ( ! empty( $settings['icon'] ) ) {
                    ?><i <?php echo $widget->get_render_attribute_string( 'i' ); ?>></i><?php
                }
                ?>
                </<?php echo 'span'; ?>>
            </div>
            <?php endif; ?>
            <div class="elementor-icon-box-content">
                <<?php echo $settings['title_size']; ?> <?php echo $widget->get_render_attribute_string( 'title' ); ?>>
                    <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $widget->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
                </<?php echo $settings['title_size']; ?>>
                <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                <p <?php echo $widget->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php
        $content = ob_get_clean();
        return $content;
    }

    public function print_template( $content ) {
        ob_start();
        $this->content_template( $content );
        return ob_get_clean();
    }

    public function content_template( $content ) {
        ?>
        <#
        var link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
            iconTag = link ? 'a' : 'span',
            iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
            migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );

        view.addRenderAttribute( 'description_text', 'class', 'elementor-icon-box-description' );

        if ( '' != settings.description_css ) {
            view.addRenderAttribute( 'description_text', 'class', settings.description_css );            
        }

        view.addInlineEditingAttributes( 'title_text', 'none' );
        view.addInlineEditingAttributes( 'description_text', 'none' );

        view.addRenderAttribute( 'title', 'class', 'elementor-icon-box-title' );
        if ( '' != settings.title_css ) {
            view.addRenderAttribute( 'title', 'class', settings.title_css );            
        }

        view.addRenderAttribute( 'icon', 'class', [
            'elementor-icon', 'elementor-animation-' + settings.hover_animation
        ] );

        if ( '' != settings.icon_css ) {
            view.addRenderAttribute( 'icon', 'class', settings.icon_css );            
        }

        view.addRenderAttribute( 'wrapper', 'class', 'elementor-icon-box-wrapper' );

        if ( '' != settings.wrap_css ) {
            view.addRenderAttribute( 'wrapper', 'class', settings.wrap_css );
        }
        #>
        <div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
            <# if ( settings.icon || settings.selected_icon ) { #>
            <div class="elementor-icon-box-icon">
                <{{{ iconTag + ' ' + link }}} {{{ view.getRenderAttributeString( 'icon' ) }}}>
                    <# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
                        {{{ iconHTML.value }}}
                        <# } else { #>
                            <i class="{{ settings.icon }}" aria-hidden="true"></i>
                        <# } #>
                </{{{ iconTag }}}>
            </div>
            <# } #>
            <div class="elementor-icon-box-content">
                <{{{ settings.title_size }}} {{{ view.getRenderAttributeString( 'title' ) }}}>
                    <{{{ iconTag + ' ' + link }}} {{{ view.getRenderAttributeString( 'title_text' ) }}}>{{{ settings.title_text }}}</{{{ iconTag }}}>
                </{{{ settings.title_size }}}>
                <# if ( settings.description_text ) { #>
                <p {{{ view.getRenderAttributeString( 'description_text' ) }}}>{{{ settings.description_text }}}</p>
                <# } #>
            </div>
        </div>
           <?php
    }
}