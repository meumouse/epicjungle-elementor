<?php
namespace EpicJungleElementor\Modules\ImageGrid;

use EpicJungleElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Image_Grid',
        ];
    }

    public function get_name() {
        return 'ej-image-grid';
    }
}
