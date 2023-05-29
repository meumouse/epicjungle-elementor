<?php
namespace EpicJungleElementor\Modules\NavMenu\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use EpicJungleElementor\Base\Base_Widget;
use Elementor\Group_Control_Image_Size;
use EpicJungleElementor\Core\Utils as EJ_Utils;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Responsive\Responsive;
use EpicJungleElementor\Plugin;
use EpicJungleElementor\Modules\NavMenu\Classes;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Header_Nav extends Skin_Base {

    protected $nav_menu_index = 1;

    private $files_upload_handler = false;

    public function get_id() {
        return 'header_nav';
    }

    public function get_title() {
        return esc_html__( 'Navegação do cabeçalho', 'epicjungle-elementor' );
    }

    public function get_script_depends() {
        return [ 'smartmenus' ];
    }

    public function on_export( $element ) {
        unset( $element['settings']['menu'] );

        return $element;
    }

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
    }

    public function render() {
        $available_menus = $this->get_available_menus();

        if ( ! $available_menus ) {
            return;
        }

        $settings = $this->parent->get_active_settings();


        $anchor_class = [
            $settings['anchor_class'],
        ];

        $item_class = [
            'nav-item ',
            $settings['menu_item_css_class'],
        ];

        $icon_class = [
            'list-social-icon',
            $settings['icon_class'],
        ];

        $args = [
            'echo'          => false,
            'menu'          => $settings['menu'],
            'menu_class'    => 'ej-elementor-nav-menu navbar-nav ',
            'menu_id'       => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'fallback_cb'   => '__return_empty_string',
            'container'     => '',
            'item_class'     => $item_class,
            'anchor_class'   => $anchor_class,
            'icon_class'     => $icon_class,

        ];

        if ( ! empty( $settings['menu_css_class'] ) ) {
            $args['menu_class'] .= $settings['menu_css_class'];
        }

        if ( class_exists( 'WP_Bootstrap_Navwalker' ) ) {
            $args['walker'] = new \WP_Bootstrap_Navwalker();
        }

        // Add custom filter to handle Nav Menu HTML output.
        add_filter( 'nav_menu_item_id', '__return_empty_string' );
        add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
        
        // General Menu.
        $menu_html = wp_nav_menu( $args );

        // Remove all our custom filters.
        remove_filter( 'nav_menu_item_id', '__return_empty_string' );
        remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ] );

        if ( empty( $menu_html ) ) {
            return;
        }

        $this->parent->add_render_attribute( 'main-menu', 'role', 'navigation' );

        $this->parent->add_render_attribute( 'main-menu', 'class', [
            'ej-elementor-nav-menu--main',
            'ej-elementor-nav-menu__container',
        ] );
        ?>
        <nav <?php echo $this->parent->get_render_attribute_string( 'main-menu' ); ?>><?php echo $menu_html; ?></nav>
        <?php
    }

     public function handle_link_classes( $atts, $item, $args, $depth ) {
        $classes ='elementor-item';

        if ( empty( $atts['class'] ) ) {
            $atts['class'] = $classes;
        } else {
            $atts['class'] .= ' ' . $classes;
        }

        return $atts;
    }

    public function render_plain_content() {}
}