<?php
namespace EpicJungleElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Files_Upload_Handler;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Icons_Carousel extends Base {
    private $slide_prints_count = 0;
    private $files_upload_handler = false;

    public function get_name() {
        return 'ej-icon-carousel';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de ícones', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_keywords() {
        return [ 'icon', 'icon', 'carousel', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
    }

   
    protected function register_controls() {
        parent::register_controls();
        $this->remove_control( 'gutter' );
        $this->update_control(
            'autoplay',
            [
                'label'     => esc_html__( 'Reprodução automática', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'before',
                'frontend_available' => true,
            ]
        );

        $this->update_control(
            'image_class',
            [
               'label'        => esc_html__( 'Classe CSS da imagem', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'title'       => esc_html__( 'Adicione sua classe personalizada para a tag <img> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'default'     => 'mb-3',
                'label_block' => true,
                'description' => esc_html__( 'Classe CSS adicional que você deseja aplicar à tag img', 'epicjungle-elementor' ),
            ]
        );

        $this->update_control(
            'autoplay_speed',
            [
                'label'     => esc_html__( 'Velocidade de reprodução automática', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 6000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->start_controls_section(
            'section_Icon',
            [
                'label' => __( 'Ícone', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 
                    'show_label' => 'yes' 
                ],
                
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __( 'Cor do ícone', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-inner .cs-carousel-label i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'icon_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .cs-carousel-label i',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'Título',
            [
                'label' => __( 'Título', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 
                    'show_label' => 'yes' 
                ],
                
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Cor do título', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-inner .cs-carousel-label' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .cs-carousel-label',
            ]
        );

        $this->add_control(
            'title_css_class', [
                'label'   => esc_html__( 'Classe CSS do título', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'font-size-sm'


            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'number',
            [
                'label' => __( 'Número', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 
                    'show_label' => 'yes' 
                ],
                
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label'     => __( 'Cor do número', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-inner .cs-carousel-label' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'Number_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .cs-carousel-label',
            ]
        );

        $this->add_control(
            'number_css_class', [
                'label'   => esc_html__( 'Classe CSS do número', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'font-size-sm'


            ]
        );


        $this->end_controls_section();

    }


    protected function add_repeater_controls( Repeater $repeater ) {
        $enabled = Files_Upload_Handler::is_enabled();

        $repeater->add_control(
            'icon',
            [
                'label' => __( 'Ícone', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
            ]
        );

        
        $repeater->add_control(
            'number',
            [
                'label'   => __( 'Número', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'   => __( 'Título', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
            ]
        );        
        
    }

    protected function get_repeater_defaults() {
        $placeholder_image_src = Utils::get_placeholder_image_src();

        $defaults  = [];
        $title     = [ 'Área total', 'Chuveiros', 'Acesso', 'Andares completos', 'Estacionamento' ];
        $numbers     = [ '362', '5', '24/7', '3', '2' ];

        foreach( $numbers as $key => $number ) {
            $defaults[] = [
                'title'    => $title[ $key ],
                'number'   => $number,
                'icon'     => [ 'url' => $placeholder_image_src ]
            ];
        }

        return $defaults;


    }


    protected function print_slide( array $slide, array $settings, $element_key ) {

        ?>
        <div class="text-center">
            <?php
            
            $this->add_render_attribute( $element_key . '-image', [
                'src' => $slide['icon']['url'],
                'alt' => ! empty( $slide['title'] ) ? $slide['title'] : '',
                'class' => $settings['image_class'],
                'width' => '54',
            ] );
            ?>
            <img <?php echo $this->get_render_attribute_string( $element_key . '-image' ); ?>>
            <div class="text-muted" style="font-size: 2.25rem;"><?php echo $slide['number'];?></div>
            <h3 class="h5"><?php echo $slide['title'];?></h3>
        </div>
        <?php
    }


    protected function render() {
        $uniqId            = 'icon-carousel-' . $this->get_id();
        $settings          = $this->get_settings_for_display();
        $this->files_upload_handler = Files_Upload_Handler::is_enabled();
       
        $default_settings  = [];

        $settings  = array_merge( $default_settings, $settings );

        $column    = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 3;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 4;
        $column_lg = ! empty( $settings['slides_per_view'] )        ? intval( $settings['slides_per_view'] )        : 5;


        $content_carousel_settings = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'autoHeight'        => true,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'items'             => $this->get_settings( 'posts_per_page' ),
            'gutter'           => 15,
            'responsive'        => array (
                '0'       => array( 'items'   => 2 ),
                '410'     => array( 'items'   => $column ),
                '580'     => array( 'items'   => $column_md ),
                '740'    => array( 'items'   => $column_lg ),
            )
        ];

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $content_carousel_settings['autoplayTimeout'] = $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 6000;
            $content_carousel_settings['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

        
        $this->add_render_attribute(
            'icon-carousel', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 

        ?>
       
        <div class="cs-carousel">
            <div <?php echo $this->get_render_attribute_string( 'icon-carousel' ); ?>><?php
               foreach ( $settings['slides'] as $index => $slide ) :
                    $this->slide_prints_count++;
                    $this->print_slide( $slide, $settings, 'content-slide-' . $index . '-' . $this->slide_prints_count );
                endforeach; ?>
            </div>
        </div><?php        
    }

}