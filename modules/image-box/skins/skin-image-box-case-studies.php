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

class Skin_Image_Box_Case_Studies extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        add_filter( 'elementor/widget/print_template', [ $this, 'skin_print_template' ], 10, 2 );
        add_action( 'elementor/element/image-box/section_image/before_section_end', [ $this, 'section_image_controls' ], 10, 2 );
        add_action( 'elementor/element/image-box/section_style_image/before_section_end', [ $this, 'style_image_controls' ] );
        add_action( 'elementor/element/image-box/section_style_content/before_section_end', [ $this, 'style_content_controls' ] );
        
    }

    public function get_id() {
        return 'case-studies';
    }

    public function get_title() {
        return esc_html__( 'Estudos de caso', 'epicjungle-elementor' );
    }

     public function style_image_controls( $widget ) {
        $this->parent = $widget;

        $widget->update_control( 'image_space', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $widget->update_control( 'image_size', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $widget->update_control( 'hover_animation', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );
    }


    public function section_image_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;

        $widget->update_control( 'position', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $widget->update_control( 'description_text', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $widget->update_control( 'title_text', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $this->add_control(
            'title_text',
            [
                'label' => __( 'Título', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __( 'Fulano de tal', 'epicjungle-elementor' ),
                'placeholder' => __( 'Insira seu título', 'epicjungle-elementor' ),
                'label_block' => true,
                'condition' => [ '_skin' => 'case-studies' ]
            ]
        );
    }

    public function style_content_controls( $widget ) {
        $this->parent = $widget;

        $widget->update_control( 'heading_description', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $widget->update_control( 'description_color', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $widget->update_control( 'description_typography', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );

        $widget->update_control( 'content_vertical_alignment', [
            'condition' => [ '_skin!' => 'case-studies' ]
        ] );
    }

    public function skin_print_template( $content, $widget ) {
        if ( 'image-box' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }
    public function render() {
        $widget   = $this->parent;
        $settings = $widget->get_settings_for_display();
        $img_wrapper = $settings[ 'image_box_wrapper_class' ];
        $img_css     = $settings[ 'image_class' ];
        $img_classes =[ 'image' ];
        $title       = $settings[ $this->get_control_id('title_text') ];
        $has_title   = ! Utils::is_empty( $title );
        $title_css   = $settings[ 'title_css' ];
        $title_html  = $title;

        $widget->add_render_attribute( 'img_wrapper', 'class', [
            'elementor-image-box-img',
        ] );

        if ( ! empty( $settings['link']['url'] ) ) {
            $link_class="card border-0 box-shadow mx-auto card-hover";
        } else {
            $link_class="card border-0 box-shadow mx-auto";
        }

        $widget->add_render_attribute( 'link', [
            'href'  => $settings['link']['url'],
            'class' => $link_class,
        ] );


        if ( ! empty( $img_css ) ) {
            $img_classes = $img_css;
        }

        $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
        $image_html = EJ_Utils::add_class_to_image_html( $image_html, $img_classes ); 


        $widget->add_render_attribute( 'title', 'class', 'elementor-image-box-title' );

        if ( ! empty( $title_css ) ) {
            $widget->add_render_attribute( 'title', 'class', $title_css );
        }

        $widget->add_render_attribute( 'wrapper', 'class', [
            'elementor-image-box-wrapper',
            $img_wrapper 
        ] );

        ?><div <?php echo $widget->get_render_attribute_string( 'wrapper' );?>>
        <?php if ( ! empty( $settings['link']['url'] ) ) : ?>
            <a <?php echo $widget->get_render_attribute_string( 'link' );?> style="max-width: 400px;">
        <?php else: ?>  
            <span class="<?php echo esc_attr( $link_class );?>" style="max-width: 400px;">  
        <?php endif; ?>   
                <div class = "card-img-top">
                    <?php print( $image_html ); ?>
                </div>
                <div class="elementor-image-box-content card-body"><?php
                    printf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $widget->get_render_attribute_string( 'title' ), $title_html );?>
                </div>
        <?php if ( ! empty( $settings['link']['url'] ) ) : ?>
            </a>
        <?php else: ?>  
            </span>
        <?php endif; ?>  
        
        </div>
        <?php
    }

}