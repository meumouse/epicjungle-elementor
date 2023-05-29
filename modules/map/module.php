<?php
namespace EpicJungleElementor\Modules\Map;

use EpicJungleElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Map'
		];
	}

	public function get_name() {
		return 'ej-map';
	}
}