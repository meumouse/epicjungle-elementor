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

class Hero_Image_Carousel extends Base {
	private $slide_prints_count = 0;
	private $files_upload_handler = false;

	public function get_name() {
        return 'ej-hero-image-carousel';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de imagem Hero', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_keywords() {
        return [ 'posts-carousel-without-image', 'posts', 'carousel', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
    }

   
    protected function register_controls() {
    	parent::register_controls();
    	$this->remove_control( 'slides_per_view' );
        $this->remove_control( 'controls' );
        $this->remove_control( 'nav' );
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
                'default'     => 'rounded',
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
            'show_background_image',
            [
                'label'     => esc_html__( 'Mostrar imagem de fundo', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        ); 

        $this->add_control(
            'bg_image',
            [
                'label' => __( 'Imagem de fundo', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
                'condition' => [ 
                    'show_background_image' => 'yes' 
                ],
            ]
        );

        $this->add_control(
            'show_label',
            [
                'label'     => esc_html__( 'Mostrar rótulo', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        );
        $this->end_injection();

        $this->start_controls_section(
            'section_label',
            [
                'label' => __( 'Rótulo', 'epicjungle-elementor' ),
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

        $this->add_control(
            'label_text_color',
            [
                'label'     => __( 'Cor do rótulo', 'epicjungle-elementor' ),
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
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .cs-carousel-label',
            ]
        );

        $this->add_control(
            'label_css_class', [
                'label'   => esc_html__( 'Classe CSS do rótulo', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'font-size-sm'


            ]
        );


        $this->end_controls_section();

    }


    protected function add_repeater_controls( Repeater $repeater ) {
    	$enabled = Files_Upload_Handler::is_enabled();

    	$default_icon             = [
			'value'               => 'fe fe-calendar',
			'library'             => 'fe-regular',
		];

		$repeater->add_control(
			'logo',
			[
				'label' => __( 'Imagem', 'epicjungle-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

        $repeater->add_control(
            'logo_link', [
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
			'label',
			[
				'label'   => __( 'Rótulo', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Agendamento de equipe', 'epicjungle-elementor' ),
			]
		);

        $repeater->add_control(
            'selected_item_icon',
            [
                'label'            => esc_html__( 'Ícone', 'epicjungle-elementor' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'item_icon',
                'default' => [
                    'value'   => 'fe fe-calendar',
                    'library' => 'fe-regular',
                ],

            ]
        );
        
        
	}

    protected function get_repeater_defaults() {
        $placeholder_image_src = Utils::get_placeholder_image_src();

        $defaults  = [];
        $label     = [ 'Agendamento de equipe', 'Gerenciamento de contas', 'Mensagens incorporadas' ];
        $icons  = [ 'fe fe-calendar','fe fe-user', 'fe fe-mail' ];

        foreach( $icons as $key => $icon ) {
            $defaults[] = [
                'selected_item_icon' => [ 'value' => $icon ],
                'label'    => $label[ $key ],
                'logo'     => [ 'url' => $placeholder_image_src ]
            ];
        }

        return $defaults;


    }


	protected function print_slide( array $slide, array $settings, $element_key ) {
	 	if( empty( $slide['logo']['url'] ) ) {
            return;
        }
	 	$migration_allowed = Icons_Manager::is_migration_allowed();
	 	$enabled           = Files_Upload_Handler::is_enabled();

        if ( ! empty( $slide['logo']['url'] ) ) {
            $this->add_render_attribute( $element_key . '-logo', [
                'src'   => $slide['logo']['url'],
                'alt'   => 'image',
                'class' => 'img-fluid mb-5 w-50 mx-auto',
            ] );
        }
        
        ob_start();
			$migrated = isset( $slide['__fa4_migrated']['selected_item_icon'] );
			// add old default
			if ( ! isset( $slide['item_icon'] ) && ! $migration_allowed ) {
				$slide['item_icon'] = 'fe-check';
			}

			$is_new = ! isset( $slide['item_icon'] ) && $migration_allowed;

			if ( ! empty( $slide['item_icon'] ) || ( ! empty( $slide['selected_item_icon']['value'] ) && $is_new ) ) :
				if ( $is_new || $migrated ) : ?>

				<?php Icons_Manager::render_icon( $slide['selected_item_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i class="<?php echo esc_attr( $slide['item_icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>

			<?php endif;
		$image_carousel_icon = ob_get_clean();


        $link_key = 'logo-link_' . $element_key;
        $logo     = 'logo_' . $element_key;
        $this->add_link_attributes( $link_key, $slide['logo_link'] );

        $file_ext = pathinfo( $slide['logo']['url'], PATHINFO_EXTENSION );
        $is_svg_logo = $file_ext === 'svg' ? true : false;
        $load_svg_logo = $this->files_upload_handler && isset( $slide['logo_inline_svg'] ) && $slide['logo_inline_svg'] === 'yes' && $is_svg_logo;

        ?>

        <div data-carousel-label='<?php echo esc_attr( $image_carousel_icon ); ?><span><?php echo $slide['label']; ?></span>'>
            <?php
            
            $this->add_render_attribute( $element_key . '-image', [
                'src' => $slide['logo']['url'],
                'alt' => ! empty( $slide['label'] ) ? $slide['label'] : '',
                'class' => $settings['image_class']
            ] );
            ?>
            <a class="ej-hero-image-carousel-link" <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                <img <?php echo $this->get_render_attribute_string( $element_key . '-image' ); ?>>
            </a>
               
        </div>
       
        <?php
    }

    protected function print_slide_label( array $slide, array $settings, $element_key ) {

        $label_css   = $settings['label_css_class' ];

        $this->add_render_attribute( 'label', 'class', '' );

        if ( ! empty( $label_css ) ) {
            $this->add_render_attribute( 'label', 'class', $label_css );
        }


        $migration_allowed = Icons_Manager::is_migration_allowed();

        $migrated = isset( $slide['__fa4_migrated']['selected_item_icon'] );
        // add old default
        if ( ! isset( $slide['item_icon'] ) && ! $migration_allowed ) {
            $slide['item_icon'] = 'fe-check';
        }

        $is_new = ! isset( $slide['item_icon'] ) && $migration_allowed;

        if ( ! empty( $slide['item_icon'] ) || ( ! empty( $slide['selected_item_icon']['value'] ) && $is_new ) ) :
            if ( $is_new || $migrated ) : ?>

                <?php Icons_Manager::render_icon( $slide['selected_item_icon'], [ 'aria-hidden' => 'true' ] );
            else : ?>
                    <i class="<?php echo esc_attr( $slide['item_icon'] ); ?>" aria-hidden="true"></i>
            <?php endif; ?>

        <?php endif; ?>
        <?php if ( ! empty( $slide['label'] ) ): ?>
            <span  <?php echo $this->get_render_attribute_string( 'label' ); ?>>
                <?php echo $slide['label'];?>
            </span><?php
        endif;  


    }

	protected function render() {
        $uniqId            = 'image-carousel-' . $this->get_id();
        $settings          = $this->get_settings_for_display();
        $this->files_upload_handler = Files_Upload_Handler::is_enabled();
        $migration_allowed = Icons_Manager::is_migration_allowed();

        $default_settings  = [];

        $settings  = array_merge( $default_settings, $settings );

        $content_carousel_settings = [
            'nav'               => false,
            'autoHeight'        => true,
            'controls'          => false,
            'mode'              => 'gallery',
            'autoplay'          => isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ? true : false,
        ];


        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
            $content_carousel_settings['autoplayTimeout'] = $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 6000;
            $content_carousel_settings['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

        
        $this->add_render_attribute(
            'image-carousel', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 

        ?>
        <div class="cs-carousel bg-size-cover mx-auto pt-6 pb-2 epicjungle-image-carousel"<?php if ( $settings['show_background_image'] === 'yes' && ! empty ( $settings['bg_image']['url'] ) ):?> style="max-width: 705px;background-image: url(<?php echo esc_url( $settings["bg_image"]["url"] )?> );"<?php endif; ?>>
        	
            <div class="position-relative">
                
               <?php if  ( $settings['show_label'] === 'yes' ) : ?>
                    <div class="cs-frame-browser-label">
                        <div <?php echo $this->get_render_attribute_string( 'image-carousel' ); ?>>
                            <?php foreach ( $settings['slides'] as $index => $slide ) : ?>
                                <div class="cs-carousel-label-inner">
                                    <div class="cs-carousel-label"><?php
                                    $this->slide_prints_count++;
                                    $this->print_slide_label( $slide, $settings, 'content-slide-' . $index . '-' . $this->slide_prints_count ); ?>
                                    </div>
                                </div><?php
                           
                            endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
               
      
              <div class="cs-frame-browser-body">
	            <div <?php echo $this->get_render_attribute_string( 'image-carousel' ); ?>><?php
			       foreach ( $settings['slides'] as $index => $slide ) :
			            $this->slide_prints_count++;
			            $this->print_slide( $slide, $settings, 'content-slide-' . $index . '-' . $this->slide_prints_count );
			        endforeach; ?>
			    </div>
			</div>
		</div>

      

        <div class="cs-carousel-pager pt-4 text-nowrap text-center mt-4">
             <?php foreach ( $settings['slides'] as $key => $slide ) : 
                if ( count( $settings['slides'] ) > 1 ) {
                    $test = $key+1; ?>
                    <button class="<?php if ( $test == 1 ) echo esc_attr( ' active' ); ?>" data-nav data-goto="<?php echo esc_attr ( $test );?>"></button>
                <?php }
            endforeach; ?>
          
        </div>
   
       
	</div><?php
        
    }

}