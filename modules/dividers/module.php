<?php
namespace EpicJungleElementor\Modules\Dividers;

use EpicJungleElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Dividers'
		];
	}

	public function get_name() {
		return 'ar-dividers';
	}
}