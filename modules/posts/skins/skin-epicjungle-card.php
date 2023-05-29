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

class Skin_EpicJungle_Card extends Skin_Base {

    public function get_id() {
        return 'epicjungle-card';
    }

    public function get_title() {
        return esc_html__( 'Cartão EpicJungle', 'epicjungle-elementor' );
    }
   
    protected function render_image() {
        if ( 'none' === $this->get_instance_value( 'show_image' ) ) {
            return;
        }

        $img_class = 'img-fluid';

        the_post_thumbnail( 'full', [ 'class' => $img_class ] ); 
     }

    protected function render_featured_image() {

        if ( ! has_post_thumbnail()  ) {
            return;
        }
        ?><!-- Image -->
        <?php if ( $this->get_instance_value( 'show_image' ) ) : ?>
            <a class="card-img-top" href="<?php echo esc_url( get_permalink() ); ?>">
                <?php $this->render_image(); ?>
            </a><?php
        endif;
    }

    protected function render_category() {

        if ( $this->get_instance_value( 'show_category' ) ) : 
            $categories = get_the_terms( get_the_ID(), 'category' );
            if ( ! empty( $categories ) ) : ?>
                    <?php
                        echo implode( ', ', array_map( function ( $category ) {
                        return sprintf( '<a href="%s" class="meta-link">%s</a>',
                            esc_url( get_category_link( $category ) ),
                            esc_html( $category->name )
                        );
                    }, $categories ) ); ?>
                <?php endif; unset( $categories ); 
        endif; 
    }


    protected function render_card_body($img_pos = '') {
        $style     = $this->get_instance_value( 'style' );

        $card_body  = 'card-body';
        $heading    = 'card-body__heading d-box box-orient-vertical post__title overflow-hidden nav-heading mb-4';
        $category   = 'card-body__category d-box box-orient-vertical post__category overflow-hidden';
        $title_tag  = $this->get_instance_value( 'title_tag' );

        if ( 'vertical' === $style ) {
            $heading .= ' h5';
        } else {
            $heading .= ' h4';
        }

        if ( ( 'right' === $img_pos) && ('horizontal' === $style ) ) {
            $card_body .= ' order-sm-1';
        }

        ?><!-- Body -->

        <div class="<?php echo esc_attr( $card_body ); ?>">
            
            <span class="post__category mb-2 d-inline-block font-size-sm"><?php $this->render_category(); ?></span>

            <?php if ( $this->get_instance_value( 'show_title' ) ) : ?>
            <!-- Heading -->
            <<?php echo $title_tag; ?> class="<?php echo esc_attr( $heading ); ?>">
                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
            </<?php echo $title_tag; ?>>
            <?php endif; ?>
            <?php if ( $this->get_instance_value( 'show_author' ) ) : ?>
            <a class="media meta-link font-size-sm align-items-center pt-3" href="<?php echo esc_url( get_permalink() ); ?>">
                <?php $this->render_avatar(); ?>
                <?php $this->render_author(); ?>
            </a>
            <?php endif; ?>

            <?php $this->render_meta_data(); ?>
            
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
        <div class="media-body pl-2 ml-1 mt-n1"><?php echo esc_html('por', 'epicjungle-elementor'); ?><span class="font-weight-semibold ml-1"><?php the_author(); ?></span>
        </div><?php
        
    }

    protected function render_meta_data() {
        /** @var array $settings e.g. [ 'author', 'date', ... ] */
        $settings = $this->get_instance_value( 'meta_data' );
        
        if ( empty( $settings ) ) {
            return;
        }
        ?>
        <div class="card-meta mt-3 text-right text-nowrap elementor-post__meta-data">
            <?php

            if ( in_array( 'comments', $settings ) ) {
                $this->render_comment();
            }

            if ( in_array( 'date', $settings ) ) {
                $this->render_date();
            }

            if ( in_array( 'time', $settings ) ) {
                $this->render_time();
            }

            ?>
        </div>
        <?php
    }

    protected function render_date() { 
        ?><!-- Date -->
        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>">
            <i class="fe fe-calendar mr-1 mt-n1"></i>&nbsp;
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date( 'j M'); ?></time>
        </a><?php
    }

