<?php
namespace EpicJungleElementor\Modules\Carousel;

use EpicJungleElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {

	public function get_widgets() {
		return [

			'Posts_Carousel',
			'Posts_Without_Image_Carousel',
			'Hero_Image_Carousel',
			'Testimonial_Carousel',
			'Project_Carousel',
			'Offers_Carousel',	
			'Icons_Carousel',			
		];
	}

	public function get_name() {
		return 'ej-carousel';
	}
}
