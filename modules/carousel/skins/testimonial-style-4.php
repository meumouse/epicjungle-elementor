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


class Testimonial_Style_4 extends Skin_Base {


    public function get_id() {
        return 'skin-style-4';
    }

    public function get_title() {
        return esc_html__( 'Estilo 4', 'epicjungle-elementor' );
    }


    protected function print_slide( array $slide, array $settings, $element_key ) {
        
        $settings = $this->parent->get_settings();
        ?><div class="pt-3">
            <blockquote class="blockquote mx-1">
                <p <?php echo $this->parent->get_render_attribute_string( 'content' ); ?>><?php echo $slide['content']; ?></p>
                <?php if ( ! empty( $settings['content_css'] ) ) : ?>
                    <p <?php echo $this->parent->get_render_attribute_string( 'content' ); ?>><?php echo $slide['content_2']; ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $slide['name'] ) ) : ?>
                    <footer class="blockquote-footer"><?php echo $slide['name']; ?>
                    </footer>
                <?php endif; ?>
            </blockquote>
        </div><?php

    }

    public function render() {
        $widget   = $this->parent;
        $settings = $widget->get_settings();

        $uniqId   = 'testimoial-slider-' . $this->get_id();
        $settings = $this->parent->get_settings_for_display();
        //echo '<pre>' . print_r( $settings, 1 ) . '</pre>';

        $default_control_args['controls'] = '';
        $default_nav_args['nav']          = '';


        $default_carousel_args = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'autoplay'          => isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ? true : false,
            'gutter'           => 20,
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
            </div>         
        <?php
    }
}


