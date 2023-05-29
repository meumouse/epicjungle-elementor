<?php

namespace AroundElementor\Modules\BasicGallery;

use AroundElementor\Base\Module_Base;
use AroundElementor\Modules\BasicGallery\Skins;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function get_name() {
        return 'ar-basic-gallery';
    }

    public function add_actions() {
        add_action( 'elementor/widget/image-gallery/skins_init', [ $this, 'init_skins' ], 10 );
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Around_Gallery( $widget ) );
    }

}