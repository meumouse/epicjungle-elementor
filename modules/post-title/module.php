<?php
namespace EpicJungleElementor\Modules\PostTitle;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
use EpicJungleElementor\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Post_Title'
        ];
    }

    public function get_name() {
        return 'ej-post-title';
    }
}
