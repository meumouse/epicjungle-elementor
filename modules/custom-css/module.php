<?php
namespace EpicJungleElementor\Modules\CustomCss;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Core\DynamicTags\Dynamic_CSS;
use Elementor\Core\Files\CSS\Post;
use Elementor\Element_Base;
use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public static function is_active() {
        return ! class_exists( 'ElementorPro\Plugin');
    }

    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function get_name() {
        return 'ej-custom-css';
    }

    /**
     * @param $element    Controls_Stack
     * @param $section_id string
     */
    public function register_controls( Controls_Stack $element, $section_id ) {
        // Remove Custom CSS Banner (From free version)
        if ( 'section_custom_css_pro' !== $section_id ) {
            return;
        }

        $this->replace_go_pro_custom_css_controls( $element );
    }

    /**
     * @param $post_css Post
     * @param $element  Element_Base
     */
    public function add_post_css( $post_css, $element ) {
        if ( $post_css instanceof Dynamic_CSS ) {
            return;
        }

        $element_settings = $element->get_settings();

        if ( empty( $element_settings['custom_css'] ) ) {
            return;
        }

        $css = trim( $element_settings['custom_css'] );

        if ( empty( $css ) ) {
            return;
        }
        $css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

        // Add a css comment
        $css = sprintf( '/* Start custom CSS for %s, class: %s */', $element->get_name(), $element->get_unique_selector() ) . $css . '/* End custom CSS */';

        $post_css->get_stylesheet()->add_raw_css( $css );
    }

    /**
     * @param $post_css Post
     */
    public function add_page_settings_css( $post_css ) {
        $document = Plugin::elementor()->documents->get( $post_css->get_post_id() );
        $custom_css = $document->get_settings( 'custom_css' );

        $custom_css = trim( $custom_css );

        if ( empty( $custom_css ) ) {
            return;
        }

        $custom_css = str_replace( 'selector', $document->get_css_wrapper_selector(), $custom_css );

        // Add a css comment
        $custom_css = '/* Start custom CSS */' . $custom_css . '/* End custom CSS */';

        $post_css->get_stylesheet()->add_raw_css( $custom_css );
    }

    /**
     * @param Controls_Stack $controls_stack
     */
    public function replace_go_pro_custom_css_controls( $controls_stack ) {
        $old_section = Plugin::elementor()->controls_manager->get_control_from_stack( $controls_stack->get_unique_name(), 'section_custom_css_pro' );

        Plugin::elementor()->controls_manager->remove_control_from_stack( $controls_stack->get_unique_name(), [ 'section_custom_css_pro', 'custom_css_pro' ] );

        $controls_stack->start_controls_section(
            'section_custom_css',
            [
                'label' => __( 'CSS personalizado', 'epicjungle-elementor' ),
                'tab' => $old_section['tab'],
            ]
        );

        $controls_stack->add_control(
            'custom_css_title',
            [
                'raw' => __( 'Adicione seu próprio CSS personalizado aqui', 'epicjungle-elementor' ),
                'type' => Controls_Manager::RAW_HTML,
            ]
        );

        $controls_stack->add_control(
            'custom_css',
            [
                'type' => Controls_Manager::CODE,
                'label' => __( 'CSS personalizado', 'epicjungle-elementor' ),
                'language' => 'css',
                'render_type' => 'ui',
                'show_label' => false,
                'separator' => 'none',
            ]
        );

        $controls_stack->add_control(
            'custom_css_description',
            [
                'raw' => __( 'Use "selector" para direcionar o elemento wrapper. Exemplos:<br>selector {color: red;} // Para elemento principal<br>selector .child-element {margin: 10px;} // Para elemento filho<br>.minha-classe {text-align: center; } // Ou use qualquer seletor personalizado', 'epicjungle-elementor' ),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $controls_stack->end_controls_section();
    }

    public function localize_settings( array $settings ) {
        $settings['i18n']['custom_css'] = __( 'CSS personalizado', 'epicjungle-elementor' );

        return $settings;
    }

    protected function add_actions() {

        add_action( 'elementor/element/after_section_end', [ $this, 'register_controls' ], 10, 2 );
        add_action( 'elementor/element/parse_css', [ $this, 'add_post_css' ], 10, 2 );
        add_action( 'elementor/css-file/post/parse', [ $this, 'add_page_settings_css' ] );
        add_filter( 'epicjungle_elementor/editor/localize_settings', [ $this, 'localize_settings' ] );
    }
}
