<?php
namespace EpicJungleElementor\Modules\Map\Widgets;

use EpicJungleElementor\Base\Base_Widget;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Map extends Base_Widget {

	public function get_name() {
		return 'ej-map';
	}

	public function get_title() {
		return __( 'Mapa', 'epicjungle-elementor' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_keywords() {
		return [ 'map', 'embed', 'location' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_map',
			[
				'label' => esc_html__( 'Mapa', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'map_link',
			[
				'label' => __( 'Insira seu iFrame', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d230483.1797117837!2d-49.42988256603672!3d-25.495050066652695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dce35351cdb3dd%3A0x6d2f6ba5bacbe809!2sCuritiba%2C%20PR!5e0!3m2!1spt-BR!2sbr!4v1651600747709!5m2!1spt-BR!2sbr',
			]
		);

		$this->add_control(
            'map_image', [
                'label'   => __( 'Imagem', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default'   => [ 'url' => get_template_directory_uri() . '/assets/img/demo/coworking/map.jpg' ]
            ]
        );

        $this->add_control(
            'marker', [
                'label'   => __( 'Marcador', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [ 'url' => get_template_directory_uri() . '/assets/img/pages/contacts/marker.png' ]
            ]
        );

        $this->add_control(
            'gallery_item_css', [
                'label'         => esc_html__( 'Classe CSS', 'epicjungle-elementor' ),
                'type'          => Controls_Manager::TEXT,
                'title'         => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description'   => esc_html__( 'Classe aplicada ao item da galeria. ex: minha-classe', 'epicjungle-elementor' ),
                'default'       => 'rounded-lg'
            ]
        );

        $this->add_control(
            'marker_css', [
                'label'         => esc_html__( 'Classe CSS', 'epicjungle-elementor' ),
                'type'          => Controls_Manager::TEXT,
                'title'         => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description'   => esc_html__( 'Classe aplicada para wrapper de imagem de marcador', 'epicjungle-elementor' ),
                'default'       => ''
            ]
        );

        $this->add_control(
            'enable_bg_image',
            [
                'label'      => __( 'Ativar imagem de fundo', 'epicjungle-elementor' ),
                'type'       => Controls_Manager::SWITCHER,
                'label_on'   => __( 'Mostrar', 'epicjungle-elementor' ),
                'label_off'  => __( 'Ocultar', 'epicjungle-elementor' ),
                'default'    => 'no',
            ]
        );

		
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$gallery_item_css   = $settings['gallery_item_css' ];
		$marker_css   = $settings['marker_css' ];

        $this->add_render_attribute( 'gallery_item_css', 'class', [
        	'cs-gallery-item', 
        	'cs-map-popup' 
        ] );

        if ( ! empty( $gallery_item_css ) ) {
            $this->add_render_attribute( 'gallery_item_css', 'class', $gallery_item_css );
        }

        $this->add_render_attribute( 'marker_css', 'class', [
        	'map__marker', 
        ] );

        if ( ! empty( $marker_css ) ) {
            $this->add_render_attribute( 'marker_css', 'class', $marker_css );
        }

		?><div class="cs-gallery">
			<a <?php echo $this->get_render_attribute_string( 'gallery_item_css' ); ?> <?php if ( $settings['enable_bg_image'] === 'yes' ) : ?> style="background-image: url( <?php echo $settings['map_image']['url']; ?> )" <?php endif; ?> href="<?php echo $settings[ 'map_link' ] ?>" data-iframe="true" data-sub-html="&lt;h6 class=&quot;font-size-sm text-light&quot;&gt;396 Lillian Blvd, Holbrook, NY 11741&lt;/h6&gt;" >

	            <?php if ( $settings['enable_bg_image'] === 'no' ) : ?>
	                <img src="<?php echo $settings['map_image']['url'] ?>" alt="Maps"/>
	            <?php endif; ?>
				<span class="cs-gallery-caption">
					<i class="fe-maximize-2 font-size-xl mt-n1 mr-2"></i>
					<?php echo esc_html__('Expandir o mapa', 'epicjungle-elementor'); ?>
				</span>
                <div <?php echo $this->get_render_attribute_string( 'marker_css' ); ?>>
                	<img src="<?php echo $settings['marker']['url']; ?>" alt="Map marker"/>
                </div>
            </a>
        </div>
		<?php

		
	}

	protected function content_template() {}
}
