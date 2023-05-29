<?php
namespace EpicJungleElementor\Modules\HighlightedHeading\Widgets;

use EpicJungleElementor\Base\Base_Widget;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use EpicJungleElementor\Plugin;
use EpicJungleElementor\Core\Controls_Manager AS EJ_Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class Highlighted_Heading
 */
class Highlighted_Heading extends Base_Widget {

    public function get_name() {
        return 'highlighted-heading';
    }

    public function get_title() {
        return esc_html__( 'Título destacado', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-site-title';
    }

    public function get_categories() {
        return [ 'epicjungle' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_title', [
                'label' => esc_html__( 'Título', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'before_title', [
                'label'       => esc_html__( 'Antes do texto destacado', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'Digite seu título', 'epicjungle-elementor' ),
                'default'     => 'Bem-vindo ao ',
                'description' => esc_html__( 'Use <br> para quebrar em duas linhas', 'epicjungle-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'highlighted_text', [
                'label'       => esc_html__( 'Texto destacado', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'after_title', [
                'label'       => esc_html__( 'Após o texto destacado', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => '',
                'placeholder' => esc_html__( 'Digite seu título', 'epicjungle-elementor' ),
                'description' => esc_html__( 'Use <br> para quebrar em duas linhas', 'epicjungle-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link', [
                'label'     => esc_html__( 'Link', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [
                    'active' => true,
                ],
                'default'   => [
                    'url' => '',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'size', [
                'label'   => esc_html__( 'Tamanho', 'epicjungle-elementor' ),
                'type'    => EJ_Controls_Manager::FONT_SIZE,
                'default' => '',
            ]
        );

        $this->add_control(
            'header_size', [
                'label'   => esc_html__( 'Tag HTML', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
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
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label' => esc_html__( 'Alinhamento', 'epicjungle-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Centro', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Direita', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justificado', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_highlighted_style', [
                'label' => esc_html__( 'Título', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color', [
                'label'     => esc_html__( 'Cor do título', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .epicjungle-elementor-highlighted-heading__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .epicjungle-elementor-highlighted-heading__title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_control(
            'title_css', [
                'label'       => esc_html__( 'CSS adicional', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'h1 mb-0',
                'description' => esc_html__( 'Classes CSS adicionais separadas por espaço que você gostaria de aplicar ao título', 'epicjungle-elementor' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style', [
                'label' => esc_html__( 'Texto destacado', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'highlight_color', [
                'label'     => esc_html__( 'Cor de destaque', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .epicjungle-elementor-highlighted-heading__highlighted-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'highlighted_typography',
                'selector' => '{{WRAPPER}} .epicjungle-elementor-highlighted-heading__highlighted-text',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_control(
            'highlighted_css', [
                'label'       => esc_html__( 'CSS destacado', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'bg-faded-primary rounded text-primary px-3 py-2',
                'description' => esc_html__( 'Classes CSS adicionais separadas por espaço que você gostaria de aplicar ao texto destacado', 'epicjungle-elementor' )
            ]
        );

        $this->end_controls_section();

         $this->start_controls_section(
            'section_parallax_style', [
                'label' => esc_html__( 'Parallax', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'parallax_css', [
                'label'       => esc_html__( 'CSS Parallax', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'Classes CSS adicionais separadas por espaço que você gostaria de aplicar ao texto destacado', 'epicjungle-elementor' )
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( '' === $settings['highlighted_text'] && '' === $settings['before_title'] ) {
            return;
        }

        $this->add_render_attribute( 'title', 'class', 'epicjungle-elementor-highlighted-heading__title' );

        if ( ! empty( $settings['size'] ) && 'default' !== $settings['size'] ) {
            $this->add_render_attribute( 'title', 'class', $settings['size'] );
        }

        if ( ! empty( $settings['title_css'] ) ) {
            $this->add_render_attribute( 'title', 'class', $settings['title_css'] );
        }

        $this->add_render_attribute( 'highlight', 'class', 'epicjungle-elementor-highlighted-heading__highlighted-text' );

        if ( ! empty( $settings['highlighted_css'] ) ) {
            $this->add_render_attribute( 'highlight', 'class', $settings['highlighted_css'] );            
        }

        if ( ! empty( $settings['highlighted_text'] ) ) {
            $highlighted_text = '<span ' . $this->get_render_attribute_string( 'highlight' ) . '>' . $settings['highlighted_text'] .'</span>';
        } else {
            $highlighted_text = '';
        }

        $title = $settings['before_title'] . $highlighted_text . $settings['after_title'];

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_link_attributes( 'url', $settings['link'] );
            $this->add_render_attribute( 'url', 'class', [ 'text-reset', 'text-decoration-none' ] );

            $title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $title );
        }

        $title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'title' ), $title );

        echo $title_html;
    }

    protected function content_template() {
        ?>
        <#
        view.addRenderAttribute( 'highlight', 'class', 'epicjungle-elementor-highlighted-heading__highlighted-text');

        if ( '' !== settings.highlighted_css ) {
            view.addRenderAttribute( 'highlight', 'class', settings.highlighted_css );
        }

        var title = settings.before_title + '<span ' + view.getRenderAttributeString( 'highlight' ) + '>' + settings.highlighted_text + '</span>' + settings.after_title;

        if ( '' !== settings.link.url ) {
            title = '<a href="' + settings.link.url + '">' + title + '</a>';
        }

        view.addRenderAttribute( 'title', 'class', [ 'epicjungle-elementor-highlighted-heading__title', settings.size ] );

        if ( '' !== settings.title_css ) {
            view.addRenderAttribute( 'title', 'class', settings.title_css );
        }

        var title_html = '<' + settings.header_size  + ' ' + view.getRenderAttributeString( 'title' ) + '>' + title + '</' + settings.header_size + '>';

        print( title_html );
        #>
        <?php
    }
}