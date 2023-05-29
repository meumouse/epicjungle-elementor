<?php
namespace EpicJungleElementor\Modules\NavMenu\Widgets;

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
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Responsive\Responsive;
use EpicJungleElementor\Plugin;
use EpicJungleElementor\Modules\NavMenu\Skins;

/**
 * EpicJungle Elementor Market Button widget.
 *
 * EpicJungle Elementor widget that displays a Market Button with the ability to control every
 * aspect of the Market Button design.
 *
 * @since 1.0.0
 */
class Nav_Menu extends Base_Widget {

	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Footer_Icons( $this ) );
		$this->add_skin( new Skins\Skin_Topbar_Right_Nav( $this ) );
		$this->add_skin( new Skins\Skin_Topbar_Left_Nav( $this ) );
		$this->add_skin( new Skins\Skin_Header_Nav( $this ) );
		$this->add_skin( new Skins\Skin_Navbar_Tool( $this ) );
	}

	protected $nav_menu_index = 1;

    private $files_upload_handler = false;

    /**
     * Get widget name.
     *
     * Retrieve Market Button widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'ej-nav-menu';
    }

    /**
     * Get widget title.
     *
     * Retrieve Market Button widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Menu de navegação', 'epicjungle-elementor' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Market Button widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-nav-menu';
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
        return [ 'ej-nav-menu', 'menu' ];
    }

    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    public function get_script_depends() {
		return [ 'smartmenus' ];
	}

	public function on_export( $element ) {
		unset( $element['settings']['menu'] );

		return $element;
	}

	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'epicjungle-elementor' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label' => __( 'Menu', 'epicjungle-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description' => sprintf( __( 'Vá para a <a href="%s" target="_blank">tela de menus</a> para gerenciar seus menus.', 'epicjungle-elementor' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'Não há menus em seu site.', 'epicjungle-elementor' ) . '</strong><br>' . sprintf( __( 'Vá para a <a href="%s" target="_blank">tela de menus</a> para criar um.', 'epicjungle-elementor' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}


		$this->add_control(
			'align_items',
			[
				'label' => __( 'Alinhar', 'epicjungle-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Esquerda', 'epicjungle-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Centro', 'epicjungle-elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => __( 'Direita', 'epicjungle-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'ej-elementor-nav-menu__align-',
				'selectors' => [
                	'{{WRAPPER}} .ej-elementor-nav-menu' => 'justify-content: {{VALUE}};',
                ],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Horizontal', 'epicjungle-elementor' ),
					'vertical' => __( 'Vertical', 'epicjungle-elementor' ),
					'dropdown' => __( 'Dropdown', 'epicjungle-elementor' ),
				],
				'frontend_available' => true,
			]
		);

		
		$this->add_control(
            'sb-light', [
                'label'        => esc_html__( 'Ícone claro?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition' => [
					'_skin' => 'footer_icons',
				],
            ]
        );

        $this->add_control(
            'sb-outline', [
                'label'        => esc_html__( 'Ícone contornado?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition' => [
					'_skin' => 'footer_icons',
				],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => __( 'Menu principal', 'epicjungle-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_control(
            'menu_css_class', [
                'label'   		=> esc_html__( 'Classe CSS do menu', 'epicjungle-elementor' ),
                'type'   		=> Controls_Manager::TEXT,
                'title'   		=> esc_html__( 'Adicione sua classe personalizada para o menu sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description'   => esc_html__( 'Classes adicionadas à tag <ul>', 'epicjungle-elementor' ),
                'default' 		=> ''
            ]
        );

        $this->add_control(
            'menu_item_css_class', [
                'label'   => esc_html__( 'Classe CSS do item de menu', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para o item de menu sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description'   => esc_html__( 'Aulas adicionadas à tag <ll>', 'epicjungle-elementor' ),
                'default' => ''
            ]
        );

        $this->add_control(
            'anchor_class', [
                'label'   => esc_html__( 'Classe CSS Âncora', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para <a> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description'   => esc_html__( 'Classes adicionadas à tag <a>', 'epicjungle-elementor' ),
                'default' => ''
            ]
        );

        $this->add_control(
            'icon_class', [
                'label'   => esc_html__( 'Classe CSS de ícone', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para <i> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'description'   => esc_html__( 'Classes adicionadas à tag <i>', 'epicjungle-elementor' ),
                'default' => ''
            ]
        );


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ej-elementor-nav-menu .ej-elementor-item',
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
            'nav-link-light', [
                'label'        => esc_html__( 'Link de navegação claro?', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Sim', 'epicjungle-elementor' ),
                'label_off'    => esc_html__( 'Não', 'epicjungle-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

		$this->add_control(
			'color_menu_item',
			[
				'label' => __( 'Cor do texto', 'epicjungle-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_3,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Ao passar o mouse', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'color_menu_item_hover',
			[
				'label' => __( 'Cor do texto', 'epicjungle-elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item:hover,
					{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item.ej-elementor-item-active,
					{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item.highlighted,
					{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item:focus' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			[
				'label' => __( 'Ativo', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'color_menu_item_active',
			[
				'label' => __( 'Cor do texto', 'epicjungle-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item.ej-elementor-item-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		/* This control is required to handle with complicated conditions */

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label' => __( 'Preenchimento horizontal', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label' => __( 'Preenchimento vertical', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ej-elementor-nav-menu--main .ej-elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_space_between',
			[
				'label' => __( 'Espaço entre', 'epicjungle-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .ej-elementor-nav-menu--layout-horizontal .ej-elementor-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .ej-elementor-nav-menu--layout-horizontal .ej-elementor-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ej-elementor-nav-menu--main:not(.ej-elementor-nav-menu--layout-horizontal) .ej-elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$available_menus = $this->get_available_menus();

		if ( ! $available_menus ) {
			return;
		}

		$settings = $this->get_active_settings();

		$anchor_class = [
            'nav-link-style',
            // 'p-0',
            'yes' === $settings['nav-link-light'] ? 'nav-link-light ': '',
            $settings['anchor_class'],
        ];

        $item_class = [
            'px-0 ',
            $settings['layout'] === 'horizontal' ? 'list-inline-item ' : '',
            $settings['menu_item_css_class'],
        ];

        $icon_class = [
            'list-social-icon',
            $settings['icon_class'],
        ];

		$args = [
			'echo' => false,
			'menu' => $settings['menu'],
			'menu_class' => 'ej-elementor-nav-menu list-inline font-size-sm ',
			'menu_id' => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'item_class'     => $item_class,
            'anchor_class'   => $anchor_class,
            'icon_class'     => $icon_class,
			'container' => '',

		];

		if ( 'horizontal' === $settings['layout'] ) {
			$args['menu_class'] .= ' d-flex';
		}

		if ( ! empty( $settings['menu_css_class'] ) ) {
			$args['menu_class'] .= $settings['menu_css_class'];
		}

		if ( class_exists( 'WP_Bootstrap_Navwalker' ) ) {
			$args['walker'] = new \WP_Bootstrap_Navwalker();
		}

		// Add custom filter to handle Nav Menu HTML output.
		add_filter( 'nav_menu_item_id', '__return_empty_string' );
		add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
		
		// General Menu.
		$menu_html = wp_nav_menu( $args );

		// Remove all our custom filters.
		remove_filter( 'nav_menu_item_id', '__return_empty_string' );
		remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ] );

		if ( empty( $menu_html ) ) {
			return;
		}

		$this->add_render_attribute( 'main-menu', 'class', [
			'ej-elementor-nav-menu--main',
			'ej-elementor-nav-menu__container',
			'ej-elementor-nav-menu--layout-' . $settings['layout'],
		] );
		?>
		<nav <?php echo $this->get_render_attribute_string( 'main-menu' ); ?>><?php echo $menu_html; ?></nav>
		<?php
	}

	 public function handle_link_classes( $atts, $item, $args, $depth ) {
        $classes ='ej-elementor-item';

        if ( empty( $atts['class'] ) ) {
            $atts['class'] = $classes;
        } else {
            $atts['class'] .= ' ' . $classes;
        }

        return $atts;
    }

	public function render_plain_content() {}
}