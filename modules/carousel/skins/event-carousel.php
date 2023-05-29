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
use Elementor\Widget_Base;


class Event_carousel extends Skin_Base {

	public function get_id() {
        return 'event-carousel';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de eventos', 'epicjungle-elementor' );
    }

	public function on_import( $element ) {
        if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
            $element['settings']['posts_post_type'] = 'tribe_events';
        }

        return $element;
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
            $categories = get_the_terms( get_the_ID(), 'tribe_events_cat' );
            if ( ! empty( $categories ) ) : ?>
                    <?php
                        echo implode( ', ', array_map( function ( $category ) {
                        return sprintf( '<a href="%s" class="meta-link font-size-sm mb-2">%s</a>',
                            esc_url( get_category_link( $category ) ),
                            esc_html( $category->name )
                        );
                    }, $categories ) ); ?>
                <?php endif; unset( $categories ); 
        endif; 
    }

    protected function render_date() { 
        ?><!-- Date -->
        <div class="text-sm-center mt-0 mt-sm-n3 text-nowrap">
	        <span class="d-sm-block text-primary mr-2 mr-sm-0 mb-n3" style="font-size: 3.75rem">
	            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date( 'd'); ?></time>
	        </span>
	        <span class="font-size-xl text-muted text-uppercase">
	        	<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date( 'M'); ?></time>
	        </span>
	    </div><?php
    }

    protected function render_avatar() {
        echo get_avatar( get_the_author_meta( 'ID' ), 42, '', '', [ 'class' => 'avatar-img rounded-circle' ] ); 
    }

    protected function render_author() {
        ?><!-- Author -->
        <div class="media-body pl-2 ml-1 mt-n1">
        	<?php echo esc_html('por', 'epicjungle-elementor'); ?>
        	<span class="font-weight-semibold ml-1"><?php the_author(); ?></span>
        </div><?php
        
    }

    protected function render_card_body() {
 		$settings = $this->parent->get_settings();
        $card_body  = 'card-body py-5 px-4';
        $heading    = 'h4 nav-heading mb-4 ej-post__title';
        $category   = 'card-body__category post__category';
        $title_tag  = $settings['title_tag'];

    
        ?><!-- Body -->

        <div class="<?php echo esc_attr( $card_body ); ?>">
            <div class="d-sm-flex py-sm-4 px-lg-3">
                <?php $this->render_date(); ?>
            	<div class="post__category pl-sm-4 pl-lg-5">
            		<?php $this->render_category(); ?>
            		<?php if ( 'yes' === $settings['show_title'] ) : ?>
            			<!-- Heading -->
			            <<?php echo $title_tag; ?> class="<?php echo esc_attr( $heading ); ?>">
			                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			            </<?php echo $title_tag; ?>>
		            <?php endif; ?>
		            <?php if ( 'yes' === $settings['show_author'] ) : ?>
			            <a class="media meta-link font-size-sm align-items-center pt-2" href="<?php echo esc_url( get_permalink() ); ?>">
			                <?php $this->render_avatar(); ?>
			                <?php $this->render_author(); ?>
			            </a>
            		<?php endif; ?>
            	</div>
            </div>
        </div>
        <?php
    }

    public function render_featured_left() { ?>
        <span class="badge badge-lg badge-floating badge-floating-left badge-success">
            <?php echo esc_html( 'Novo', 'epicjungle-elementor' );?>
        </span><?php
    }

    public function render_featured_right() { ?>
        <span class="badge badge-lg badge-floating badge-floating-right badge-success">
            <?php echo esc_html( 'Novo', 'epicjungle-elementor' );?>
        </span><?php    
    }

    public function render_is_featured_sticky($featured) { 
    	$settings = $this->parent->get_settings();
        $featured = $settings['featured'];

        if( 'left' === $featured ){
            $this->render_featured_left();
        } else {
            $this->render_featured_right();
        }
    }

    protected function render_content_html() {
        $settings = $this->parent->get_settings();
        $featured = $settings['featured'];

        ?><div class="card h-100 border-0 box-shadow mx-1">

            <?php if( is_sticky() && ( 'yes' === $settings['show_sticky_badge'] ) ){
                $this->render_is_featured_sticky( $featured );
            }
            
          	$this->render_card_body(); ?>

        </div><?php
    }

    protected function render_loop_header() {
        ?>
        <div class="cs-carousel epicjungle-events-carousel">
            <div <?php echo $this->parent->get_render_attribute_string( 'events-slider' ); ?>>
            
        <?php
    }

    protected function render_loop_footer() {
        ?>
        </div></div>
                
        <?php
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

        
        $column_lg = ! empty( $settings['slides_per_view'] )        ? intval( $settings['slides_per_view'] )        : 2;
        $gutter_lg = ! empty( $settings['gutter']['size'] )        ? intval( $settings['gutter']['size'] )        : 23;


        $content_carousel_settings = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'autoHeight'        => true,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'items'             => $this->parent->get_settings( 'posts_per_page' ),
            'responsive'        => array (
                '0'       => array( 'items'   => 1 ),
                '800'     => array( 'items'   => $column_lg, 'gutter' => $gutter_lg ),
            )
        ];

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $content_carousel_settings['autoplay'] = $settings['autoplayTimeout'] ? $settings['autoplayTimeout'] : 1500;
            $content_carousel_settings['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

        
        $this->parent->add_render_attribute(
            'events-slider', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 

        $this->render_loop_header();
            while ( $query->have_posts() ) {
                $query->the_post();

                $this->render_post();
            } 

       $this->render_loop_footer();
        wp_reset_postdata();
        
    }
}