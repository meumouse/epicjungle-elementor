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


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Footer_Icons extends Skin_Base {

    protected $nav_menu_index = 1;

    private $files_upload_handler = false;

    public function get_id() {
        return 'footer_icons';
    }

    public function get_title() {
        return esc_html__( 'Ícones de rodapé', 'epicjungle-elementor' );
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
            'social-btn ',
            'yes' === $settings['sb-light'] ? 'sb-light ': '',
            'yes' === $settings['sb-outline'] ? 'sb-outline ' : '',
            $settings['anchor_class'],
        ];

        $item_class = [
            'mr-2 mb-2',
            $settings['menu_item_css_class'],
        ];

        $icon_class = [
            'list-social-icon',
            $settings['icon_class'],
        ];

        $args = [
            'echo'          => false,
            'menu'          => $settings['menu'],
            'menu_class'    => 'ej-elementor-nav-menu list-unstyled d-flex pt-2 pt-sm-0 ',
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

        // General Menu.
        $menu_html = wp_nav_menu( $args );

        // Dropdown Menu.
        $args['menu_id'] = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();
        $dropdown_menu_html = wp_nav_menu( $args );

        // Remove all our custom filters.
        remove_filter( 'nav_menu_item_id', '__return_empty_string' );

        if ( empty( $menu_html ) ) {
            return;
        }

        $this->parent->add_render_attribute( 'menu-toggle', [
            'class' => 'elementor-menu-toggle',
            'role' => 'button',
            'tabindex' => '0',
            'aria-label' => __( 'Menu alternar', 'epicjungle-elementor' ),
            'aria-expanded' => 'false',
        ] );

        if ( Plugin::elementor()->editor->is_edit_mode() ) {
            $this->parent->add_render_attribute( 'menu-toggle', [
                'class' => 'elementor-clickable',
            ] );
        }

        $this->parent->add_render_attribute( 'main-menu', 'role', 'navigation' );

        $this->parent->add_render_attribute( 'main-menu', 'class', [
            'ej-elementor-nav-menu--main',
            'elementor-nav-menu__container',
            'elementor-nav-menu--layout-horizontal',
        ] );
        ?>
        <nav <?php echo $this->parent->get_render_attribute_string( 'main-menu' ); ?>><?php echo $menu_html; ?></nav>
        <?php
    }

    public function render_plain_content() {}
}
