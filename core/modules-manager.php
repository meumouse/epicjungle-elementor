<?php
namespace EpicJungleElementor\Core;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

final class Modules_Manager {
    /**
     * @var Module_Base[]
     */
    private $modules = [];

    public function __construct() {
        $modules = [
            'accordion',
            'basic-gallery',
            'brands',
            'breadcrumb',
            'button',
            'cards-carousel',
            'carousel',
            'column',
        //    'countdown',
            'custom-attributes',
            'custom-css',
        //    'dividers',
            'docs',
            'dynamic-tags',
            'heading',
            'highlighted-heading',
            'hotspots',
            'icon-box',
            'icon-list',
            'image',
            'image-box',
            'image-carousel',
            'image-grid',
            'login',
        //    'map',
            'market-button',
            'nav-menu',
            'page-settings',
        //    'parallax',
            'post-info',
            'post-title',
            'posts',
            'pricing',
            'query-control',
            'search',
            'section',
            'shapes',
            'share-buttons',
            'sidebar',
            'social-icons',
            'tabs',
        //    'team-member',
            'text-editor',
            'video',
            'woocommerce',
        ];

        foreach ( $modules as $module_name ) {
            $class_name = str_replace( '-', ' ', $module_name );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = '\EpicJungleElementor\Modules\\' . $class_name . '\Module';

            /** @var Module_Base $class_name */
            if ( $class_name::is_active() ) {
                $this->modules[ $module_name ] = $class_name::instance();
            }
        }

        $this->init_actions();
    }

    public function init_actions() {
        add_action( 'elementor/widget/before_render_content', [ $this, 'before_render_content' ], 10 );
        add_action( 'elementor/widget/render_content', [ $this, 'render_content' ], 10, 2 );
        add_filter( 'elementor/widget/print_template', array( $this, 'print_template' ), 10, 2 );
    }

    public function before_render_content( $widget ) {
        $widget_name = $widget->get_name();
        do_action( "epicjungle-elementor/widget/{$widget_name}/before_render_content", $widget );
    }

    public function render_content( $content, $widget ) {
        $widget_name = $widget->get_name();
        $content = apply_filters( "epicjungle-elementor/widget/{$widget_name}/render_content", $content, $widget );
        return $content;
    }

    public function print_template( $content, $widget ) {
        $widget_name = $widget->get_name();
        $content = apply_filters( "epicjungle-elementor/widget/{$widget_name}/print_template", $content, $widget );
        return $content;
    }

    /**
     * @param string $module_name
     *
     * @return Module_Base|Module_Base[]
     */
    public function get_modules( $module_name ) {
        if ( $module_name ) {
            if ( isset( $this->modules[ $module_name ] ) ) {
                return $this->modules[ $module_name ];
            }

            return null;
        }

        return $this->modules;
    }

    /**
     * Get repeater setting key.
     *
     * Retrieve the unique setting key for the current repeater item. Used to connect the current element in the
     * repeater to it's settings model and it's control in the panel.
     *
     * PHP usage (inside `Widget_Base::render()` method):
     *
     *    $tabs = $this->get_settings( 'tabs' );
     *    foreach ( $tabs as $index => $item ) {
     *        $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
     *        $this->add_inline_editing_attributes( $tab_title_setting_key, 'none' );
     *        echo '<div ' . $this->get_render_attribute_string( $tab_title_setting_key ) . '>' . $item['tab_title'] . '</div>';
     *    }
     *
     * @since 1.8.0
     * @access protected
     *
     * @param string $setting_key      The current setting key inside the repeater item (e.g. `tab_title`).
     * @param string $repeater_key     The repeater key containing the array of all the items in the repeater (e.g. `tabs`).
     * @param int $repeater_item_index The current item index in the repeater array (e.g. `3`).
     *
     * @return string The repeater setting key (e.g. `tabs.3.tab_title`).
     */
    public function get_repeater_setting_key( $setting_key, $repeater_key, $repeater_item_index ) {
        return implode( '.', [ $repeater_key, $repeater_item_index, $setting_key ] );
    }

    /**
     * Add inline editing attributes.
     *
     * Define specific area in the element to be editable inline. The element can have several areas, with this method
     * you can set the area inside the element that can be edited inline. You can also define the type of toolbar the
     * user will see, whether it will be a basic toolbar or an advanced one.
     *
     * Note: When you use wysiwyg control use the advanced toolbar, with textarea control use the basic toolbar. Text
     * control should not have toolbar.
     *
     * PHP usage (inside `Widget_Base::render()` method):
     *
     *    $this->add_inline_editing_attributes( 'text', 'advanced' );
     *    echo '<div ' . $this->get_render_attribute_string( 'text' ) . '>' . $this->get_settings( 'text' ) . '</div>';
     *
     * @since 1.8.0
     * @access protected
     *
     * @param string $key     Element key.
     * @param string $toolbar Optional. Toolbar type. Accepted values are `advanced`, `basic` or `none`. Default is
     *                        `basic`.
     */
   

    public function add_inline_editing_attributes( $widget, $key, $toolbar = 'basic' ) {
        if ( ! Plugin::elementor()->editor->is_edit_mode() ) {
            return;
        }

        $widget->add_render_attribute( $key, [
            'class' => 'elementor-inline-editing',
            'data-elementor-setting-key' => $key,
        ] );

        if ( 'basic' !== $toolbar ) {
            $widget->add_render_attribute( $key, [
                'data-elementor-inline-editing-toolbar' => $toolbar,
            ] );
        }
    }
}