<?php
namespace EpicJungleElementor\Core;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Elementor\Utils;

final class Icons_Manager {
    public function __construct() {
        add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'additional_tabs' ], 20 );
    }

    public function additional_tabs( $tabs ) {
        $new_tabs = [
            'feather-icons' => [
                'name'          => 'feather-icons',
                'label'         => esc_html__( 'Feather Icons', 'epicjungle-elementor' ),
                'url'           => get_template_directory_uri() . '/assets/fonts/feather.css',
                'enqueue'       => [],
                'prefix'        => 'fe-',
                'displayPrefix' => '',
                'labelIcon'     => 'fe-feather',
                'ver'           => '4.24.1',
                'fetchJson'     => get_template_directory_uri() . '/assets/fonts/feather.js',
                'native'        => false,
            ],

        ];

        return array_merge( $tabs, $new_tabs );
    }
}