<?php
namespace AroundElementor\Modules\BasicGallery\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use AroundElementor\Plugin;
use AroundElementor\Core\Utils as ARUtils;

class Skin_Light_Gallery extends Skin_Base  {
    
    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        
    }

    public function get_id() {
        return 'ar-light-gallery';
    }

    public function get_title() {
        return esc_html__( 'Light Gallery', 'around-elementor' );
    }

     public function get_name() {
        return 'ar-light-gallery';
    }

    public function add_lightgallery_data_to_image( $link_html, $id ) {
        $widget   = $this->parent;
        $settings = $widget->get_settings_for_display();
        $widget->add_render_attribute( 'link-'.$id, 'class', [ 'cs-gallery-item', 'rounded-lgwded' ] );
    
        return preg_replace( '/^<a/', '<a ' . $widget->get_render_attribute_string( 'link-'.$id ), $link_html );
       
    }

    public function render() {

        $widget   = $this->parent;   
        $settings = $widget->get_settings();

        if ( ! $settings['wp_gallery'] ) {
            return;
        }

        $ids  = wp_list_pluck( $settings['wp_gallery'], 'id' );
        $args = array();

        $args['ids']  = implode( ',', $ids );
        $args['size'] = $settings['thumbnail_size'];

        if ( $settings['gallery_columns'] ) {
            $args['columns'] = $settings['gallery_columns'];
        }

        if ( $settings['gallery_link'] ) {
            $args['link'] = $settings['gallery_link'];
        }

        if ( ! empty( $settings['gallery_rand'] ) ) {
            $args['orderby'] = $settings['gallery_rand'];
        }

        if ( isset( $settings['wp_gallery'][0]['url'] ) ) {
            $urls = wp_list_pluck( $settings['wp_gallery'], 'url' );
            $this->render_cs_gallery( $urls, $args['columns'] );
        } else {
            add_filter( 'wp_get_attachment_link', [ $this, 'add_lightgallery_data_to_image' ], 10, 2 );

            echo cs_gallery_shortcode_light( $args );

            remove_filter( 'wp_get_attachment_link', [ $this, 'add_lightgallery_data_to_image' ] );
        }
    }

    public function render_cs_gallery( $urls, $columns ) {
        ?><div class="cs-gallery row row-cols-<?php echo esc_attr( $columns ); ?>"><?php
        foreach( $urls as $url ) {
            ?><div class="mb-grid-gutter">
                <a href="<?php echo esc_url( $url ); ?>" class="cs-gallery-item rounded-lg">
                    <img src="<?php echo esc_url( $url ); ?>" alt="Gallery thumbnail">
                </a>
            </div><?php
        }
        ?></div><?php
    }
}
