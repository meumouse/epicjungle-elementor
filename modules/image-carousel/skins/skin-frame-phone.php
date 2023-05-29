<?php
namespace EpicJungleElementor\Modules\ImageCarousel\Skins;

use Elementor\Skin_Base;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Control_Media;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Skin_Frame_Phone extends Skin_Base {

    public function get_id() {
        return 'cs-frame-phone';
    }

    public function get_title() {
        return esc_html__( 'Moldura de celular', 'epicjungle-elementor' );
    }

    protected function _register_controls_actions() {
         add_action( 'elementor/element/image-carousel/section_image_carousel/before_section_end', [ $this, 'modify_section_image_carousel_controls' ] );
         add_action( 'elementor/element/image-carousel/section_additional_options/before_section_end', [ $this, 'modify_section_additional_options_controls' ] );
    }

    public function modify_section_image_carousel_controls( Widget_Base $widget ) {

        $this->parent = $widget;

        $remove_controls = [ 'open_lightbox', 'slides_to_show', 'slides_to_scroll', 'image_stretch', 'navigation', 'caption_type'];

        foreach( $remove_controls as $control ) {
            $this->parent->update_control( $control, [
                'condition' => [
                    '_skin!' => 'cs-frame-phone'
                ]
            ] );
        }

        $this->add_control( 
            'phone_time', [
                'label'       => esc_html__( 'Phone Time', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => '9:41 AM',
            ], [
                'position'    => [
                    'of'  => '_skin'
                ]
            ] 
        );
    }

    public function modify_section_additional_options_controls( Widget_Base $widget ) {
        $this->parent->update_control( 'section_additional_options', [
            'condition' => [
                '_skin!' => 'cs-frame-phone'
            ]
        ] );
    }

    public function render() {
        $settings = $this->parent->get_settings_for_display();

        if ( empty( $settings['carousel'] ) ) {
            return;
        }

        $this->render_phone_frame( $settings );
    }

    private function get_link_url( $attachment, $instance ) {
        if ( 'none' === $instance['link_to'] ) {
            return false;
        }

        if ( 'custom' === $instance['link_to'] ) {
            if ( empty( $instance['link']['url'] ) ) {
                return false;
            }

            return $instance['link'];
        }

        return [
            'url' => wp_get_attachment_url( $attachment['id'] ),
        ];
    }

    private function get_image_caption( $attachment ) {
        $caption_type = $this->parent->get_settings_for_display( 'caption_type' );

        if ( empty( $caption_type ) ) {
            return '';
        }

        $attachment_post = get_post( $attachment['id'] );

        if ( 'caption' === $caption_type && isset( $attachment_post->post_excerpt ) ) {
            return $attachment_post->post_excerpt;
        }

        if ( 'title' === $caption_type && isset( $attachment_post->post_title ) ) {
            return $attachment_post->post_title;
        }

        $caption = isset( $attachment_post->post_content ) ? $attachment_post->post_content: '';

        return $caption;
    }

    private function render_phone_frame( $settings ) {

        $phone_time = isset( $settings[ $this->get_control_id( 'phone_time' ) ] ) ? $settings[ $this->get_control_id( 'phone_time' ) ] : '9:41 AM';

        $slides = [];

        foreach ( $settings['carousel'] as $index => $attachment ) {
            $image_url = isset( $attachment['url'] ) ? $attachment['url'] : Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );
            $image_html = '<img src="' . esc_attr( $image_url ) . '" alt="' . esc_attr( Control_Media::get_image_alt( $attachment ) ) . '" />';

            $link_tag = '';

            $link = $this->get_link_url( $attachment, $settings );

            if ( $link ) {
                $link_key = 'link_' . $index;

                $this->parent->add_link_attributes( $link_key, $link );

                $link_tag = '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
            }

            $image_caption = $this->get_image_caption( $attachment );

            $slide_html = $link_tag . $image_html;

            if ( $link ) {
                $slide_html .= '</a>';
            }

            $slides[] = $slide_html;

        }

        if ( empty( $slides ) ) {
            return;
        }

        ?><div class="cs-carousel">
            <div class="cs-frame-phone mx-auto">
                <div class="cs-frame-phone-status-bar text-light">
                    <span class="text-nowrap"><?php echo esc_html( $phone_time ); ?></span>
                    <span class="text-nowrap text-right">
                        <i class="fe-wifi mr-2"></i>
                        <i class="fe-battery-charging"></i>
                    </span>
                </div>
                <div class="cs-frame-phone-body">
                    <div class="cs-carousel-inner" data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;controls&quot;: false, &quot;nav&quot;: false, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 6000}">
                        <?php echo implode( '', $slides ); ?>
                    </div>
                </div>
            </div>
            <div class="cs-carousel-pager text-nowrap text-center">
                <?php $i = 1; foreach( $slides as $slide ): ?>
                <button <?php if ( 1 === $i ) : ?>class="active"<?php endif; ?> data-nav data-goto="<?php echo esc_attr( $i ); ?>"></button>
                <?php $i++; endforeach; ?>
            </div>
          </div><?php
    }
}