<?php

namespace EpicJungleElementor\Modules\Button;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Modules\Button\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function get_name() {
        return 'override-button';
    }

    public function add_actions() {
        add_action( 'elementor/widget/button/skins_init', [ $this, 'init_skins' ], 10 );
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Button_Epicjungle( $widget ) );
    }
}