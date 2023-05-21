<?php

namespace EpicJungleElementor\Includes\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;

class Group_Control_Shape_Divider extends Group_Control_Base {

    protected static $fields;

    public static function get_type() {
        return 'shape-divider';
    }

    private static function get_curve_details( $style ) {
        switch( $style ) {
            case 'curve-bottom-1':
                $class[] = 'shape-bottom'; 
                $class[] = 'shape-fluid-x';
                $path    = 'curves/curve-bottom-center.svg';
            break;
            case 'curve-top':
                $class[] = 'shape-bottom'; 
                $class[] = 'shape-fluid-x';
                $path    = 'curves/curve-top-center.svg';
            break;
            case 'curve-bottom-3':
                $class[] = 'shape-bottom'; 
                $class[] = 'shape-fluid-x';
                $path    = 'curves/curve-bottom-center.svg';
            break;
            case 'curve-bottom-4':
                $class[] = 'shape-bottom'; 
                $class[] = 'shape-fluid-x';
                $path    = 'curves/curve-6.svg';
            break;
            case 'curve-right':
                $class[] = 'shape-right'; 
                $class[] = 'shape-fluid-y';
                $path    = 'curves/curve-4.svg';
            break;
            case 'curve-left':
                $class[] = 'shape-left'; 
                $class[] = 'shape-fluid-y';
                $path    = 'curves/curve-left.svg';
            break;
        }

        return [ 'class' => $class, 'path' => $path ];
    }

    private static function get_angle_details( $style ) {
        switch( $style ) {
            case 'angle-top':
                $class[] = 'shape-top'; 
                $class[] = 'shape-fluid-x';
                $path    = 'angles/angle-top.svg';
            break;
            case 'angle-top-flip':
                $class[] = 'shape-top'; 
                $class[] = 'shape-fluid-x';
                $class[] = 'shape-flip-x';
                $path    = 'angles/angle-top.svg';
            break;
            case 'angle-bottom':
                $class[] = 'shape-bottom'; 
                $class[] = 'shape-fluid-x';
                $path    = 'angles/angle-bottom.svg';
            break;
            case 'angle-bottom-flip':
                $class[] = 'shape-bottom'; 
                $class[] = 'shape-fluid-x';
                $class[] = 'shape-flip-x';
                $path    = 'angles/angle-bottom.svg';
            break;
            case 'angle-right':
                $class[] = 'shape-right'; 
                $class[] = 'shape-fluid-y';
                $path    = 'angles/angle-right.svg';
            break;
            case 'angle-left':
                $class[] = 'shape-left'; 
                $class[] = 'shape-fluid-y';
                $path    = 'angles/angle-left.svg';
            break;
        }

        return [ 'class' => $class, 'path' => $path ];
    }

    private static function get_blur_details( $style ) {
        switch( $style ) {
            case 'blur-1':
                $class[] = 'shape-blur-1'; 
                $path    = 'blurs/blur-1.svg';
            break;
            case 'blur-2':
                $class[] = 'shape-blur-2'; 
                $path    = 'blurs/blur-2.svg';
            break;
            case 'blur-3':
                $class[] = 'shape-top'; 
                $class[] = 'shape-fluid-x';
                $path    = 'blurs/blur-3.svg';
            break;
            case 'blur-4':
                $class[] = 'shape-blur-4'; 
                $path    = 'blurs/blur-4.svg';
            break;
        }

        return [ 'class' => $class, 'path' => $path ];
    }

    private static function get_wave_details() {
        return [ 
            'class' => [ 'shape-top', 'shape-fluid-x' ],
            'path'  => 'waves/wave-1.svg'
        ];
    }

    public static function get_shape_divider( $settings, $key = 'shape_divider' ) {
        
        $html         = '';
        $enable_shape = $settings[ $key . '_enable_shape' ];

        if ( 'no' === $enable_shape ) {
            return;
        }

        $shape = $settings[ $key . '_shape' ];
        $class = [
            'shape', 'svg-shim'
        ]; 

        if ( ! empty( $settings[ $key . '_shape_css'] ) ) {
            $class[] = $settings[ $key . '_shape_css'];
        }

        if ( 'curve' === $shape ) {
            $style   = $settings[ $key . '_curve_style' ];
            $details = self::get_curve_details( $style );
        } elseif ( 'angle' === $shape ) {
            $style   = $settings[ $key . '_angle_style' ];
            $details = self::get_angle_details( $style );
        } elseif ( 'blur' === $shape ) {
            $style   = $settings[ $key . '_blur_style' ];
            $details = self::get_blur_details( $style );
        } elseif ( 'wave' === $shape ) {
            $details = self::get_wave_details();
        }

        if ( isset( $details['path'] ) ) {
            $path         = 'assets/img/shapes/' . $details['path'];
            $class_string = implode( ' ', array_merge( $class, $details['class'] ) );
            
            ob_start(); ?>
            <div class="<?php echo esc_attr( $class_string ); ?>">
                <?php require get_theme_file_path( $path ); ?>
            </div><?php
            $html = ob_get_clean();
        }

        return $html;
    }

