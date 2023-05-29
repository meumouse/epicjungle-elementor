<?php
namespace EpicJungleElementor\Modules\Pricing\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
//use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use EpicJungleElementor\Modules\Pricing\Skins;
use EpicJungleElementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Pricing extends Base_Widget {
	
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Horizontal( $this ) );
		$this->add_skin( new Skins\Skin_Featured( $this ) );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ej-pricing';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Preços', 'epicjungle-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-price-table';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'pricing', 'table' ];
	}

	protected function register_controls() {

		// Content Tab
		$this->pricing_table_general_controls_content_tab();

		$this->pricing_table_skins_add_controls();

		$this->pricing_table_heading_controls_content_tab();
		$this->pricing_table_price_controls_content_tab();
		$this->pricing_table_features_controls_content_tab();
		$this->pricing_table_button_controls_content_tab();

		// Style Tab

		$this->pricing_table_heading_controls_style_tab();
		$this->pricing_table_price_controls_style_tab();
		$this->pricing_table_features_controls_style_tab();
		$this->pricing_table_button_controls_style_tab();
	}

	public function pricing_table_skins_add_controls() {

		// Heading Content Tab Start
		$this->start_controls_section(
			'skin_header',
			[
				'label'      => esc_html__( 'Cabeçalho', 'epicjungle-elementor' ),
				'condition'  => [
					'_skin'  => 'featured'
				],

			]
		);

		$this->add_control(
			'skin_featured_heading',
			[
				'label'     => esc_html__( 'Cabeçalho', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Premium', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'skin_featured_heading_tag',
			[
				'label'    => esc_html__( 'Tag de título HTML', 'epicjungle-elementor' ),
				'type'     => Controls_Manager::SELECT,
				'options'  => [
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'SPAN',
				],
				'default'  => 'h3',
			]
		);


		$this->add_control(
			'skin_featured_heading_background_color',
			[
				'label'   => esc_html__( 'Cor de fundo do título', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'primary'   => 'Primary',
					'secondary' => 'Secondary',
					'success'   => 'Success',
					'danger'    => 'Danger',
					'warning'   => 'Warning',
					'info'      => 'Info',
					'light'     => 'Light',
					'dark'      => 'Dark',
					'gradient'  => 'Gradient'
				],
				'default'       => 'gradient',
			]
		);

		// Heading Content Tab End
		$this->end_controls_section();


		$this->start_controls_section(
			'skin_section_title',
			[
				'label'       => esc_html__( 'Título', 'epicjungle-elementor' ),
				'condition'   => [
					'_skin'   => 'horizontal'
				],
			]
		);
	

		$this->add_control(
			'skin_title',
			[
				'label'     => esc_html__( 'Título', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Grátis', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'skin_title_tag',
			[
				'label'    => esc_html__( 'Título HTML Tag', 'epicjungle-elementor' ),
				'type'     => Controls_Manager::SELECT,
				'options'  => [
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'SPAN',
				],
				'default'  => 'h3',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'skin_section_title_style',
			[
				'label'       => esc_html__( 'Título', 'epicjungle-elementor' ),
				'tab'         => Controls_Manager::TAB_STYLE,
				'show_label'  => false,
				'condition'   => [
					'_skin'   => 'horizontal',
				],
			]
		);

		$this->add_control(
			'skin_title_color',
			[
				'label'      => esc_html__( 'Cor', 'epicjungle-elementor' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ej-elementor-price-table-skin__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'skin_title_typography',
				'selector'  => '{{WRAPPER}} .ej-elementor-price-table-skin__title',
				'scheme'    => Schemes\Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_responsive_control(
			'skin_title_width',
			[
				'label' => __( 'Largura máxima', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 100,
					],
					'rem' => [
						'min' => 10,
						'max' => 600,
					],
				],
				'default' => [
					'size' => 15,
					'unit' => 'rem',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'size_units' => [ '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__horizontal .ej-elementor-price-table__title' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'skin_section_description',
			[
				'label'     => esc_html__( 'Descrição', 'epicjungle-elementor' ),
				'condition' => [
					'_skin' => 'horizontal',
				],
			]
		);

		$this->add_control(
			'skin_description',
			[
				'label'    => esc_html__( 'Descrição', 'epicjungle-elementor' ),
				'type'     => Controls_Manager::TEXTAREA,
				'rows'     => 10,
				'default'  => esc_html__( 'Find aute irure dolor in reprehenderit in volatek', 'epicjungle-elementor' ),
				'placeholder' => esc_html__( 'Digite sua descrição aqui', 'epicjungle-elementor' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'skin_section_description_style',
			[
				'label'      => esc_html__( 'Descrição', 'epicjungle-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'_skin'  => 'horizontal',
				],
			]
		);

		$this->add_control(
			'skin_description_color',
			[
				'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table-skin__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'skin_description_typography',
				'selector' => '{{WRAPPER}} .ej-elementor-price-table-skin__description',
				'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
            'description_css_class', [
                'label'   => esc_html__( 'Descrição da classe CSS', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'font-size-xs'


            ]
        );

        $this->add_responsive_control(
			'skin_description_width',
			[
				'label' => __( 'Largura máxima', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 100,
					],
					'rem' => [
						'min' => 10,
						'max' => 600,
					],
				],
				'default' => [
					'size' => 20,
					'unit' => 'rem',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => '%',
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'size_units' => [ '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__horizontal .ej-elementor-price-table__price' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

		$this->end_controls_section();
		
	}

	public function pricing_table_general_controls_content_tab() {

		// General Content Tab Start
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'Geral', 'epicjungle-elementor' ),
			]
		);


		$this->add_control(
			'show_pricing_table_border',
			[
				'label'              => esc_html__( 'Mostrar borda?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'description'        => esc_html__( 'Ativar para exibir borda.', 'epicjungle-elementor' ),
				'frontend_available' => true,
				'condition'          => [
					'_skin'          => '',
				],
			]
		);


		$this->add_control(
			'show_pricing_table_box_shadow',
			[
				'label'              => esc_html__( 'Mostrar sombra da caixa?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'no',
				'description'        => esc_html__( 'Ative para exibir a sombra da caixa.', 'epicjungle-elementor' ),
				'frontend_available' => true,
				'condition'          => [
					'_skin'          => '',
				],
			]
		);


		$this->add_control(
			'show_price',
			[
				'label'              => esc_html__( 'Mostrar preço?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'description'        => esc_html__( 'Ative para exibir o preço.', 'epicjungle-elementor' ),
				'frontend_available' => true,
			]

		);

		$this->add_control(
			'show_features',
			[
				'label'              => esc_html__( 'Mostrar recursos?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'description'        => esc_html__( 'Ative para exibir recursos.', 'epicjungle-elementor' ),
				'frontend_available' => true,

			]
		);

		$this->add_control(
			'show_description',
			[
				'label'              => esc_html__( 'Mostrar descrição?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'description'        => esc_html__( 'Ative para exibir a descrição.', 'epicjungle-elementor' ),
				'frontend_available' => true,
				'condition'          => [ '_skin' => 'horizontal' ],
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'             => esc_html__( 'Mostrar botão?', 'epicjungle-elementor' ),
				'type'              => Controls_Manager::SWITCHER,
				'default'           => 'yes',
				'description'       => esc_html__( 'Ativar para exibir o botão.', 'epicjungle-elementor' ),
				'frontend_available'=> true,
				'condition'         => [
					'_skin!'        => 'horizontal',
				],
			]
		);


		// General Content Tab End
		$this->end_controls_section();
	}

	public function pricing_table_heading_controls_content_tab() {

		// Heading Content Tab Start
		$this->start_controls_section(
			'section_header',
			[
				'label'           => esc_html__( 'Cabeçalho', 'epicjungle-elementor' ),
				'condition'       => [
					'_skin'       => '',
				],
			]
		);

		$this->add_control(
			'heading',
			[
				'label'          => esc_html__( 'Cabeçalho', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::TEXT,
				'default'        => esc_html__( 'Grátis', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'         => esc_html__( 'Tag de título HTML', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::SELECT,
				'options'       => [
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'SPAN',
				],
				'default'  => 'h3',
			]
		);


		$this->add_control(
			'heading_background_color',
			[
				'label'           => esc_html__( 'Cor de fundo do título', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'primary'   => 'Primary',
					'secondary' => 'Secondary',
					'success'   => 'Success',
					'danger'    => 'Danger',
					'warning'   => 'Warning',
					'info'      => 'Info',
					'light'     => 'Light',
					'dark'      => 'Dark',
					'gradient'  => 'Gradient'
				],
				'default'       => 'secondary',
			]
		);

		// Heading Content Tab End
		$this->end_controls_section();
	}

	public function pricing_table_price_controls_content_tab() {

		// Pricing Content Tab Start
		$this->start_controls_section(
			'section_pricing',
			[
				'label'      => esc_html__( 'Preços', 'epicjungle-elementor' ),
				'condition'  => [ 
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'               => esc_html__( 'Currency Symbol', 'epicjungle-elementor' ),
				'type'                => Controls_Manager::SELECT,
				'options'             => [
					''                => esc_html__( 'None', 'epicjungle-elementor' ),
					'dollar'       => '&#36; ' . _x( 'Dólar', 'Currency Symbol', 'epicjungle-elementor' ),
					'euro'         => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'epicjungle-elementor' ),
					'baht'         => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'epicjungle-elementor' ),
					'franc'        => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'epicjungle-elementor' ),
					'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'epicjungle-elementor' ),
					'krona'        => 'kr ' . _x( 'Krona', 'Currency Symbol', 'epicjungle-elementor' ),
					'lira'         => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'epicjungle-elementor' ),
					'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'epicjungle-elementor' ),
					'peso'         => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'epicjungle-elementor' ),
					'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'epicjungle-elementor' ),
					'real'         => 'R$ ' . _x( 'Real brasileiro', 'Currency Symbol', 'epicjungle-elementor' ),
					'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'epicjungle-elementor' ),
					'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'epicjungle-elementor' ),
					'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'epicjungle-elementor' ),
					'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'epicjungle-elementor' ),
					'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'epicjungle-elementor' ),
					'won'          => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'epicjungle-elementor' ),
					'custom'       => esc_html__( 'Personalizado', 'epicjungle-elementor' ),
				],
				'default'          => 'real',
			]
		);

		$this->add_control(
			'currency_symbol_custom',
			[
				'label'               => esc_html__( 'Símbolo personalizado', 'epicjungle-elementor' ),
				'type'                => Controls_Manager::TEXT,
				'condition'           => [
					'currency_symbol' => 'custom',
				],
			]
		);

		$this->add_control(
			'price',
			[
				'label'               => esc_html__( 'Preço', 'epicjungle-elementor' ),
				'type'                => Controls_Manager::TEXT,
				'default'             => '0',
				'dynamic'             => [
					'active'          => true,
				],
			]
		);

		$this->add_control(
			'new_price',
			[
				'label'              => esc_html__( 'Novo preço', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::TEXT,
				'description'        => esc_html__( 'Este campo é usado para alternador de preços', 'epicjungle-elementor' ),
				'default'            => '0',
				'dynamic'            => [
					'active'         => true,
				],
				
			]
		);


		$this->add_control(
			'currency_format',
			[
				'label'             => esc_html__( 'Formato da moeda', 'epicjungle-elementor' ),
				'type'              => Controls_Manager::SELECT,
				'options'           => [
					''              => '1,234.56 (Default)',
					','             => '1.234,56',
				],
			]
		);


		$this->add_control(
			'price_subtext',
			[
				'label'            => esc_html__( 'Subtexto de preço', 'epicjungle-elementor' ),
				'type'             => Controls_Manager::TEXTAREA,
				'default'          => esc_html__( 'por mês', 'epicjungle-elementor' ),
			]
		);

		// Pricing Content Tab End
		$this->end_controls_section();
	}

	public function pricing_table_features_controls_content_tab() {

		// Recursos Content Tab Start
		$this->start_controls_section(
			'section_features',
			[
				'label'             => esc_html__( 'Recursos', 'epicjungle-elementor' ),
				'condition'         => [ 
					'show_features' => 'yes',
					
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label'            => esc_html__( 'Lista de texto', 'epicjungle-elementor' ),
				'type'             => Controls_Manager::TEXT,
				'default'          => esc_html__( 'Lista de itens', 'epicjungle-elementor' ),
			]
		);

		$repeater->add_control(
			'item_text_color',
			[
				'label'           => esc_html__( 'Lista de cor do texto', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::COLOR,
				'selectors'       => [
					'{{WRAPPER}} {{CURRENT_ITEM}} span'   => 'color: {{VALUE}}',
				],
				'default'         => '#737491'
			]
		);

		$default_icon             = [
			'value'               => 'fe fe-check',
			'library'             => 'fe-regular',
		];

		$repeater->add_control(
			'selected_item_icon',
			[
				'label'            => esc_html__( 'Ícone', 'epicjungle-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'item_icon',
				'default'          => $default_icon,
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label'           => esc_html__( 'Cor do ícone', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::COLOR,
				'selectors'       => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i'   => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}}',
				],
				'default'         => '#766df4'
			]
		);

		$repeater->add_control(
			'item_icon_size',

			[
				'label'          => esc_html__( 'Tamanho do ícone', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', '%', 'rem' ],
				'range'          => [
					'px'         => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
					'%'        => [
						'min'  => 0,
						'max'  => 100,
					],
					'rem'      => [
						'min'  => 0.1,
						'max'  => 10,
					],
				],
				'default'     => [
					'unit'    => 'rem',
					'size'    => 1.25,
				],


				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'font-size: {{SIZE}}{{UNIT}}',

				],
				
			]
		);



		$this->add_control(
			'features_list',
			[
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'item_text'          => esc_html__( '20 milhões de faixas', 'epicjungle-elementor' ),
						'selected_item_icon' => $default_icon,
					],
					[
						'item_text'          => esc_html__( 'Reprodução aleatória', 'epicjungle-elementor' ),
						'selected_item_icon' => $default_icon,
					],
					[
						'item_text'          => esc_html__( 'Sem anúncios', 'epicjungle-elementor' ),
						'selected_item_icon' => $default_icon,
					],
					[
						'item_text'          => esc_html__( 'Obtenha saltos ilimitados', 'epicjungle-elementor' ),
						'selected_item_icon' => $default_icon,
					],
					[
						'item_text'          => esc_html__( 'Modo offline', 'epicjungle-elementor' ),
						'selected_item_icon' => $default_icon,
					],
					[
						'item_text'          => esc_html__( '7 perfis', 'epicjungle-elementor' ),
						'selected_item_icon' => $default_icon,
					],
				],
				'title_field'                => '{{{ item_text }}}',
			]
		);

		// Recursos Content Tab End
		$this->end_controls_section();
	}

	public function pricing_table_button_controls_content_tab() {


		// Botão Content Tab Start
		$this->start_controls_section(
			'section_button',
			[
				'label'                    => esc_html__( 'Botão', 'epicjungle-elementor' ),
				'condition'                => [
					'show_button'          => 'yes',
					'_skin!'               => 'horizontal',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'                    => esc_html__( 'Botão de texto', 'epicjungle-elementor' ),
				'type'                     => Controls_Manager::TEXT,
				'default'                  => esc_html__( 'Comece agora', 'epicjungle-elementor' ),
				'placeholder'              => esc_html__( 'Clique aqui', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'                   => esc_html__( 'Link', 'epicjungle-elementor' ),
				'type'                    => Controls_Manager::URL,
				'dynamic'                 => [
					'active'              => true,
				],
				'placeholder'             => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
				'default'                 => [
					'url'                 => '#',
				],
			]
		);

		$this->add_control(
            'button_variant',
            [
                'label'                => esc_html__( 'Variante', 'epicjungle-elementor' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'outline',
                'options'              => [
                    ''                 => esc_html__( 'Padrão', 'epicjungle-elementor' ),
                    'outline'          => esc_html__( 'Contorno', 'epicjungle-elementor' ),
                    'translucent'      => esc_html__( 'Translúcido', 'epicjungle-elementor' ),
                ]
            ],
            [
                'position'            => [
                    'of'              => 'button_type'
                ]
            ]
        );

		$this->add_control(
			'button_type',
			[
				'label'              => esc_html__( 'Tipo', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'primary',
				'options'            => [
					'primary'     => esc_html__( 'Primário', 'epicjungle-elementor' ),
                    'secondary'   => esc_html__( 'Secundário', 'epicjungle-elementor' ),
                    'success'     => esc_html__( 'Sucesso', 'epicjungle-elementor' ),
                    'danger'      => esc_html__( 'Perigo', 'epicjungle-elementor' ),
                    'warning'     => esc_html__( 'Aviso', 'epicjungle-elementor' ),
                    'info'        => esc_html__( 'Informação', 'epicjungle-elementor' ),
                    'dark'        => esc_html__( 'Escuro', 'epicjungle-elementor' ),
                    'link'        => esc_html__( 'Link', 'epicjungle-elementor' ),
                    'gradient'    => esc_html__( 'Degradê', 'epicjungle-elementor' ),

				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'          => esc_html__( 'Tamanho', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'sm'    => esc_html__( 'Pequeno', 'epicjungle-elementor' ),
					''      => esc_html__( 'Base', 'epicjungle-elementor' ),
					'lg'    => esc_html__( 'Grande', 'epicjungle-elementor' ),
					'block' => esc_html__( 'Block', 'epicjungle-elementor' ),
				],
				'style_transfer' => true,
				'default'        => '',
			]
		);


		$this->add_control(
			'button_selected_icon',
			[
				'label'            => esc_html__( 'Ícone', 'epicjungle-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'button_icon',
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label'           => esc_html__( 'ID do botão', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::TEXT,
				'dynamic'         => [
					'active'      => true,
				],
				'default'         => '',
				'title'           => esc_html__( 'Adicione seu ID personalizado SEM a tecla de cerquilha. ex: meu-id', 'epicjungle-elementor' ),
				'description'     => esc_html__( 'Certifique-se de que o ID seja exclusivo e não seja usado em nenhum outro lugar da página em que este formulário é exibido. Este campo permite <code>A-z 0-9</code> e caracteres de sublinhado sem espaços.', 'epicjungle-elementor' ),
				'separator'       => 'before',
			]
		);

		// Botão Content Tab End
		$this->end_controls_section();
	}


	public function pricing_table_heading_controls_style_tab() {

		// Heading Style Tab Start
		$this->start_controls_section(
			'section_header_style',
			[
				'label'         => esc_html__( 'Cabeçalho', 'epicjungle-elementor' ),
				'tab'           => Controls_Manager::TAB_STYLE,
				'show_label'    => false,
                'condition'     => [
					'_skin'     => ['','featured' ]
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'         => esc_html__( 'Preenchimento', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'{{WRAPPER}} .ej-elementor-price-table__heading-container,
					{{WRAPPER}} .featured-card .ej-elementor-price-table__heading-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'        => esc_html__( 'Cor', 'epicjungle-elementor' ),
				'type'         => Controls_Manager::COLOR,
				'selectors'    => [
					'{{WRAPPER}} .ej-elementor-price-table__heading' => 'color: {{VALUE}}',
				],
				'default'      => '#737491',
				'condition'    => [
					'_skin'    => '',
				],
			]
		);

		$this->add_control(
			'skin_featured_heading_color',
			[
				'label'       => esc_html__( 'Cor', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .featured-card .ej-elementor-price-table__heading' => 'color: {{VALUE}}',
				],
				'default'     => '#ffffff',
				'condition'   => [
					'_skin'   => 'featured',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'        => 'heading_typography',
				'selector'    => '{{WRAPPER}} .ej-elementor-price-table__heading,
				 {{WRAPPER}} .featured-card .ej-elementor-price-table__heading',
				'scheme'      => Schemes\Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
            'heading_css_class', [
                'label'       => esc_html__( 'Classe CSS do cabeçalho', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'title'       => esc_html__( 'Adicione sua classe personalizada para o cartão em destaque. ex: card-active', 'epicjungle-elementor' ),
                'default'     => 'py-5 px-grid-gutter'


            ]
        );


		// Heading Style Tab End
		$this->end_controls_section();
	}

	public function pricing_table_price_controls_style_tab() {

		// Pricing Style Tab Start
		$this->start_controls_section(
			'section_pricing_element_style',
			[
				'label'          => esc_html__( 'Preços', 'epicjungle-elementor' ),
				'tab'            => Controls_Manager::TAB_STYLE,
				'show_label'     => false,
				'condition'      => [ 
					'show_price' => 'yes' ,
				],
			]
		);

		$this->add_control(
			'price_alignment',
			[
				'label'          => esc_html__( 'Alinhamento de preços', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::CHOOSE,
				'options'        => [
					'flex-start' => [
						'title'     => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
						'icon'      => 'eicon-text-align-left',
					],
					'center'     => [
						'title'     => esc_html__( 'Centro', 'epicjungle-elementor' ),
						'icon'      => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title'     => esc_html__( 'Direita', 'epicjungle-elementor' ),
						'icon'      => 'eicon-text-align-right',
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .ej-elementor-price-table__price' => 'justify-content: {{VALUE}}',
				],
				'default'        => 'flex-start',
				'condition'      => [ 
					'_skin!'     => 'horizontal',
				],
			]
		);

		$this->add_control(
			'currency_symbol_color',
			[
				'label'          => esc_html__( 'Cor do símbolo de moeda', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .ej-elementor-price-table__currency' => 'color: {{VALUE}}',
				],
				'default'        => '#9e9fb4',
				'separator'      => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'            => 'currency_symbol_typography',
				'selector'        => '{{WRAPPER}} .ej-elementor-price-table__currency',
				'scheme'          => Schemes\Typography::TYPOGRAPHY_1,
 	            'fields_options'  => [
 	            	 'typography' => ['default' => 'yes'],
					'font_weight' => [
						'default' => '400',
					],
					
					'font_size'   => [
						'default' => ['size' => 2, 'unit' => 'rem' ],
					],
				],

			]
		);


		$this->add_control(
			'price_color',
			[
				'label'          => esc_html__( 'Cor do preço', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .ej-elementor-price-table__integer-part' => 'color: {{VALUE}}',
				],
				'default'        => 'var(--ej-primary)',
				'separator'      => 'before',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'            => 'price_typography',
				'selector'        => '{{WRAPPER}} .ej-elementor-price-table__integer-part',
				'scheme'          => Schemes\Typography::TYPOGRAPHY_1,
				'fields_options'  => [
					'typography'  => ['default' => 'yes'],
					'font_weight' => [
						'default' => '400',
					],
					
					'font_size'   => [
						'default' => ['size' => 4, 'unit' => 'rem' ],
					],

					'line_height' => [
						'default' => ['size' => 76.8, 'unit' => 'px' ]
					],
				],

			]
		);

		$this->add_control(
			'heading_currency_style',
			[
				'label'          => esc_html__( 'Símbolo de moeda', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::HEADING,
				'separator'      => 'before',
				
			]
		);

		$this->add_control(
			'currency_position',
			[
				'label'         => esc_html__( 'Posição', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'before',
				'options'       => [
					'before'    => [
						'title'    => esc_html__( 'Antes', 'epicjungle-elementor' ),
						'icon'     => 'eicon-h-align-left',
					],
					'after'      => [
						'title'     => esc_html__( 'Depois', 'epicjungle-elementor' ),
						'icon'      => 'eicon-h-align-right',
					],
				],
			]
		);

		$this->add_control(
			'currency_vertical_position',
			[
				'label'        => esc_html__( 'Posição vertical', 'epicjungle-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'top'      => [
						'title'   => esc_html__( 'Superior', 'epicjungle-elementor' ),
						'icon'    => 'eicon-v-align-top',
					],
					'middle'   => [
						'title'   => esc_html__( 'Meio', 'epicjungle-elementor' ),
						'icon'    => 'eicon-v-align-middle',
					],
					'bottom'   => [
						'title'   => esc_html__( 'Inferior', 'epicjungle-elementor' ),
						'icon'    => 'eicon-v-align-bottom',
					],
				],
				'default'      => 'bottom',
				'selectors_dictionary' => [
					'top'              => 'flex-start',
					'middle'           => 'center',
					'bottom'           => 'flex-end',
				],
				'selectors'     => [
					'{{WRAPPER}} .ej-elementor-price-table__currency' => 'align-self: {{VALUE}}',
				],
				'condition'     => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'heading_price_subtext_style',
			[
				'label'       => esc_html__( 'Subtexto de preço', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::HEADING,
				'separator'   => 'before',
				'condition'   => [
					'price_subtext!' => '',
				],
			]
		);

		$this->add_control(
			'price_subtext_color',
			[
				'label'      => esc_html__( 'Cor', 'epicjungle-elementor' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ej-elementor-price-table__subtext' => 'color: {{VALUE}}',
				],
				'condition'  => [
					'price_subtext!' => '',
				],
				'default'    => '#9e9fb4',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_subtext_typography',
				'selector'  => '{{WRAPPER}} .ej-elementor-price-table__subtext',
				'scheme'    => Schemes\Typography::TYPOGRAPHY_2,
				'condition' => [
					'price_subtext!' => '',
				],
				'fields_options'  => [
					'typography'  => ['default' => 'yes'],
					'font_weight' => [
						'default' => '500',
					],
					
					'font_size'   => [
						'default' => ['size' => 1.125, 'unit' => 'rem' ],
					],

					'line_height' => [
						'default' => ['size' => 23.4, 'unit' => 'px' ]
					],
				],
				
			]
		);

		$this->add_control(
            'pricing_css_class', [
                'label'       => esc_html__( 'Classe CSS dos preços', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'title'       => esc_html__( 'Adicione sua classe personalizada para o cartão em destaque. por exemplo: card-active', 'epicjungle-elementor' ),
                'default'     => 'display-2 px-1 mr-2'


            ]
        );

		// Pricing Style Tab End
		$this->end_controls_section();
	}

	
	public function pricing_table_features_controls_style_tab() {

		// Recursos Style Tab Start
		$this->start_controls_section(
			'section_features_list_style',
			[
				'label'      => esc_html__( 'Recursos', 'epicjungle-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [ 
					'show_features' => 'yes',
					//'_skin' => '',
				],
			]
		);

		$this->add_responsive_control(
			'features_list_padding',
			[
				'label'      => esc_html__( 'Preenchimento', 'epicjungle-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ej-elementor-price-table__features-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		

		// $this->add_control(
		// 	'features_list_color',
		// 	[
		// 		'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
		// 		'type'      => Controls_Manager::COLOR,
		// 		'separator' => 'before',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .ej-elementor-price-table__features-list' => 'color: {{VALUE}}',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'features_list_typography',
				'selector' => '{{WRAPPER}} .ej-elementor-price-table__features-list .ej-list-item',
				'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'features_list_alignment',
			[
				'label'   => esc_html__( 'Alinhamento', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title'  => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
						'icon'   => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => esc_html__( 'Centro', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Direita', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__features-list .ej-list-item' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label'   => esc_html__( 'Largura', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'%'   => [
						'min' => 25,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__features-list' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		// Recursos Style Tab End
		$this->end_controls_section();
	}

	public function pricing_table_button_controls_style_tab() {

		// Botão Style Tab Start
		$this->start_controls_section(
			'section_button_style',
			[
				'label'      => esc_html__( 'Botão', 'epicjungle-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition'  => [
					'_skin!' => 'horizontal',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ej-elementor-price-table__button',
			]
		);

		 $this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'   => esc_html__( 'Normal', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'   => esc_html__( 'Cor do texto', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'   => esc_html__( 'Cor de fundo', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'button_text_hover_color',
			[
				'label'     => esc_html__( 'Cor do texto', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__button:hover, {{WRAPPER}} .ej-elementor-price-table__button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ej-elementor-price-table__button:hover svg, {{WRAPPER}} .ej-elementor-price-table__button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => esc_html__( 'Cor de fundo', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-price-table__button:hover, {{WRAPPER}} .ej-elementor-price-table__button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label'   => esc_html__( 'Animação ao passar o mouse', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Preenchimento', 'epicjungle-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ej-elementor-price-table__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_classes',
			[
				'label'     => esc_html__( 'Classe CSS do botão', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [
					'active'    => true,
				],
				'title'     => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
			]
		);

		// Botão Style Tab End
		$this->end_controls_section();
	}

	public function render_currency_symbol( $symbol, $location ) {
		$currency_position = $this->get_settings( 'currency_position' );
		$location_setting = ! empty( $currency_position ) ? $currency_position : 'before';
		if ( ! empty( $symbol ) && $location === $location_setting ) {
			echo '<span class="ej-elementor-price-table__currency h2 font-weight-normal text-muted ej-elementor-currency--' . $location . ' mb-1 mr-2">' . $symbol . '</span>';
		}
	}

	public function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar'    => '&#36;',
			'euro'      => '&#128;',
			'franc'     => '&#8355;',
			'pound'     => '&#163;',
			'ruble'     => '&#8381;',
			'shekel'    => '&#8362;',
			'baht'      => '&#3647;',
			'yen'       => '&#165;',
			'won'       => '&#8361;',
			'guilder'   => '&fnof;',
			'peso'      => '&#8369;',
			'peseta'    => '&#8359',
			'lira'      => '&#8356;',
			'rupee'     => '&#8360;',
			'indian_rupee' => '&#8377;',
			'real'      => 'R$',
			'krona'     => 'kr',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
	}

	/**
	 * Render Price Table widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$symbol = '';

		if ( ! empty( $settings['currency_symbol'] ) ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}

		$currency_format = empty( $settings['currency_format'] ) ? '.' : $settings['currency_format'];
		$price = explode( $currency_format, $settings['price'] );

		$intpart = $price[0];
		
		$this->add_render_attribute( 'button_text', 'class', [
			'ej-elementor-price-table__button',
			'btn',

		] );

		if ( 'outline' === $settings['button_variant'] ) {
            $btn_class = 'btn-outline-' . $settings['button_type'];
        } elseif ( 'translucent' === $settings['button_variant'] ) {
            $btn_class = 'btn-translucent-' . $settings['button_type'];
        } else {
            $btn_class = 'btn-' . $settings['button_type'];
        }
        $this->add_render_attribute( 'button_text', 'class', $btn_class );

		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button_text', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'button_text', $settings['link'] );
		}

		if ( ! empty( $settings[ 'button_classes' ] ) ) {
			$this->add_render_attribute( 'button_text', 'class', $settings['button_classes'] );
		}


		$this->add_render_attribute( 'heading', 'class', 'ej-elementor-price-table__heading mb-0' );

		$this->add_render_attribute( 'price_subtext', 'class', [ 'ej-elementor-price-table__subtext mb-2' ]);
		$this->add_render_attribute( 'pricing_box_description', 'class', 'ej-elementor-price-table__description' );

		$this->add_inline_editing_attributes( 'heading' );
		$this->add_inline_editing_attributes( 'price_subtext' );
		$this->add_inline_editing_attributes( 'button_text' );
		$this->add_inline_editing_attributes( 'pricing_box_description' );


		$heading_tag = $settings['heading_tag'];
		

		$migration_allowed = Icons_Manager::is_migration_allowed();
		$button_icon_migrated = isset( $settings['__fa4_migrated']['button_selected_icon'] );
		$is_new_button_icon = empty( $settings['button_icon'] ) && $migration_allowed;

		// Pricing Table Header Content
		ob_start();
			?><div class="ej-elementor-price-table__heading-container text-center card-img-top bg-<?php echo esc_attr( $settings[ 'heading_background_color' ] ); ?> <?php echo esc_attr( $settings[ 'heading_css_class' ] ); ?>">
				<<?php echo $heading_tag . ' ' . $this->get_render_attribute_string( 'heading' ); ?>><?php echo $settings['heading'] . '</' . $heading_tag; ?>>
			</div><?php 
		$pricing_table_header_content = ob_get_clean();


		// Pricing Table Price Content
		ob_start();

		if (  '' !== $settings['price'] && $settings[ 'show_price' ] == 'yes' ): ?>
			<div class="ej-elementor-price-table__price d-flex align-items-end py-2 px-4 mb-4">
				
				<?php if ( '' !== $settings['price'] ) : $this->render_currency_symbol( $symbol, 'before' ); endif;?>

				<?php if ( ( ! empty( $intpart ) || 0 <= $intpart ) ) : ?>
					<span class="ej-elementor-price-table__integer-part price cs-price  <?php echo esc_attr( $settings[ 'pricing_css_class' ] ); ?>" data-current-price="<?php echo esc_attr( $settings['price']); ?>" data-new-price="<?php echo esc_attr( $settings['new_price']); ?>"><?php echo $intpart; ?></span>
				<?php endif; ?>

				<?php if ( '' !== $settings['price'] ) : $this->render_currency_symbol( $symbol, 'after' ); endif;?>
					
				<?php if ( '' !== $settings['price']  && ! empty( $settings['price_subtext'] ) ): ?>
					<span <?php echo $this->get_render_attribute_string( 'price_subtext' ); ?>><?php echo wp_kses_post( $settings['price_subtext']); ?></span>
				<?php endif; ?>

			</div>
		<?php endif;
		$pricing_table_price_content = ob_get_clean();

		// Pricing Table Description Content
		ob_start();
			if ( $settings[ 'show_description' ] == 'yes' && ! empty( $settings['pricing_box_description'] ) ): ?>
				<p <?php echo $this->get_render_attribute_string( 'pricing_box_description' ); ?>><?php echo $settings['pricing_box_description']; ?></p>
			<?php endif;
		$pricing_table_desciption_content = ob_get_clean();

		// Pricing Table Recursos Content
		ob_start();
			if ( ! empty( $settings['features_list'] ) && $settings[ 'show_features' ] == 'yes' ) : ?>
				<ul class="ej-elementor-price-table__features-list list-unstyled py-2 mb-4">
					<?php
					foreach ( $settings['features_list'] as $index => $item ) :
						$repeater_setting_key = $this->get_repeater_setting_key( 'item_text', 'features_list', $index );


						$this->add_inline_editing_attributes( $repeater_setting_key );

						$migrated = isset( $item['__fa4_migrated']['selected_item_icon'] );
						// add old default
						if ( ! isset( $item['item_icon'] ) && ! $migration_allowed ) {
							$item['item_icon'] = 'fe-check';
						}
						$is_new = ! isset( $item['item_icon'] ) && $migration_allowed;
						
						?>
						<li class="ej-list-item elementor-repeater-item-<?php echo $item['_id']; ?> d-flex align-items-center mb-3">
							<?php if ( ! empty( $item['item_icon'] ) || ! empty( $item['selected_item_icon'] ) ) : ?>

								<?php if ( $is_new || $migrated ) : ?>

								<?php Icons_Manager::render_icon( $item['selected_item_icon'], ['aria-hidden' => 'true', 'class' => 'mr-2']);
								else : ?>
									<i class="<?php echo esc_attr( $item['item_icon'] ); ?> mr-2" aria-hidden="true"></i>
								<?php endif; ?>

							<?php endif; ?>
							<?php if ( ! empty( $item['item_text'] ) ) : ?>
								<span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['item_text']; ?></span>
							<?php else :
								echo '&nbsp;';
							endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif;
		$pricing_table_features_content = ob_get_clean();

		// Pricing Table Botão Content
		ob_start();
			if ( ! empty( $settings['button_text'] ) && $settings[ 'show_button' ] == 'yes' ) : ?>
				<div class="text-center mb-2">
					<a <?php if ( $settings[ 'button_css_id' ] ): ?>id="<?php echo esc_attr( $settings[ 'button_css_id' ] ); ?>"<?php endif; ?> <?php echo $this->get_render_attribute_string( 'button_text' ); ?>>		
						<?php echo $settings['button_text']; ?>
						<?php if ( ! empty( $settings['button_icon'] ) || ! empty( $settings['button_selected_icon']['value'] ) ) : ?>
							<?php if ( $is_new_button_icon || $button_icon_migrated ) :
								Icons_Manager::render_icon( $settings['button_selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'ml-2' ] );
							else : ?>
								<i class="<?php echo esc_attr( $settings['button_icon'] ); ?> ml-2" aria-hidden="true"></i>
							<?php endif; ?>
						<?php endif; ?>
					</a>
				</div>
			<?php endif;
		$pricing_table_button_content = ob_get_clean();

		?>
		
		<div class="ej-elementor-price-table card w-100<?php echo esc_attr( $settings['show_pricing_table_border'] !== 'yes' ? ' border-0' : '');?><?php echo esc_attr( $settings['show_pricing_table_box_shadow'] == 'yes' ? ' box-shadow' : '');?>">

			<?php 
				if ( $settings['heading'] && ! empty( $settings['heading'] ) ): ?>
				<?php echo wp_kses_post( $pricing_table_header_content ); ?>

			<?php endif; ?>
			<div class="card-body px-grid-gutter py-grid-gutter"><?php
				echo wp_kses_post( $pricing_table_price_content );
				echo wp_kses_post( $pricing_table_desciption_content );
				echo wp_kses_post( $pricing_table_features_content ); 
				echo wp_kses_post( $pricing_table_button_content ); ?>
			</div>
		</div>	
				
		<?php
	}

	/**
	 * Render Price Table widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
			let symbols = {
				dollar: '&#36;',
				euro: '&#128;',
				franc: '&#8355;',
				pound: '&#163;',
				ruble: '&#8381;',
				shekel: '&#8362;',
				baht: '&#3647;',
				yen: '&#165;',
				won: '&#8361;',
				guilder: '&fnof;',
				peso: '&#8369;',
				peseta: '&#8359;',
				lira: '&#8356;',
				rupee: '&#8360;',
				indian_rupee: '&#8377;',
				real: 'R$',
				krona: 'kr'
			};

			let symbol = '',
				iconsHTML = {};
				
			

			if ( settings.currency_symbol ) {
				if ( 'custom' !== settings.currency_symbol ) {
					symbol = symbols[ settings.currency_symbol ] || '';
				} else {
					symbol = settings.currency_symbol_custom;
				}
			}


			let buttonClasses = 'ej-elementor-price-table__button btn';

			
			if ( settings.button_size ) {
				buttonClasses += ' btn-' + settings.button_size;
			}

			
			if ( settings.hover_animation ) {
				buttonClasses += ' elementor-animation-' + settings.hover_animation;
			}

			
			if ( settings.button_classes ) {
				buttonClasses += ' ' + settings.button_classes;
			}

			if ( 'outline' === settings.button_variant ) {
            	buttonClasses = 'btn-outline-' . settings.button_type;
	        } elseif ( 'translucent' === settings.button_variant ) {
	            buttonClasses = 'btn-translucent-' . settings.button_type;
	        } else {
	            buttonClasses = 'btn-' . settings.button_type;
	        }
	        view.addRenderAttribute( 'button_text', 'class', buttonClasses );

			let buttonIconHTML = elementor.helpers.renderIcon( view, settings.button_selected_icon, { 'aria-hidden': true, 'class': 'ml-2' }, 'i' , 'object' );

			let buttonIconMigrated = elementor.helpers.isIconMigrated( settings, 'button_selected_icon' );

			view.addRenderAttribute( 'heading', 'class', 'ej-elementor-price-table__heading' );


			view.addRenderAttribute( 'period', 'class', [ 'ej-elementor-price-table__period', 'ej-elementor-typo-excluded', 'h2', 'align-self-end', 'mb-1' ] );

			view.addRenderAttribute( 'price_subtext', 'class', [ 'ej-elementor-price-table__subtext mb-2' ]);
        	view.addRenderAttribute( 'pricing_box_description', 'class', 'ej-elementor-price-table__description' );


			view.addRenderAttribute( 'button_text', 'class', buttonClasses  );
			

			view.addInlineEditingAttributes( 'heading' );
			view.addInlineEditingAttributes( 'period' );
			view.addInlineEditingAttributes( 'price_subtext' );
			view.addInlineEditingAttributes( 'button_text' );
			view.addInlineEditingAttributes( 'pricing_box_description' );

			let currencyFormat = settings.currency_format || '.';
			let	price = settings.price.split( currencyFormat );
			let	intpart = price[0];
			let	fraction = price[1];
			let	periodElement = '<span ' + view.getRenderAttributeString( "period" ) + '>' + settings.period + '</span>';
		#>
		
		<div class="ej-elementor-price-table card w-100<# settings.show_pricing_table_border !== 'yes' ? ' border-0' : '' #><# settings.show_pricing_table_box_shadow == 'yes' ? ' box-shadow' : '' #>">
			<# if ( settings.heading ) { #>
				<span class="ej-elementor-price-table__heading-container text-center card-img-top bg-<# print( settings.heading_background_color ); #> <# print( settings.heading_css_class ); #>">
					<{{ settings.heading_tag }} {{{ view.getRenderAttributeString( 'heading' ) }}}>{{{ settings.heading }}}</{{ settings.heading_tag }}>
				</span>

			<# } #>
			<div class="card-body px-grid-gutter py-grid-gutter">
				<# if ( intpart && settings.show_price ) { #>
					<div class="ej-elementor-price-table__price d-flex align-items-end py-2 px-4 mb-4">
						
						<# if ( ! _.isEmpty( symbol ) && ( 'before' === settings.currency_position || _.isEmpty( settings.currency_position ) ) ) { #>
							<span class="ej-elementor-price-table__currency ej-elementor-currency--before mb-1 mr-2">{{{ symbol }}}</span>
						<# } #>

						

						<# if ( ( ! _.isEmpty( intpart ) || 0 <= intpart )  ){ #>
							<span class="ej-elementor-price-table__integer-part price cs-price px-1 mr-2" data-current-price="{{ settings.price}}" data-new-price="{{ settings.new_price }}">{{{ intpart }}}</span>

						<# } #>

						<# if ( ! _.isEmpty( symbol ) && 'after' == settings.currency_position ) { #>
						<span class="ej-elementor-price-table__currency ej-elementor-currency--after mb-1 mr-2">{{{ symbol }}}</span>
						<# } #>

						<# if ( settings.period && 'beside' === settings.period_position ) { #>
							{{{ periodElement }}}
						<# } #>
						
						<# if ( settings.price_subtext ) { #>
							{{{ '<span ' + view.getRenderAttributeString( "price_subtext" ) + '>' + settings.price_subtext + '</span>' }}}
						<# } #>
					</div>
				<# } #>

				<# if ( settings.show_description && settings.pricing_box_description ) { #>
					{{{ '<p ' + view.getRenderAttributeString( "pricing_box_description" ) + '>' + settings.pricing_box_description + '</p>' }}}
				<# } #>

				<# if ( settings.features_list && settings.show_features ) { #>
					<ul class="ej-elementor-price-table__features-list list-unstyled py-2 mb-4">
						<# _.each( settings.features_list, function( item, index ) {

							let featureKey = view.getRepeaterSettingKey( 'item_text', 'features_list', index );
							let	migrated = elementor.helpers.isIconMigrated( item, 'selected_item_icon' );

							if ( settings.features_list.length === index + 1 ) {
								view.addRenderAttribute( featureKey, {
									'class': 'mb-0',
								} );
							}

							view.addInlineEditingAttributes( featureKey );
						#>
							<li class="ej-list-item elementor-repeater-item-{{ item._id }} d-flex mb-3">
								<# if ( item.item_icon || item.selected_item_icon ) { #>
									
										<# iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.selected_item_icon, { 'aria-hidden': 'true', 'class': 'mr-2' }, 'i', 'object' );
										if ( ( ! item.item_icon || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) { #>
											{{{ iconsHTML[ index ].value }}}
										<# } else { #>
											<i class="{{ item.item_icon }} mr-2" aria-hidden="true"></i>
										<# } #>
									
								<# } #>
								<# if ( ! _.isEmpty( item.item_text.trim() ) ) { #>
									<span {{{ view.getRenderAttributeString( featureKey ) }}}>{{{ item.item_text }}}</span>
								<# } else { #>
									&nbsp;
								<# } #>
							</li>
						<# } ); #>
					</ul>
				<# } #>

				<# if ( settings.button_text && settings.show_button ) { #>
					<div class="text-center mb-2">
						<a id="{{ settings.button_css_id }}" href="#!" {{{ view.getRenderAttributeString( 'button_text' ) }}}>
							{{{ settings.button_text }}}
							<# if ( settings.button_icon || settings.button_selected_icon ) {
								if ( ( buttonIconMigrated || ! settings.button_icon ) && buttonIconHTML.rendered ) { #>
									{{{ buttonIconHTML.value }}}
								<# } else { #>
									<i class="{{ settings.button_icon }} ml-2" aria-hidden="true"></i>
								<# }
							} #>
						</a>
					</div>
				<# } #>
			</div>
		</div>
	
		<?php
	}
}