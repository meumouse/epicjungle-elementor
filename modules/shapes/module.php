<?php

namespace EpicJungleElementor\Modules\Shapes;

use EpicJungleElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

     public function get_widgets() {
        return [
            'Shapes',
        ];
    }

    public function __construct() {
        parent::__construct();

        $this->add_actions();
    }

    public function get_name() {
        return 'ej-shapes';
    }

    public function add_actions() {
        add_filter( 'elementor/shapes/additional_shapes', [ $this, 'shape_options' ] );
    }

    public function shape_options( $additional_shapes ) {

        $additional_shapes ['epicjungle-slant-bottom-right'] =[
            'title'        => _x( 'epicjungle - Inclinação-inferior-direita', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/slant/slant-bottom-right.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/slant/slant-bottom-right.svg',
        ];

        $additional_shapes ['epicjungle-slant-bottom-left'] =[
            'title'        => _x( 'epicjungle - Inclinação-inferior-esquerda', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/slant/slant-bottom-left.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/slant/slant-bottom-left.svg',
        ];

        $additional_shapes ['epicjungle-slant-top-right'] =[
            'title'        => _x( 'epicjungle - Inclinação-superior-direita', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/slant/slant-top-right.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/slant/slant-top-right.svg',
        ];

        $additional_shapes ['epicjungle-slant-top-left'] =[
            'title'        => _x( 'epicjungle - Inclinação-superior-esquerda', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/slant/slant-top-left.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/slant/slant-top-left.svg',
        ];

        $additional_shapes ['epicjungle-curve-bottom-center'] =[
            'title'        => _x( 'epicjungle - Curva-inferior-centralizado', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-bottom-center.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-bottom-center.svg',
        ];

        $additional_shapes ['epicjungle-curve-top-center'] =[
            'title'        => _x( 'epicjungle - Curva-superior-centralizado', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-top-center.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-top-center.svg',
        ];

        $additional_shapes ['epicjungle-curve-bottom-right'] =[
            'title'        => _x( 'epicjungle - Curva-inferior-direita', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-bottom-right.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-bottom-right.svg',
        ];

        $additional_shapes ['epicjungle-curve-bottom-left'] =[
            'title'        => _x( 'epicjungle - Curva-inferior-esquerda', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-bottom-left.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-bottom-left.svg',
        ];

        $additional_shapes ['epicjungle-curve-top-right'] =[
            'title'        => _x( 'epicjungle - Curva-superior-direita', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-top-right.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-top-right.svg',
        ];

        $additional_shapes ['epicjungle-curve-top-left'] =[
            'title'        => _x( 'epicjungle - Curva-superior-esquerda', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-top-left.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-top-left.svg',
        ];


        $additional_shapes ['epicjungle-curve-right'] =[
            'title'        => _x( 'epicjungle - Curva direita', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-right.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-right.svg',
        ];

        $additional_shapes ['epicjungle-curve-left'] =[
            'title'        => _x( 'epicjungle - Curva esquerda', 'Formas', 'epicjungle-elementor' ),
            'has_negative' => false,
            'has_flip'     => false,
            'height_only'  => false,
            'url'          => get_template_directory_uri() . '/assets/img/shapes/curves/curve-left.svg',
            'path'         => get_stylesheet_directory() . '/assets/img/shapes/curves/curve-left.svg',
        ];

        return $additional_shapes;
    }
}