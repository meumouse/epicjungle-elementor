<?php
namespace EpicJungleElementor\Modules\Breadcrumb\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use EpicJungleElementor\Base\Base_Widget;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Breadcrumb extends Base_Widget {

	public function get_name() {
		return 'ej-epicjungle-breadcrumb';
	}

	public function get_title() {
		return __( 'EpicJungle Breadcrumbs', 'epicjungle-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_keywords() {
		return [ 'shop', 'store', 'breadcrumbs', 'internal links', 'product' ];
	}

	protected function render() {
		epicjungle_breadcrumb();
	}

	public function render_plain_content() {}
}
	