<?php

namespace EpicJungleElementor\Modules\IconList;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Modules\IconList\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function get_name() {
        return 'override-icon-list';
    }


    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Icon_List_Flex( $widget ) );
        $widget->add_skin( new Skins\Skin_CS_Widget( $widget ) );
    }

    public function add_actions() {
        add_action( 'elementor/widget/icon-list/skins_init', [ $this, 'init_skins' ], 10 );
    }

    public function render_content( $content, $widget ) {
        ob_start();
        $settings = $widget->get_settings_for_display();

        $widget->add_render_attribute( 'icon', 'class',[
            'epicjungle-elementor-icon-list__icon',
        ] );

        if ( ! empty( $settings['link_css'] ) ) {
            $widget->add_render_attribute( 'link_css','class',$settings['link_css'] );
        }

        if ( ! empty( $widget->get_settings( 'icon_css' ) ) ) {
            $widget->add_render_attribute( 'icon', 'class', $settings[ 'icon_css' ] );
        }

        $repeater_setting_key = Plugin::instance()->modules_manager->get_repeater_setting_key( 'text', 'icon_list', 'elementor-icon-list-text' );

        $widget->add_render_attribute( $repeater_setting_key, 'class', [
            'epicjungle-elementor-icon-list__heading', 'mb-1'
        ] );        


        $widget->add_render_attribute( 'icon_list', 'class', [
            'elementor-icon-list-items',
        ] );
        $widget->add_render_attribute( 'list_item', 'class',[
            'elementor-icon-list-item',
        ] );


        if ( 'inline' === $settings['view'] ) {
            $widget->add_render_attribute( 'icon_list', 'class', 'elementor-inline-items' );
            $widget->add_render_attribute( 'list_item', 'class', 'elementor-inline-item' );
        }?>
        <ul <?php echo $widget->get_render_attribute_string( 'icon_list' ); ?>>
            <?php
            foreach ( $settings['icon_list'] as $index => $item ) :  
                ?>
                <li <?php echo $widget->get_render_attribute_string( 'list_item' ); ?>>

                    <?php if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) ) ): ?>
                    <div <?php echo $widget->get_render_attribute_string( 'icon' ); ?>>
                        <?php Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                <?php endif; ?>
                <span <?php echo $widget->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['text']; ?></span>
                <?php
                if ( ! empty( $item['link']['url'] ) ) {
                    $link_key = 'link_' . $index;

                    $widget->add_link_attributes( $link_key, $item['link'] );

                    echo '<a ' . $widget->get_render_attribute_string( 'link_css' ). $widget->get_render_attribute_string( $link_key ) . '></a>';
                } ?>                   
                </li><?php
            endforeach;?>
        </ul>
        <?php $content = ob_get_clean();
        return $content;
    }
}