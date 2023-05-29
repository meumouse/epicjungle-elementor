<?php
namespace EpicJungleElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use EpicJungleElementor\Modules\Carousel\Skins;
use EpicJungleElementor\Modules\QueryControl\Module as Module_Query;
use EpicJungleElementor\Modules\QueryControl\Controls\Group_Control_Related;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Posts_Carousel extends Base {

    /**
     * @var \WP_Query
     */
    protected $query = null;

    public function get_name() {
        return 'ej-carousel-1';
    }

    public function get_title() {
        return esc_html__( 'Carrossel de postagens', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'posts-carousel', 'posts', 'carousel', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
    }

    public function get_query() {
        return $this->query;
    }


    protected function register_skins() {
        $this->add_skin( new Skins\Event_Carousel( $this ) );
        $this->add_skin( new Skins\Skin_Featured_Post( $this ) );
        $this->add_skin( new Skins\Post_Video_Carousel( $this ) );
        
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
        
        $this->register_post_layout_controls();

        $this->register_query_section_controls();

        parent::register_controls();

        $this->register_slides_style_section_controls();
        
        $this->remove_control( 'slides' );
        $this->remove_control( 'image_class' );
        $this->remove_control( 'speed' );
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

        $this->update_responsive_control(
            'controls_position',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Posição dos controles', 'epicjungle-elementor' ),
                'options' => [
                    'cs-controls-center'  => esc_html__( 'Centro', 'epicjungle-elementor' ),
                    'cs-controls-left'    => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                    'cs-controls-right'   => esc_html__( 'Direita', 'epicjungle-elementor' ),
                    'cs-controls-inside'  => esc_html__( 'Dentro', 'epicjungle-elementor' ),
                    'cs-controls-outside' => esc_html__( 'Fora', 'epicjungle-elementor' ),
                    'cs-controls-onhover' => esc_html__( 'Ao passar o mouse', 'epicjungle-elementor' ),
                    
                ],
                'default'      => 'cs-controls-right',
                'condition' => [
                    'controls' => 'yes',
                    '_skin!'   => 'skin-featured-post'
                ],
                'frontend_available' => true,
            ]
        );

        

    }


    public function query_posts( $settings ) {
        $query_args = [
            'posts_per_page' => $settings[ 'posts_per_page' ],
        ];

        //@var Module_Query $elementor_query 
        $elementor_query = Module_Query::instance();
        $this->query = $elementor_query->get_query( $this, 'posts', $query_args, [] );
    }

    protected function register_query_section_controls() {
        $this->start_controls_section(
            'section_post_carousel_query', [
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




    protected function register_post_layout_controls() {
    	$this->start_controls_section(
            'section_post', [
                'label'     => esc_html__( 'Geral', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'show_category',
			[
				'label'     => esc_html__( 'Categoria', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control( 'show_image', 
			[
	            'label' => __( 'Mostrar imagem', 'epicjungle-elementor' ),
	            'default' => 'yes',
	            'type'      => Controls_Manager::SWITCHER,
	            'options' => [
	                 'yes' => __( 'Sim', 'epicjungle-elementor' ),
	                 'none' => __( 'Não', 'epicjungle-elementor' ),
	            ],
            ]
        );

		$this->add_control(
			'show_sticky_badge',
			[
				'label'     => esc_html__( 'Mostrar emblema fixo', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',
                'condition' => [
                    '_skin!'  => 'skin-featured-post',
                ],

			]
		);

		$this->add_control( 'featured', [
            'label'     => esc_html__( 'Posição do emblema fixo', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'left',
            'options'   => [
                'left'  => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                'right'  => esc_html__( 'Direita', 'epicjungle-elementor' ),
            ],
            'condition' => [
				'show_sticky_badge' => 'yes',
                '_skin!'  => 'skin-featured-post',
			],
        ] );

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

		$this->add_control(
			'meta_data',
			[
				'label' => __( 'Metadados', 'epicjungle-elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => [ 'date', 'comments' ],
				'multiple' => true,
				'options' => [
					'date' => __( 'Data', 'epicjungle-elementor' ),
					'comments' => __( 'Comentários', 'epicjungle-elementor' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'     => esc_html__( 'Autor', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',
                'condition' => [
                    '_skin!'  => 'skin-featured-post',
                ],
			]
		);

        $this->add_control(
            'enable_progress_bar',
            [
                'label'     => esc_html__( 'Mostrar barra de progresso', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
                'condition' => [
                    '_skin'  => 'skin-featured-post',
                ],
            ]
        );


        $this->add_control(
            'show_floating_text',
            [
                'label'     => esc_html__( 'Mostrar texto flutuante', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'condition' => [
                    '_skin'  => 'skin-featured-post',
                ],
            ]
        ); 

        $this->add_control(
            'floating_text',
            [
               'label'        => esc_html__( 'Texto flutuante', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'       => esc_html__( 'Conheça a viagem', 'epicjungle-elementor' ),
                'label_block' => true,
                'condition' => [ 
                    'show_floating_text' => 'yes' ,
                     '_skin'  => 'skin-featured-post',
                ],
                
            ]
        );

        $this->add_control(
            'selected_item_icon',
            [
                'label'            => esc_html__( 'Ícone', 'epicjungle-elementor' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'item_icon',
                'default' => [
                    'value'   => 'fe-chevron-right',
                    'library' => 'fe-regular',
                ],
                'condition' => [ 
                    'show_floating_text' => 'yes',
                    '_skin'  => 'skin-featured-post',
                ],

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section (
            'section_floating_text',
            [
                'label' => __( 'Texto flutuante', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 
                    'show_floating_text' => 'yes' ,
                     '_skin'  => 'skin-featured-post',
                ],
                
            ]
        );

        $this->add_control(
            'floating_text_color',
            [
                'label'     => __( 'Cor do texto flutuante', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cs-carousel-inner .card .card-img-top .ej-floating-text' => 'color: {{VALUE}};',
                ],
                'condition' => [ 
                    'show_floating_text' => 'yes' ,
                     '_skin'  => 'skin-featured-post',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'floating_text_typography',
                'selector' => '{{WRAPPER}} .cs-carousel-inner .card .card-img-top .ej-floating-text',
                'condition' => [ 
                    'show_floating_text' => 'yes' ,
                     '_skin'  => 'skin-featured-post',
                ],
            ]
        );

        $this->add_control(
            'floating_text_css', [
                'label'   => esc_html__( 'Classe CSS do texto flutuante', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para a descrição do cartão. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default' => 'text-light font-weight-medium',
                 'condition' => [ 
                    'show_floating_text' => 'yes' ,
                     '_skin'  => 'skin-featured-post',
                ],


            ]
        ); 


         $this->end_controls_section();
	}

	


    protected function register_slides_style_section_controls() {
        $this->start_controls_section(
            'section_style_slides', [
                'label'     => esc_html__( 'Postagem', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title'  => 'yes',
                ],
            ]
        );

        
        $this->add_control(
            'title_typo_style', [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__( 'Opções de título', 'epicjungle-elementor' ),
                'separator' => 'before',
                'condition' => [
                    'show_title'  => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color', [
                'label'     => esc_html__( 'Cor do texto do título', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ej-post__title a'   => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title'  => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'      => 'title_typography',
                'selector'  => '{{WRAPPER}} .ej-post__title',
                'condition' => [
                    'show_title'  => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

  
   
    protected function render_image() {
    	$settings = $this->get_settings();
        if ( 'none' === $settings['show_image'] ) {
            return;
        }

        $img_class = 'img-fluid';

        the_post_thumbnail( 'full', [ 'class' => $img_class ] ); 
     }

    protected function render_featured_image() {
    	$settings = $this->get_settings();
        if ( ! has_post_thumbnail()  ) {
            return;
        }
        ?><!-- Image -->
        <?php if ( $settings['show_image'] ) : ?>
            <a class="card-img-top" href="<?php echo esc_url( get_permalink() ); ?>">
                <?php $this->render_image(); ?>
            </a><?php
        endif;
       

    }

    protected function render_category() {
    	$settings = $this->get_settings();
        if ( 'yes' === $settings['show_category'] ) : 
            $categories = get_the_terms( get_the_ID(), 'category' );
            if ( ! empty( $categories ) ) : ?>
                    <?php
                        echo implode( ', ', array_map( function ( $category ) {
                        return sprintf( '<a href="%s" class="meta-link">%s</a>',
                            esc_url( get_category_link( $category ) ),
                            esc_html( $category->name )
                        );
                    }, $categories ) ); ?>
                <?php endif; unset( $categories ); 
        endif; 
    }


    protected function render_card_body() {
 		$settings = $this->get_settings();
        $card_body  = 'card-body';
        $heading    = 'card-body__heading post__title h5 nav-heading mb-4 ej-post__title';
        $category   = 'card-body__category post__category';
        $title_tag  = $settings['title_tag'];

    
        ?><!-- Body -->

        <div class="<?php echo esc_attr( $card_body ); ?>">
            
            <span class="post__category mb-2 d-inline-block font-size-sm"><?php $this->render_category(); ?></span>

            <?php if ( 'yes' === $settings['show_title'] ) : ?>
            <!-- Heading -->
            <<?php echo $title_tag; ?> class="<?php echo esc_attr( $heading ); ?>">
                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
            </<?php echo $title_tag; ?>>
            <?php endif; ?>
            <?php if ( 'yes' === $settings['show_author'] ) : ?>
            <a class="media meta-link font-size-sm align-items-center pt-3" href="<?php echo esc_url( get_permalink() ); ?>">
                <?php $this->render_avatar(); ?>
                <?php $this->render_author(); ?>
            </a>
            <?php endif; ?>

            <?php $this->render_meta_data(); ?>
            
        </div>


        <?php
    }


    protected function render_meta_divider() {
        ?><!-- Divider -->
        <span class="meta-divider"><?php $this->get_instance_value( 'meta_separator' ); ?></span><?php
    }

    protected function render_avatar() {
        echo get_avatar( get_the_author_meta( 'ID' ), 36, '', '', [ 'class' => 'avatar-img rounded-circle' ] ); 
    }

    protected function render_author() {
        ?><!-- Author -->
        <div class="media-body pl-2 ml-1 mt-n1"><span class="font-weight-semibold ml-1"><?php esc_html('por', 'epicjungle-elementor'); ?><?php the_author(); ?></span>
        </div><?php
        
    }

    protected function render_meta_data() {
        $settings = $this->get_settings();
        $meta_data = $settings['meta_data'];

        if ( empty( $meta_data ) ) {
            return;
        }
        ?>
        <div class="card-meta mt-3 text-right text-nowrap elementor-post__meta-data">
            <?php

            if ( in_array( 'comments', $meta_data ) ) {
                $this->render_comment();
            }

            if ( in_array( 'date', $meta_data ) ) {
                $this->render_date();
            }

            ?>
        </div>
        <?php
    }

    protected function render_date() { 
        ?><!-- Date -->
        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>">
            <i class="fe fe-calendar mr-1 mt-n1"></i>&nbsp;
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date( 'j M'); ?></time>
        </a><?php
    }

    protected function render_time() {
        ?>
        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>">
            <i class="fe fe-clock mr-1 mt-n1"></i>&nbsp;
            <?php the_time(); ?>
        </a>
        <?php
    }


    protected function render_comment() {
        ?><!-- Date -->

        <a class="meta-link font-size-xs" href="<?php echo esc_url( get_permalink() ); ?>"><i class="fe fe-message-square mr-1"></i>&nbsp;<?php comments_number(); ?></a><span class="meta-divider"></span><?php
    }


    public function render_featured_left() { ?>
        <span class="badge badge-floating badge-pill badge-primary badge-floating-left">
            <?php echo esc_html( 'Destacado', 'epicjungle-elementor' );?>
        </span><?php
    }

    public function render_featured_right() { ?>
        <span class="badge badge-floating badge-pill badge-primary badge-floating-right">
            <?php echo esc_html( 'Destacado', 'epicjungle-elementor' );?>
        </span><?php    
    }

    public function render_is_featured_sticky($featured) { 
    	$settings = $this->get_settings();
        $featured = $settings['featured'];

        if( 'left' === $featured ){
            $this->render_featured_left();
        } else {
            $this->render_featured_right();
        }
    }

    protected function render_content_html() {
        $settings = $this->get_settings();
        $featured = $settings['featured'];

        ?><article class="card card-hover mx-1">

            <?php if( is_sticky() && ( 'yes' === $settings['show_sticky_badge'] ) ){
                $this->render_is_featured_sticky( $featured );
            }
            
            $this->render_featured_image(); ?>

            <?php $this->render_card_body(); ?>

        </article><?php
    }


    protected function render_post() { ?>
        <div class="pb-2"><?php
            $this->render_content_html(); ?>
        </div><?php
        
    }

    protected function render_loop_header() {
        ?>
        <div class="cs-carousel epicjungle-posts-carousel">
            <div <?php echo $this->get_render_attribute_string( 'posts-slider' ); ?>>
            
        <?php
    }

    protected function render_loop_footer() {
        ?>
        </div></div>
                
        <?php
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
        ); 

        $this->render_loop_header();
            while ( $query->have_posts() ) {
                $query->the_post();

                $this->render_post();
            } 

       $this->render_loop_footer();
        wp_reset_postdata();
        
    }

}