<?php
namespace EpicJungleElementor\Modules\PostInfo\Widgets;

use EpicJungleElementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Base extends Base_Widget {

	/*public function get_categories() {
		return [ 'theme-elements' ];
	}*/

	public function render_plain_content() {}
}
