<?php

namespace EpicJungleElementor\Modules\ImageCarousel;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Modules\ImageCarousel\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function add_actions() {
        add_action( 'elementor/widget/image-carousel/skins_init', [ $this, 'init_skins' ], 10 );  
    }

    public function get_name() {
        return 'override-image-carousel';
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Cs_Gallery( $widget ) );
        $widget->add_skin( new Skins\Skin_Frame_Phone( $widget ) );
        $widget->add_skin( new Skins\Skin_Frame_Browser( $widget ) );
    }
}