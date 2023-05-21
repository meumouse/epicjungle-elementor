<?php
namespace EpicJungleElementor;

use EpicJungleElementor\Core\Modules_Manager;
use EpicJungleElementor\Core\Controls_Manager;
use EpicJungleElementor\Core\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Main class plugin
 */
class Plugin {

    /**
     * @var Plugin
     */
    private static $_instance;

    /**
     * @var Modules_Manager
     */
    public $modules_manager;

    public $controls_manager;

    private static $classes_aliases;

    public static function get_classes_aliases() {
        if ( ! self::$classes_aliases ) {
            return self::init_classes_aliases();
        }

        return self::$classes_aliases;
    }

    private static function init_classes_aliases() {
        $classes_aliases = [
            'EpicJungleElementor\Modules\PanelPostsControl\Module' => 'EpicJungleElementor\Modules\QueryControl\Module',
            'EpicJungleElementor\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'EpicJungleElementor\Modules\QueryControl\Controls\Group_Control_Posts',
            'EpicJungleElementor\Modules\PanelPostsControl\Controls\Query' => 'EpicJungleElementor\Modules\QueryControl\Controls\Query',
        ];

        return $classes_aliases;
    }

    /**
     * Throw error on object clone
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @since 1.0.0
     * @return void
     */
    public function __clone() {
        // Cloning instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, __( 'Something went wrong.', 'epicjungle-elementor' ), '1.0.0' );
    }

    /**
     * Disable unserializing of the class
     *
     * @since 1.0.0
     * @return void
     */
    public function __wakeup() {
        // Unserializing instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, __( 'Something went wrong.', 'epicjungle-elementor' ), '1.0.0' );
    }

    /**
     * @return \Elementor\Plugin
     */

    public static function elementor() {
        return \Elementor\Plugin::$instance;
    }

    /**
     * @return Plugin
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private static function normalize_class_name( $string, $delimiter = ' ' ) {
        return str_replace( ' ', $delimiter, ucwords( str_replace( $delimiter, ' ', $string ) ) );
    }

    public function autoload( $class ) {
        if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
            return;
        }

        $classes_aliases = self::get_classes_aliases();

        $has_class_alias = isset( $classes_aliases[ $class ] );

        // Backward Compatibility: Save old class name for set an alias after the new class is loaded
        if ( $has_class_alias ) {
            $class_alias_name = $classes_aliases[ $class ];
            $class_to_load = $class_alias_name;
        } else {
            $class_to_load = $class;
        }

        if ( ! class_exists( $class_to_load ) ) {
            $filename = strtolower(
                preg_replace(
                    [ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
                    [ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
                    $class_to_load
                )
            );
            $filename = EPICJUNGLE_ELEMENTOR_PATH . $filename . '.php';
            $filename = str_replace( 'controls' . DIRECTORY_SEPARATOR . 'control-', 'controls' . DIRECTORY_SEPARATOR, $filename );
            $filename = str_replace( 'groups' . DIRECTORY_SEPARATOR . 'group-control-', 'groups' . DIRECTORY_SEPARATOR, $filename );

            if ( is_readable( $filename ) ) {
                include( $filename );
            }
        }

        if ( $has_class_alias && class_exists( $class_alias_name ) ) {
            class_alias( $class_alias_name, $class );
        }
    }

    public function on_elementor_init() {

        $this->setup_elementor();

        $this->modules_manager  = new Modules_Manager();
        $this->controls_manager = new Controls_Manager();
        $this->icons_manager    = new Icons_Manager();
        /**
         * Elementor Pro init.
         *
         * Fires on Elementor Pro init, after Elementor has finished loading but
         * before any headers are sent.
         *
         * @since 1.0.0
         */
        do_action( 'epicjungle_elementor/init' );
    }

    public static function get_size_class_options() {
        
    }

    private function setup_hooks() {
        add_action( 'elementor/init', [ $this, 'on_elementor_init' ] );
    }

    public function setup_elementor() {

        if ( is_admin() && ( apply_filters( 'epicjungle_force_setup_elementor', false ) || get_option( 'epicjungle_setup_elementor' ) != 'completed' ) ) {
            
            update_option( 'elementor_disable_color_schemes', 'yes' );
            update_option( 'elementor_disable_typography_schemes', 'yes' );
            update_option( 'elementor_optimized_dom_output', 'enabled' );
            update_option( 'elementor_unfiltered_files_upload', '1' );
            update_option( 'elementor_cpt_support', [ 'post', 'page', 'mas_static_content', 'jetpack-portfolio', 'docs', 'job_listing' ] );

            \Elementor\Plugin::$instance->experiments->set_feature_default_state( 'e_dom_optimization', 'active' );

            //Get default/active kit
            $active_kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();

            //Get and store current active kit settings in an array variable 'settings' 
            $kit_data['settings'] = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings();

            if ( function_exists( 'epicjungle_default_colors' ) && $default_colors = epicjungle_default_colors() ) {
                $kit_data['settings']['system_colors'] = $default_colors;
            }

            // Save active kit new settings
            $active_kit->save( $kit_data );

            update_option( 'epicjungle_setup_elementor', 'completed' );
        }
    }

    /**
     * Plugin constructor.
     */
    private function __construct() {
        spl_autoload_register( [ $this, 'autoload' ] );

        $this->setup_hooks();

        //require_once get_template_directory() . '/inc/classes/class-wp-bootstrap-navwalker.php';

        //Load templates file
        //require_once ( EPICJUNGLE_ELEMENTOR_TEMPLATES_PATH . 'templates.php' );

    }

    final public static function get_title() {
        return esc_html__( 'EpicJungle Elementor', 'epicjungle-elementor' );
    }
}

Plugin::instance();