    protected function render_time() {
        ?>
        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>">
            <i class="fe fe-clock mr-1 mt-n1"></i>&nbsp;
            <?php the_time(); ?>
        </a>
        <?php
    }


    protected function render_comment() {
        ?><!-- Date -->

        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>"><i class="fe fe-message-square mr-1"></i>&nbsp;<?php echo get_comments_number(); ?></a><span class="meta-divider"></span><?php
    }

    private function image_wrapper( $card_img ){ 
        $style        = $this->get_instance_value( 'style' );
        $bg           = 'style="background-image: url( ' . get_the_post_thumbnail_url() . ' );"';

        if ( ! has_post_thumbnail() ) {
            return;
        }

        ?>

        <?php if ( $this->get_instance_value( 'show_image' ) ) : 
            if ( $style === 'vertical' ): ?>
                <a class="card-img-top<?php echo esc_attr( $card_img ); ?>" href="<?php echo esc_url( get_permalink() ); ?>">
                <!-- Image (placeholder) -->
                    <?php $this->render_image(); ?>

                </a>
            <?php else: ?>
                 <a class="card-img-top<?php echo esc_attr( $card_img ); ?>" <?php echo $bg; ?> href="<?php echo esc_url( get_permalink() ); ?>"> </a>
            <?php endif; 

        endif;
    }

    public function render_featured_left() { ?>
        <span class="badge badge-floating badge-pill badge-primary badge-floating-left">
            <?php echo esc_html( 'Destacado', 'epicjungle-elementor' );?>
        </span><?php
    }

    public function render_featured_right() { ?>
        <span class="badge badge-floating badge-pill badge-primary badge-floating-right">
            <?php echo esc_html( 'Destacado', 'epicjungle-elementor' );?>
        </span><?php    
    }

    public function render_is_featured_sticky($featured) { 
        $featured = $this->get_instance_value( 'featured' );

        if( 'left' === $featured ){
            $this->render_featured_left();
        } else {
            $this->render_featured_right();
        }
    }

    protected function render_vertical_post() {
        $card = 'card card-hover';
        $masonry      = $this->get_instance_value( 'show_masonry' ); 
        $featured = $this->get_instance_value( 'featured' );

        ?><div class="card card-hover">

            <?php if( is_sticky() && $this->get_instance_value( 'show_sticky_badge' )) {
                $this->render_is_featured_sticky($featured);
            }
            

            $this->render_featured_image(); ?>

            <?php $this->render_card_body(); ?>

        </div><?php
    }


    public function render_horizontal_post($img_pos) {
        $featured = $this->get_instance_value( 'featured' );
        $card_img  = ' card-img-'.$img_pos;

        if ( 'right' === $img_pos ) {
             $card_img .= ' order-sm-2';
        }

        
        ?> 
        <div class="col-sm-12"> 
            <article class="card card-horizontal card-hover mb-grid-gutter">
                
                <?php if( is_sticky() && $this->get_instance_value( 'show_sticky_badge' ) ) {
                    $this->render_is_featured_sticky($featured);
                }
                $this->image_wrapper( $card_img ); 
                
                $this->render_card_body($img_pos); ?>
                
            </article>
        </div><?php 
    }

    protected function render_post() {
        $style        = $this->get_instance_value( 'style' ); 
        $width        = $this->get_instance_value( 'width' ); 
        $masonry      = $this->get_instance_value( 'show_masonry' ); 
        $page      = $this->get_instance_value( 'posts_per_page' ); 
        $query = $this->parent->get_query();
        $index = $query->current_post;        

        if ( $index % 2 === 0 ) {
            $img_pos = 'left';
        } else {
            $img_pos = 'right';
        }
            
        if ( 'vertical' === $style ) { 
            
            if ( 'yes' === $masonry ) : ?>
                <div class="cs-grid-item">

            <?php else: ?>        
                <div class="col-12 col-md-6 col-lg-<?php echo $width;?> d-flex<?php if ( has_post_thumbnail() ):?> has-post-thumbnail<?php endif; ?> mb-grid-gutter">

            <?php endif; 

            $this->render_vertical_post();
            if (  'yes' === $masonry ) : ?>
                </div>

            <?php else: ?>        

                </div>
            <?php endif; 
            
        } else {
            $this->render_horizontal_post( $img_pos );
        }
    }
}