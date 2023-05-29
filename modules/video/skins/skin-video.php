<?php
namespace EpicJungleElementor\Modules\Video\Skins;

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
use EpicJungleElementor\Plugin;
use Elementor\Repeater;
use EpicJungleElementor\Core\Utils as EJ_Utils;

class Skin_Video extends Skin_Base {
    
    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
    }

    public function get_id() {
        return 'video';
    }

    public function get_title() {
        return esc_html__( 'EpicJungle Vídeo Lightbox', 'epicjungle-elementor' );
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/video/section_video_style/before_section_end', [ $this, 'register_video_lightbox_controls' ] );
        add_action( 'elementor/element/video/section_image_overlay/before_section_end', [ $this, 'register_video_imagebox_controls' ] );
        add_filter( 'epicjungle-elementor/widget/video/print_template', [ $this, 'skin_print_template' ], 20, 2 );
    }

    public function register_video_lightbox_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;

        $this->add_control(
            'wrapper_css', [
                'label'       => esc_html__( 'Classes de Wrapper Video', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description' => esc_html__( 'Aplicado ao wrapper superior do widget de vídeo ', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'link_css', [
                'label'       => esc_html__( 'Classe CSS do link de vídeo', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description' => esc_html__( 'Aplicado à tag <a> do widget de vídeo ', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'action_text_css', [
                'label'       => esc_html__( 'Classes de texto de ação', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description' => esc_html__( 'Aplicado à tag <span> do widget de vídeo ', 'epicjungle-elementor' ),
            ]
        );

         $this->add_control(
            'action_text', [
                'label'       => esc_html__( 'Texto de ação', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'title'       => esc_html__( 'Adicione seu texto de ação para vídeo aqui', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'show_action_text',
            [
                'label'     => esc_html__( 'Texto de ação', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'no',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'video_text', [
                'label'       => esc_html__( 'Texto do vídeo', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'title'       => esc_html__( 'Adicione seu texto de vídeo para vídeo aqui', 'epicjungle-elementor' ),
            ]
        );


        
    }

    public function register_video_imagebox_controls( Elementor\Widget_Base $widget ) {
        $this->parent = $widget;
        $this->parent->remove_control( 'section_image_overlay' );
    }

    
    public function render() {     
        $widget   = $this->parent;   
        $settings = $widget->get_settings();
        $video_url = $settings[ $settings['video_type'] . '_url' ];

        $widget->add_render_attribute( 'video-wrapper', 'class', 'elementor-video-wrapper' );

        if ( ! empty( $settings[ $this->get_control_id( 'wrapper_css' ) ] ) ) {
            $widget->add_render_attribute( 'video-wrapper', 'class', $settings[  $this->get_control_id( 'wrapper_css') ] );   
        }

        

        $widget->add_render_attribute( 'link_css', 'class', [
            'cs-video-btn',
            $settings[  $this->get_control_id( 'link_css') ]
            // $settings( 'link_css' ) ,
        ] ); 

        $widget->add_render_attribute( 'action_css', 'class', [
            'text-light',
            $settings[  $this->get_control_id( 'action_text_css') ]
            // $settings( 'action_text_css' ) ,
        ] ); ?>

        <div <?php echo $widget->get_render_attribute_string( 'video-wrapper' ); ?>>
            <a <?php echo $widget->get_render_attribute_string( 'link_css' ); ?> href="<?php echo ( $settings['youtube_url'] );?>" data-sub-html="<h6 class=&quot;font-size-sm text-light&quot;><?php echo $settings[ $this->get_control_id( 'video_text' ) ]; ?></h6>">
            </a>
            <?php if ( $settings[ $this->get_control_id( 'show_action_text' ) ] == 'yes' ): ?>
                <span <?php echo $widget->get_render_attribute_string( 'action_css' ); ?> style="max-width: 15rem;">
                    <?php echo $settings[ $this->get_control_id( 'action_text' ) ]; ?>
                </span>
            <?php endif ?>
            
        </div><?php
    }



    public function skin_print_template( $content, $widget ) {
        if( 'video' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }
}