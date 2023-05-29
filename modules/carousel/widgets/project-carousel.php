<?php
namespace EpicJungleElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use EpicJungleElementor\Modules\QueryControl\Module as Module_Query;
use EpicJungleElementor\Modules\QueryControl\Controls\Group_Control_Related;
use EpicJungleElementor\Core\Utils as EJ_Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Project_Carousel extends Base {

    /**
     * @var \WP_Query
     */
    protected $query = null;

    public function get_name() {
        return 'ej-project-carousel';
    }
    //public function __construct( Elementor\Widget_Base $parent ) {
     //   parent::__construct( $parent );
    //}

    public function get_title() {
        return esc_html__( 'Carrossel de projetos', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'project-carousel', 'project', 'carousel', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
    }

    public function get_query() {
        return $this->query;
    }

    public function on_import( $element ) {
        if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
            $element['settings']['posts_post_type'] = 'post';
        }

        return $element;
    }

    protected function add_repeater_controls( Repeater $repeater ) {}

    protected function get_repeater_defaults() {}

    protected function print_slide( array $slide, array $settings, $element_key ) {}

    protected function register_controls() {
      
        $this->register_title_controls();
        $this->register_query_section_controls();

        parent::register_controls();
       }

    public function query_posts( $settings ) {
        $query_args = [
            'posts_per_page' => $settings[ 'posts_per_page' ],
        ];

        /** @var Module_Query $elementor_query */
        $elementor_query = Module_Query::instance();
        $this->query = $elementor_query->get_query( $this, 'posts', $query_args, [] );
    }

    protected function register_title_controls() {
         $this->start_controls_section(
            'section_layout', [
                'label'     => esc_html__( 'Layout', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

         $this->add_control(
            'posts_per_page',
            [
                'label' => __( 'Postagens por página', 'epicjungle-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 3,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'     => esc_html__( 'Título', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'     => esc_html__( 'Tag HTML do título', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default'   => 'h3',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'exclude' => [ 'custom' ],
                'default' => 'medium',
                'prefix_class' => 'elementor-portfolio--thumbnail-size-',
            ]
        );
        $this->end_controls_section();
    }

    protected function register_query_section_controls() {
        $this->start_controls_section(
            'section_query', [
                'label'     => esc_html__( 'Query', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            Group_Control_Related::get_type(),
            [
                'name'    => 'posts', 
                'presets' => [ 'full' ],
                'exclude' => [
                    'posts_per_page', 
                ],
            ]
        );

        $this->end_controls_section();
    }



    protected function render_project_loop_header() {
      ?>
      <div class="cs-carousel">        
       <div <?php echo $this->get_render_attribute_string( 'project-carousel' ); ?>>
        <?php
         }

    public function render_project_post() { 
          ?>
        <div class="pb-2">
            <!-- Card -->
            <div class="card card-curved-body box-shadow card-slide mx-1">
                <!-- Image -->  
                <div class="card-slide-inner">
                    <?php $this->render_thumbnail("card-img"); ?>
                    <a class="card-body text-center" href="<?php echo esc_url( get_permalink() );?>">
                        <!-- Heading -->
                        <?php $this->render_portfolio_title(); ?>
                        <!-- Preheading -->
                        <?php $this->render_portfolio_category(); ?>
                    </a>
                </div>
            </div>
        </div>
    <?php  }

    protected function render_portfolio_title() {
        $settings    = $this->get_settings();
       // echo '<pre>'.print_r($settings,1).'</pre>';exit;


        $show_title  = $settings['show_title'];
        if ( $show_title != 'yes') {
            return;
        }
        $tag = $settings['title_tag'];
        ?>
        <<?php echo $tag;?> <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php the_title(); ?></<?php echo $tag; ?>><?php
    }

     protected function render_portfolio_category() { ?>
        <p <?php echo $this->get_render_attribute_string( 'category' ); ?>><?php echo strip_tags( get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ' ) ); ?></p>
   <?php }


protected function render_thumbnail( $img_classes ) {

        $settings = $this->get_settings();
         $setting_key=$settings ['thumbnail_size_size'];
        // echo $setting_key;
        $settings[ $setting_key ] = [
            'id' => get_post_thumbnail_id(),
        ];

        $thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, $setting_key );
        $thumbnail_html = EJ_Utils::add_class_to_image_html( $thumbnail_html, $img_classes );

        if ( empty( $thumbnail_html ) ) {
            return;
        }       
                 echo $thumbnail_html; ?>   
        <?php
    }


public function set_render_attributes() {
        $this->add_render_attribute( 'title', 'class', [
             'h5', 'nav-heading', 'mt-1 mb-2'
        ] );

        $this->add_render_attribute( 'category', 'class', [
             'font-size-sm', 'text-muted', 'mb-1'
        ] );

    }


     protected function render_masonry_loop_footer() {?>
        </div>
        </div> <!-- / .row -->
    <?php }

 public function render() {
        $settings = $this->get_settings_for_display();
        $this->query_posts( $settings );
        /** @var \WP_Query $query */
        $query = $this->get_query();
        if ( ! $query->found_posts ) {
            return;
        }

         $uniqId = 'project-carousel-' . $this->get_id();

        $default_settings = [];

        $settings  = array_merge( $default_settings, $settings );

        $column    = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 2;
        $column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 3;
        $column_lg = ! empty( $settings['slides_per_view'] )        ? intval( $settings['slides_per_view'] )        : 3;

        $gutter    = ! empty( $settings['gutter_mobile']['size'] ) ? intval( $settings['gutter_mobile']['size'] ) : 16;
        $gutter_md = ! empty( $settings['gutter_tablet']['size'] ) ? intval( $settings['gutter_tablet']['size'] ) : 16;
        $gutter_lg = ! empty( $settings['gutter']['size'] )        ? intval( $settings['gutter']['size'] )        : 23;


        $content_carousel_settings = [
            'nav'               => isset( $settings['nav'] ) && $settings['nav'] === 'yes' ? true : false,
            'autoHeight'        => true,
            'controls'          => isset( $settings['controls'] ) && $settings['controls'] === 'yes' ? true : false,
            'items'             => $this->get_settings( 'posts_per_page' ),
            'responsive'        => array (
                '0'       => array( 'items'   => 1, 'gutter' => $gutter ),
                '576'     => array( 'items'   => $column, 'gutter' => $gutter ),
                '900'     => array( 'items'   => $column_md, 'gutter' => $gutter_md ),
                '1100'    => array( 'items'   => $column_lg, 'gutter' => $gutter_lg ),
            )
        ];

        if( isset( $settings['autoplay'] ) && $settings['autoplay'] === 'yes' ) {
           $content_carousel_settings['autoplay'] = $settings['autoplayTimeout'] ? $settings['autoplayTimeout'] : 1500;
          $content_carousel_settings['pauseAutoPlayOnHover'] = isset( $settings['pause_on_hover'] ) && $settings['pause_on_hover'] === 'yes' ? true : false;
        }

         $this->add_render_attribute(
            'project-carousel', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); 

        $this->render_project_loop_header();
        // It's the global `wp_query` it self. and the loop was started from the theme.
        if ( $query->in_the_loop ) {
            $this->current_permalink = get_permalink();
            $this->render_project_post();
        } else {
            $this->set_render_attributes();
            while ( $query->have_posts() ) {
                $query->the_post();
                $this->current_permalink = get_permalink();
                $this->render_project_post();
            }
        }
        wp_reset_postdata();
        $this->render_masonry_loop_footer();
    }
}