    public function init_fields() {
        $fields = [];

        $fields['enable_shape'] = [
            'label' => esc_html__( 'Ativar divisor de forma?', 'epicjungle-elementor' ),
            'type'  => Controls_Manager::SWITCHER,
        ];

        $fields['shape'] = [
            'label'     => esc_html__( 'Divisor de forma', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
                'curve' => esc_html__( 'Curva', 'epicjungle-elementor' ),
                'angle' => esc_html__( 'Ângulo', 'epicjungle-elementor' ),
                'wave'  => esc_html__( 'Onda', 'epicjungle-elementor' ),
                'blur'  => esc_html__( 'Desfoque', 'epicjungle-elementor' ),
            ],
            'default'   => 'curve',
            'condition' => [
                'enable_shape' => 'yes'
            ]
        ];

        $fields['curve_style'] = [
            'label'   => esc_html__( 'Estilo de curva', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'curve-bottom-1' => esc_html__( 'Curva inferior', 'epicjungle-elementor' ),
                'curve-top'      => esc_html__( 'Curva superior', 'epicjungle-elementor' ),
                'curve-bottom-3' => esc_html__( 'Curva inferior 3', 'epicjungle-elementor' ),
                'curve-bottom-4' => esc_html__( 'Curva inferior 4', 'epicjungle-elementor' ),
                'curve-right'    => esc_html__( 'Curva à direita', 'epicjungle-elementor' ),
                'curve-left'     => esc_html__( 'Curva à esquerda', 'epicjungle-elementor' ),
            ],
            'default'  => 'curve-bottom-1',
            'condition' => [
                'shape'        => 'curve',
                'enable_shape' => 'yes'
            ],
        ];

        $fields['angle_style'] = [
            'label'     => esc_html__( 'Estilo de ângulo', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
                'angle-top'         => esc_html__( 'Ângulo superior', 'epicjungle-elementor' ),
                'angle-top-flip'    => esc_html__( 'Ângulo com giro superior', 'epicjungle-elementor' ),
                'angle-bottom'      => esc_html__( 'Ângulo inferior', 'epicjungle-elementor' ),
                'angle-bottom-flip' => esc_html__( 'Ângulo com giro inferior', 'epicjungle-elementor' ),
                'angle-right'       => esc_html__( 'Ângulo à direita', 'epicjungle-elementor' ),
                'angle-left'        => esc_html__( 'Ângulo à esquerda', 'epicjungle-elementor' )
            ],
            'default'   => 'angle-top',
            'condition' => [
                'shape'        => 'angle',
                'enable_shape' => 'yes'
            ]
        ];

        $fields['blur_style'] = [
            'label'     => esc_html__( 'Estilo de desfoque', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
                'blur-1' => esc_html__( 'Desfoque 1', 'epicjungle-elementor' ),
                'blur-2' => esc_html__( 'Desfoque 2', 'epicjungle-elementor' ),
                'blur-3' => esc_html__( 'Desfoque 3', 'epicjungle-elementor' ),
                'blur-4' => esc_html__( 'Desfoque 4', 'epicjungle-elementor' ),
            ],
            'condition' => [
                'shape'        => 'blur',
                'enable_shape' => 'yes'
            ]
        ];

        $fields['shape_color'] = [
            'label'       => esc_html__( 'Cor da forma', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::COLOR,
            'selectors'   => [
                '{{WRAPPER}} .shape' => 'color: {{VALUE}};'
            ],
            'condition'   => [
                'enable_shape' => 'yes'
            ]
        ];

        $fields['shape_css'] = [
            'label'       => esc_html__( 'Classe CSS da forma', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'description' => esc_html__( 'CSS adicional a ser aplicado à div da forma', 'epicjungle-elementor' ),
            'condition'   => [
                'enable_shape' => 'yes'
            ]
        ];

        //$fields['color'] = 

        return $fields;
    }

    protected function get_default_options() {
        return [
            'popover' => false,
        ];
    }
}