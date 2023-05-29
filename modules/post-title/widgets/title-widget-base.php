<?php
namespace EpicJungleElementor\Modules\PostTitle\Widgets;

use Elementor\Widget_Heading;
use Elementor\Plugin;
use EpicJungleElementor\Base\Base_Widget_Trait;
use EpicJungleElementor\Plugin as EpicJunglePlugin;
use Elementor\Controls_Manager;
use EpicJungleElementor\Core\Controls_Manager AS EJ_Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

abstract class Title_Widget_Base extends Widget_Heading {

	use Base_Widget_Trait;

    abstract protected function get_dynamic_tag_name();

    protected function should_show_page_title() {
        $current_doc = Plugin::instance()->documents->get( get_the_ID() );
        if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
            return false;
        }

        return true;
    }

    protected function register_controls() {
        parent::register_controls();

        $dynamic_tag_name = $this->get_dynamic_tag_name();

        $this->update_control( 'title', [
            'dynamic' => [
                'default' => EpicJunglePlugin::elementor()->dynamic_tags->tag_data_to_tag_text( null, $dynamic_tag_name ),
            ],
        ], [
            'recursive' => true,
        ] );

        $this->update_control( 'size', [
            'label'   => esc_html__( 'Tamanho', 'epicjungle-elementor' ),
            'type'    => EJ_Controls_Manager::FONT_SIZE,
            'default' => 'default',
        ] );
        
        $this->update_control( 'header_size', [
            'default' => 'h1',
        ] );

        $this->update_control(
			'title_color',[
				'selectors' => [
					'{{WRAPPER}} .epicjungle-heading__title' => 'color: {{VALUE}};',
				],
			]
		);
		
        $this->remove_control( 'blend_mode' );

        //$this->remove_control( 'typography_typography' );

        $this->add_control( 'title_css', [
            'label'       => esc_html__( 'CSS adicional', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'description' => esc_html__( 'Classes CSS adicionais separadas por espaço que você gostaria de aplicar ao título', 'epicjungle-elementor' )
        ], [
            'position' => [
                'type' => 'section',
                'at'   => 'end',
                'of'   => 'section_title_style'
            ]
        ] );
    }

    protected function get_html_wrapper_class() {
        return parent::get_html_wrapper_class() . ' elementor-page-title elementor-widget-' . parent::get_name();
    }

    protected function render() {
        if ( $this->should_show_page_title() ) {
            $settings = $this->get_settings_for_display();

            if ( '' === $settings['title'] ) {
                return;
            }

            $this->add_render_attribute( 'title', 'class', 'epicjungle-heading__title' );

            if ( ! empty( $settings['title_css'] ) ) {
                $this->add_render_attribute( 'title', 'class', $settings['title_css'] );
            }

            if ( ! empty( $settings['size'] ) && 'default' !== $settings['size'] ) {
                $this->add_render_attribute( 'title', 'class', $settings['size'] );
            }

            $this->add_inline_editing_attributes( 'title' );

            $title = $settings['title'];

            if ( ! empty( $settings['link']['url'] ) ) {
                $this->add_link_attributes( 'url', $settings['link'] );

                $title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $title );
            }

            $title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'title' ), $title );

            echo $title_html;
        }
    }
}

