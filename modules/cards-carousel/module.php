<?php
namespace EpicJungleElementor\Modules\CardsCarousel;

use EpicJungleElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Cards_Carousel',
        ];
    }

    public function get_name() {
        return 'ej-cards-carousel';
    }
}
