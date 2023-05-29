<?php
namespace EpicJungleElementor\Modules\TeamMember\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Ícones_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use EpicJungleElementor\Modules\TeamMember\Skins;
use EpicJungleElementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Team_Member extends Base_Widget {
	
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Style_2( $this ) );
		$this->add_skin( new Skins\Skin_Style_3( $this ) );
		$this->add_skin( new Skins\Skin_Style_4( $this ) );
		$this->add_skin( new Skins\Skin_Style_5( $this ) );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ej-team-member';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__(  'Membro da equipe', 'epicjungle-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-person';
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
		return [ 'team', 'member' ];
	}

	protected function register_controls() {

		// Content Tab
		$this->team_member_general_controls_content_tab();
		$this->team_member_skins_add_controls();

		//  Style Tab
		$this->team_member_general_controls_style_tab();
	
	}

	
	public function team_member_general_controls_content_tab() {

		// Geral Content Tab Start
		$this->start_controls_section(
			'section_general',
			[
				'label'               => esc_html__( 'Geral', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'show_team_card_border',
			[
				'label'              => esc_html__( 'Mostrar borda?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'description'        => esc_html__( 'Ativar para exibir a borda.', 'epicjungle-elementor' ),
				'frontend_available' => true,
				'condition'          => [
					'_skin!' => ['style-3', 'style-4'],
				],
			]
		);

		$this->add_control(
			'show_team_card_box_shadow',
			[
				'label'             => esc_html__( 'Mostrar sombra da caixa?', 'epicjungle-elementor' ),
				'type'              => Controls_Manager::SWITCHER,
				'default'           => 'no',
				'description'       => esc_html__( 'Ativar para exibir a sombra da caixa.', 'epicjungle-elementor' ),
				'frontend_available'=> true,
				'condition'         => [
					'_skin!' => ['style-3', 'style-4'],
				],
			]
		);


		$this->add_control(
			'show_team_image',
			[
				'label'              => esc_html__( 'Mostrar imagem do autor?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'description'        => esc_html__( 'Ativar para mostrar a imagem do autor.', 'epicjungle-elementor' ),
				'frontend_available' => true,
				'condition'          => [
					'_skin!'         => 'style-2',
				],
			]
		);

		$this->add_control(
			'show_social_icon',
			[
				'label'             => esc_html__( 'Mostrar ícone social do autor?', 'epicjungle-elementor' ),
				'type'              => Controls_Manager::SWITCHER,
				'default'           => 'yes',
				'description'       => esc_html__( 'Ativar para exibir o ícone social do autor.', 'epicjungle-elementor' ),
				'frontend_available'=> true,
			]
		);


		$this->add_control(
			'show_card_body_curved',
			[
				'label'              => esc_html__( 'Ativar corpo curvo do cartão?', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'description'        => esc_html__( 'Ative para exibir o corpo do cartão curvo.', 'epicjungle-elementor' ),
				'frontend_available' => true,
				'condition'          => [
					'_skin'          => '',
				],
			]
		);

        $this->add_control(
			'card_body_alignment',
			[
				'label'              => esc_html__( 'Alinhamento do corpo do cartão', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'left'           => [
						'title' => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'         => [
						'title' => esc_html__( 'Centro', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'          => [
						'title' => esc_html__( 'Direita', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .ej-elementor-card .card-body' => 'text-align: {{VALUE}}',
				],
				'default'            => 'center',
				'condition'          => [
					'_skin'          => '',
				],
				


			]
		);

		$this->add_control(
			'card_alignment',
			[
				'label'              => esc_html__( 'Alinhamento da equipe', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'left'           => [
						'title'  => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
						'icon'   => 'eicon-text-align-left',
					],
					'center'         => [
						'title' => esc_html__( 'Centro', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'          => [
						'title' => esc_html__( 'Direita', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .ej-elementor-team-member-3.team-style-3, {{WRAPPER}} .ej-elementor-team-member-3.team-style-5' => 'text-align: {{VALUE}}',
				],
				'default'           => 'left',
				'condition'         => [
					'_skin'         => ['style-3','style-5']
				],
			]
		);


		$this->add_control(
			'author_image_alignment',
			[
				'label'            => esc_html__( 'Alinhamento de imagem do autor', 'epicjungle-elementor' ),
				'type'             => Controls_Manager::CHOOSE,
				'options'          => [
					'left'         => [
						'title' => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'right'        => [
						'title'=> esc_html__( 'Direita', 'epicjungle-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors'        => [
					'{{WRAPPER}} .ej-elementor-team-member-3.team-style-4' => 'text-align: {{VALUE}}',
				],
				'default'         => 'left',
				'condition'       => [
					'_skin'   => 'style-4',
				],
			]
		);

		$this->add_control(
			'author_image_border-radius',
			[
				'label'          => esc_html__( 'Raio da borda da imagem do autor', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => [
					'rounded'         => esc_html__( 'Arredondado', 'epicjungle-elementor' ),
					'rounded-circle'  => esc_html__( 'Círculo arredondado', 'epicjungle-elementor' ),
				],
				'default'        => 'rounded',
				'condition'           => [
					'_skin'           => ['style-3', 'style-4', 'style-5'],
				],
			]
		);



		$this->add_control(
			'title_tag',
			[
				'label'           => esc_html__( 'Crachá', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'SPAN',
				],
				'default'        => 'h3',
			]
		);

		$this->add_control(
			'team_social_buttons_style',
			[
				'label'            => esc_html__( 'Estilo de ícone social', 'epicjungle-elementor' ),
				'type'             => Controls_Manager::SELECT,
				'options'          => [
					''             => esc_html__( 'Sólido', 'epicjungle-elementor' ),
					'sb-outline'   => esc_html__( 'Contorno', 'epicjungle-elementor' ),
				],
				'default'          => '',
				'condition'        => [
					'_skin'        => ['style-3', 'style-4', 'style-5'],
				],
			]
		);

		$default_icon = [
			'value'   => 'fe fe-instagram',
			'library' => 'fe-regular',
		];

		$placeholder_image_src = Utils::get_placeholder_image_src();


		$this->add_control(
			'selected_item_icon',
			[
				'label'            => esc_html__( 'Ícone', 'epicjungle-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'item_icon',
				'default'          => $default_icon,
				'condition'        => [
					'show_social_icon'     => 'yes',
					'_skin'        => '',
				],
				'separator'        => 'before',
			]
		);

		$this->add_control(
            'link', [
                'label'            => esc_html__( 'Link do ícone', 'epicjungle-elementor' ),
                'type'             => Controls_Manager::URL,
                'dynamic'          => [
                    'active'       => true,
                ],
                'placeholder'      => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default'          => [
                    'url'          => '#',
                ],
                'condition'        => [
					'_skin'        => '',
				],
            ]
        );

		$this->add_control(
            'team_author_image',
            [
                'label'            => esc_html__(  'Escolha a imagem', 'epicjungle-elementor' ),
                'type'             => Controls_Manager::MEDIA,
                'dynamic'          => [
                    'active'       => true,
                ],
                'default'          => [
					'url'          => Utils::get_placeholder_image_src(),
				],
				'condition'        => [
					'_skin'        => '',
					'show_team_image'     => 'yes',
				],
				
            ]
        );


        $this->add_control(
			'title',
			[
				'label'          => esc_html__(  'Nome', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::TEXT,
				'default'        => esc_html__(  'Nome do autor', 'epicjungle-elementor' ),
				'condition'      => [
					'_skin'      => '',
				],
			]
		);

		

		$this->add_control(
			'position',
			[
				'label'          => esc_html__(  'Posição', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::TEXT,
				'default'        => esc_html__(  'Posição', 'epicjungle-elementor' ),
				'condition'      => [
					'_skin'      => '',
				],
			]
		);

		// Geral Content Tab End
		$this->end_controls_section();
	}


	public function team_member_general_controls_style_tab() {

		// Geral Style Tab Start
		$this->start_controls_section(
			'section_general_style',
			[
				'label'         => esc_html__(  'Geral', 'epicjungle-elementor' ),
				'tab'           => Controls_Manager::TAB_STYLE,
				'show_label'    => false,
				'condition'     => [
					'_skin!'    => 'style-2'
				],
			]
		);

		$this->add_control(
			'team_card_hover_background_color',
			[
				'label'         => esc_html__(  'Cor de fundo do cartão de equipe', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .ej-elementor-card .card-img-gradient:after' => 'background: {{VALUE}} !important',
				],
				'alpha'        => true,
				'default'      => 'rgba(118,109,244,0.35)',
				'condition'    => [
					'show_team_image'     => 'yes',
					'_skin'     => ''
				],
				'separator'    => 'before',
				
				
				
			]
		);


		$this->add_control(
			'team_card_hover_border_color',
			[
				'label'        => esc_html__(  'Cor da borda do cartão de equipe', 'epicjungle-elementor' ),
				'type'         => Controls_Manager::COLOR,
				'selectors'    => [
					'{{WRAPPER}} .ej-elementor-card.card.card-hover:hover, {{WRAPPER}} .card-hover.border-0::before, {{WRAPPER}} .card-active.border-0::before' => 'border-color: {{VALUE}} !important',
				],
				'alpha'        => true,
				'default'      => 'rgba(118,109,244,0.35)',
				'condition'    => [
					'_skin'    => ''
				],
				
				
			]
		);

		$this->add_control(
			'social_icon_color',
			[
				'label'               => esc_html__(  'Cor do ícone social', 'epicjungle-elementor' ),
				'type'                => Controls_Manager::COLOR,
				'selectors'           => [
					'{{WRAPPER}} .ej-elementor-card .card-floating-icon' => 'color: {{VALUE}}',
				],
				'separator'           => 'before',
				'default'             => '#766df4',
				'condition'           => [
					'show_social_icon'=> 'yes',
					'_skin'           => ''
				],
				'separator'           => 'before',
				
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'               => esc_html__(  'Cor do título', 'epicjungle-elementor' ),
				'type'                => Controls_Manager::COLOR,
				'selectors'           => [
					'{{WRAPPER}} .ej-elementor-team-member__name, {{WRAPPER}} .ej-elementor-team-member-3 .ej-elementor-team-member-skin__name' => 'color: {{VALUE}}'
				],
				'default'             => '#4a4b65',
				'condition'           => [
					'_skin!'          => 'style-2'
				],
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'title_typography',
				'selector'         =>  
					'{{WRAPPER}} .ej-elementor-team-member__name, 
					{{WRAPPER}} .ej-elementor-team-member-3 .ej-elementor-team-member-skin__name',
				
				'scheme'           => Schemes\Typography::TYPOGRAPHY_1,
				'condition'        => [
					'_skin!'       => 'style-2'
				],

			]
		);

		$this->add_control(
            'title_css_class', [
                'label'           => esc_html__( 'Classe CSS do título', 'epicjungle-elementor' ),
                'type'            => Controls_Manager::TEXT,
                'title'           => esc_html__( 'Adicione sua classe personalizada para o nome da equipe. por exemplo: h6', 'epicjungle-elementor' ),
                'default'         => 'h6'


            ]
        );


		$this->add_control(
			'position_color',
			[
				'label'           => esc_html__(  'Cor da posição', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::COLOR,
				'selectors'       => [
					'{{WRAPPER}} .ej-elementor-team-member__position' => 'color: {{VALUE}}'
				],
				'default'         => '#737491',
				'separator'       => 'before',
				'condition'       => [
					'_skin'       => ''
				],
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'            => 'position_typography',
				'selectors'       => '{{WRAPPER}} .ej-elementor-team-member__position',
				'scheme'          => Schemes\Typography::TYPOGRAPHY_2,
				'condition'       => [
					'_skin'       => ''
				],

			]
		);

		$this->add_control(
			'skin_1_position_color',
			[
				'label'           => esc_html__(  'Cor da posição', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::COLOR,
				'selectors'       => [
					'{{WRAPPER}} .ej-elementor-team-member-3 .ej-elementor-team-member-skin__position' => 'color: {{VALUE}}'
				],
				'default'         => '#9e9fb4',
				'separator'       => 'before',
				'condition'       => [
					'_skin!'      => ['', 'style-2']
				],
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'            => 'skin_1_position_typography',
				'selectors'       => '{{WRAPPER}} .ej-elementor-team-member-3 .ej-elementor-team-member-skin__position',
				'scheme'          => Schemes\Typography::TYPOGRAPHY_2,
				'condition'       => [
					'_skin!'      => ['', 'style-2']
				],

			]
		);

		$this->add_control(
            'position_css_class', [
                'label'           => esc_html__( 'Classe CSS da Posição', 'epicjungle-elementor' ),
                'type'            => Controls_Manager::TEXT,
                'title'           => esc_html__( 'Adicione sua classe personalizada para a posição da equipe. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default'         => 'font-size-xs'


            ]
        );


		$this->add_control(
			'skin_contact_info_color',
			[
				'label'           => esc_html__(  'Cor das informações de contato', 'epicjungle-elementor' ),
				'type'            => Controls_Manager::COLOR,
				'selectors'       => [
					'{{WRAPPER}} .ej-elementor-team-member-3.team-style-5 .nav-link-style' => 'color: {{VALUE}}'
				],
				'default'         => '##5a5b75',
				'condition'       => [
					'_skin'       => ['style-5']
				],
				'separator'       => 'before',
			]
		);



		// Geral Content Tab End
		$this->end_controls_section();
	}

	public function team_member_skins_add_controls() {
		$default_icon = [
			'value'              => 'fe fe-instagram',
			'library'            => 'fe-regular',
		];

		// Heading Content Tab Start
		$this->start_controls_section(
			'skin_general',
			[
				'label'          => esc_html__(  'Equipe', 'epicjungle-elementor' ),
				'condition'      => [
					'_skin!'     => '',
				],
			
			]
		);

		$this->add_control(
            'skin_team_author_image',
            [
                'label'          => esc_html__(  'Escolher imagem', 'epicjungle-elementor' ),
                'type'           => Controls_Manager::MEDIA,
                'dynamic'        => [
                    'active'     => true,
                ],
                'default'        => [
					'url'        => Utils::get_placeholder_image_src(),
				],
				'condition'      => [
					'show_team_image'  => 'yes',
				],
				
            ]
        );

        $this->add_control(
			'skin_title',
			[
				'label'          => esc_html__(  'Nome', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::TEXT,
				'default'        => esc_html__(  'Nome do autor', 'epicjungle-elementor' ),
			]
		);

		

		$this->add_control(
			'skin_position',
			[
				'label'         => esc_html__(  'Posição', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__(  'Posição', 'epicjungle-elementor' ),
			]
		);

		$this->add_control(
			'skin_contact_number',
			[
				'label'         => esc_html__(  'Número de contato do autor', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__(  '(41) 91234-5678', 'epicjungle-elementor' ),
				'condition'     => [
					'_skin'     => 'style-5',

				],
			]
		);

		$this->add_control(
			'skin_contact_email',
			[
				'label'         => esc_html__(  'E-mail de contato do autor', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__(  'fulano@exemplo.com', 'epicjungle-elementor' ),
				'condition'     => [
					'_skin'     => 'style-5',

				]
			]
		);


		$repeater = new Repeater();


        $repeater->add_control(
            'skin_icon_link', [
                'label'        => esc_html__(  'Link do ícone social', 'epicjungle-elementor' ),
                'type'         => Controls_Manager::URL,
                'dynamic'      => [
                    'active'   => true,
                ],
                'placeholder'  => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
                'default'      => [
                    'url'      => '#',
                ],
            ]


        );

        $repeater->add_control(
			'skin_selected_icon',
			[
				'label'         => esc_html__(  'Ícone', 'epicjungle-elementor' ),
				'type'          => Controls_Manager::ICONS,
				'fa4compatibility' => 'skin_item_icon',
			]
		);

		$this->add_control(
            'skin_social_icon', [
            	'label'          => esc_html__(  'Ícones sociais', 'epicjungle-elementor' ),
                'type'           => Controls_Manager::REPEATER,
                'fields'         => $repeater->get_controls(),
                'condition'      => [
					'_skin!'     => '',
					'show_social_icon'     => 'yes',

				],
				'default'        => [
					[	
						'skin_selected_icon' => [
							'value'   => 'fe fe-facebook',
							'library' => 'fe-regular',
						],
					],
					[
						
						'skin_selected_icon' => [
							'value'   => 'fe fe-twitter',
							'library' => 'fe-regular',
						],
					],
					[
						
						'skin_selected_icon' => [
							'value'   => 'fe fe-instagram',
							'library' => 'fe-regular',
						],
					],
					
				],

				'title_field'          => '<# var migrated = "undefined" !== typeof __fa4_migrated, skin_item_icon = ( "undefined" === typeof skin_item_icon ) ? false : skin_item_icon; #>{{{ elementor.helpers.renderÍcone( skin_selected_icon, skin_item_icon, true, migrated, true ) }}}',
            ]
        );
		

		// Skin Geral Content Tab End
		$this->end_controls_section();



		// Skin Geral Style Tab Start
		$this->start_controls_section(
			'skin_general_style',
			[
				'label'               => esc_html__(  'Geral', 'epicjungle-elementor' ),
				'tab'                 => Controls_Manager::TAB_STYLE,
				'show_label'          => false,
				'condition'           => [
					'_skin'           => 'style-2',

				],
				
			]
		);

		$this->add_control(
			'skin_social_icon_color',
			[
				'label'              => esc_html__(  'Cor dos ícones sociais', 'epicjungle-elementor' ),
				'type'               => Controls_Manager::COLOR,
				'selectors'          => [
					'{{WRAPPER}} .ej-elementor-card .card-img-overlay .team-style-2-social-icons a' => 'color: {{VALUE}}',
				],
				'default'            => '#ffffff',
				'separator'          => 'before',
				'condition'          => [
					'_skin'          => 'style-2',
					'show_social_icon'  => 'yes',

				],
			]
		);

		$this->add_control(
			'skin_title_color',
			[
				'label'               => esc_html__(  'Cor do título', 'epicjungle-elementor' ),
				'type'                => Controls_Manager::COLOR,
				'selectors'           => [
					'{{WRAPPER}} .ej-elementor-team-member-skin__name' => 'color: {{VALUE}}',
				],
				'default'             => '#ffffff',
				'condition'           => [
					'_skin'           => 'style-2',

				],
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'             => 'skin_title_typography',
				'selector'         => '{{WRAPPER}} .ej-elementor-team-member-skin__name',
				'scheme'           => Schemes\Typography::TYPOGRAPHY_1,
				'condition'        => [
					'_skin'        => 'style-2',

				],
			]
		);

		$this->add_control(
            'skin_title_css_class', [
                'label'           => esc_html__( 'Classe CSS do título', 'epicjungle-elementor' ),
                'type'            => Controls_Manager::TEXT,
                'title'           => esc_html__( 'Adicione sua classe personalizada para o nome da equipe. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default'         => 'h6',
                'description'     => esc_html__( 'Título CSS para Estilo 2', 'epicjungle-elementor' ),



            ]
        );

		$this->add_control(
			'skin_position_color',
			[
				'label'          => esc_html__(  'Cor da posição', 'epicjungle-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .ej-elementor-team-member-skin__position' => 'color: {{VALUE}}',
				],
				'default'        => '#ffffff',
				'separator'      => 'before',
				'condition'      => [
					'_skin'      => 'style-2',

				],

			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'         => 'skin_position_typography',
				'selector'     => '{{WRAPPER}} .ej-elementor-team-member-skin__position',
				'scheme'       => Schemes\Typography::TYPOGRAPHY_1,
				'condition'     => [
					'_skin'     => 'style-2',

				],

			]
		);

		$this->add_control(
            'skin_position_css_class', [
                'label'           => esc_html__( 'Posição CSS Class', 'epicjungle-elementor' ),
                'type'            => Controls_Manager::TEXT,
                'title'           => esc_html__( 'Adicione sua classe personalizada para a posição da equipe. por exemplo: font-size-xs', 'epicjungle-elementor' ),
                'default'         => 'font-size-xs',
                'description'     => esc_html__( 'Posição CSS para Estilo 2', 'epicjungle-elementor' ),


            ]
        );


		// Skin Geral Style Tab End
		$this->end_controls_section();

	}


	

	/**
	 * Render Price Table widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display(); 
		

		$this->add_render_attribute( 'title', 'class', 'ej-elementor-team-member__name card-title mb-2' );
		$this->add_inline_editing_attributes( 'title' );

		if ( ! empty( $settings[ 'title_css_class' ] ) ) {
            $this->add_render_attribute( 'title', 'class', $settings[ 'title_css_class' ] );
        }


		$this->add_render_attribute( 'position', 'class', 'ej-elementor-team-member__position mb-0' );
		$this->add_inline_editing_attributes( 'position' );

		if ( ! empty( $settings[ 'position_css_class' ] ) ) {
            $this->add_render_attribute( 'position', 'class', $settings[ 'position_css_class' ] );
        }


		?>
		<div class="ej-elementor-team-member team-style-1">
			
			<?php $has_image = $settings['team_author_image' ]['url'];
	
			$migrated = isset( $settings['__fa4_migrated']['selected_item_icon'] );

			$is_new = empty( $settings['icon'] ) && Ícones_Manager::is_migration_allowed();

			$has_icon = ( ! $is_new || ! empty( $settings['selected_item_icon']['value'] ) ); ?>

				
			<div class="ej-elementor-card card card-hover<?php echo esc_attr( $settings['show_card_body_curved'] == 'yes' ? ' card-curved-body' : '');?><?php echo esc_attr( $settings['show_team_card_border'] !== 'yes' ? ' border-0' : '');?><?php echo esc_attr( $settings['show_team_card_box_shadow'] == 'yes' ? ' box-shadow' : '');?> mx-auto" style="max-width: 21rem;">
			<?php if ( $has_icon && 'yes' == $settings['show_social_icon'] ) : ?>
				<a class="card-floating-icon" href="<?php echo esc_attr( $settings['link']['url'] ); ?>">
					<?php
					if ( $is_new || $migrated ) { ?>
						<?php Ícones_Manager::render_icon( $settings['selected_item_icon']);
					} else { ?>
						<i class="<?php echo esc_attr( $settings['item_icon'] ); ?>" aria-hidden="true"></i>
					<?php } ?>
					
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $has_image ) && 'yes' == $settings['show_team_image'] ) : ?>
			  	<div class="card-img-top card-img-gradient">
			    	<img src="<?php echo esc_attr ( $has_image ); ?>" alt="..."/>
			  	</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['title'] ) || ! empty( $settings['position'] ) ) : ?>
			  	<div class="card-body">
			  		<?php if ( ! empty( $settings['title'] ) ): ?>
						<!-- Title -->
						<<?php echo $settings['title_tag'] . ' ' . $this->get_render_attribute_string( 'title' ); ?>><?php echo $settings['title'] . '</' . $settings['title_tag']; ?>>
					<?php endif;	
				
			    	if ( ! empty( $settings['position'] ) ): ?>
						<p <?php echo $this->get_render_attribute_string( 'position' ); ?>><?php echo $settings['position']; ?></p> 
				 	<?php endif; ?>
			  	</div>
			<?php endif; ?>
		</div>
			
		</div>
				
		<?php
	}

	/**
	 * Render Price Table widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>

		<div class="ej-elementor-team-member team-style-1">
			
			<# $has_image = $settings['team_author_image' ]['url'];
	
			$migrated = isset( $settings['__fa4_migrated']['selected_item_icon'] );

			$is_new = empty( $settings['icon'] ) && Ícones_Manager::is_migration_allowed();

			$has_icon = ( ! $is_new || ! empty( $settings['selected_item_icon']['value'] ) ); #>

				
			<div class="ej-elementor-card card card-hover<# settings.show_card_body_curved == 'yes' ? ' card-curved-body' : '');#><# settings.show_team_card_border !== 'yes' ? ' border-0' : '');#><# settings.show_team_card_box_shadow == 'yes' ? ' box-shadow' : '');#> mx-auto" style="max-width: 21rem;">
			<# if ( settings.show_social_icon ) : #>
				<a class="card-floating-icon" href="#!">
					<# if ( item.item_icon || item.selected_item_icon ) { #>
							
						<# iconsHTML[ index ] = elementor.helpers.renderÍcone( view, item.selected_item_icon, { 'aria-hidden': 'true', 'class': 'mr-2' }, 'i', 'object' );
						if ( ( ! item.item_icon || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) { #>
							{{{ iconsHTML[ index ].value }}}
						<# } else { #>
							<i class="{{ item.item_icon }} mr-2" aria-hidden="true"></i>
						<# } #>
					
					<# } #>		

					
				</a>
			<# endif; #>

			<# if ( ! _.isEmpty( has_image )  && settings.show_team_image ) : #>
			  	<div class="card-img-top card-img-gradient">
			    	<img src="settings.team_author_image.url" alt="..."/>
			  	</div>
			<# endif; #>

			
		  	<div class="card-body">
		  		<# if ( settings.title ) : #>
					<{{ settings.title_tag }} {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</{{ settings.title_tag }}>
				<# endif;	
			
		    	if ( settings.position ) : #>

		    	{{{ '<p ' + view.getRenderAttributeString( "position" ) + '>' + settings.position + '</p>' }}}

					
			 	<# endif; #>
		  	</div>

		</div>
	
		<?php
	}
	
}