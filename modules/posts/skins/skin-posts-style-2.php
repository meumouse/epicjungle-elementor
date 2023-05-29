<?php
namespace EpicJungleElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Skin_Posts_Style_2 extends Skin_Base {

    public function get_id() {
        return 'epicjungle-posts-with-sidebar';
    }

    public function get_title() {
        return esc_html__( 'Postagens com barra lateral', 'epicjungle-elementor' );
    }

    protected function render_category() {

        if (  $this->get_instance_value( 'show_category' ) ) : 
            $terms = get_the_terms( get_the_ID(), 'category' );

            if ( empty( $terms ) || is_wp_error( $terms ) ) {
                return;
            }

            $links = [];
            foreach ( $terms as $term ){
                $cat_bg = get_term_meta( $term->term_id, 'category_bg', true );

                $links[] = sprintf( '<span href="%s" class="badge badge-lg badge-floating text-white" rel="tag" style="background-color:' . $cat_bg .'">%s</span>',
                    esc_url( get_category_link( $term ) ),
                    esc_html( $term->name )
                );
            }

            echo apply_filters( 'epicjungle_featured_post_category_badge', wp_kses_post( sprintf( implode( '', $links  ) ) ));

        endif;

    }
    

    protected function render_featured_image_with_category( ) {

        $video = $this-> epicjungle_get_post_video();
        ?>
        <?php if ( $this->get_instance_value( 'show_image' ) ) : ?>
            
            <?php if ( get_post_meta( get_the_ID(), 'ej_post_video', true) ) : ?>
                <!-- Image with video-->
                <div class="card-img-top d-flex align-items-center justify-content-center" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url( <?php the_post_thumbnail_url( get_the_ID(),'full' ); ?> );"<?php endif; ?>>
                    <?php $this->render_category(); ?>
                    <a class="cs-video-btn cs-video-btn-sm" href="<?php echo esc_url( $video ); ?>"></a>
                </div><?php

                else :
                ?><!-- Image without video-->
                    <a class="card-img-top" href="<?php echo esc_url( get_permalink() ); ?>" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url( <?php the_post_thumbnail_url( get_the_ID(),'full' ); ?> );"<?php endif; ?>>
                        <?php $this->render_category(); ?>
                    </a><?php
            endif;
        endif;
    }


    protected function render_card_body($img_pos = '') {
        $style     = $this->get_instance_value( 'style' );

        $card_body  = 'card-body';
        $heading    = 'card-body__heading h4 nav-heading text-capitalize mb-3';
        $title_tag  = $this->get_instance_value( 'title_tag' );

        ?><!-- Body -->

        <div class="<?php echo esc_attr( $card_body ); ?>">
            <?php $this->render_meta(); ?>

            <!-- Heading -->
            <?php if ( $this->get_instance_value( 'show_title' ) ) : ?>
                <<?php echo $title_tag; ?> class="<?php echo esc_attr( $heading ); ?>">
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                </<?php echo $title_tag; ?>>
            <?php endif; ?>

            <!-- content -->
            <?php if ( $this->get_instance_value( 'show_content' ) ) : ?>
                <p class="mb-0 font-size-sm text-muted"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
            
            <?php $this->render_meta_data(); ?>
        </div>
        <?php
    }


    protected function render_meta_data() {
        /** @var array $settings e.g. [ 'author', 'date', ... ] */
        $settings = $this->get_instance_value( 'meta_data' );
        
        if ( empty( $settings ) ) {
            return;
        }
        ?>
        <div class="mt-3 text-right text-nowrap">
            <?php

            if ( in_array( 'date', $settings ) ) {
                $this->render_date();
            }

            if ( in_array( 'comments', $settings ) ) {
                $this->render_comment();
            }

            ?>
        </div>
        <?php
    }

    protected function render_date() { 
        ?><!-- Date -->
        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>">
            <i class="fe fe-calendar mr-1 mt-n1"></i>&nbsp;
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date( 'M j'); ?></time><span class="meta-divider"></span>
        </a><?php
    }


    protected function render_comment() {
        ?><!-- Date -->

        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>"><i class="fe fe-message-square mr-1"></i>&nbsp;<?php echo get_comments_number(); ?></a><?php
    }

    protected function render_meta() {
        ?>

        <span class="d-inline-block mb-2 pb-1 font-size-sm text-muted">
            <?php $this->epicjungle_get_post_time(); ?>
            <?php $this->epicjungle_get_post_portions(); ?>
            <?php $this->epicjungle_get_post_video_time(); ?>
        </span>
        <?php
    }

   protected function epicjungle_get_post_time( $post = null ) {
        $post = get_post( $post );

        if ( ! $post ) {
            return false;
        }

        $meta_data = get_post_meta( $post->ID, 'ej_post_time', true );
        $time     = maybe_unserialize( $meta_data );

        
        if ( get_post_meta($post->ID, 'ej_post_time', true) ) : ?>
            <i class="fe fe-clock mr-1 mt-n1"></i>&nbsp;
            <?php echo esc_attr( $time );?>
        <?php endif; ?> <?php
    }

    protected function epicjungle_get_post_portions( $post = null ) {
        $post = get_post( $post );

        if ( ! $post ) {
            return false;
        }

        $meta_data = get_post_meta( $post->ID, 'ej_post_portions', true );
        $portions     = maybe_unserialize( $meta_data );

        if ( get_post_meta($post->ID, 'ej_post_portions', true) ) : ?>
            <?php echo esc_html__( ' — ', 'epicjungle-elementor' ) ?><?php echo esc_attr( $portions );?>
        <?php endif; ?> <?php

    }

    protected function epicjungle_get_post_video( $post = null ) {
        $post = get_post( $post );

        if ( ! $post ) {
            return false;
        }

        $meta_data = get_post_meta( $post->ID, 'ej_post_video', true );
        $video     = maybe_unserialize( $meta_data );

        return $video;
    }

    protected function epicjungle_get_post_video_time( $post = null ) {
        $post = get_post( $post );

        if ( ! $post ) {
            return false;
        }

        $meta_data = get_post_meta( $post->ID, 'ej_video_time', true );
        $video_time     = maybe_unserialize( $meta_data );

        if ( get_post_meta($post->ID, 'ej_video_time', true) ) : ?>
            <i class="fe-video font-size-base mr-2 mt-n1"></i><?php echo esc_attr( $video_time );?>
        <?php endif; ?> <?php
    }

    protected function render_post() {
        ?><div class = "col-md-12">
            <article class="card card-horizontal card-hover mb-grid-gutter">
                <?php $this->render_featured_image_with_category(); ?>
                <?php $this->render_card_body(); ?>
            </article>
        </div><?php
    }

}    