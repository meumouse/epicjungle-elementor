<?php
namespace EpicJungleElementor\Modules\Carousel\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use EpicJungleElementor\Core\Utils as EJ_Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use Elementor\Widget_Base;


class Skin_Featured_Post extends Skin_Base {
    

	public function get_id() {
        return 'skin-featured-post';
    }

    public function get_title() {
        return esc_html__( 'Postagem em destaque com barra de progresso', 'epicjungle-elementor' );
    }

    protected function render_image() {
        $settings = $this->parent->get_settings();
        if ( 'none' === $settings['show_image'] ) {
            return;
        }

        $img_class = 'img-fluid';

        the_post_thumbnail( 'full', [ 'class' => $img_class ] ); 
     }

     protected function render_category() {

        $settings = $this->parent->get_settings();
        if ( 'yes' === $settings['show_category'] ) : 
            $terms = get_the_terms( get_the_ID(), 'category' );

            if ( empty( $terms ) || is_wp_error( $terms ) ) {
                return;
            }

            $links = [];
            foreach ( $terms as $term ){
                $cat_bg = get_term_meta( $term->term_id, 'category_bg', true );

                $links[] = sprintf( '<a href="%s" class="d-block badge-primary text-white badge-lg badge-floating-right" rel="tag" style="background-color:' . $cat_bg .'">%s</a>',
                    esc_url( get_category_link( $term ) ),
                    esc_html( $term->name )
                );
            }

            echo apply_filters( 'epicjungle_featured_post_category_badge', wp_kses_post( sprintf( '<span class="badge-floating badge badge-lg badge-floating-right p-0">%s</span>', implode( '', $links  ) ) ));

        endif;

    }

