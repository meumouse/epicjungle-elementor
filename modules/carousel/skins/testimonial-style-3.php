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


class Testimonial_Style_3 extends Skin_Base {


	public function get_id() {
        return 'skin-style-3';
    }

    public function get_title() {
        return esc_html__( 'Estilo 3', 'epicjungle-elementor' );
    }


    protected function get_slide_image_url( $slide, array $settings ) {
        $image_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'image_size', $settings );

        if ( ! $image_url ) {
            $image_url = $slide['image']['url'];
        }

        return $image_url;
    }

    protected function print_slide( array $slide, array $settings, $element_key ) {
        $settings = $this->parent->get_settings();
        $author_css   = $settings['author_css_class' ];

        $this->parent->add_render_attribute( 'content', 'class', 'ej-testimonial-slide-content' );

        $this->parent->add_render_attribute( $element_key . '-card-img', 'class', 'ej-testimonial-slide-author' );

        if ( ! empty( $author_css ) ) {
            $this->parent->add_render_attribute( $element_key . '-card-img', 'class', $author_css );
        }

        $this->parent->add_render_attribute( $element_key . '-card-img', 'href', $slide['link']['url'] );


        if ( ! empty( $settings['content_css'] ) ) {
            $this->parent->add_render_attribute( 'content', 'class', $settings['content_css'] );
        }

        ?>
        <div class="py-2">
            <div class="card h-100 border-0 box-shadow mx-1">
                <div class="card-body">
                    <?php if( isset( $settings['show_blockquote'] ) && $settings['show_blockquote'] === 'yes' ) : ?>
                    <blockquote class="blockquote font-size-sm">
                        <p <?php echo $this->parent->get_render_attribute_string( 'content' ); ?>><?php echo $slide['content']; ?></p>
                    </blockquote><?php
                else : ?>
                    <a class="media align-items-center nav-heading mb-3" href="#">
                        <?php if ( ! empty( $slide['product_image']['url'] ) ) :
                            $this->parent->add_render_attribute( $element_key . '-card-image', [
                                'src'   => $slide['product_image']['url'],
                                'alt'   => ! empty( $slide['product_image'] ) ? $slide['product_title'] : '',
                                'width' => "60"
                            ] );?>
                            <img <?php echo $this->parent->get_render_attribute_string( $element_key . '-card-image' ); ?>>
                        <?php endif; ?>
                        <div class="media-body font-size-md font-weight-medium pl-2 ml-1"><?php echo $slide['product_title']; ?></div>
                    </a>
                    <p <?php echo $this->parent->get_render_attribute_string( 'content' ); ?>><?php echo $slide['content']; ?></p>
                <?php endif; ?>
                    
                </div>
                <?php if ( ! empty( $slide['name'] ) ) : ?>
                    <footer class="testimonial-footer font-size-sm px-4 pb-4">
                        <div class="media align-items-center border-top mb-n2 pt-3">
                           <?php if ( ! empty( $slide['image']['url'] ) ) :
                                $this->parent->add_render_attribute( $element_key . '-image', [
                                    'src' => $slide['image']['url'],
                                    'alt' => ! empty( $slide['name'] ) ? $slide['name'] : '',
                                    'class' => 'rounded-circle',
                                ] );?>
                                <img <?php echo $this->parent->get_render_attribute_string( $element_key . '-image' ); ?>>
                            <?php endif; ?>
                            <div class="media-body text-heading font-weight-medium pl-2 ml-1 mt-n1">
                                <a <?php echo $this->parent->get_render_attribute_string( $element_key . '-card-img' ); ?>>
                                    <?php echo $slide['name']; ?>
                                </a>
                            </div>
                        </div>
                    </footer>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="py-2">
            <a class="card h-100 border-0 box-shadow mx-1" href = <?php echo $slide['insta_image_link']['url']; ?>>
                <span class="card-floating-icon"><i class="fe-instagram"></i></span>
                    <?php $this->parent->add_render_attribute( $element_key . '-insta_image', [
                        'src' => $slide['insta_image']['url'],
                        'alt' => ! empty( $slide['insta_name'] ) ? $slide['insta_name'] : '',
                        'width' => '42',

                    ] ); ?>
                <div class = "card-img-top">
                    <img <?php echo $this->parent->get_render_attribute_string( $element_key . '-insta_image' ); ?> />
                </div>
                <?php if ( ! empty( $slide['insta_name'] ) ) : ?>
                    <footer class="testimonial-footer font-size-sm mt-auto py-2 px-4">
                        <div class="media align-items-center py-2">
                           <?php if ( ! empty( $slide['insta_author_image']['url'] ) ) :
                                $this->parent->add_render_attribute( $element_key . '-insta_author_image', [
                                    'src' => $slide['insta_author_image']['url'],
                                    'alt' => ! empty( $slide['insta_name'] ) ? $slide['insta_name'] : '',
                                    'class' => 'rounded-circle',
                                    'width' => '42',
                                ] );?>
                                <img <?php echo $this->parent->get_render_attribute_string( $element_key . '-insta_author_image' ); ?>>
                            <?php endif; ?>
                            <div class="media-body text-heading font-weight-medium pl-2 ml-1 mt-n1">
                                <?php echo $slide['insta_name']; ?>
                            </div>
                        </div>
                    </footer>
                <?php endif; ?>
            </a>
        </div><?php
    }

    public function render() {
        $widget   = $this->parent;
        $settings = $widget->get_settings();

        
        $column = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 2;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 3;
        $column_lg = ! empty( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 5;


        $default_carousel_args = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'autoplay'          => isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ? true : false,
            'items'             => 2,
            'responsive'        => array (
                '0'       => array( 'items'   => 1,             'gutter' => 16 ),
                '520'     => array( 'items'   => $column,       'gutter' => 12 ),
                '860'     => array( 'items'   => $column_md,    'gutter' => 23 ),
                '1080'    => array( 'items'  => 4,              'gutter' => 23 ),
                '1380'    => array( 'items'   => $column_lg,    'gutter' => 23 ),
                '1600'    => array( 'items'   => 6,             'gutter' => 23 ),
            )
        ];

        $default_carousel_args = apply_filters( 'epicjungle_testimonial_carousel_slider_default_carousel_args', $default_carousel_args );

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $default_carousel_args['autoPlay']             = $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 1500;
            $default_carousel_args['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

        if( isset( $settings['controls'] ) && $settings['controls'] === 'yes' ) {
            $default_control_args['controls']     = $settings['controls_position'];
        }

        if( isset( $settings['nav'] ) && $settings['nav'] === 'yes' ) {
            $default_nav_args['nav']     =  isset( $settings['nav_position'] ) && $settings['nav_position'] ? 'cs-dots-inside' : '';
        }

        if( isset( $settings['nav'] ) && $settings['nav'] === 'yes' ) {
            $default_nav_args['nav']     .= isset( $settings['nav_skin'] ) && $settings['nav_skin'] ? ' cs-dots-light' : '';
        }

        $this->parent->add_render_attribute(
            'testimonial-carousel-inner', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $default_carousel_args ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 

        ?><div class="cs-carousel">
            <div <?php echo $this->parent->get_render_attribute_string( 'testimonial-carousel-inner' ); ?>>
                <?php foreach ( $settings['slides'] as $slide ) :
                    $this->print_slide( $slide, $settings, 'image-slide-' . $slide['_id'] );
                endforeach; ?>
            </div>           
        </div><?php
    }
}