<?php
namespace EpicJungleElementor\Modules\Sidebar\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Cs_Sidebar_Skin extends Skin_Base {
    
     public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
    }

    public function get_id() {
        return 'cs-sidebar';
    }

    public function get_title() {
        return esc_html__( 'Barra lateral CS', 'epicjungle-elementor' );
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/sidebar/section_sidebar/before_section_end', [ $this, 'add_sidebar_controls' ], 10 );
    }

    public function add_sidebar_controls( Widget_Base $widget ) {
        $this->parent = $widget;

        $this->add_control( 'sidebar_right', [
            'label'       => esc_html__( 'Barra lateral direita?', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::SWITCHER,
            'default'     => 'yes',
            'description' => esc_html__( 'Ative para exibir a barra lateral na direção certa.', 'epicjungle-elementor' ),
            'frontend_available' => true,
        ] );


        $this->add_control( 'title', [
            'label'       => esc_html__( 'Título da barra lateral', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Barra lateral', 'epicjungle-elementor' ),
            'label_block' => true,
        ] );

        $this->add_control( 'offcanvas-body-class', [
            'label'       => esc_html__( 'Classe de corpo Offcanvas', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'px-4 pt-3 pt-lg-0 pe-lg-0 ps-lg-2 ps-xl-4',
            'label_block' => true,
        ] );
    }

    public function render() {     
        $widget       = $this->parent;   
        $settings     = $this->parent->get_settings_for_display();
        $sidebar_id   = 'sidebar-' . uniqid();
        
        $this->parent->add_render_attribute( 'offcanvas_body', 'class', [
            'cs-offcanvas-body',
        ] );

        $offcanvas_body_css = $settings[ $this->get_control_id( 'offcanvas-body-class' ) ];
        if ( ! empty( $offcanvas_body_css ) ) {
            $this->parent->add_render_attribute( 'offcanvas_body', 'class', $offcanvas_body_css );
        }

        $this->parent->add_render_attribute( 'offcanvas', 'class', [
            'cs-offcanvas-collapse',
        ] );

        if ( $settings[ $this->get_control_id( 'sidebar_right' ) ] == 'yes' ) {
            $this->parent->add_render_attribute( 'offcanvas', 'class', 'cs-offcanvas-right' );
        }

        if ( ! empty( $settings['_element_id'] ) ) {
            $sidebar_id = trim( $settings['_element_id'] ) . '-widget';
            $this->parent->add_render_attribute( 'offcanvas_id', 'id', $sidebar_id );
        }

        $sidebar = $this->parent->get_settings_for_display( 'sidebar' );

        if ( empty( $sidebar ) ) {
            return;
        }

        ?><div <?php echo $this->parent->get_render_attribute_string( 'offcanvas' ); ?><?php echo $this->parent->get_render_attribute_string( 'offcanvas_id' ); ?>>
            <div class="cs-offcanvas-cap navbar-box-shadow px-4 mb-3">
                <h5 class="mt-1 mb-0"><?php echo esc_html( $settings[ $this->get_control_id( 'title' ) ] ); ?></h5>
                <button class="close lead" type="button" data-toggle="offcanvas" data-offcanvas-id="<?php echo esc_attr( $sidebar_id ); ?>"><span aria-hidden="true">&times;</span></button>
            </div>
            <div <?php echo $this->parent->get_render_attribute_string( 'offcanvas_body' ); ?> data-simplebar>
                <?php dynamic_sidebar( $sidebar ); ?>
            </div>
        </div>
        <button class="btn btn-primary btn-sm cs-sidebar-toggle" type="button" data-toggle="offcanvas" data-offcanvas-id="<?php echo esc_attr( $sidebar_id ); ?>">
            <i class="fe-sidebar font-size-base mr-2"></i>
            <?php echo esc_html( $settings[ $this->get_control_id( 'title' ) ] ); ?>
        </button><?php
    }

    public function skin_print_template( $content, $widget ) {
        if( 'sidebar' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }
}