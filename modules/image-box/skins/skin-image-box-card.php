<?php
namespace EpicJungleElementor\Modules\ImageBox\Skins;

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

class Skin_Image_Box_Card extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        add_filter( 'elementor/widget/print_template', [ $this, 'skin_print_template' ], 10, 2 );
        add_action( 'elementor/element/image-box/section_image/before_section_end', [ $this, 'section_image_controls' ], 10, 2 );
        add_action( 'elementor/element/image-box/section_style_content/after_section_start', [ $this, 'style_content_controls' ] );
        
    }

    public function get_id() {
        return 'image-box-card';
    }

    public function get_title() {
        return esc_html__( 'Cartão', 'epicjungle-elementor' );
    }


    public function style_content_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;
        
        $widget->update_control( 'text_align', [
            'condition' => [ '_skin' => '' ]
        ] );

        $widget->update_control( 'content_vertical_alignment', [
            'condition' => [ '_skin' => 'image-box-card' ]
        ] );

        $this->add_responsive_control(
            'text_align',
            [
                'label'      => __( 'Alinhamento', 'epicjungle-elementor' ),
                'type'       => Controls_Manager::CHOOSE,
                'options'    => [
                    'left'   => [
                        'title' => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Centro', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Direita', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justificado', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'content_vertical_alignment',
            [
                'label'      => esc_html__( 'Alinhamento vertical', 'epicjungle-elementor' ),
                'type'       => Controls_Manager::SELECT,
                'options'    => [
                    'top'    => esc_html__( 'Superior', 'epicjungle-elementor' ),
                    'middle' => esc_html__( 'Meio', 'epicjungle-elementor' ),
                    'bottom' => esc_html__( 'Inferior', 'epicjungle-elementor' ),
                ],
                'default'      => 'top',
                'prefix_class' => 'elementor-vertical-align-',
            ]
        );
    }


    public function section_image_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;

        $widget->update_control( 'position', [
            'condition' => [ '_skin' => '' ]
        ] );

        $this->add_control(
            'position', [
                'label'   => esc_html__( 'Posição da imagem', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left'  => [
                        'title' => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Direita', 'epicjungle-elementor' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label'     => esc_html__( 'Leia mais', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'no',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'readmore', [
                'label'     => esc_html__( 'Texto do link de ação', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Leia mais', 'epicjungle-elementor' ),
                'condition' => [
                    $this->get_control_id( 'show_read_more' ) => 'yes',
                ],
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label'            => __( 'Ícone de leia mais', 'epicjungle-elementor' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value' => 'fe fe-chevron-right',
                    'library' => 'fe-regular',
                ],
                'condition' => [
                    $this->get_control_id( 'show_read_more' ) => 'yes',
                ],
            ]
        );
    }

    public function skin_print_template( $content, $widget ) {
        if ( 'image-box' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }

    private function render_image( $settings ) {
        $widget = $this->parent;

        if ( empty( $settings['image']['url'] ) ) {
            return;
        }

        $img_pos     = $settings[ 'image_box_card_position' ];
        $img_classes = [ 'd-inline-block', 'mb-3', 'mb-xl-0' ];
        $img_css     = $settings['image_class'];

        if ( 'right' === $img_pos ) {
            $widget->add_render_attribute( 'img_wrapper', 'class', 'order-2' );
        }

        if ( 'right' === $img_pos ) {
            $widget->add_render_attribute( 'img_wrapper', 'class', 'pl-xl-3 ml-xl-3' );
        } else {
            $widget->add_render_attribute( 'img_wrapper', 'class', 'pr-xl-3 mr-xl-3' );
        }

        $widget->add_render_attribute( 'img_wrapper', 'class', [
            'elementor-image-box-img', 'position-relative'
        ] );

        if ( ! empty( $img_css ) ) {
            $img_classes = array_merge( $img_classes, explode( ' ', $img_css ) );
        }

        $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
        $image_html = EJ_Utils::add_class_to_image_html( $image_html, $img_classes ); 

        if ( ! empty( $settings['link']['url'] ) ) {
            $image_html = '<a ' . $widget->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
        }


        ?>

        <div <?php echo $widget->get_render_attribute_string( 'img_wrapper' );?>>
            <!-- Image -->
            <?php print( $image_html ); ?>
        </div><?php
    }

    private function render_title( $settings ) {
        $widget     = $this->parent;
        $title      = $settings['title_text'];
        $has_title  = ! Utils::is_empty( $title );
        $title_css  = $settings[ 'title_css' ];
        $title_html = $title;

        if ( ! $has_title ) {
            return;
        }

        $widget->add_render_attribute( 'title', 'class', 'elementor-image-box-title' );

        if ( ! empty( $settings['link']['url'] ) ) {
            $title_html = '<a ' . $widget->get_render_attribute_string( 'link' ) . '>' . $title_html . '</a>';
        }

        if ( ! empty( $title_css ) ) {
            $widget->add_render_attribute( 'title', 'class', $title_css );
        }

        printf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $widget->get_render_attribute_string( 'title' ), $title_html );
    }

    private function render_description( $settings ) {
        $widget   = $this->parent;
        $desc     = $settings[ 'description_text' ];
        $has_desc = ! Utils::is_empty( $desc );
        $desc_css = $settings[ 'desc_css' ];

        if ( ! $has_desc ) {
            return;
        }

        $widget->add_render_attribute( 'description_text', 'class', [ 'elementor-image-box-description', '' ] );

        if ( ! empty( $desc_css ) ) {
            $widget->add_render_attribute( 'description_text', 'class', $desc_css );
        }

        printf( '<p %1$s>%2$s</p>', $widget->get_render_attribute_string( 'description_text' ), $settings['description_text'] );
    }

    private function render_content( $settings ) {
        $widget      = $this->parent;
        $img_pos     = $settings[ 'image_box_card_position' ];
        $has_content = ! Utils::is_empty( $settings['title_text'] ) || ! Utils::is_empty( $settings['description_text'] );

        if ( ! $has_content ) {
            return;
        }

        $widget->add_render_attribute( 'content', 'class', [
            'elementor-image-box-content', 'media-body'
        ] ); ?>

        <div <?php echo $widget->get_render_attribute_string( 'content' );?>>
            <?php 
                $this->render_title( $settings );
                $this->render_description( $settings );
                $this->render_read_more( $settings );
            ?>
        </div><?php

        

    }

    protected function render_read_more( $settings ) {
        $widget      = $this->parent;
        $migrated    = isset( $settings['__fa4_migrated']['selected_icon'] );
        $selected_icon = $this->get_instance_value( 'selected_icon' );
        $action_link =  $settings['link']['url'];

        if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            $settings['icon'] = 'fe fe-chevron-right';
        }

        $is_new = ! isset ( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        $has_icon = ( ! $is_new || ! empty( $settings['selected_icon']['value'] ) );

        if ( ! $this->get_instance_value( 'show_read_more' ) ) {
            return;
        }

        ?>
        <a class="elementor-post__read-more nav-link-style d-inline-flex align-items-center pt-1" href="<?php echo esc_url( $action_link );?>"><?php echo $this->get_instance_value( 'readmore' ); ?><?php Icons_Manager::render_icon( $selected_icon , ['aria-hidden' => 'true', 'class' => 'font-size-xl ml-1 mt-1'] );?></a>
        <?php
    }


    public function render() {
        $widget   = $this->parent;
        $settings = $widget->get_settings_for_display();
        $img_wrapper = $settings[ 'image_box_wrapper_class' ];
        $img_pos     = $settings[ 'image_box_card_position' ];

        if ( 'right' === $img_pos ) {
            $img_pos_class = 'right';
        } else {
             $img_pos_class = 'left';
        }

        $widget->add_render_attribute( 'wrapper', 'class', [
            'elementor-image-box-wrapper',
            'bg-light',
            'box-shadow',
            'rounded-lg', 'py-5', 'px-4',
            $img_wrapper 
        ] );

        ?><div <?php echo $widget->get_render_attribute_string( 'wrapper' );?>>
            <div class="media d-block d-xl-flex align-items-center px-lg-3 py-xl-2 text-center text-sm-<?php echo esc_attr( $img_pos_class ); ?>"><?php
                $this->render_image( $settings );
                $this->render_content( $settings ); ?>
            </div>
        </div><?php
    }

}