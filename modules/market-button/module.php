<?php
namespace EpicJungleElementor\Modules\MarketButton;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
use EpicJungleElementor\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Market_Button'
        ];
    }

    public function get_name() {
        return 'ej-market-button';
    }
}
