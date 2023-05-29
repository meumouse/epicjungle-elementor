<?php

namespace EpicJungleElementor\Modules\Video;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Modules\Video\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function add_actions() {
        add_action( 'elementor/widget/video/skins_init', [ $this, 'init_skins' ], 10 );
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Video( $widget ) );
    }

    public function get_name() {
        return 'video';
    }
    
}