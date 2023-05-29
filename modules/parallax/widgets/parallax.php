<?php
namespace EpicJungleElementor\Modules\Parallax\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use EpicJungleElementor\Base\Base_Widget;
use EpicJungleElementor\Modules\ImageGrid\Skins;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes;
use Elementor\Utils;

class Parallax extends Base_Widget {

    public function get_name() {
        return 'ej-parallax';
    }

    public function get_title() {
        return esc_html__( 'Parallax', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-parallax';
    }

   protected function register_controls() {
        $this->start_controls_section(
            'section_parallax', [
                'label' => esc_html__( 'Parallax', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'enable_bg',
            [
                'label'        => esc_html__( 'Ativar imagem de fundo', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'description'  => esc_html__( 'Ativar a opção Parallax.', 'epicjungle-elementor' ),
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __( 'Imagem de fundo', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'enable_bg' => 'yes',
                ]
            ]
        );


        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Escolher imagem', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
                'data-depth',
                [
                    'label'              => esc_html__( 'Profundidade', 'epicjungle-elementor' ),
                    'type'               => Controls_Manager::NUMBER,
                    'default'            => 0.1,
                    'min'                => 0,
                    'step'               => .1,
                    'render_type'        => 'none',
                    'frontend_available' => true,
                ]
            );

        $repeater->add_control(
                'z-index',
                [
                    'label'              => esc_html__( 'Z Index', 'epicjungle-elementor' ),
                    'type'               => Controls_Manager::NUMBER,
                    'default'            => 1,
                    'min'                => 0,
                    'step'               => 1,
                    'render_type'        => 'none',
                    'frontend_available' => true,
                ]
            );

        $repeater->add_control(
            'position', [
                'label'        => esc_html__( 'Posição relativa?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'content_settings', [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_parallax_style', [
                'label' => esc_html__( 'Parallax', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'parallax_css', [
                'label'       => esc_html__( 'CSS Parallax', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'Classes CSS adicionais separadas por espaço que você gostaria de aplicar ao texto destacado', 'epicjungle-elementor' ),
                'default'     => '',
            ]
        );

        $this->add_control( 'max_width', [
            'label'        => esc_html__( 'Largura máxima', 'epicjungle-elementor' ),
            'type'         => Controls_Manager::SLIDER,
            'default'      => [ 'unit' => 'px' ],
            'size_units'   => [ '%', 'px' ],
            'range'        => [
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 1040,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cs-parallax' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ] );
    }

    /**
     * Render Dividers widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $count    = count( $settings[ 'content_settings' ] );
        $items    = $settings[ 'content_settings'];

        $this->add_render_attribute( 'parallax', 'class', [
            'cs-parallax',
            $settings['parallax_css'],
        ] );   

        ?>

        <div <?php echo $this->get_render_attribute_string( 'parallax' ); ?>>
            <?php if ( $settings['enable_bg'] === 'yes' ) : ?>
                <img class="d-block" src=<?php echo $settings['bg_image']['url']; ?>/>
            <?php endif; ?>
            <?php foreach( $items as $index => $item ) :

                $count       = $index + 1; 
                $parallax    = $this->get_repeater_setting_key( 'parallax', 'content_settings', $index );
                $is_relative = $item['position'];
                    
                $this->add_render_attribute( $parallax, [
                    'class'      => 'ej-parallax cs-parallax-layer',
                    'data-depth' => $item['data-depth'],
                ] );

                if ( $is_relative === 'yes' ) {
                    $this->add_render_attribute( $parallax, 'class', 'position-relative' );
                }

                ?>
                <div <?php echo $this->get_render_attribute_string( $parallax ); ?>>
                    <img alt="Image" src=<?php echo $item['image']['url'] ?>>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php
    }
}