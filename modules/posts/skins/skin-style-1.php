<?php
namespace EpicJungleElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Skin_Base as Elementor_Skin_Base;
use EpicJungleElementor;
use EpicJungleElementor\Plugin;
use EpicJungleElementor\Core\Utils as EJ_Utils;

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}

class Skin_Style_1 extends Skin_Base {

    public function get_id() {
        return 'portfolio-style-1';
    }

    public function get_title() {
        return esc_html__( 'Estilo 1', 'epicjungle-elementor' );
    }

    /**
    * Function for Portfolio loop
    */
    public function render_portfolio_post() { 
        $terms  = get_the_terms( get_the_ID(), 'jetpack-portfolio-tag' );
        $groups = '';
        $groups_arr = [];

        if ( is_array( $terms ) ) {
            foreach( $terms as $term ) {
                $groups_arr[] = $term->slug;
            }
        }

        $groups = implode( '","', $groups_arr );

        ?>
        <div class="cs-grid-item" data-groups='[&quot;<?php echo esc_attr( $groups ); ?>&quot;]'>
            <!-- Card -->
            <a class="card card-hover border-0 box-shadow" href="<?php echo esc_url( get_permalink() ); ?>">
                <!-- Image -->
                    <?php $this->render_thumbnail("rounded-top"); ?>
                <!-- Footer -->
                <div class="card-body text-center">
                    <!-- Heading -->
                    <?php $this->render_portfolio_title(); ?>
                    <!-- Preheading -->
                    <?php $this->render_portfolio_category(); ?>
                </div>
            </a>
        </div>
    <?php  }

    protected function render_loop_header() {
        $settings    = $this->parent->get_settings();
        $filter      =  $settings['filters'];
        if ('yes' == $filter ) { ?>
            <div class="cs-masonry-filterable pt-3 pt-md-0">
                <?php $this->portfolio_filters(); } ?>           
        <div class="cs-masonry-grid" data-columns="<?php echo esc_attr( $settings['columns'] ); ?>">
        <?php }

    protected function render_loop_footer() {
         $settings    = $this->parent->get_settings();
         $filter      =  $settings['filters']; ?>
        </div> <!-- / .row -->
        <?php if ('yes' == $filter ) { ?>
        </div><?php 
        } 

        $parent_settings = $this->parent->get_settings();
        if ( '' === $parent_settings['pagination_type'] ) {
            return;
        }

        $page_limit = $this->parent->get_query()->max_num_pages;
        if ( '' !== $parent_settings['pagination_page_limit'] ) {
            $page_limit = min( $parent_settings['pagination_page_limit'], $page_limit );
        }

        if ( 2 > $page_limit ) {
            return;
        }

        $this->parent->add_render_attribute( 'pagination', 'class', 'elementor-pagination' );

        $has_numbers = in_array( $parent_settings['pagination_type'], [ 'numbers', 'numbers_and_prev_next' ] );
        $has_prev_next = in_array( $parent_settings['pagination_type'], [ 'prev_next', 'numbers_and_prev_next' ] );

        $links = [];

        if ( $has_numbers ) {
            $paginate_args = [
                'type' => 'array',
                'current' => $this->parent->get_current_page(),
                'total' => $page_limit,
                'prev_next' => false,
                'show_all' => 'yes' !== $parent_settings['pagination_numbers_shorten'],
                'before_page_number' => '<span class="elementor-screen-only">' . __( 'Página', 'epicjungle-elementor' ) . '</span>',
            ];

            if ( is_singular() && ! is_front_page() ) {
                global $wp_rewrite;
                if ( $wp_rewrite->using_permalinks() ) {
                    $paginate_args['base'] = trailingslashit( get_permalink() ) . '%_%';
                    $paginate_args['format'] = user_trailingslashit( '%#%', 'single_paged' );
                } else {
                    $paginate_args['format'] = '?page=%#%';
                }
            }

            $links = paginate_links( $paginate_args );
        }

        if ( $has_prev_next ) {
            $prev_next = $this->parent->get_posts_nav_link( $page_limit );
            array_unshift( $links, $prev_next['prev'] );
            $links[] = $prev_next['next'];
        }

        ?>
        <nav class="elementor-pagination" role="navigation" aria-label="<?php esc_attr_e( 'Paginação', 'epicjungle-elementor' ); ?>">
            <?php echo implode( PHP_EOL, $links ); ?>
        </nav>
        <?php
    }

    public function set_render_attributes() {
        $this->parent->add_render_attribute('title','class',['h5','nav-heading','mb-2']);
        $this->parent->add_render_attribute('category','class',['font-size-sm','text-muted','mb-2']);
    }

    public function render() {
        $this->parent->query_posts();
        $query = $this->parent->get_query();
        if ( ! $query->found_posts ) {
            return;
        }
        $this->render_loop_header();
        // It's the global `wp_query` it self. and the loop was started from the theme.
        if ( $query->in_the_loop ) {
            $this->current_permalink = get_permalink();
            $this->render_portfolio_post();
        } else {
            $this->set_render_attributes();
            while ( $query->have_posts() ) {

                $query->the_post();
                $this->current_permalink = get_permalink();
                $this->render_portfolio_post();
            }
        }
        wp_reset_postdata();
        $this->render_loop_footer();
    }
}