<?php
namespace EpicJungleElementor\Modules\Pricing\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;

use EpicJungleElementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Pricing_Hours extends Base_Widget {

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
		return 'ej-pricing-hours';
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
		return esc_html__( 'Horários de preços', 'epicjungle-elementor' );
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
			'label_1',
			[
				'label'       => esc_html__( 'Rótulo 1', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '2 horas - R$6', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'label_2',
			[
				'label'       => esc_html__( 'Rótulo 2', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '4 horas - R$10', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'label_3',
			[
				'label'       => esc_html__( 'Rótulo 3', 'epicjungle-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '1 dia - R$18', 'epicjungle-elementor' ),
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
	 	<div class="d-flex align-items-center justify-content-between border rounded mx-auto mb-5 py-3 px-5" style="max-width: 730px;">
	 		<i class="fe-clock lead text-primary p-2"></i>
	        <h5 class="p-2 mb-0"><?php echo esc_attr( $settings['label_1'] ); ?></h5>
	        <h5 class="p-2 mb-0"><?php echo esc_attr( $settings['label_2'] ); ?></h5>
	        <h5 class="p-2 mb-0"><?php echo esc_attr( $settings['label_3'] ); ?></h5>
    	</div><?php
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
	   	<div class="d-flex align-items-center justify-content-between border rounded mx-auto mb-5 py-3 px-5" style="max-width: 730px;">
 			<i class="fe-clock lead text-primary p-2"></i>
				<h5 class="p-2 mb-0">{{ settings.label_1 }}</h5>
	        <h5 class="p-2 mb-0">{{ settings.label_1 }}</h5>
	        <h5 class="p-2 mb-0">{{ settings.label_1 }}</h5>
	    </div>	
		<?php

	}
}