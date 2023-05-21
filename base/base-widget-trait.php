<?php
namespace EpicJungleElementor\Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

trait Base_Widget_Trait {

    public function is_editable() {
        return true;
    }
}
