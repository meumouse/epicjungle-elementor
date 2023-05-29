<?php
namespace EpicJungleElementor\Modules\Pricing\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;

use EpicJungleElementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Price_Switcher extends Base_Widget {

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
		return 'ej-price-switcher';
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
		return esc_html__( 'Alternador de preço', 'epicjungle-elementor' );
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
		return [ 'pricing', 'table', 'switcher' ];
	}

	protected function register_controls() {

		// Content Tab
		//$this->price_switcher_general_controls_content_tab();
		$this->start_controls_section(
			'section_general',
			[
				'label'       => esc_html__( 'Geral', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'show_price_switcher',
			[
				'label'       => esc_html__( 'Mostrar alternador de preços?', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => esc_html__( 'Ative para exibir o alternador de preços.', 'epicjungle-elementor' ),
				'frontend_available' => true,
				
			]
		);


		$this->add_control(
			'title_1',
			[
				'label'       => esc_html__( 'Rótulo à esquerda', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Por mês', 'epicjungle-elementor' ),
				'condition'   => [
					'show_price_switcher' => 'yes'
				],
			]
		);

		$this->add_control(
			'title_2',
			[
				'label'       => esc_html__( 'Rótulo à direita', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Anual', 'epicjungle-elementor' ),
				'condition'   => [
					'show_price_switcher' => 'yes'
				],
			]
		);

		// Content Tab End
		$this->end_controls_section();


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

		?>
		<?php if ( $settings[ 'show_price_switcher' ] == 'yes' ): ?>
			<div class="cs-price-switch justify-content-end">
			    <span class="cs-price-label mr-2"><?php echo esc_attr( $settings['title_1'] ); ?></span>

			    <div class="custom-control custom-switch">
			      	<input class="custom-control-input" type="checkbox" id="priceSwitch">
			      	<label class="custom-control-label" for="priceSwitch"></label>
			    </div>

			    <span class="cs-price-label ml-n1"><?php echo esc_attr( $settings['title_2'] ); ?></span>
		 	</div>
			 
			<?php
		endif;
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
		<# if ( settings.show_price_switcher == 'yes' ){ #>
		   	<div class="cs-price-switch justify-content-end pb-2 mb-4">
			    <span class="cs-price-label mr-2">{{ settings.title_1 }}</span>

			    <div class="custom-control custom-switch">
			      	<input class="custom-control-input" type="checkbox" id="priceSwitch">
			      	<label class="custom-control-label" for="priceSwitch"></label>
			    </div>

		    	<span class="cs-price-label ml-1">{{ settings.title_2 }}</span>
		 	</div>
		
		 <# } #>
	
		<?php

	}
}