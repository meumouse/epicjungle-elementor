<?php

namespace EpicJungleElementor\Templates\Classes;

use EpicJungleElementor\Templates;

if( ! defined( 'ABSPATH' ) ) exit; // No access of directly access

if( ! class_exists('Premium_Templates_Assets') ) {

    /**
     * Premium Templates Assets.
     *
     * Premium Templates Assets class is responsible for enqueuing all required assets for integration templates on the editor page.
     *
     * @since 3.6.0
     * 
     */
    class Premium_Templates_Assets {
        
        /*
         * Instance of the class
         * 
         * @since 3.6.0
         * @access private
         */
        private static $instance = null;

        /**
        * Premium_Templates_Assets constructor.
        *
        * Triggers the required hooks to enqueue CSS/JS files.
        *
        * @since 3.6.0
        * @access public
         * 
        */
        public function __construct() {

            add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_preview_styles' ) );

            add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

            add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ), 0 );

            add_action( 'elementor/editor/footer', array( $this, 'load_footer_scripts') );

        }

        /**
         * Preview Styles
         * 
         * Enqueue required templates CSS file.
         * 
         * @since 3.6.0
         * @access public
         */
        public function enqueue_preview_styles() {
            
            $is_rtl = is_rtl() ? '-rtl' : '';
            
            wp_enqueue_style(
                'epicjungle-elementor-templates-editor-preview-style',
                EPICJUNGLE_ELEMENTOR_ASSETS_URL . '/templates/css/preview' . $is_rtl . '.css', 
                array(),
                EPICJUNGLE_ELEMENTOR_VERSION,
                'all'
            );
            
        }

        /**
         * Editor Styles
         * 
         * Enqueue required editor CSS files.
         * 
         * @since 3.6.0
         * @access public
         * 
         */
        public function editor_styles() {
            
            $is_rtl = is_rtl() ? '-rtl' : '';
            
            wp_enqueue_style(
                'epicjungle-elementor-templates-editor-style',
                EPICJUNGLE_ELEMENTOR_ASSETS_URL . '/templates/css/editor' . $is_rtl . '.css',
                array(),
                EPICJUNGLE_ELEMENTOR_VERSION,
                'all'
            );
            
        }
        
        /**
         * Editor Scripts
         * 
         * Enqueue required editor JS files, localize JS with required data.
         * 
         * @since 3.6.0
         * @access public
         */
        public function editor_scripts() {

            wp_enqueue_script(
                'epicjungle-elementor-templates-editor',
                EPICJUNGLE_ELEMENTOR_ASSETS_URL . '/templates/js/editor.js',
                array(
                    'jquery',
                    'underscore',
                    'backbone-marionette'
                ),
                EPICJUNGLE_ELEMENTOR_VERSION,
                true
            );

            wp_localize_script( 'epicjungle-elementor-templates-editor', 'LkPremiumTempsData', apply_filters(
               'epicjungle_elementor_templates_editor_localize',
                array(
                    'Elementor_Version'     => ELEMENTOR_VERSION,
                    //'PremiumTemplatesBtn'   => Templates\premium_templates()->config->get('premium_temps'),
                    'modalRegions'          => $this->get_modal_region(),
                    // 'license'               => array(
                    //     'status'        => Templates\premium_templates()->config->get('status'),
                    //     'activateLink'  => Templates\premium_templates()->config->get('license_page'),
                    //     'proMessage'    => Templates\premium_templates()->config->get('pro_message')
                    // )
                ))
            );

        }
        
        /**
         * Get Modal Region
         * 
         * Get modal region in the editor.
         * 
         * @since 3.6.0
         * @access public
         */
        public function get_modal_region() {

            return array(
                'modalHeader'  => '.dialog-header',
                'modalContent' => '.dialog-message',
            );
            
        }
        
        /**
         * Add Templates Scripts
         * 
         * Load required templates for the templates library.
         * 
         * @since 3.6.0
         * @access public
         */
        public function load_footer_scripts() {
            
            $scripts = glob( EPICJUNGLE_ELEMENTOR_TEMPLATES_PATH . 'scripts/*.php' );
            
            array_map( function( $file ) {
                
                $name = basename( $file, '.php' );
                ob_start();
                include $file;
                printf( '<script type="text/html" id="tmpl-lk-premium-%1$s">%2$s</script>', $name, ob_get_clean() );
                
            }, $scripts);
            
        }
        
        /**
         * Get Instance
         * 
         * Creates and returns an instance of the class.
         * 
         * @since 3.6.0
         * @access public
         * 
         * @return object
         */
        public static function get_instance() {
            
            if( self::$instance == null ) {
                
                self::$instance = new self;
                
            }
            
            return self::$instance;
            
        }
            
        
    }
    
}