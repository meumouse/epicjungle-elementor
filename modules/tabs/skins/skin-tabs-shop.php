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
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;


class Skin_Tabs_Shop extends Skin_Base {

    public function get_id() {
        return 'tabs-shop';
    }

    public function get_title() {
        return esc_html__( 'Loja Hero', 'epicjungle-elementor' );
    }

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        add_filter( 'elementor/widget/print_template', [ $this, 'skin_print_template' ], 10, 2 );    
    }

    public function skin_print_template( $content, $widget ) {
        if ( 'tabs' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/tabs/section_tabs/before_section_end', [ $this, 'add_repeater_controls' ] );
        add_action( 'elementor/element/tabs/section_tabs/before_section_end', [ $this, 'modify_tabs_controls' ] );
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

        $repeater->add_control(
            'title_image',
            [
                'label' => __( 'Ícone da guia', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'title_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'thumbanil',
            ]
        );

        $repeater->add_control(
            'content_image',
            [
                'label' => __( 'Imagem de conteúdo', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'description' => esc_html__( 'A imagem do conteúdo aplica-se apenas à guia loja', 'epicjungle-elementor' ),

            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'content_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'thumbanil',
            ]
        );


        $repeater->add_control(
            'tab_btn_text',
            [
                'label' => __( 'Texto do botão', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Compre agora - R$45.00', 'epicjungle-elementor' ),
                'placeholder' => __( 'Compre agora - R$45.00', 'epicjungle-elementor' ),
                'description' => esc_html__( 'Texto do botão aplica-se apenas à guia loja', 'epicjungle-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'btn_link',
            [
                'label' => __( 'Botão de link', 'epicjungle-elementor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

       
        $this->add_control( 'tabs', [
            'fields' => $repeater->get_controls(),
            'type'      => Controls_Manager::REPEATER,
        ] );
    }

    public function modify_tabs_controls( Widget_Base $widget ) {

        $this->parent = $widget;

        $remove_controls = [ 'tabs', 'type', 'tabs_align_horizontal' ];

        foreach( $remove_controls as $control ) {
            $this->parent->update_control( $control, [
                'condition' => [
                    '_skin' => ''
                ]
            ] );
        }
    }

    public function render() {
        
        $widget   = $this->parent;
        $settings = $widget->get_settings_for_display();
        $tabs     = $settings[ $this->get_control_id( 'tabs' ) ];  
        $id_int   = substr( $widget->get_id_int(), 0, 3 );
        $img_css  = $settings['image_class'];
        ?>
        <div class= "row align-items-center shop-tabs pb-7">
            <div class="col-lg-3 pt-3">
                <ul class="nav nav-tabs cs-media-tabs cs-media-tabs-light justify-content-center justify-content-lg-start pb-3 mb-4 pb-lg-0 mb-lg-0" role="tablist"><?php
                    foreach ( $tabs as $index => $item ) :
                        $tab_count = $index + 1;
                        ?><li class="nav-item mb-3" style="max-width: 16.25rem;">
                            <a class="nav-link <?php if ( $tab_count === 1 ): ?>active<?php endif;?>" href="#tabs<?php echo $tab_count?>" data-toggle="tab" role="tab">
                                <div class="media align-items-center"><?php 

                                    $image_html = Group_Control_Image_Size::get_attachment_image_html( $item,'title_image' );

                                    if ( false === strpos( $image_html, 'class="' ) ) {
                                        $image_html = str_replace( '<img', '<img class="' . esc_attr( $img_css ) . '"', $image_html );
                                    } else {
                                        $image_html = str_replace( 'class="', 'class="' . esc_attr( $img_css ) .' ' , $image_html );
                                    }

                                    echo $image_html;

                                    ?><div class="media-body pl-2 ml-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="font-size-sm pr-1"><?php echo $item['tab_title']; ?></div><i class="fe-chevron-right lead ml-2 mr-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li><?php 
                    endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <div class="tab-content"><?php
                    foreach ( $tabs as $index => $item ) :
                        $tab_count = $index + 1;
                    ?>                    
                    <div class="tab-pane fade <?php if ( $tab_count === 1 ): ?>show active<?php endif;?>" id="tabs<?php echo $tab_count?>">
                        <div class="row align-items-center">
                            <div class="col-lg-6 order-lg-2 pb-1 mb-4 pb-lg-0 mb-lg-0">
                                <div class="mx-auto" style="max-width: 443px;"><?php 
                                    $image_html = Group_Control_Image_Size::get_attachment_image_html( $item,'content_image' );
                                    echo $image_html;
                                ?></div>
                            </div>
                            <div class="col-lg-6 order-lg-1 text-center text-lg-left">
                                <div class="pl-xl-5">
                                    <h2 class="elementor-tab-title h1"><?php echo $item['tab_title']; ?></h2>
                                    <div class="elementor-tab-content font-size-lg mb-lg-5 d-block border-0 p-0"><?php echo $item['tab_content'] ; ?></div>
                                    <a class="btn btn-translucent-light" href="<?php echo esc_attr( $item['btn_link']['url'] ); ?>"><?php echo $item['tab_btn_text']; ?></a>
                                </div>
                            </div>
                        </div>
                    </div><?php 
                    endforeach; 
                ?></div>
            </div>
        </div><?php
    }
}