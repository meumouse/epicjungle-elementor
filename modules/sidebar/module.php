<?php

namespace EpicJungleElementor\Modules\Sidebar;

use EpicJungleElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();

        $this->add_actions();
    }

    public function get_name() {
        return 'override-sidebar';
    }


    public function add_actions() {
        add_action( 'elementor/widget/sidebar/skins_init', [ $this, 'init_skins' ], 10 );
        
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Cs_Sidebar_Skin( $widget ) );
    }
}