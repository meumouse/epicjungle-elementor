<?php
namespace EpicJungleElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

use EpicJungleElementor\Modules\QueryControl\Module as Module_Query;
use EpicJungleElementor\Modules\QueryControl\Controls\Group_Control_Related;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Posts_Without_Image_Carousel extends Base {

    /**
     * @var \WP_Query
     */
    protected $query = null;

    public function get_name() {
        return 'ej-posts-carousel-without-image';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de postagens sem imagem', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'posts-carousel-without-image', 'posts', 'carousel', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
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
        //$this->register_post_count_control();
        $this->register_post_layout_controls();
        $this->register_query_section_controls();
        parent::register_controls();
        $this->register_slides_style_section_controls();

        $this->remove_control( 'slides' );
        $this->remove_control( 'image_class' );
        $this->remove_control( 'speed' );
        $this->remove_control( 'controls' );
        $this->update_responsive_control(
            'slides_per_view', [
                'options'   => [
                    ''      => __( 'Padrão', 'epicjungle-elementor' ),
                    '1'     => __( '1', 'epicjungle-elementor' ),
                    '2'     => __( '2', 'epicjungle-elementor' ),
                    '3'     => __( '3', 'epicjungle-elementor' ),
                    '4'     => __( '4', 'epicjungle-elementor' ),
                ],
            ]
        );

        $this->update_control(
            'nav',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__( 'Pontos', 'epicjungle-elementor' ),
                'default'      => 'yes',
                'label_off'    => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'label_on'     => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'prefix_class' => 'elementor-pagination-',
                'render_type'  => 'template',
                'frontend_available' => true,
            ]
        );


    }


    protected function register_post_layout_controls() {
        $this->start_controls_section(
            'section_post', [
                'label'     => esc_html__( 'Geral', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_border',
            [
                'label'     => esc_html__( 'Desativar borda', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'no',
            ]
        );

        $this->add_control(
            'show_box_shadow',
            [
                'label'     => esc_html__( 'Ativar sombra da caixa', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'no',
               
            ]
        );

        $this->end_controls_section();
    }



    public function query_posts( $settings ) {
        $query_args = [
            'posts_per_page' => $settings[ 'posts_per_page' ],
        ];

        /** @var Module_Query $elementor_query */
        $elementor_query = Module_Query::instance();
        $this->query = $elementor_query->get_query( $this, 'posts', $query_args, [] );
    }

    protected function register_query_section_controls() {
        $this->start_controls_section(
            'section_query', [
                'label'     => esc_html__( 'Query', 'epicjungle-elementor' ),
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

        $this->add_group_control(
            Group_Control_Related::get_type(),
            [
                'name'    => 'posts', //$this->get_name(),
                'presets' => [ 'full' ],
                'exclude' => [
                    'posts_per_page', //use the one from Layout section
                ],
            ]
        );


        
        //$this->remove_control( 'posts_post_type' );

        $this->end_controls_section();
    }


    protected function register_slides_style_section_controls() {
        $this->start_controls_section(
            'section_style_slides', [
                'label'     => esc_html__( 'Postagem', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'open_new_tab', [
                'label'     => esc_html__( 'Abrir em nova janela', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Não', 'epicjungle-elementor' ),
                'default'   => 'no',
                'render_type'   => 'none',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_typo_style', [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Opções de título', 'epicjungle-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color', [
                'label'     => esc_html__( 'Cor do texto do título', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ej-post__title a'   => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'      => 'title_typography',
                'selector'  => '{{WRAPPER}} .ej-post__title',
            ]
        );

        $this->add_control(
            'meta_typo_style', [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Meta opções', 'epicjungle-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_meta', [
                'label'     => esc_html__( 'Mostrar meta?', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'show_avatar', [
                'label'     => esc_html__( 'Mostrar avatar?', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_author', [
                'label'     => esc_html__( 'Mostrar autor?', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_date', [
                'label'     => esc_html__( 'Mostrar data?', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_author_typo_style', [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Opções de texto do autor', 'epicjungle-elementor' ),
                'separator' => 'before',
                'condition' => [
                    'show_meta'     => 'yes',
                    'show_author'   => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_author_color', [
                'label'     => esc_html__( 'Cor do texto do metaautor', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ej-post__meta--author'    => 'color: {{VALUE}} !important',
                ],
                'condition' => [
                    'show_meta'     => 'yes',
                    'show_author'   => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'      => 'meta_author_typography',
                'selector'  => '{{WRAPPER}} .ej-post__meta--author',
                'condition' => [
                    'show_meta'     => 'yes',
                    'show_author'   => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_date_typo_style', [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Opções de texto de data', 'epicjungle-elementor' ),
                'separator' => 'before',
                'condition' => [
                    'show_meta' => 'yes',
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_date_color', [
                'label'     => esc_html__( 'Cor do texto metadata', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ej-post__meta--date'  => 'color: {{VALUE}} !important',
                ],
                'condition' => [
                    'show_meta' => 'yes',
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'      => 'meta_date_typography',
                'selector'  => '{{WRAPPER}} .ej-post__meta--date',
                'condition' => [
                    'show_meta' => 'yes',
                    'show_date' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render_loop_header() {
        ?>
        <div class="cs-carousel posts-carousel-without-image">
            <div <?php echo $this->get_render_attribute_string( 'posts-slider' ); ?>>
            
        <?php
    }

    protected function render_loop_footer() {
        ?>
        </div></div>
                
        <?php
    }

    protected function render_image_html() {
        $settings = $this->get_settings();

        $post_id = get_the_ID();
        $post_thumbnail_id = get_post_thumbnail_id();

        $this->add_render_attribute( $post_id . '-card-img', [
            'class' => [ 'img-fluid', 'd-md-none', 'invisible' ],
        ] );

        if ( empty( $post_thumbnail_id ) || $post_thumbnail_id < 1 ) {
            $post_thumbnail_url = Utils::get_placeholder_image_src();
            $post_thumbnail_bg_url = 'background-image: url(' . $post_thumbnail_url . ');';
            $this->add_render_attribute( $post_id . '-card-img', [
                'src' => $post_thumbnail_url,
            ] );
        } else {
            $attachment_image = wp_get_attachment_image_src( $post_thumbnail_id, 'medium' );
            $post_thumbnail_bg_url = 'background-image: url(' . get_the_post_thumbnail_url() . ');';
            $this->add_render_attribute( $post_id . '-card-img', [
                'src' => $attachment_image[0],
            ] );
        }

        
        ?>
        <a class="card-img-top" href="<?php echo get_permalink(); ?>"<?php if( isset( $settings['open_new_tab'] ) && $settings['open_new_tab'] === 'yes' ) { echo esc_attr( ' target="_blank ' ); } ?>>
            <img <?php echo $this->get_render_attribute_string( $post_id . '-card-img' ); ?>>
        </a>
        <?php
        
    }

    protected function render_content_html() {
        $settings = $this->get_settings();
       
        if ( is_sticky() ):
            $this->render_loop_sticky_badge();
        endif;


        ?><article class="card card-hover h-100 pt-4 pb-5 mx-1<?php echo esc_attr( $settings['show_border'] === 'yes' ) ? ' border-0': ''; ?><?php echo esc_attr( $settings['show_box_shadow'] === 'yes' ) ? ' box-shadow': ''; ?>">
            <div class="card-body pt-5 px-4 px-xl-5">
            <span class="font-size-sm mb-2 d-block">
                <?php $this->render_loop_post_category( $settings ); ?>
            </span><?php
            $this->render_loop_title( $settings ); ?>
        </div>
            
        <?php if( ( isset( $settings['show_meta'] ) && $settings['show_meta'] === 'yes' ) && ( ( isset( $settings['show_avatar'] ) && $settings['show_avatar'] === 'yes' ) || ( isset( $settings['show_author'] ) && $settings['show_author'] === 'yes' ) || ( isset( $settings['show_date'] ) && $settings['show_date'] === 'yes' ) ) ) {
            $this->render_loop_meta( $settings );
        } ?>
        </article><?php
        
    }

   

    protected function render_loop_title() { 
    $settings = $this->get_settings(); ?>
    <h3 class="ej-post__title h4 nav-heading mb-4">
        <a href="<?php echo esc_url( get_permalink() ); ?>"<?php if( isset( $settings['open_new_tab'] ) && $settings['open_new_tab'] === 'yes' ) { echo esc_attr( ' target="_blank ' ); } ?>>
            <?php echo get_the_title(); ?>  
        </a>
    </h3><?php

        
    }

    protected function render_loop_sticky_badge() { ?>
        <span class="badge badge-lg badge-floating badge-floating-right badge-success"><?php echo esc_html( 'Destacado', 'epicjungle-elementor' );?></span><?php
    }

    protected function render_loop_post_category() { 
        $categories = get_the_terms( get_the_ID(), 'category' );

        if ( ! empty( $categories ) ) : 
                echo implode( ', ', array_map( function ( $category ) {
                $settings = $this->get_settings();
                $cat_new_tab = ( isset( $settings['open_new_tab'] ) && $settings['open_new_tab'] === 'yes' ) ?  esc_attr ( ' target="_blank ' ) : '';
                return sprintf( '<a href="%s"%s class="meta-link">%s</a>',
                    esc_url( get_category_link( $category ) ),
                    esc_attr( $cat_new_tab ),
                    esc_html( $category->name )
                );
            }, $categories ) ); 
        endif; unset( $categories ); 
    }

    protected function render_loop_meta( $settings ) {
        ?>

        <div class="px-4 px-xl-5 pt-2">
            <a class="media meta-link font-size-sm align-items-center" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"<?php if( isset( $settings['open_new_tab'] ) && $settings['open_new_tab'] === 'yes' ) { echo esc_attr( ' target="_blank ' ); } ?>>
                <?php if( isset( $settings['show_avatar'] ) && $settings['show_avatar'] === 'yes' ) { ?>
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 42, '', get_the_author_meta( 'display_name' ), [ 'class' => 'avatar-img rounded-circle loaded tns-complete' ] ); ?>
                <?php } ?>

                <?php if( isset( $settings['show_author'] ) && $settings['show_author'] === 'yes' ) { ?>
                    <div class="media-body pl-2 ml-1 mt-n1"><?php echo esc_html__( 'por', 'epicjungle-elementor' );?><span class="ej-post__meta--author font-weight-semibold ml-1"><?php the_author(); ?></span></div>
                <?php } ?>
            </a>
            <?php if( isset( $settings['show_date'] ) && $settings['show_date'] === 'yes' ) { ?>
                <div class="mt-3 text-right text-nowrap">
                    <a class="meta-link font-size-xs" href="<?php echo get_permalink(); ?>"<?php if( isset( $settings['open_new_tab'] ) && $settings['open_new_tab'] === 'yes' ) { echo esc_attr( ' target="_blank ' ); } ?>><i class="fe fe-calendar mr-2 mt-n1"></i><time datetime="<?php echo get_the_date('d-m-Y'); ?>"><?php echo get_the_date('j'); ?><?php echo get_the_date( ' M'); ?></time></a>
                </div>
            <?php } ?>
        </div>

        <?php
    }

   


    protected function render_post() { ?>
        <div class="pb-2">
            <?php $this->render_content_html(); ?>

        </div><?php
        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->query_posts( $settings );

        /** @var \WP_Query $query */
        $query = $this->get_query();


        if ( ! $query->found_posts ) {
            return;
        }

        $uniqId = 'posts-slider-' . $this->get_id();

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
            'posts-slider', [
                'class'                 => 'cs-carousel-inner',
                'data-carousel-options' => htmlspecialchars( json_encode( $content_carousel_settings ), ENT_QUOTES, 'UTF-8' ),
                'data-aos-id' => 'carousel:in',
                'data-aos'    => true,
            ]
        ); ?>
        
         <div class="cs-carousel posts-carousel-without-image">
            <div <?php echo $this->get_render_attribute_string( 'posts-slider' ); ?>>
            <?php while ( $query->have_posts() ) {
                $query->the_post();

                $this->render_post();
            } ?>

        </div></div><?php
        wp_reset_postdata();
        
    }

}