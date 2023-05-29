<?php
namespace EpicJungleElementor\Modules\NavMenu;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
use EpicJungleElementor\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Nav_Menu',
        ];
    }

    public function get_name() {
        return 'ej-nav-menu';
    }
}