    protected function render_featured_image() {
        $widget   = $this->parent;
        $settings = $widget->get_settings();

        if ( ! has_post_thumbnail()  ) {
            return;
        } 


        $migration_allowed = Icons_Manager::is_migration_allowed();
        $enabled           = Files_Upload_Handler::is_enabled();

        ob_start();
            $migrated = isset( $settings['__fa4_migrated']['selected_item_icon'] );
            // add old default
            if ( ! isset( $settings['item_icon'] ) && ! $migration_allowed ) {
                $settings['item_icon'] = 'fe-check';
            }

            $is_new = ! isset( $settings['item_icon'] ) && $migration_allowed;

            if ( ! empty( $settings['item_icon'] ) || ( ! empty( $settings['selected_item_icon']['value'] ) && $is_new ) ) :
                if ( $is_new || $migrated ) : ?>

                <?php Icons_Manager::render_icon( $settings['selected_item_icon'], [ 'aria-hidden' => 'true', 'class' => 'font-size-lg ml-1' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['item_icon'] ); ?> font-size-lg ml-1" aria-hidden="true"></i>
                <?php endif; ?>

            <?php endif;
        $floating_text_icon = ob_get_clean(); 

        $this->parent->add_render_attribute( 'floating_text', 'class', 'ej-floating-text card-floating-text' );


        if ( ! empty( $settings['floating_text_css'] ) ) {
            $this->parent->add_render_attribute( 'floating_text', 'class', $settings['floating_text_css'] );
        }
            
        ?>
        
        <?php if ( $settings['show_image'] ) : ?>
            <?php $this->render_category(); ?>
            <a class="card-img-top card-img-gradient" href="<?php echo esc_url( get_permalink() ); ?>">
                <?php $this->render_image(); ?>

                <?php if ( ! empty( $settings['floating_text'] ) && $settings['show_floating_text'] === 'yes' ) { ?>
                    <span <?php echo $this->parent->get_render_attribute_string( 'floating_text' ); ?>><?php echo $settings['floating_text']; ?>
                        <?php echo wp_kses_post( $floating_text_icon ); ?>
                    </span>
                <?php } ?>

            </a><?php
        endif; 
        
       

    }


    protected function render_card_body() {
        $settings = $this->parent->get_settings();
        $card_body  = 'card-body';
        $heading    = 'card-body__heading post__title nav-heading ej-post__title h5 pt-1 mb-3';
        $category   = 'card-body__category post__category';
        $title_tag  = $settings['title_tag'];

    
        ?><!-- Body -->

        <div class="<?php echo esc_attr( $card_body ); ?>">
            <?php $this->render_meta_data(); ?>

            <?php if ( 'yes' === $settings['show_title'] ) : ?>
            <!-- Heading -->
            <<?php echo $title_tag; ?> class="<?php echo esc_attr( $heading ); ?>">
                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
            </<?php echo $title_tag; ?>>
            <?php endif; ?>

            <?php $this->render_time(); ?>
                        
        </div>


        <?php
    }

        protected function render_meta_divider() {
        ?><!-- Divider -->
        <span class="meta-divider"><?php $this->get_instance_value( 'meta_separator' ); ?></span><?php
    }

    protected function render_avatar() {
        echo get_avatar( get_the_author_meta( 'ID' ), 36, '', '', [ 'class' => 'avatar-img rounded-circle' ] ); 
    }

    protected function render_author() {
        ?><!-- Author -->
        <div class="media-body pl-2 ml-1 mt-n1"><span class="font-weight-semibold ml-1"><?php esc_html('por', 'epicjungle-elementor'); ?><?php the_author(); ?></span>
        </div><?php
        
    }

    protected function render_meta_data() {
        $settings = $this->parent->get_settings();
        $meta_data = $settings['meta_data'];

        if ( empty( $meta_data ) ) {
            return;
        }
        ?>
        <div class="card-meta mb-3 text-nowrap elementor-post__meta-data">
            <?php


            if ( in_array( 'date', $meta_data ) ) {
                $this->render_date();
            }

            if ( in_array( 'comments', $meta_data ) ) {
                $this->render_comment();
            }

            ?>
        </div>
        <?php
    }

    protected function render_date() { 
        ?><!-- Date -->
        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>">
            <i class="fe fe-calendar mr-1 mt-n1"></i>
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date( 'M j'); ?></time>
        </a><?php
    }


    protected function render_time() {
        $time     = $this->epicjungle_get_post_time();
        $portions = $this->epicjungle_get_post_portions();
        

        if ( !empty( $time ) ||  !empty( $portions) ): ?>
            <p class="font-size-sm text-muted mb-2">
                <?php echo esc_attr( $time );
                if ( !empty( $portions)):
                    echo esc_html(' — ');
                    echo esc_attr( $portions );
                endif;?>
            </p>
        <?php
    endif;
    }

   protected function epicjungle_get_post_time( $post = null ) {
        $post = get_post( $post );

        if ( ! $post ) {
            return false;
        }

        $meta_data = get_post_meta( $post->ID, 'ej_post_time', true );
        $time      = maybe_unserialize( $meta_data );

        return $time;
    }

    protected function epicjungle_get_post_portions( $post = null ) {
        $post = get_post( $post );

        if ( ! $post ) {
            return false;
        }

        $meta_data    = get_post_meta( $post->ID, 'ej_post_portions', true );
        $portions     = maybe_unserialize( $meta_data );

        return $portions;
    }


    protected function render_comment() {
        ?><!-- Date -->

        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>"><span class="meta-divider ml-1"></span><i class="fe fe-message-square mr-1"></i>&nbsp;<?php comments_number(); ?></a><?php
    }

    protected function render_content_html() {
        $settings = $this->parent->get_settings();
        $widget = $this->parent;
        $featured = $settings['featured'];

        ?><article class="card h-100 border-0 box-shadow card-hover mx-1">
           
            <?php $this->render_featured_image(); ?>

            <?php $this->render_card_body(); ?>

        </article><?php
    }


    protected function render_post() { ?>
        <div class="pb-2"><?php
            $this->render_content_html(); ?>
        </div><?php
        
    }

    public function render() {
        $settings = $this->parent->get_settings_for_display();
        $this->parent->query_posts( $settings );

        /** @var \WP_Query $query */
        $query = $this->parent->get_query();


        if ( ! $query->found_posts ) {
            return;
        }

        $uniqId = 'events-slider-' . $this->get_id();

        $default_settings = [];

        $settings  = array_merge( $default_settings, $settings );

        $column    = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 2;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 3;
        $column_lg = ! empty( $settings['slides_per_view'] )        ? intval( $settings['slides_per_view'] )        : 3;

        $gutter    = ! empty( $settings['gutter_mobile']['size'] ) ? intval( $settings['gutter_mobile']['size'] ) : 16;
        $gutter_md = ! empty( $settings['gutter_tablet']['size'] ) ? intval( $settings['gutter_tablet']['size'] ) : 16;
        $gutter_lg = ! empty( $settings['gutter']['size'] )        ? intval( $settings['gutter']['size'] )        : 16;


        $content_carousel_settings = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'autoHeight'        => true,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'items'             => $this->parent->get_settings( 'posts_per_page' ),
            'responsive'        => array (
                '0'       => array( 'items'   => 1, 'gutter' => $gutter ),
                '500'     => array( 'items'   => $column, 'gutter' => $gutter ),
                '768'     => array( 'items'   => $column_md, 'gutter' => $gutter_md ),
                '991'     => array( 'items'   => $column_lg, 'gutter' => $gutter_lg ),
            )

        ];

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $content_carousel_settings['autoplay'] = $settings['autoplayTimeout'] ? $settings['autoplayTimeout'] : 1500;
            $content_carousel_settings['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

        
        $this->parent->add_render_attribute(
            'posts-slider', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 
        ?>


        <div class="cs-carousel featured-carousel-progress">
            <?php if ( $settings['enable_progress_bar'] === 'yes' ): ?>
                <div class="cs-carousel-progress ml-auto mb-4 pb-2">
                    <div class="text-sm text-muted text-center mb-2">
                        <span class="cs-current-slide mr-1"></span><?php echo esc_html__('de', 'epicjungle-elementor');?><span class="cs-total-slides ml-1"></span>
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar"></div>
                    </div>
                </div>
            <?php endif; ?>

            <div <?php echo $this->parent->get_render_attribute_string( 'posts-slider' ); ?>>
                <?php while ( $query->have_posts() ) {
                    $query->the_post();

                    $this->render_post();
                } 

                wp_reset_postdata(); ?>
            </div>
        </div><?php

    }
 
}