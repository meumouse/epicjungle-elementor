<?php

namespace EpicJungleElementor\Modules\Tabs\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Skin_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use EpicJungleElementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;

class Skin_Tabs_Schedule extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        add_filter( 'elementor/widget/print_template', [ $this, 'skin_print_template' ], 10, 2 );
    }

    public function get_id() {
        return 'tabs-epicjungle-schedule';
    }

    public function get_title() {
        return esc_html__( 'Cronograma', 'epicjungle-elementor' );
    }

    public function skin_print_template( $content, $widget ) {
        if ( 'tabs' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/tabs/section_tabs/before_section_end', [ $this, 'add_repeater_controls' ], 10 );
    }


    public function add_repeater_controls( Widget_Base $widget ) {

        $this->parent = $widget;

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => __( 'Título da guia', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Título da guia', 'epicjungle-elementor' ),
                'placeholder' => __( 'Título da guia', 'epicjungle-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label' => __( 'Conteúdo da guia', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::TEXTAREA,
                'default' => __( 'Conteúdo da guia', 'epicjungle-elementor' ),
                'placeholder' => __( 'Conteúdo da guia', 'epicjungle-elementor' ),
                'dynamic' => [
                    'active' => false,
                ],
            ]
        );

        $repeater->add_control( 'static_block_id', [
            'label'       => esc_html__( 'ID do bloco estático', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
        ] );
      
        $this->add_control( 'tabs', [
            'fields' => $repeater->get_controls(),
            'type'      => Controls_Manager::REPEATER,
        ] );
    }


    public function render() {
        
        $widget     = $this->parent;
        $settings   = $widget->get_settings_for_display();
        $tabs       = $settings[ $this->get_control_id( 'tabs' ) ];  
        $id_int     = substr( $widget->get_id_int(), 0, 3 );
        ?>
            
        <ul class="nav nav-tabs cs-fancy-tabs mb-5 mx-auto" style="max-width: 50rem;" role="tablist">
            <?php foreach ( $tabs as $index => $item ) :
                $tab_count = $index + 1; ?>
                <li class="nav-item">
                    <a class="nav-link <?php if ( $tab_count === 1 ): ?>active<?php endif;?>" href="#tabs<?php echo $tab_count?>" data-toggle="tab" role="tab" aria-controls="tabs<?php echo $tab_count?>" aria-selected="true">
                        <span class="elementor-tab-title cs-fancy-tab-text h1 font-weight-normal"><?php echo $item['tab_title']; ?></span>
                        <span class="cs-fancy-tab-shape"></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
       <div class="tab-content">
        <?php foreach ( $tabs as $index => $item ) :
                $tab_count = $index + 1; 
                $static_id  = $item [ 'static_block_id']; 
            ?>
            <div class="tab-pane fade <?php if ( $tab_count === 1 ): ?>show active<?php endif;?>" role="tabpanel" id="tabs<?php echo esc_attr( $tab_count ); ?>">
                <?php echo $item['tab_content'] . '  ' . epicjungle_render_content( $static_id, false ); ?> 
            </div>
        <?php endforeach; ?>
        </div><?php
    }
}