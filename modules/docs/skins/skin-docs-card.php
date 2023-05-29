<?php
namespace EpicJungleElementor\Modules\Docs\Skins;

use EpicJungleElementor\Base\Base_Widget;
use EpicJungleElementor\Modules\QueryControl\Module as Module_Query;
use EpicJungleElementor\Modules\QueryControl\Controls\Group_Control_Related;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Skin_Base;

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}

class Skin_Docs_Card extends Skin_Base {

    public function get_name() {
        return 'ej-docs-card';
    }

    public function get_id() {
        return 'ej-docs-card';
    }

    public function get_title() {
        return esc_html__( 'Cartão', 'epicjungle-elementor' );
    }

    protected function render_loop_header() {
        ?><div class="row"><?php 
    }

    protected function render_loop_footer() {
        ?></div><?php 
    }

    public function query_posts() {
        $query_args = [
            'posts_per_page' => $this->parent->get_settings( 'posts_per_page' ),
            'post_parent'    => 0,
        ];

        /** @var Module_Query $elementor_query */
        $elementor_query = Module_Query::instance();
        $this->_query = $elementor_query->get_query( $this->parent, 'posts', $query_args, [] );
    }

    public function get_query() {
        return $this->_query;
    }

    public function render() { 
        if ( epicjungle_is_wedocs_activated() ) { 
            $settings = $this->parent->get_settings();
            $this->query_posts();

            /** @var \WP_Query $query */
            $query = $this->get_query();

            if ( ! $query->found_posts ) {
                return;
            }

            $this->render_loop_header(); 

            while ( $query->have_posts() ) {

                $query->the_post();

                $this->render_post();
            }

            $this->render_loop_footer();

            wp_reset_postdata();

        } else {
            echo esc_html__( 'Por favor, instale e ative o plugin weDocs', 'epicjungle-elementor' );
        }
    }

    public function render_post(){ 
        global $post;
        
        $thepostid = isset( $thepostid )? $thepostid : $post->ID;

        ?>
        <div class="col-lg-4 col-sm-6 mb-grid-gutter">
            <!-- Card -->
            <a class="card h-100 border-0 box-shadow card-hover" href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                <div class="card-body pl-grid-gutter pr-grid-gutter text-center">

                    <!-- Icon -->
                    <?php if ( function_exists( 'ej_wedocs_featured_icon' ) ) {
                        ej_wedocs_featured_icon( $thepostid, 'h2 text-primary mt-2 mb-4' ); 
                    } ?>
                    <!-- Heading -->
                    <h3 class="h5">
                        <?php echo esc_html( $post->post_title ); ?>
                    </h3>

                    <!-- Text -->
                    <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                        <p class="font-size-sm text-body"><?php echo esc_html( $post->post_excerpt ); ?></p>
                    <?php endif; ?>

                    <div class="btn btn-translucent-primary btn-sm mb-2"><?php echo esc_html__( 'Leia mais', 'epicjungle-elementor' ); ?></div>                  
                </div>
            </a>
        </div>
        <?php 
    }
}