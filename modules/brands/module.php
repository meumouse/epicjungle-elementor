<?php
namespace EpicJungleElementor\Modules\Brands;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
use EpicJungleElementor\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Brands'
        ];
    }

    public function get_name() {
        return 'ej-brands';
    }
}
