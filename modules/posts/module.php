<?php
namespace EpicJungleElementor\Modules\Posts;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Modules\Posts\Widgets\Posts_Base;
use EpicJungleElementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_name() {
        return 'posts';
    }

    public function get_widgets() {
        return [
            'Posts',
            'Portfolio',
        ];
    }

    /**
     * Fix WP 5.5 pagination issue.
     *
     * Return true to mark that it's handled and avoid WP to set it as 404.
     *
     * @see https://github.com/elementor/elementor/issues/12126
     * @see https://core.trac.wordpress.org/ticket/50976
     *
     * Based on the logic at \WP::handle_404.
     *
     * @param $handled - Default false.
     * @param $wp_query
     *
     * @return bool
     */
    public function allow_posts_widget_pagination( $handled, $wp_query ) {
        // Check it's not already handled and it's a single paged query.
        if ( $handled || empty( $wp_query->query_vars['page'] ) || ! is_singular() || empty( $wp_query->post ) ) {
            return $handled;
        }

        $document = EpicJungleElementor\Plugin::elementor()->documents->get( $wp_query->post->ID );

        return $this->is_valid_pagination( $document->get_elements_data(), $wp_query->query_vars['page'] );
    }

    /**
     * Checks a set of elements if there is a posts/archive widget that may be paginated to a specific page number.
     *
     * @param array $elements
     * @param       $current_page
     *
     * @return bool
     */
    public function is_valid_pagination( array $elements, $current_page ) {
        $is_valid = false;

        // Get all widgets that may add pagination.
        $widgets = EpicJungleElementor\Plugin::elementor()->widgets_manager->get_widget_types();
        $posts_widgets = [];
        foreach ( $widgets as $widget ) {
            if ( $widget instanceof Posts_Base ) {
                $posts_widgets[] = $widget->get_name();
            }
        }

        EpicJungleElementor\Plugin::elementor()->db->iterate_data( $elements, function( $element ) use ( &$is_valid, $posts_widgets, $current_page ) {
            if ( isset( $element['widgetType'] ) && in_array( $element['widgetType'], $posts_widgets, true ) ) {
                // Has pagination.
                if ( ! empty( $element['settings']['pagination_type'] ) ) {
                    // No max pages limits.
                    if ( empty( $element['settings']['pagination_page_limit'] ) ) {
                        $is_valid = true;
                    } elseif ( (int) $current_page <= (int) $element['settings']['pagination_page_limit'] ) {
                        // Has page limit but current page is less than or equal to max page limit.
                        $is_valid = true;
                    }
                }
            }
        } );

        return $is_valid;
    }

    public function __construct() {
        parent::__construct();

        add_filter( 'pre_handle_404', [ $this, 'allow_posts_widget_pagination' ], 10, 2 );
        //add_filter( 'register_post_type_job_listing', [ $this, 'show_register_post_type_job_listing' ] );
        //add_action( 'init', [ $this, 'wpjm_add_excerpt_support' ] );
    }

}