<?php
namespace EpicJungleElementor\Modules\Pricing;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
use EpicJungleElementor\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Pricing',
        //    'Price_Switcher',
        //    'Pricing_Hours',
        ];
    }

    public function get_name() {
        return 'ej-pricing';
    }
}
