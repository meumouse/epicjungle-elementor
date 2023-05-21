<?php
namespace EpicJungleElementor\Base;

use EpicJungleElementor;
use Elementor\Core\Base\Module;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

abstract class Module_Base extends Module {

    public function get_widgets() {
        return [];
    }

    public function __construct() {
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_widget_categories' ] );
    }

    public function init_widgets() {
        $widget_manager = EpicJungleElementor\Plugin::elementor()->widgets_manager;

        foreach ( $this->get_widgets() as $widget ) {

            $class_name = $this->get_reflection()->getNamespaceName() . '\Widgets\\' . $widget;

            $widget_manager->register_widget_type( new $class_name() );
        }
    }

    /**
     * Widget Category Register
     *
     * @since  1.0.0
     * @access public
     */
    public function add_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'epicjungle',
            [
                'title' => esc_html__( 'EpicJungle', 'epicjungle-elementor' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }
}
