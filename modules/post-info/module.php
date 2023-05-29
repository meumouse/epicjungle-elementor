<?php
namespace EpicJungleElementor\Modules\PostInfo;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
use EpicJungleElementor\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Post_Info'
        ];
    }

    public function get_name() {
        return 'ej-post-info';
    }
}
