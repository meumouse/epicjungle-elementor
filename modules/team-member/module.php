<?php
namespace EpicJungleElementor\Modules\TeamMember;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
use EpicJungleElementor\Base\Module_Base;

class Module extends Module_Base {

    public function get_widgets() {
        return [
            'Team_Member',
        ];
    }

    public function get_name() {
        return 'ej-team-member';
    }
}
