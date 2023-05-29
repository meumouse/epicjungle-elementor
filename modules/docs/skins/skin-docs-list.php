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

class Skin_Docs_List extends Skin_Base {

    public function get_name() {
        return 'ej-docs-list';
    }

    public function get_id() {
        return 'ej-docs-list';
    }

    public function get_title() {
        return esc_html__( 'Lista', 'epicjungle-elementor' );
    }

    public function query_posts() {
        $query_args = [
            'posts_per_page' => $this->parent->get_settings( 'posts_per_page' ),
        ];

        /** @var Module_Query $elementor_query */
        $elementor_query = Module_Query::instance();
        $this->_query = $elementor_query->get_query( $this->parent, 'posts', $query_args, [] );
    }

    public function get_query() {
        return $this->_query;
    }

    public function render() { 

        $settings = $this->parent->get_settings();
        $this->query_posts();

        $query = $this->get_query();

        if ( ! $query->found_posts ) {
            return;
        }
         
        ?><ul class="list-unstyled row mb-0"><?php 
            
            while( $query->have_posts() ): $query->the_post();  ?>
            
            <li class="col-sm-6 mb-0">
                <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                   <i class="fe-book text-muted mr-2"></i>
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" class="nav-link-style"><?php the_title(); ?></a>
                </div>
            </li>
            
            <?php endwhile; ?>
            
            <?php wp_reset_postdata(); ?>

        </ul><?php
    }
}