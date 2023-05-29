<?php
namespace EpicJungleElementor\Modules\BasicGallery\Skins;

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
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use EpicJungleElementor\Plugin;
use EpicJungleElementor\Core\Utils as EJ_Utils;

class Skin_Epicjungle_Gallery extends Skin_Base  {
    
    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        
    }

    public function get_id() {
        return 'ej-epicjungle-gallery';
    }

    public function get_title() {
        return esc_html__( 'EpicJungle Gallery', 'epicjungle-elementor' );
    }

     public function get_name() {
        return 'ej-epicjungle-gallery';
    }

    public function add_epicjunglegallery_data_to_image( $link_html, $id ) {
        $widget   = $this->parent;
        $settings = $widget->get_settings_for_display();
        $instance = 1;
    
        $selector = "gallery-{$instance}";

        $widget->add_render_attribute( 'link-'.$id, 'class', [ 'cs-gallery-item', 'rounded-lg mb-3 mb-md-0' ] );

       $link_html = str_replace( '<a', '<a ' . $widget->get_render_attribute_string( 'link-' . $id ) . 'data-sub-html="<h6 class=\'font-size-sm text-light\'>' . wp_get_attachment_caption( $id ) . '</h6>"', $link_html );
       $link_html = str_replace( '</a>', '<span class="cs-gallery-caption" id="'.$selector .'-' . $id .'">' . wp_get_attachment_caption( $id ) . '</span></a>', $link_html );
       return $link_html;

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
        }?>

        <div class="cs-gallery">
           

        <?php

        add_filter( 'wp_get_attachment_link', [ $this, 'add_epicjunglegallery_data_to_image' ], 10, 2 );


        echo cs_gallery_shortcode( $args );


        remove_filter( 'wp_get_attachment_link', [ $this, 'add_epicjunglegallery_data_to_image' ] ); ?>

        </div>
       

        <?php    
    }
}
