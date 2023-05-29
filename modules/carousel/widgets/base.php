<?php
namespace EpicJungleElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use EpicJungleElementor\Base\Base_Widget;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use Elementor\Group_Control_Image_Size;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Base extends Base_Widget {

	private $slide_prints_count = 0;

	public function get_script_depends() {
		return [ 'imagesloaded', 'jquery', 'tiny-slider' ];

	}

	abstract protected function add_repeater_controls( Repeater $repeater );

	abstract protected function get_repeater_defaults();

	abstract protected function print_slide( array $slide, array $settings, $element_key );


	protected function register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label'    => esc_html__( 'Slides', 'epicjungle-elementor' ),
				'tab'      => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$this->add_repeater_controls( $repeater );

		$this->add_control(
			'slides',
			[
				'label'     => esc_html__( 'Slides', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeater->get_controls(),
				'default'   => $this->get_repeater_defaults(),
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Slides por visualização', 'epicjungle-elementor' ),
				'options' => [
					''  => __( 'Padrão', 'epicjungle-elementor' ),
					'1' => __( '1', 'epicjungle-elementor' ),
					'2' => __( '2', 'epicjungle-elementor' ),
					'3' => __( '3', 'epicjungle-elementor' ),
					'4' => __( '4', 'epicjungle-elementor' ),
					'5' => __( '5', 'epicjungle-elementor' ),
					'6' => __( '6', 'epicjungle-elementor' ),
				],
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Opções adicionais', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'controls',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Setas', 'epicjungle-elementor' ),
				'default'      => 'yes',
				'label_off'    => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'label_on'     => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'prefix_class' => 'elementor-arrows-',
				'render_type'  => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'controls_position',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Posição dos controles', 'epicjungle-elementor' ),
				'options' => [
					'cs-controls-center'  => esc_html__( 'Centro', 'epicjungle-elementor' ),
					'cs-controls-left'    => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
					'cs-controls-right'   => esc_html__( 'Direita', 'epicjungle-elementor' ),
					'cs-controls-inside'  => esc_html__( 'Dentro', 'epicjungle-elementor' ),
					'cs-controls-outside' => esc_html__( 'Fora', 'epicjungle-elementor' ),
					'cs-controls-onhover' => esc_html__( 'Ao passar o mouse', 'epicjungle-elementor' ),
					
				],
				'default'      => 'cs-controls-right',
				'condition' => [
					'controls' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'nav',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Pontos', 'epicjungle-elementor' ),
				'default'      => 'false',
				'label_off'    => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'label_on'     => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'prefix_class' => 'elementor-pagination-',
				'render_type'  => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'nav_position',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Posição dos pontos', 'epicjungle-elementor' ),
				'default'      => 'false',
				'label_off'    => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'label_on'     => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'prefix_class' => 'elementor-pagination-',
				'render_type'  => 'template',
				'frontend_available' => true,
				'condition' => [
					'nav' => 'yes',
				],
			]
		);

		$this->add_control(
			'nav_skin',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Estilo dos pontos', 'epicjungle-elementor' ),
				'default'      => 'false',
				'label_off'    => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'label_on'     => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'prefix_class' => 'elementor-pagination-',
				'render_type'  => 'template',
				'frontend_available' => true,
				'condition' => [
					'nav' => 'yes',
				],
			]
		);



		$this->add_control(
			'loop',
			[
				'label'      => esc_html__( 'Loop infinito', 'epicjungle-elementor' ),
				'type'       => Controls_Manager::SWITCHER,
				'default'    => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => esc_html__( 'Reprodução automática', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'separator' => 'before',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'autoheight',
			[
				'label'     => esc_html__( 'Altura automática', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'separator' => 'before',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Velocidade de reprodução automática', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1500,
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'     => esc_html__( 'Pausar ao passar o mouse', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
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

        $this->add_responsive_control(
            'gutter',
            [
                'label'       => esc_html__( 'Preenchimento da calha', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'devices'     => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => 23,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '16',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px' ],
               
            ]
        );

		$this->end_controls_section();
	}

	protected function get_slide_image_url( $slide, array $settings ) {
		$image_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'image_size', $settings );

		if ( ! $image_url ) {
			$image_url = $slide['image']['url'];
		}
;
		return $image_url;
	}
}