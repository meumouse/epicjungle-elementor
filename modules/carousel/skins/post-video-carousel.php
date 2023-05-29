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


class Post_Video_Carousel extends Skin_Base {
    

	public function get_id() {
        return 'post-video-carousel';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de postagens de vídeos', 'epicjungle-elementor' );
    }

    protected function render_image() {
        $settings = $this->parent->get_settings();
        if ( 'none' === $settings['show_image'] ) {
            return;
        }

        the_post_thumbnail( 'full' ); 
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

    protected function render_content_html() {
        $settings = $this->parent->get_settings();
        $widget = $this->parent;
        $video = $this-> epicjungle_get_post_video();

        ?><div class="cs-gallery">
            <a class="cs-gallery-item cs-gallery-video rounded-lg" href="<?php echo esc_url( $video ); ?>" data-sub-html="&lt;h6 class=&quot;font-size-sm text-light&quot;&gt;<?php the_title(); ?>&lt;/h6&gt;">
                <?php $this-> render_image() ?>
                <span class="cs-gallery-caption"><?php the_title(); ?></span>
            </a>
        </div><?php
    }


    protected function render_post() { ?>
        <div>
            <?php $this->render_content_html(); ?>
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

        $default_settings = [];

        $settings  = array_merge( $default_settings, $settings );

        $column    = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 2;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 3;
        $column_lg = ! empty( $settings['slides_per_view'] )        ? intval( $settings['slides_per_view'] )        : 3;

        $gutter    = ! empty( $settings['gutter_mobile']['size'] ) ? intval( $settings['gutter_mobile']['size'] ) : 16;
        $gutter_md = ! empty( $settings['gutter_tablet']['size'] ) ? intval( $settings['gutter_tablet']['size'] ) : 30;
        $gutter_lg = ! empty( $settings['gutter']['size'] )        ? intval( $settings['gutter']['size'] )        : 30;


        $content_carousel_settings = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'navAsThumbnails'   => true,
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
            'carousel-inner', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 
        ?>
        <div class="cs-carousel post-video-carousel">
            <div <?php echo $this->parent->get_render_attribute_string( 'carousel-inner' ); ?>>
                <?php while ( $query->have_posts() ) {
                    $query->the_post();

                    $this->render_post();
                } 

                wp_reset_postdata(); ?>
            </div>
        </div><?php
    }
}