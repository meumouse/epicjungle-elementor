<?php
namespace EpicJungleElementor\Modules\dividers\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Repeater;
use Elementor\Core\Schemes;
use Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use EpicJungleElementor\Includes\Controls\Groups\Group_Control_Shape_Divider;

/**
 * Elementor Dividers widget.
 *
 * Elementor widget that displays an dividers into the page.
 *
 * @since 1.0.0
 */
class Dividers extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve Dividers widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'ar-dividers';
    }

    /**
     * Get widget title.
     *
     * Retrieve Dividers widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Shape Dividers', 'around-elementor' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Dividers widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-divider';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Dividers widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'around' ];
    }

    /**
     * Register Dividers widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_image', [
                'label' => esc_html__( 'Shape Divider', 'around-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'align', [
                'label'     => esc_html__( 'Alignment', 'around-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'center',
                'separator' => 'before',
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'around-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'around-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'around-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'image_hide' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Shape_Divider::get_type(), [
                'name' => 'section_divider'
            ]
        );

        $this->add_control(
            'overflow_hidden', [
                'label'     => esc_html__( 'Overflow Hidden ?', 'around-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',                
                'condition' => [
                    'section_divider_shape' => 'blur',
                ],
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();
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

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-dividers' );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php echo Group_Control_Shape_Divider::get_shape_divider( $settings, 'section_divider' ); ?>
        </div>
        <?php
    }
}
