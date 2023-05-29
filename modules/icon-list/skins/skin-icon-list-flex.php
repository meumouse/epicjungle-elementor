<?php

namespace EpicJungleElementor\Modules\IconList\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Skin_Base;
use Elementor\Group_Control_Typography;

class Skin_Icon_List_Flex extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
    }

    public function get_id() {
        return 'flex';
    }

    public function get_title() {
        return esc_html__( 'Flexível', 'epicjungle-elementor' );
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/icon-list/section_icon/before_section_end', [ $this, 'register_icon_list_controls' ] );
        add_action( 'elementor/element/icon-list/section_icon_list/before_section_end', [ $this, 'icon_list_controls' ], 20 );
        add_action( 'elementor/element/icon-list/section_text_style/before_section_end', [ $this, 'icon_text_style' ], 20 );
        add_action( 'elementor/element/icon-list/section_icon_style/before_section_end', [ $this, 'register_icon_style_controls' ], 20 );
        add_filter( 'epicjungle-elementor/widget/icon-list/print_template', array( $this, 'skin_print_template' ), 10, 2 );
    }

    public function register_icon_list_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;

        $widget->update_control( 'view', [
            'condition' => [ '_skin' => '' ]
        ] );

        $widget->update_control( 'link_click', [
            'condition' => [ '_skin' => '' ]
        ] );
    }

    public function icon_list_controls( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;

        $widget->update_control( 'section_icon_list', [
            'condition' => [ '_skin!' => 'flex' ]
        ] );

    }

    public function icon_text_style( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;

        $widget->update_control( 'section_text_style', [
            'condition' => [ '_skin!' => 'flex' ]
        ] );

    }

    public function register_icon_style_controls( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;

        $widget->update_control( 'icon_size', [
            'condition' => [ '_skin!' => 'flex' ]
        ] );

        $widget->update_control( 'icon_color_hover', [
            'condition' => [ '_skin!' => 'flex' ]
        ] );

        $widget->update_control( 'icon_self_align', [
            'condition' => [ '_skin!' => 'flex' ]
        ] );

        $widget->update_control(
            'icon_color', [
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i'            => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg'          => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .epicjungle-elementor-icon-list__icon i'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .epicjungle-elementor-icon-list__icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_css', [
                'label'        => esc_html__( 'Classes de ícones CSS', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::TEXT,
                'dynamic'      => [
                    'active' => true,
                ],
                'title'        => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description'  => esc_html__( 'Classes CSS aplicadas ao encapsulamento de ícone.', 'epicjungle-elementor' )
            ]
        );        
    }

    public function render() {
        $widget   = $this->parent;
        $settings = $widget->get_settings();

       
        ?>


        <div class="d-flex align-items-center justify-content-between">

            <?php 
            $last_key = array_key_last( $settings['icon_list'] );
            foreach ( $settings['icon_list'] as $index => $item ) :
                $count = $index + 1;
                    $icon_class = 'epicjungle-elementor-icon-list__icon';
                    $icon_class .= $index != $last_key ? ' mr-4 ' : '' ;
                    $icon_class .= $settings[ $this->get_control_id( 'icon_css' ) ];
            
                ?><div class="<?php echo $icon_class ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
    }

    public function skin_print_template( $content, $widget ) {
        if( 'icon-list' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }
}