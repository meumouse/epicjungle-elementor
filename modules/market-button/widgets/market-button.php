<?php
namespace EpicJungleElementor\Modules\MarketButton\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use EpicJungleElementor\Base\Base_Widget;
use Elementor\Group_Control_Image_Size;
use EpicJungleElementor\Core\Utils as EJ_Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;


/**
 * EpicJungle Elementor Botão de mercado widget.
 *
 * EpicJungle Elementor widget that displays a Botão de mercado with the ability to control every
 * aspect of the Botão de mercado design.
 *
 * @since 1.0.0
 */
class Market_Button extends Base_Widget {

    private $files_upload_handler = false;

    /**
     * Get widget name.
     *
     * Retrieve Botão de mercado widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'ej-market-button';
    }

    /**
     * Get widget title.
     *
     * Retrieve Botão de mercado widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Botão de mercado', 'epicjungle-elementor' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Botão de mercado widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-button';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'market_button', 'image' ];
    }

    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_market_btn',
            [
                'label' => __( 'Botão', 'epicjungle-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __( 'Alinhamento', 'epicjungle-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Esquerda', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Centro', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Final', 'epicjungle-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .epicjungle-market-button' => 'justify-content:{{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title1',
            [
                'label'       => esc_html__( 'Título do botão Apple', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'App Store', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'App Store', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'subtitle1',
            [
                'label'       => esc_html__( 'Subtítulo do botão Apple', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Baixa na', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Baixa na', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'link1',
            [
                'label' => __( 'Apple App Store Link', 'epicjungle-elementor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'title2',
            [
                'label'       => esc_html__( 'Título do botão do Google', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Google Play', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Google Play', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'subtitle2',
            [
                'label'       => esc_html__( 'Subtítulo do botão do Google', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Baixa na', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Baixa na', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'link2',
            [
                'label' => __( 'Link da Google App Store', 'epicjungle-elementor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'btn-outline', [
                'label'        => esc_html__( 'Botão contornado?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_market_btn_style', [
                'label' => esc_html__( 'Botão de mercado', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __( 'Tipografia do título', 'epicjungle-elementor' ),
                'name' => 'Tipografia do título',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .btn-market-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __( 'Tipografia de subtítulos', 'epicjungle-elementor' ),
                'name' => 'Tipografia de subtítulos',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .btn-market-subtitle',
            ]
        );


        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Cor do texto', 'epicjungle-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .btn-market-title' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .btn-market-subtitle' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Cor de fundo', 'epicjungle-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-market' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Raio da borda', 'epicjungle-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-market' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }


    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings[ 'link1' ] ) ) {
            $this->add_link_attributes( 'button1', $settings[ 'link1' ] );
            $this->add_render_attribute( 'button1', 'class', [
                'btn-market btn-apple ',
                'yes' === $settings['btn-outline'] ? 'btn-outline ': '',
            ] );
            $this->add_render_attribute( 'button1', 'role', 'button' );
        }

        if ( ! empty( $settings[ 'link2' ] ) ) {
            $this->add_link_attributes( 'button2', $settings[ 'link2' ] );
            $this->add_render_attribute( 'button2', 'class', [ 
                'btn-market btn-google ',
                'yes' === $settings['btn-outline'] ? 'btn-outline ': '',
            ] );
            $this->add_render_attribute( 'button2', 'role', 'button' );
        }

        $this->add_render_attribute( 'subtitle1', 'class', 'btn-market-subtitle' );
        $this->add_render_attribute( 'title1', 'class', 'btn-market-title' );
        $this->add_render_attribute( 'subtitle2', 'class', 'btn-market-subtitle' );
        $this->add_render_attribute( 'title2', 'class', 'btn-market-title' );

        ?>
        <div class="epicjungle-market-button d-sm-flex">
            <div class="mr-sm-3 mb-3">
                <a <?php echo $this->get_render_attribute_string( 'button1' ); ?>>
                    <span <?php echo $this->get_render_attribute_string( 'subtitle1' ); ?>><?php echo $settings[ 'subtitle1' ]; ?></span>
                    <span <?php echo $this->get_render_attribute_string( 'title1' ); ?>><?php echo $settings[ 'title1' ]; ?></span>
                </a>
            </div>
            <div class="mb-3">
                <a <?php echo $this->get_render_attribute_string( 'button2' ); ?>>
                    <span <?php echo $this->get_render_attribute_string( 'subtitle2' ); ?>><?php echo $settings[ 'subtitle2' ]; ?></span>
                    <span <?php echo $this->get_render_attribute_string( 'title2' ); ?>><?php echo $settings[ 'title2' ]; ?></span>
                </a>
            </div>
        </div>
        <?php
    }
}