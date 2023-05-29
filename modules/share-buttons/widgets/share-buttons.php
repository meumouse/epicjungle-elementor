<?php
namespace EpicJungleElementor\Modules\ShareButtons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use EpicJungleElementor\Base\Base_Widget;
use EpicJungleElementor\Modules\ShareButtons\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Share_Buttons extends Base_Widget {

	public static $networks_class_dictionary = [
		'google' => 'fa fa-google-plus',
		'pocket' => 'fa fa-get-pocket',
		'email' => 'fa fa-envelope',
	];

	public static $networks_icon_mapping = [
		'google' => 'fab fa-google-plus-g',
		'pocket' => 'fab fa-get-pocket',
		'email' => 'fas fa-envelope',
		'print' => 'fas fa-print',
	];

	public function get_style_depends() {
		if ( Icons_Manager::is_migration_allowed() ) {
			return [
				'elementor-icons-fa-solid',
				'elementor-icons-fa-brands',
			];
		}
		return [];
	}

	public static function get_network_class( $network_name ) {
		$prefix = 'fa ';
		if ( Icons_Manager::is_migration_allowed() ) {
			if ( isset( self::$networks_icon_mapping[ $network_name ] ) ) {
				return self::$networks_icon_mapping[ $network_name ];
			}
			$prefix = 'fab ';
		}
		if ( isset( self::$networks_class_dictionary[ $network_name ] ) ) {
			return self::$networks_class_dictionary[ $network_name ];
		}

		return $prefix . 'fa-' . $network_name;
	}

	public function get_name() {
		return 'ej-share-buttons';
	}

	public function get_title() {
		return __( 'Botões de compartilhamento', 'epicjungle-elementor' );
	}

	public function get_icon() {
		return 'eicon-share';
	}

	public function get_keywords() {
		return [ 'sharing', 'social', 'icon', 'button', 'like' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_buttons_content',
			[
				'label' => __( 'Botões de compartilhamento', 'epicjungle-elementor' ),
			]
		);

		$repeater = new Repeater();

		$networks = Module::get_networks();

		$networks_names = array_keys( $networks );

		$repeater->add_control(
			'button',
			[
				'label' => __( 'Rede', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => array_reduce( $networks_names, function( $options, $network_name ) use ( $networks ) {
					$options[ $network_name ] = $networks[ $network_name ]['title'];

					return $options;
				}, [] ),
				'default' => 'facebook',
			]
		);

		$repeater->add_control(
			'text',
			[
				'label' => __( 'Rótulo personalizado', 'epicjungle-elementor' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'share_buttons',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'button' => 'facebook',
					],
					[
						'button' => 'twitter',
					],
					[
						'button' => 'linkedin',
					],
				],
				'title_field' => '<i class="{{ elementorPro.modules.shareButtons.getNetworkClass( button ) }}" aria-hidden="true"></i> {{{ elementorPro.modules.shareButtons.getNetworkTitle( obj ) }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'Visualização', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'icon-text' => 'Ícone e Texto',
					'icon' => 'Ícone',
					'text' => 'Texto',
				],
				'default' => 'icon',
				'separator' => 'before',
				'prefix_class' => 'elementor-share-buttons--view-',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'show_label',
			[
				'label' => __( 'Rótulo', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Mostrar', 'epicjungle-elementor' ),
				'label_off' => __( 'Ocultar', 'epicjungle-elementor' ),
				'default' => 'yes',
				'condition' => [
					'view' => 'icon-text',
				],
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => __( 'Estilo', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'gradient' => __( 'Degradê', 'epicjungle-elementor' ),
					'minimal' => __( 'Minimalista', 'epicjungle-elementor' ),
					'framed' => __( 'Emoldurado', 'epicjungle-elementor' ),
					'boxed' => __( 'Ícone em caixa', 'epicjungle-elementor' ),
					'flat' => __( 'Plano', 'epicjungle-elementor' ),
				],
				'default' => 'minimal',
				'prefix_class' => 'elementor-share-buttons--skin-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Forma', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'square' => __( 'Quadrado', 'epicjungle-elementor' ),
					'rounded' => __( 'Arredondado', 'epicjungle-elementor' ),
					'circle' => __( 'Círculo', 'epicjungle-elementor' ),
				],
				'default' => 'rounded',
				'prefix_class' => 'elementor-share-buttons--shape-',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Colunas', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [
					'0' => 'Auto',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'elementor-grid%s-',
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alinhamento', 'epicjungle-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Esquerda', 'epicjungle-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Centro', 'epicjungle-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Direita', 'epicjungle-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justificado', 'epicjungle-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor-share-buttons%s--align-',
				'condition' => [
					'columns' => '0',
				],
			]
		);

		$this->add_control(
			'share_url_type',
			[
				'label' => __( 'URL alvo', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'current_page' => __( 'Pagina atual', 'epicjungle-elementor' ),
					'custom' => __( 'Personalizado', 'epicjungle-elementor' ),
				],
				'default' => 'current_page',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'share_url',
			[
				'label' => __( 'Link', 'epicjungle-elementor' ),
				'type' => Controls_Manager::URL,
				'options' => false,
				'placeholder' => __( 'https://seu-link.com.br', 'epicjungle-elementor' ),
				'condition' => [
					'share_url_type' => 'custom',
				],
				'show_label' => false,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_buttons_style',
			[
				'label' => __( 'Botões de compartilhamento', 'epicjungle-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => __( 'Intervalo das Colunas', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--grid-side-margin: {{SIZE}}{{UNIT}}; --grid-column-gap: {{SIZE}}{{UNIT}}; --grid-row-gap: {{SIZE}}{{UNIT}}',
					'(tablet) {{WRAPPER}}' => '--grid-side-margin: {{SIZE}}{{UNIT}}; --grid-column-gap: {{SIZE}}{{UNIT}}',
					'(mobile) {{WRAPPER}}' => '--grid-side-margin: {{SIZE}}{{UNIT}}; --grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => __( 'Intervalo de Linhas', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}; --grid-bottom-margin: {{SIZE}}{{UNIT}}',
					'(tablet) {{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}; --grid-bottom-margin: {{SIZE}}{{UNIT}}',
					'(mobile) {{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}; --grid-bottom-margin: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_size',
			[
				'label' => __( 'Tamanho do botão', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.5,
						'max' => 2,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-share-btn' => 'font-size: calc({{SIZE}}{{UNIT}} * 10);',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Tamanho do ícone', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'em' => [
						'min' => 0.5,
						'max' => 4,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'em',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'size_units' => [ 'em', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-share-btn__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'text',
				],
			]
		);

		$this->add_responsive_control(
			'button_height',
			[
				'label' => __( 'Altura do botão', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'em' => [
						'min' => 1,
						'max' => 7,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'em',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'size_units' => [ 'em', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-share-btn' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_size',
			[
				'label' => __( 'Tamanho da borda', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
					'em' => [
						'max' => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-share-btn' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'skin' => [ 'framed', 'boxed' ],
				],
			]
		);

		$this->add_control(
			'color_source',
			[
				'label' => __( 'Cor', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'official' => __( 'Oficial', 'epicjungle-elementor' ),
					'custom' => __( 'Personalizado', 'epicjungle-elementor' ),
				],
				'default' => 'official',
				'prefix_class' => 'elementor-share-buttons--color-',
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'tabs_button_style',
			[
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Cor primária', 'epicjungle-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn .elementor-share-btn__icon' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-share-buttons--skin-framed .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Cor secundária', 'epicjungle-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn__icon' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
				'condition' => [
					'skin!' => 'framed',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Ao passar o mouse', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'primary_color_hover',
			[
				'label' => __( 'Cor primária', 'epicjungle-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-share-buttons--skin-framed .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover .elementor-share-btn__icon' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'secondary_color_hover',
			[
				'label' => __( 'Cor secundária', 'epicjungle-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover .elementor-share-btn__icon' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .elementor-share-btn__title',
				'exclude' => [ 'line_height' ],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Preenchimento de texto', 'epicjungle-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'view' => 'text',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_active_settings();
	
		if ( empty( $settings['share_buttons'] ) ) {
			return;
		}

		$button_classes = 'elementor-share-btn';

		$show_text = 'text' === $settings['view'] || 'yes' === $settings['show_label'];
		?>
		<div class="elementor-grid">
			<?php
			$networks_data = Module::get_networks();

			foreach ( $settings['share_buttons'] as $button ) {
				$network_name = $button['button'];

				// A deprecated network.
				if ( ! isset( $networks_data[ $network_name ] ) ) {
					continue;
				}

				$social_network_class = ' elementor-share-btn_' . $network_name;
				?>
					<div class="elementor-grid-item">
						<div class="<?php echo esc_attr( $button_classes . $social_network_class ); ?>">
							<?php if ( 'icon' === $settings['view'] || 'icon-text' === $settings['view'] ) : ?>
								<a class="social-btn sb-outline sb-<?php echo $network_name; ?> ml-2 my-2" href='#'>

								<i class="<?php echo self::get_network_class( $network_name ); ?>"
								   aria-hidden="true"></i>
								<span
									class="elementor-screen-only"><?php echo sprintf( __( 'Compartilhe em %s', 'epicjungle-elementor' ), $network_name ); ?></span>
							</a>
							<?php endif; ?>
							<?php if ( $show_text ) : ?>
								<div class="elementor-share-btn__text">
									<?php if ( 'yes' === $settings['show_label'] || 'text' === $settings['view'] ) : ?>
										<span class="elementor-share-btn__title">
										<?php echo $button['text'] ? $button['text'] : $networks_data[ $network_name ]['title']; ?>
									</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php
			}
			?>
		</div>
		<?php 
	}

	/**
	 * Render Botões de compartilhamento widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
			var shareButtonsEditorModule = elementorPro.modules.shareButtons,
				buttonClass = 'elementor-share-btn';

			var showText = 'icon-text' === settings.view ? 'yes' === settings.show_label : 'text' === settings.view;
		#>
		<div class="elementor-grid">
			<#
				_.each( settings.share_buttons, function( button ) {
					// A deprecated network.
					if ( ! shareButtonsEditorModule.getNetworkData( button ) ) {
						return;
					}

					var networkName = button.button,
						socialNetworkClass = 'elementor-share-btn_' + networkName;
					#>
					<div class="elementor-grid-item">
						<div class="{{ buttonClass }} {{ socialNetworkClass }}">
							<# if ( 'icon' === settings.view || 'icon-text' === settings.view ) { #>
							<a class="social-btn sb-outline sb-{{{ networkName }}} ml-2 my-2" href='#'>
								<i class="{{ shareButtonsEditorModule.getNetworkClass( networkName ) }}" aria-hidden="true"></i>
								<span class="elementor-screen-only">Compartilhe em {{{ networkName }}}</span>
							</a>
							<# } #>
							<# if ( showText ) { #>
								<div class="elementor-share-btn__text">
									<# if ( 'yes' === settings.show_label || 'text' === settings.view ) { #>
										<span class="elementor-share-btn__title">{{{ shareButtonsEditorModule.getNetworkTitle( button ) }}}</span>
									<# } #>
								</div>
							<# } #>
						</div>
					</div>
			<#  } ); #>
		</div>
		<?php
	}
}
