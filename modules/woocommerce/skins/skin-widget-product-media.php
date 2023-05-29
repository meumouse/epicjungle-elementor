<?php
namespace EpicJungleElementor\Modules\Woocommerce\Skins;

use EpicJungleElementor\Modules\Woocommerce\Classes\Products_Renderer;
use EpicJungleElementor\Modules\Woocommerce\Classes\Current_Query_Renderer;

use Elementor\Skin_Base;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Skin_Widget_Product_Media extends Skin_Base {

    public function get_id() {
        return 'widget-product-media';
    }

    public function get_title() {
        return esc_html__( 'Widget de mídia', 'epicjungle-elementor' );
    }

    protected function _register_controls_actions() {
         add_action( 'elementor/element/ej-woocommerce-products/section_content/before_section_end', [ $this, 'modify_section_content_controls' ] );
    }

    public function modify_section_content_controls( Widget_Base $widget ) {

        $this->parent = $widget;
        
        $this->add_control(
            'widget_title', [
                'label'       => esc_html__( 'Título do widget', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'Digite seu título', 'epicjungle-elementor' ),
                'default'     => 'Novas chegadas',
                'description' => esc_html__( 'Use <br> para quebrar em duas linhas', 'epicjungle-elementor' ),
                'label_block' => true,
            ], [
                'position'    => [
                    'of'  => '_skin'
                ]
            ]
        );

        $this->add_control(
            'view_more_txt', [
                'label'       => esc_html__( 'Texto ver mais', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Ver mais',
            ], [
                'position'    => [
                    'of'  => 'widget_title'
                ]
            ]
        );
        
        // $this->parent->remove_control( 'columns' );
    }

    protected function get_shortcode_object( $settings ) {
        if ( 'current_query' === $settings[ Products_Renderer::QUERY_CONTROL_NAME . '_post_type' ] ) {
            $type = 'current_query';
            return new Current_Query_Renderer( $settings, $type );
        }
        $type = 'products';
        return new Products_Renderer( $settings, $type );
    }

    public function render() {
        if ( WC()->session ) {
            wc_print_notices();
        }

        // For Products_Renderer.
        if ( ! isset( $GLOBALS['post'] ) ) {
            $GLOBALS['post'] = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
        }

        $settings = $this->parent->get_settings();

        $shortcode = $this->get_shortcode_object( $settings );

        $content = $shortcode->get_widget_content();

        $widget_title  = $settings[ $this->get_control_id( 'widget_title' ) ];
        $view_more_txt = $settings[ $this->get_control_id( 'view_more_txt' ) ];

        if ( ! empty( $widget_title ) ) :

        ?><div class="d-flex justify-content-between align-items-center mb-4 pb-1">
            <h3 class="font-size-xl mb-0"><?php echo esc_html( $widget_title ); ?></h3>
            <?php if ( ! empty( $view_more_txt ) ) : ?>
            <a class="font-size-sm font-weight-medium mr-n2" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                <?php echo esc_html( $view_more_txt ); ?><i class="fe-chevron-right font-size-lg ml-1"></i>
            </a>
            <?php endif; ?>
        </div>

        <?php endif; 

        if ( $content ) {
            echo $content;
        } elseif ( $this->parent->get_settings( 'nothing_found_message' ) ) {
            echo '<div class="elementor-nothing-found elementor-products-nothing-found">' . esc_html( $this->parent->get_settings( 'nothing_found_message' ) ) . '</div>';
        }
    }
}