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

class Offers_Carousel extends Base {
	//private $slide_prints_count = 0;
	private $files_upload_handler = false;

	public function get_name() {
        return 'ej-offers-carousel';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de ofertas', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_keywords() {
        return [ 'carousel', 'offer' ];
    }

   
    protected function register_controls() {
    	parent::register_controls();

        // $this->update_responsive_control(
        //     'slides_per_view', [
        //         'options'   => [
        //             ''      => __( 'Padrão', 'epicjungle-elementor' ),
        //             '1'     => __( '1', 'epicjungle-elementor' ),
        //             '2'     => __( '2', 'epicjungle-elementor' ),
        //             '3'     => __( '3', 'epicjungle-elementor' ),
        //             '4'     => __( '4', 'epicjungle-elementor' ),
        //         ],
        //         'default'   =>'3'
        //     ]
        // );

        
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
            'nav',
            [
                'condition' => [
                    'skin' => '',
                ],
            ]
        );

        $this->update_control(
            'controls_position',
            [
                'condition' => [
                    'skin' => '',
                ],
            ]
        );

        $this->update_control(
            'image_class',
            [
               'label'        => esc_html__( 'Classe CSS da imagem', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'title'       => esc_html__( 'Adicione sua classe personalizada para a tag <img> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'default'     => 'img-fluid',
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


        $this->start_injection( [
            'of' => 'slides',
        ] );

        
        $this->add_control(
            'enable_progress_bar',
            [
                'label'     => esc_html__( 'Mostrar barra de progresso', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        ); 
        

        $this->add_control(
            'show_badge',
            [
                'label'     => esc_html__( 'Mostrar emblema', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        ); 

        $this->add_control(
            'badge_color', [
                'label'     => esc_html__( 'Fundo do emblema', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'primary'   => 'Primário',
                    'secondary' => 'Secundário',
                    'success'   => 'Sucesso',
                    'danger'    => 'Perigo',
                    'warning'   => 'Aviso',
                    'info'      => 'Informação',
                    'light'     => 'Claro',
                    'dark'      => 'Escuro',
                    'gradient'  => 'Degradê',
                ],
                'condition' => [
                    'show_badge' => 'yes',
                ],
                'default'   => 'danger',
            ]
        );
        

        $this->add_control(
            'show_floating_text',
            [
                'label'     => esc_html__( 'Mostrar texto flutuante', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        ); 

        $this->add_control(
            'floating_text',
            [
               'label'        => esc_html__( 'Texto flutuante', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'       => esc_html__( 'Conheça a viagem', 'epicjungle-elementor' ),
                'label_block' => true,
                'condition' => [ 
                    'show_floating_text' => 'yes' 
                ],
                
            ]
        );

        $this->add_control(
            'selected_item_icon',
            [
                'label'            => esc_html__( 'Ícone', 'epicjungle-elementor' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'item_icon',
                'default' => [
                    'value'   => 'fe-chevron-right',
                    'library' => 'fe-regular',
                ],
                'condition' => [ 
                    'show_floating_text' => 'yes' 
                ],

            ]
        );



            
        $this->end_injection();

        $this->start_controls_section(
            'section_label',
            [
                'label' => __( 'Título', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'     => __( 'Cor do título', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-inner .card-body h3' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .card-body h3',
            ]
        );

        $this->add_control(
            'title_css_class', [
                'label'   => esc_html__( 'Classe CSS do título', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'h5 pt-1 mb-3'


            ]
        );


        $this->end_controls_section();



        $this->start_controls_section(
            'section_date',
            [
                'label' => __( 'Data', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label'     => __( 'Cor da data', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-inner .card-body p.ej-offer-carousel-date' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .card-body p.ej-offer-carousel-date',
            ]
        );

        $this->add_control(
            'date_css_class', [
                'label'   => esc_html__( 'Classe CSS da data', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'font-size-sm text-muted mb-2'


            ]
        );


        $this->end_controls_section();




        $this->start_controls_section(
            'section_floating_text',
            [
                'label' => __( 'Texto flutuante', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                
            ]
        );

        $this->add_control(
            'floating_text_color',
            [
                'label'     => __( 'Cor do texto flutuante', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-inner .card .card-img-top .ej-floating-text' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'floating_text_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .card .card-img-top .ej-floating-text',
            ]
        );

        $this->add_control(
            'floating_text_css', [
                'label'   => esc_html__( 'Classe CSS do texto flutuante', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'text-light font-weight-medium'


            ]
        );


        $this->end_controls_section();

    }


    protected function add_repeater_controls( Repeater $repeater ) {
    	$enabled = Files_Upload_Handler::is_enabled();


		$repeater->add_control(
			'image',
			[
				'label' => __( 'Imagem', 'epicjungle-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

        $repeater->add_control(
            'image_link', [
                'label'       => esc_html__( 'Link da imagem', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        
       	$repeater->add_control(
			'title',
			[
				'label'   => __( 'Título', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Título', 'epicjungle-elementor' ),
			]
		);

        $repeater->add_control(
            'date',
            [
                'label' => __( 'Data', 'epicjungle-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
                 'altInput'=> true,
                'altFormat'=> "F j, Y",
                'dateFormat'=> "d-m-Y",
                //'default' =>  'Apr 19, 2022',
                'default' => gmdate( 'd-m-Y', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
                /* translators: %s: Time zone. */
                'description' => sprintf( __( 'Data definida de acordo com o seu fuso horário: %s.', 'epicjungle-elementor' ), Utils::get_timezone_string() ),
            
            ]

        );

        $repeater->add_control(
            'badge_text', [
                'label'     => esc_html__( 'Texto do emblema', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '$100',
                // 'condition' => [
                //     'show_badge' => 'yes',
                // ],

            ]
        );
        
	}

    protected function get_repeater_defaults() {
        $placeholder_image_src = Utils::get_placeholder_image_src();

        $defaults  = [];
        $titles     = [ 'Curitiba/São Paulo', 'São Paulo/Rio de Janeiro', 'Bauneário Camboriú/Curitiba' ];
        $date      = [ '04 Apr, 2022','15 Jun, 2022', '19 Sep, 2022' ];
        $badge_text      = [ 'R$25','R$40', 'R$60' ];

        foreach( $titles as $key => $title ) {
            $defaults[] = [
                'title'    => $title,
                'image'   => [ 'url' => $placeholder_image_src ],
                'image_link'    => '#',
                'date'    =>  $date[ $key ],
                'badge_text' => $badge_text[ $key ]
            ];
        }

        return $defaults;


    }


	protected function print_slide( array $slide, array $settings, $element_key ) {
	 
        if( empty( $slide['image']['url'] ) ) {
            $slide['image']['url'] = Utils::get_placeholder_image_src();
        }

	 	$migration_allowed = Icons_Manager::is_migration_allowed();
	 	$enabled           = Files_Upload_Handler::is_enabled();

        ob_start();
            $migrated = isset( $settings['__fa4_migrated']['selected_item_icon'] );
            // add old default
            if ( ! isset( $settings['item_icon'] ) && ! $migration_allowed ) {
                $settings['item_icon'] = 'fe-check';
            }

            $is_new = ! isset( $settings['item_icon'] ) && $migration_allowed;

            if ( ! empty( $settings['item_icon'] ) || ( ! empty( $settings['selected_item_icon']['value'] ) && $is_new ) ) :
                if ( $is_new || $migrated ) : ?>

                <?php Icons_Manager::render_icon( $settings['selected_item_icon'], [ 'aria-hidden' => 'true', 'class' => 'font-size-lg ml-1' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['item_icon'] ); ?> font-size-lg ml-1" aria-hidden="true"></i>
                <?php endif; ?>

            <?php endif;
        $floating_text_icon = ob_get_clean();


        

        $link_key = 'image-link_' . $element_key;
        $logo     = 'image_' . $element_key;
        $this->add_link_attributes( $link_key, $slide['image_link'] );

        $file_ext = pathinfo( $slide['image']['url'], PATHINFO_EXTENSION );
        $is_svg_logo = $file_ext === 'svg' ? true : false;
        $load_svg_logo = $this->files_upload_handler && isset( $slide['image_inline_svg'] ) && $slide['image_inline_svg'] === 'yes' && $is_svg_logo;

        ?>

        <a class="card border-0 box-shadow card-hover mx-1 ej-offers-carousel-link" <?php echo $this->get_render_attribute_string( $link_key ); ?>>

            <?php $this->add_render_attribute( 'floating_text', 'class', 'ej-floating-text card-floating-text' );


            if ( ! empty( $settings['floating_text_css'] ) ) {
                $this->add_render_attribute( 'floating_text', 'class', $settings['floating_text_css'] );
            }
            

            if ( $settings['show_badge'] == 'yes' ) {
                ?><span class="badge badge-lg badge-floating badge-floating-right badge-<?php echo esc_attr( $settings[ 'badge_color' ] ); ?>" style="width: 5rem;">
                    <?php echo $slide['badge_text']; ?>
                </span>
                <?php
            } ?>

           
            <div class="card-img-top card-img-gradient">
                <?php
                
                $this->add_render_attribute( $element_key . '-image', [
                    'src' => $slide['image']['url'],
                    'alt' => ! empty( $slide['title'] ) ? $slide['title'] : '',
                    'class' => $settings['image_class']
                ] );
                ?>
                
                <img <?php echo $this->get_render_attribute_string( $element_key . '-image' ); ?>>

                <?php if ( ! empty( $settings['floating_text'] ) && $settings['show_floating_text'] === 'yes' ) { ?>
                    <span <?php echo $this->get_render_attribute_string( 'floating_text' ); ?>><?php echo $settings['floating_text']; ?>
                    <?php echo wp_kses_post( $floating_text_icon ); ?>
                     
                    </span>
                <?php } ?>

               
            </div>

            <div class="card-body text-center">
               <?php $this->print_slide_label( $slide, $settings, 'image-slide-' . $slide['_id'] ); 
               $this->print_slide_date( $slide, $settings, 'image-slide-' . $slide['_id'] ); ?>
            </div>
         </a>
       
        <?php
    }

    protected function print_slide_label( array $slide, array $settings, $element_key ) {

        $title_css   = $settings['title_css_class' ];

        $this->add_render_attribute( 'title', 'class', '' );

        if ( ! empty( $title_css ) ) {
            $this->add_render_attribute( 'title', 'class', $title_css );
        }


        if ( ! empty( $slide['title'] ) ): ?>
            <h3  <?php echo $this->get_render_attribute_string( 'title' ); ?>>
                <?php echo $slide['title'];?>
            </h3><?php
        endif;  


    }

    protected function print_slide_date( array $slide, array $settings, $element_key ) {

        $date_css   = $settings['date_css_class' ];

        $this->add_render_attribute( 'date', 'class', 'ej-offer-carousel-date' );

        if ( ! empty( $date_css ) ) {
            $this->add_render_attribute( 'date', 'class', $date_css );
        }


        if ( ! empty( $slide['date'] ) ): ?>
            <p  <?php echo $this->get_render_attribute_string( 'date' ); ?>>
                <?php echo mysql2date( 'd/m/Y', $slide['date'] );?>
            </p><?php
        endif;  


    }

	protected function render() {
      
        $settings          = $this->get_settings_for_display();
        $this->files_upload_handler = Files_Upload_Handler::is_enabled();

        
        $default_settings  = [];

        $settings  = array_merge( $default_settings, $settings );

        $column    = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 2;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 3;
        $column_lg = ! empty( $settings['slides_per_view'] )        ? intval( $settings['slides_per_view'] )        : 3;

        $gutter    = ! empty( $settings['gutter_mobile']['size'] ) ? intval( $settings['gutter_mobile']['size'] ) : 16;
        $gutter_md = ! empty( $settings['gutter_tablet']['size'] ) ? intval( $settings['gutter_tablet']['size'] ) : 16;
        $gutter_lg = ! empty( $settings['gutter']['size'] )        ? intval( $settings['gutter']['size'] )        : 23;


        $content_carousel_settings = [
            'nav'               => false,
            'autoHeight'        => true,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'mode'              => 'carousel',
            'autoplay'          => isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ? true : false,
            'items'             => $this->get_settings( 'slides_per_view' ),
            'responsive'        => array (
                '0'       => array( 'items'   => 1, 'gutter' => $gutter ),
                '540'     => array( 'items'   => $column, 'gutter' => $gutter ),
                '900'     => array( 'items'   => $column_md, 'gutter' => $gutter_md ),
                '1100'    => array( 'items'   => $column_lg, 'gutter' => $gutter_lg ),
            )
        ];


        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $content_carousel_settings['autoplayTimeout'] = $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 6000;
            $content_carousel_settings['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

        
        $this->add_render_attribute(
            'featured-post-carousel-inner', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 

        ?>
        <div class="cs-carousel epicjungle-offers-carousel">
            <?php if ( $settings['enable_progress_bar'] === 'yes' ): ?>
                <div class="cs-carousel-progress ml-auto mb-3">
                    <div class="text-sm text-muted text-center mb-2">
                        <span class="cs-current-slide mr-1"></span><?php echo esc_html__('de', 'epicjungle-elementor');?><span class="cs-total-slides ml-1"></span>
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar"></div>
                    </div>
                </div>
            <?php endif; ?>

            <div <?php echo $this->get_render_attribute_string( 'featured-post-carousel-inner' ); ?>>
                <?php foreach ( $settings['slides'] as $slide ) : ?>
                    <div class="pb-2">
                      
                        <?php $this->print_slide( $slide, $settings, 'image-slide-' . $slide['_id'] ); ?>
                   
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        	
       
	<?php
        
    }

}