<?php
namespace EpicJungleElementor\Modules\Woocommerce;

use Elementor\Core\Documents_Manager;
use Elementor\Settings;
use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Module extends Module_Base {

    const WOOCOMMERCE_GROUP = 'woocommerce';

    public static function is_active() {
        return class_exists( 'woocommerce' );
    }

    public function get_name() {
        return 'ej-woocommerce';
    }

    public function get_widgets() {
        return [
            'Products',
        ];
    }

    public function add_product_post_class( $classes ) {
        $classes[] = 'product';

        return $classes;
    }

    public function add_products_post_class_filter() {
        add_filter( 'post_class', [ $this, 'add_product_post_class' ] );
    }

    public function remove_products_post_class_filter() {
        remove_filter( 'post_class', [ $this, 'add_product_post_class' ] );
    }

    public function register_wc_hooks() {
        wc()->frontend_includes();
    }

    public function __construct() {
        parent::__construct();

        // On Editor - Register WooCommerce frontend hooks before the Editor init.
        // Priority = 5, in order to allow plugins remove/add their wc hooks on init.
        if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
            add_action( 'init', [ $this, 'register_wc_hooks' ], 5 );
        }

        $this->add_actions();
    }

    public function add_actions() {
        add_action( 'elementor/widget/ej-woocommerce-products/skins_init', [ $this, 'init_skins' ], 10 );  
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Widget_Product_Media( $widget ) );
    }
}