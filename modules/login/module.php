<?php
namespace EpicJungleElementor\Modules\Login;

use EpicJungleElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Login',
        ];
    }

    public function get_name() {
        return 'ej-login';
    }
}
