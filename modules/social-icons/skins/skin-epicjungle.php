<?php
namespace EpicJungleElementor\Modules\SocialIcons\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


use Elementor;
use Elementor\Skin_Base;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use EpicJungleElementor\Core\Utils as EJ_Utils;
use Elementor\Icons_Manager;

class Skin_EpicJungle extends Skin_Base {

    public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        add_filter( 'elementor/widget/print_template', [ $this, 'skin_print_template' ], 10, 2 );
        add_action( 'elementor/element/social-icons/section_social_icon/before_section_end', [ $this, 'section_skin_epicjungle_controls' ], 10 );
        //add_action( 'elementor/element/image-box/section_style_image/before_section_end', [ $this, 'style_image_controls' ] );
        //add_action( 'elementor/element/image-box/section_style_content/before_section_end', [ $this, 'style_content_controls' ] );
    }

    public function get_id() {
        return 'skin-epicjungle';
    }

    public function get_title() {
        return esc_html__( 'EpicJungle', 'epicjungle-elementor' );
    }

    public function skin_print_template( $content, $widget ) {
        if ( 'social-icons' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }

    public function section_skin_epicjungle_controls( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;

        $widget->update_control(
            'shape', [
                'condition' => [
                    '_skin' => '',
                ],
            ]
        );

        $this->add_control(
            'size', [
                'label' => __( 'Tamanho', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'lg',
                'options' => [
                    'sm'     => __( 'Pequeno', 'epicjungle-elementor' ),
                    '' => __( 'Médio', 'epicjungle-elementor' ),
                    'lg' => __( 'Grande', 'epicjungle-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'type', [
                'label' => __( 'Tipo', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''     => __( 'Sólido', 'epicjungle-elementor' ),
                    'outline' => __( 'Contorno', 'epicjungle-elementor' ),
                ],
            ]
        );


        $this->add_control(
            'shape', [
                'label' => __( 'Forma', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''     => __( 'Padrão', 'epicjungle-elementor' ),
                    'round' => __( 'Redondo', 'epicjungle-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'enable_light', [
                'label'        => esc_html__( 'Ativar versão clara', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'description'  => esc_html__( 'Ao ativar, adiciona um efeito de elevação ao passar o mouse', 'epicjungle-elementor' )
            ]
        );

    }


    public function render() {
        $widget   = $this->parent;
        $settings = $widget->get_settings_for_display();
      
        $fallback_defaults = [
            'fa fa-facebook',
            'fa fa-twitter',
            'fa fa-google-plus',
        ];

        $class_animation = '';

        if ( ! empty( $settings['hover_animation'] ) ) {
            $class_animation = ' elementor-animation-' . $settings['hover_animation'];
        }

        $migration_allowed = Icons_Manager::is_migration_allowed();

        ?>
        <div class="epicjungle-social-icons elementor-social-icons-wrapper elementor-grid">
            <?php
            foreach ( $settings['social_icon_list'] as $index => $item ) {
                $migrated = isset( $item['__fa4_migrated']['social_icon'] );
                $is_new = empty( $item['social'] ) && $migration_allowed;
                $social = '';

                // add old default
                if ( empty( $item['social'] ) && ! $migration_allowed ) {
                    $item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
                }

                if ( ! empty( $item['social'] ) ) {
                    $social = str_replace(
                            array("fa fa-","fe fe-"),
                            array("", ""),
                            $item['social']
                    );
                } 


                if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
                    $social = explode( ' ', $item['social_icon']['value'], 2 );
                    if ( empty( $social[1] ) ) {
                        $social = '';
                    } else {
                        $social = str_replace(
                            array("fa-","fe-"),
                            array("", ""),
                            $social[1]
                        );
                    }
                }

               

                if ( 'svg' === $item['social_icon']['library'] ) {
                    $social = get_post_meta( $item['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
                }


                $link_key = 'link_' . $index;

                $social_buttons_size  = $settings[ $this->get_control_id( 'size' ) ];
                $social_buttons_type  = $settings[ $this->get_control_id( 'type' ) ];
                $social_buttons_shape = $settings[ $this->get_control_id( 'shape' ) ];
                $enable_light         = $settings[ $this->get_control_id( 'enable_light' ) ];

    
                $shape = isset( $settings['skin_epicjungle_shape'] ) && $social_buttons_shape === 'round' ? 'sb-round' : '';
                $type  = isset( $settings['skin_epicjungle_type'] )  && $social_buttons_type === 'outline' ? 'sb-outline' : '';
                $enable  = isset( $settings['skin_epicjungle_enable_light'] )  && $enable_light === 'yes' ? 'sb-light' : '';
                
                $widget->add_render_attribute( $link_key, 'class', [
                    'epicjungle-social-icon-' . $social . $class_animation,
                    'd-inline-block',
                    'elementor-repeater-item-' . $item['_id'],
                    $shape,
                    $type,
                    $enable,
                    'social-btn sb-' . $social_buttons_size .' sb-' . $social .' mr-1 mb-2'
                ] );

                $widget->add_link_attributes( $link_key, $item['link'] );

                ?>
                <a <?php echo $widget->get_render_attribute_string( $link_key ); ?>>
                    <span class="elementor-screen-only"><?php echo ucwords( $social ); ?></span>
                    <?php
                    if ( $is_new || $migrated ) {
                        Icons_Manager::render_icon( $item['social_icon'] );
                    } else { ?>
                        <i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
                    <?php } ?>
                </a>
                
            <?php } ?>
        </div>
        <?php
    
    }

}