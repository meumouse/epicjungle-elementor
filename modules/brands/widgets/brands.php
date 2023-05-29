<?php
namespace EpicJungleElementor\Modules\Brands\Widgets;

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


/**
 * EpicJungle Elementor brands carousel widget.
 *
 * EpicJungle Elementor widget that displays a brands carousel with the ability to control every
 * aspect of the brands carousel design.
 *
 * @since 1.0.0
 */
class Brands extends Base_Widget {

    private $files_upload_handler = false;

    /**
     * Get widget name.
     *
     * Retrieve brands carousel widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'ej-brands';
    }

    /**
     * Get widget title.
     *
     * Retrieve brands carousel widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Marcas', 'epicjungle-elementor' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve brands carousel widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-ticker';
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
        return [ 'brands', 'image' ];
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
            'section_icon',
            [
                'label' => __( 'Imagem', 'epicjungle-elementor' ),
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'logo', [
                'label' => __( 'Logo', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
            ]
        );


        $repeater->add_control(
            'link',
            [
                'label' => __( 'Link', 'epicjungle-elementor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://seu-link.com.br', 'epicjungle-elementor' ),
            ]
        );

         $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'logo', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'thumbanil',
            ]
        );

        
        $this->add_control(
            'brand_logo', [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [
                        'logo'    => [ 'url' => Utils::get_placeholder_image_src() ],
                        'link'    => '',
                        //'logo_size' => 'thumbnail'
                    ],
                    [
                        'logo'    => [ 'url' => Utils::get_placeholder_image_src() ],
                        'link'    => '',
                        //'logo_size' => 'thumbnail'
                    ],
                    [
                        'logo'    => [ 'url' => Utils::get_placeholder_image_src() ],
                        'link'    => '',
                        //'logo_size' => 'thumbnail'
                    ],
                    [
                        'logo'    => [ 'url' => Utils::get_placeholder_image_src() ],
                        'link'    => '',
                        //'logo_size' => 'thumbnail'
                    ],
                    [
                        'logo'    => [ 'url' => Utils::get_placeholder_image_src() ],
                        'link'    => '',
                        //'logo_size' => 'thumbnail'
                    ],
                    [
                        'logo'    => [ 'url' => Utils::get_placeholder_image_src() ],
                        'link'    => '',
                        //'logo_size' => 'thumbnail'
                    ],


                ],
                
            ]
        
        );

       
        $this->add_control(
            'image_class',
            [
               'label'        => esc_html__( 'Classe CSS da imagem', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'title'       => esc_html__( 'Adicione sua classe personalizada para a tag <img> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'label_block' => true,
                'default'     => 'img-fluid',
                'description' => esc_html__( 'Classe CSS adicional que você deseja aplicar à tag img', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'enable_column',
            [
                'label'      => __( 'Ativar coluna', 'epicjungle-elementor' ),
                'type'       => Controls_Manager::SWITCHER,
                'label_on'   => __( 'Mostrar', 'epicjungle-elementor' ),
                'label_off'  => __( 'Ocultar', 'epicjungle-elementor' ),
                'default'    => 'yes',
            ]
        );

        $this->add_control(
            'enable_boxshadow',
            [
                'label'      => __( 'Ativar sombra da caixa', 'epicjungle-elementor' ),
                'type'       => Controls_Manager::SWITCHER,
                'label_on'   => __( 'Mostrar', 'epicjungle-elementor' ),
                'label_off'  => __( 'Ocultar', 'epicjungle-elementor' ),
                'default'    => 'no',
                'condition'    => [
                    'enable_column' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'slides_per_view', [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Slides por visualização', 'epicjungle-elementor' ),
                'options' => [
                    ''  => __( 'Padrão', 'epicjungle-elementor' ),
                    '1' => __( '1', 'epicjungle-elementor' ),
                    '2' => __( '2', 'epicjungle-elementor' ),
                    '3' => __( '3', 'epicjungle-elementor' ),
                    '4' => __( '4', 'epicjungle-elementor' ),
                    '5' => __( '5', 'epicjungle-elementor' ),
                    '6' => __( '6', 'epicjungle-elementor' ),
                ],
                'condition'    => [
                    'enable_column' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );



        $this->end_controls_section();
    }


    protected function print_item( array $item, array $settings, $element_key ) {
        if( empty( $item['logo']['url'] ) ) {
            $item['logo']['url'] = Utils::get_placeholder_image_src();
        }

        $column    = ! empty( $settings['slides_per_view_mobile'] ) ? 12/intval( $settings['slides_per_view_mobile'] ) : 6;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? 12/intval( $settings['slides_per_view_tablet'] ) : 4;
        $column_lg = ! empty( $settings['slides_per_view'] )        ? 12/intval( $settings['slides_per_view'] )        : 6;

        $this->add_render_attribute( $element_key . '-column-wrapper', 'class', [
            'col-' . $column,
            'col-md-' . $column_md,
            'col-lg-' . $column_lg,
            'elementor-repeater-item-' . $item['_id'],
            'text-center'
        ] );

//echo '<pre>' . print_r( $settings, 1 ) . '</pre>';

        $image_classes = 'img-fluid';
        $img_css       = $settings['image_class'];
        $link_class    = $settings['enable_column'] ? 'ej-brands mb-grid-gutter ': 'ej-brands-without-column ej-brands mb-4 mr-4 pr-3 ';
        if ($settings['enable_boxshadow'] != 'yes' && $settings['enable_column'] === 'yes' ) {
            $link_class    .= 'd-inline-block';
        };
        if( isset( $settings['enable_boxshadow'] ) && $settings['enable_boxshadow'] === 'yes' ) {
            $link_class    .= 'card border-0 box-shadow card-hover py-3 py-sm-4';
        }
        $this->add_render_attribute( $element_key . '-card-img', [
            'href'  =>  $item['link']['url'],
            'class' => $link_class
        ] );


        
        if ( $settings['enable_column']) : ?>
            <div <?php echo $this->get_render_attribute_string( $element_key . '-column-wrapper' ); ?>>
        <?php endif; ?>

        <?php if ( ! empty( $item['link']['url'] ) ) : ?>
            <a <?php echo $this->get_render_attribute_string( $element_key . '-card-img' ); ?>>
        <?php else: ?>  
            <span class="<?php echo esc_attr( $link_class ); ?>">  
        <?php endif; ?>        
        <?php $image_html = Group_Control_Image_Size::get_attachment_image_html( $item,'logo' );

            if ( $settings['enable_boxshadow']) : ?>
                <div class ="card-body px-1 py-0 text-center">
                    <div class="d-inline-block">
            <?php endif; ?><?php

                if ( false === strpos( $image_html, 'class="' ) ) {
                    $image_html = str_replace( '<img', '<img class="' . esc_attr( $img_css ) . '"', $image_html );
                } else {
                    $image_html = str_replace( 'class="', 'class="' . esc_attr( $img_css ) .' ' , $image_html );
                }

                echo $image_html;?>

            <?php if ( $settings['enable_boxshadow']) : ?>
                    </div>
                </div>
            <?php endif;?>
            <?php if ( ! empty( $item['link']['url'] ) ) : ?>
                </a>
            <?php else: ?>  
                </span>
            <?php endif; ?>  
        

        <?php if ( $settings['enable_column']) : ?>
            </div>
        <?php endif;?>
    
        <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->files_upload_handler = Files_Upload_Handler::is_enabled();

        $default_settings = [];

        $settings = array_merge( $default_settings, $settings );
        $class    = $settings['enable_column'] ? 'row' : '';
        $this->add_render_attribute(
            'brands', [
                'class' => ''. $class .' d-flex flex-wrap align-items-center justify-content-center justify-content-md-start',
            ]
        );
        ?>


        <div <?php echo $this->get_render_attribute_string( 'brands' ); ?>>
            <?php
            foreach ( $settings['brand_logo'] as $index => $item ) :
                $this->print_item( $item, $settings, $index );
            endforeach; ?>
        </div><?php

    }
}
