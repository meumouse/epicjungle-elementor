<?php
namespace EpicJungleElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use EpicJungleElementor;
use EpicJungleElementor\Plugin;
use EpicJungleElementor\Core\Utils as EJ_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Skin_Base extends Elementor_Skin_Base {

	/**
	 * @var string Save current permalink to avoid conflict with plugins the filters the permalink during the post render.
	 */
	protected $current_permalink;

	protected function _register_controls_actions() {
		add_action( 'elementor/element/ej-posts/section_layout/before_section_end', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/ej-posts/section_query/after_section_end', [ $this, 'register_design_controls' ] );
	}

	public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_post_count_control();
		$this->register_thumbnail_controls();
		$this->register_sticky_badge_controls();
		$this->register_category_controls();
		$this->register_title_controls();
		$this->register_author_controls();
		$this->register_meta_data_controls();
		
		
	}

	public function register_design_controls( Widget_Base $widget ) {
		$this->parent = $widget;
		
		$this->register_design_content_controls();
	}

	protected function register_thumbnail_controls() {
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

        $this->add_control( 'show_video', 
			[
	            'label' => __( 'Mostrar vídeo', 'epicjungle-elementor' ),
	            'default' => 'yes',
	            'type'      => Controls_Manager::SWITCHER,
	            'options' => [
	                 'yes' => __( 'Sim', 'epicjungle-elementor' ),
	                 'none' => __( 'Não', 'epicjungle-elementor' ),
	            ],
	            'condition' => [
					'_skin' => 'epicjungle-posts-with-sidebar',
				],
            ]
        );

        

        $this->add_control( 'style', [
            'label'   => esc_html__( ' Estilo ', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
                'horizontal' => esc_html__( 'Horizontal', 'epicjungle-elementor' ),
                'vertical'   => esc_html__( 'Vertical', 'epicjungle-elementor' ),
            ],
        ] );

       $this->add_control( 'show_masonry', [
            'label'     => __( 'Ativar alvenaria', 'epicjungle-elementor' ),
            'default'   => 'no',
            'type'      => Controls_Manager::SWITCHER,
            'yes'       => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
			'no'        => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
			'condition' => [
				$this->get_control_id( 'style!' ) => 'horizontal',
			]
            ]            
        );

        $this->add_control( 'data_column',
        	[
	            'label' => __( 'Coluna de dados', 'epicjungle-elementor' ),
	            'type'      => Controls_Manager::SELECT,
	            'default'   => '4',
	            'options'   => [
	                '2'  => esc_html__( '2', 'epicjungle-elementor' ),
	                '3'  => esc_html__( '3', 'epicjungle-elementor' ),
	                '4'  => esc_html__( '4', 'epicjungle-elementor' ),
	            
	            ],
	            'condition' => [
					$this->get_control_id( 'show_masonry' ) => 'yes',
				],
            ]
        );

        $this->add_control( 'width',
        	[
	            'label' => __( 'Coluna', 'epicjungle-elementor' ),
	            'type'      => Controls_Manager::SELECT,
	            'default'   => '4',
	            'options'   => [
	                '2'  => esc_html__( '2', 'epicjungle-elementor' ),
	                '3'  => esc_html__( '3', 'epicjungle-elementor' ),
	                '4'  => esc_html__( '4', 'epicjungle-elementor' ),
	                '5'  => esc_html__( '5', 'epicjungle-elementor' ),
	                '6'  => esc_html__( '6', 'epicjungle-elementor' ),
	            ],
	            'condition' => [
					$this->get_control_id( 'show_masonry' ) => '',
					$this->get_control_id( 'style' ) => 'vertical',
				],
            ]
        );
  
	}

	protected function register_post_count_control() {
		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Postagens por página', 'epicjungle-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);
	}

	protected function register_card_width_control() {

		$this->add_control( 'width', [
            'label'     => esc_html__( 'Largura', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => '4',
            'options'   => [
                '4'  => esc_html__( 'Um terço', 'epicjungle-elementor' ),
                '8'  => esc_html__( 'Dois terços', 'epicjungle-elementor' ),
                '6'  => esc_html__( 'Metade', 'epicjungle-elementor' ),
                '12' => esc_html__( 'Completo', 'epicjungle-elementor' ),
            ],
            'condition' => [
				$this->get_control_id( 'show_masonry' ) => 'none',
			],
        ] );
	}

	protected function register_category_controls() {
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
	}

	protected function register_sticky_badge_controls() {
		$this->add_control(
			'show_sticky_badge',
			[
				'label'     => esc_html__( 'Mostrar emblema fixo', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'default'   => 'yes',
				'separator' => 'before',
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
				$this->get_control_id( 'show_sticky_badge' ) => 'yes',
			],
        ] );
	}

	protected function register_title_controls() {
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
			'show_content',
			[
				'label'     => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
				'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
				'default'   => 'yes',
				'condition' => [
					'_skin' => 'epicjungle-posts-with-sidebar',
				],
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
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);
	}

	protected function register_meta_data_controls() {
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

	}

	protected function register_author_controls() {
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
					'_skin!' => 'epicjungle-posts-with-sidebar',
				],
			]
		);
	}	

	/**
	 * Style Tab
	 */

	protected function register_design_content_controls() {
		$this->start_controls_section(
			'section_design_content',
			[
				'label' => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label'     => esc_html__( 'Título', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .card-body__heading, {{WRAPPER}} .card-body__heading a' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector'  => '{{WRAPPER}} .card-body__heading, {{WRAPPER}} .card-body__heading a',
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		
		$this->end_controls_section();
	}

    /**
    * Function to display Portfolio Category
    */

   protected function render_portfolio_category() { ?>
        <p <?php echo $this->parent->get_render_attribute_string( 'category' ); ?>><?php echo strip_tags( get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ' ) ); ?></p>
   <?php }

	protected function render_loop_start() {
		$width         = $this->get_instance_value( 'data_column' ); 
		$style         = $this->get_instance_value( 'style' );
		$masonry       = $this->get_instance_value( 'show_masonry' );

		if ( 'vertical' === $style && 'yes' === $masonry ) : ?>
			<div class="cs-masonry-grid overflow-hidden" data-columns="<?php echo $width;?>">
		<?php else: ?>
			<div class="row"><?php 
		endif;
	}

	public function render() {
		$this->parent->query_posts();
		$settings = $this->parent->get_settings();
		/** @var \WP_Query $query */
		$query = $this->parent->get_query();

		if ( ! $query->found_posts ) {
			return;
		}
		$this->render_loop_start();
		// It's the global `wp_query` it self. and the loop was started from the theme.
		if ( $query->in_the_loop ) {
			$this->current_permalink = get_permalink();
			$this->render_post();
		} else {
			while ( $query->have_posts() ) {
				$query->the_post();

				$this->current_permalink = get_permalink();
				$this->render_post();
			}
		}
		wp_reset_postdata();
		$this->render_loop_end();
    }

	protected function render_loop_end() {
		if ( $this->get_instance_value( 'show_masonry' ) ) : ?>
			</div>
		<?php else: ?>
			</div><?php
		endif;


    $parent_settings = $this->parent->get_settings();
		if ( '' === $parent_settings['pagination_type'] ) {
			return;
		}

		$page_limit = $this->parent->get_query()->max_num_pages;
		if ( '' !== $parent_settings['pagination_page_limit'] ) {
			$page_limit = min( $parent_settings['pagination_page_limit'], $page_limit );
		}

		if ( 2 > $page_limit ) {
			return;
		}

		$this->parent->add_render_attribute( 'pagination', 'class', 'elementor-pagination' );

		$has_numbers = in_array( $parent_settings['pagination_type'], [ 'numbers', 'numbers_and_prev_next' ] );
		$has_prev_next = in_array( $parent_settings['pagination_type'], [ 'prev_next', 'numbers_and_prev_next' ] );

		$links = [];

		if ( $has_numbers ) {
			$paginate_args = [
				'type' => 'array',
				'current' => $this->parent->get_current_page(),
				'total' => $page_limit,
				'prev_next' => false,
				'show_all' => 'yes' !== $parent_settings['pagination_numbers_shorten'],
				'before_page_number' => '<span class="elementor-screen-only">' . __( 'Página', 'epicjungle-elementor' ) . '</span>',
			];

			if ( is_singular() && ! is_front_page() ) {
				global $wp_rewrite;
				if ( $wp_rewrite->using_permalinks() ) {
					$paginate_args['base'] = trailingslashit( get_permalink() ) . '%_%';
					$paginate_args['format'] = user_trailingslashit( '%#%', 'single_paged' );
				} else {
					$paginate_args['format'] = '?page=%#%';
				}
			}

			$links = paginate_links( $paginate_args );
		}

		if ( $has_prev_next ) {
			$prev_next = $this->parent->get_posts_nav_link( $page_limit );
			array_unshift( $links, $prev_next['prev'] );
			$links[] = $prev_next['next'];
		}

		?>
		<nav class="elementor-pagination" role="navigation" aria-label="<?php esc_attr_e( 'Paginação', 'epicjungle-elementor' ); ?>">
			<?php echo implode( PHP_EOL, $links ); ?>
		</nav>
		<?php
  }

	protected function render_thumbnail( $img_classes ) {
		$thumbnail = $this->get_instance_value( 'thumbnail' );

		if ( 'none' === $thumbnail && ! EpicJungleElementor\Plugin::elementor()->editor->is_edit_mode() ) {
			return;
		}

		$settings = $this->parent->get_settings();
		$setting_key = $this->get_control_id( 'thumbnail_size' );
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

	protected function render_portfolio_title() {
		$settings    = $this->parent->get_settings();
		$show_title  = $settings['show_title'];
		if ( $show_title != 'yes') {
			return;
		}
		$tag = $settings['title_tag'];
		?>
		<<?php echo $tag;?> <?php echo $this->parent->get_render_attribute_string( 'title' ); ?>><?php the_title(); ?></<?php echo $tag; ?>><?php
	}

	 protected function portfolio_filters() {
        $portfolio_cats = array();
        $query = $this->parent->get_query();
        while ( $query->have_posts() ) : 
            $query->the_post();
			//$portfolio_types = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', '', ', ', '' ); 
            $portfolio_types = get_the_terms( get_the_ID(), 'jetpack-portfolio-tag' );
        
            if ( ! $portfolio_types || is_wp_error( $portfolio_types ) ) {
                $portfolio_types = array();
            }

            $portfolio_types = array_values( $portfolio_types );

            foreach ( array_keys( $portfolio_types ) as $key ) {
                _make_cat_compat( $portfolio_types[ $key ] );           
            }

            foreach ( $portfolio_types as $portfolio_type ) {
                $portfolio_cats[ $portfolio_type->slug] = $portfolio_type->name;
            }

        endwhile; ?>
        
        <ul class="cs-masonry-filters nav nav-tabs justify-content-center mt-2 pb-4">
          
            <li class="nav-item">
            	<a class="nav-link active" href="#" data-group="all">All</a>
            </li>

            <?php foreach ( $portfolio_cats as $key => $portfolio_cat ): ?>

            	<li class="nav-item">
            		<a class="nav-link" href="#" data-group="<?php echo esc_attr( $key ); ?>" ><?php echo $portfolio_cat; ?>
            		</a>
            	</li>
            <?php endforeach; ?>
        </ul>
    <?php }
}