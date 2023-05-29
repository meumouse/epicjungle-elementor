<?php
namespace EpicJungleElementor\Modules\QueryControl\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use EpicJungleElementor\Core\Utils;
use EpicJungleElementor\Modules\QueryControl\Module as Query_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Group_Control_Query extends Group_Control_Base {

	protected static $presets;
	protected static $fields;

	public static function get_type() {
		return 'query-group';
	}

	protected function init_args( $args ) {
		parent::init_args( $args );
		$args = $this->get_args();
		static::$fields = $this->init_fields_by_name( $args['name'] );
	}

	protected function init_fields() {
		$args = $this->get_args();

		return $this->init_fields_by_name( $args['name'] );
	}

	/**
	 * Build the group-controls array
	 * Note: this method completely overrides any settings done in Group_Control_Posts
	 * @param string $name
	 *
	 * @return array
	 */
	protected function init_fields_by_name( $name ) {
		$fields = [];

		$name .= '_';

		$fields['post_type'] = [
			'label'   => esc_html__( 'Fonte', 'epicjungle-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'by_id'         => esc_html__( 'Seleção manual', 'epicjungle-elementor' ),
				'current_query' => esc_html__( 'Consulta atual', 'epicjungle-elementor' ),
			],
		];

		$fields['query_args'] = [
			'type' => Controls_Manager::TABS,
		];

		$tabs_wrapper    = $name . 'query_args';
		$include_wrapper = $name . 'query_include';
		$exclude_wrapper = $name . 'query_exclude';

		$fields['query_include'] = [
			'type'         => Controls_Manager::TAB,
			'label'        => esc_html__( 'Incluir', 'epicjungle-elementor' ),
			'tabs_wrapper' => $tabs_wrapper,
			'condition'    => [
				'post_type!' => [
					'current_query',
					'by_id',
				],
			],
		];

		$fields['posts_ids'] = [
			'label' => esc_html__( 'Pesquisar e selecionar', 'epicjungle-elementor' ),
			'type' => Query_Module::QUERY_CONTROL_ID,
			'label_block' => true,
			'multiple' => true,
			'autocomplete' => [
				'object' => Query_Module::QUERY_OBJECT_POST,
			],
			'condition' => [
				'post_type' => 'by_id',
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $include_wrapper,
			'export' => false,
		];

		$fields['include'] = [
			'label' => esc_html__( 'Incluir por', 'epicjungle-elementor' ),
			'type' => Controls_Manager::SELECT2,
			'multiple' => true,
			'options' => [
				'terms' => esc_html__( 'Termo', 'epicjungle-elementor' ),
				'authors' => esc_html__( 'Autor', 'epicjungle-elementor' ),
			],
			'condition' => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'label_block' => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $include_wrapper,
		];

		$fields['include_term_ids'] = [
			'label' => esc_html__( 'Termo', 'epicjungle-elementor' ),
			'description' => esc_html__( 'Termos são itens em uma taxonomia. As taxonomias disponíveis são: Categorias, Tags, Formatos e taxonomias personalizadas.', 'epicjungle-elementor' ),
			'type' => Query_Module::QUERY_CONTROL_ID,
			'options' => [],
			'label_block' => true,
			'multiple' => true,
			'autocomplete' => [
				'object' => Query_Module::QUERY_OBJECT_CPT_TAX,
				'display' => 'detailed',
			],
			'group_prefix' => $name,
			'condition' => [
				'include' => 'terms',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $include_wrapper,
		];

		$fields['include_authors'] = [
			'label' => esc_html__( 'Autor', 'epicjungle-elementor' ),
			'label_block' => true,
			'type' => Query_Module::QUERY_CONTROL_ID,
			'multiple' => true,
			'default' => [],
			'options' => [],
			'autocomplete' => [
				'object' => Query_Module::QUERY_OBJECT_AUTHOR,
			],
			'condition' => [
				'include' => 'authors',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $include_wrapper,
			'export' => false,
		];

		$fields['query_exclude'] = [
			'type' => Controls_Manager::TAB,
			'label' => esc_html__( 'Excluir', 'epicjungle-elementor' ),
			'tabs_wrapper' => $tabs_wrapper,
			'condition' => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
		];

		$fields['exclude'] = [
			'label' => esc_html__( 'Excluir por', 'epicjungle-elementor' ),
			'type' => Controls_Manager::SELECT2,
			'multiple' => true,
			'options' => [
				'current_post' => esc_html__( 'Postagem atual', 'epicjungle-elementor' ),
				'manual_selection' => esc_html__( 'Seleção manual', 'epicjungle-elementor' ),
				'terms' => esc_html__( 'Termo', 'epicjungle-elementor' ),
				'authors' => esc_html__( 'Autor', 'epicjungle-elementor' ),
			],
			'condition' => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'label_block' => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $exclude_wrapper,
		];

		$fields['exclude_ids'] = [
			'label' => esc_html__( 'Pesquisar e selecionar', 'epicjungle-elementor' ),
			'type' => Query_Module::QUERY_CONTROL_ID,
			'options' => [],
			'label_block' => true,
			'multiple' => true,
			'autocomplete' => [
				'object' => Query_Module::QUERY_OBJECT_POST,
			],
			'condition' => [
				'exclude' => 'manual_selection',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $exclude_wrapper,
			'export' => false,
		];

		$fields['exclude_term_ids'] = [
			'label' => esc_html__( 'Termo', 'epicjungle-elementor' ),
			'type' => Query_Module::QUERY_CONTROL_ID,
			'options' => [],
			'label_block' => true,
			'multiple' => true,
			'autocomplete' => [
				'object' => Query_Module::QUERY_OBJECT_CPT_TAX,
				'display' => 'detailed',
			],
			'group_prefix' => $name,
			'condition' => [
				'exclude' => 'terms',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $exclude_wrapper,
			'export' => false,
		];

		$fields['exclude_authors'] = [
			'label' => esc_html__( 'Autor', 'epicjungle-elementor' ),
			'type' => Query_Module::QUERY_CONTROL_ID,
			'options' => [],
			'label_block' => true,
			'multiple' => true,
			'autocomplete' => [
				'object' => Query_Module::QUERY_OBJECT_AUTHOR,
				'display' => 'detailed',
			],
			'condition' => [
				'exclude' => 'authors',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $exclude_wrapper,
			'export' => false,
		];

		$fields['avoid_duplicates'] = [
			'label' => esc_html__( 'Evite duplicatas', 'epicjungle-elementor' ),
			'type' => Controls_Manager::SWITCHER,
			'default' => '',
			'description' => esc_html__( 'Defina como Sim para evitar que postagens duplicadas apareçam. Isso afeta apenas o frontend.', 'epicjungle-elementor' ),
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $exclude_wrapper,
			'condition' => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
		];

		$fields['offset'] = [
			'label' => esc_html__( 'Desvio', 'epicjungle-elementor' ),
			'type' => Controls_Manager::NUMBER,
			'default' => 0,
			'condition' => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'description' => esc_html__( 'Use esta configuração para pular postagens (por exemplo, \'2\' para pular duas postagens).', 'epicjungle-elementor' ),
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab' => $exclude_wrapper,
		];

		$fields['select_date'] = [
			'label' => esc_html__( 'Data', 'epicjungle-elementor' ),
			'type' => Controls_Manager::SELECT,
			'post_type' => '',
			'options' => [
				'anytime' => esc_html__( 'Tudo', 'epicjungle-elementor' ),
				'today' => esc_html__( 'Dia passado', 'epicjungle-elementor' ),
				'week' => esc_html__( 'Semana passada', 'epicjungle-elementor' ),
				'month'  => esc_html__( 'Mês passado', 'epicjungle-elementor' ),
				'quarter' => esc_html__( 'Trimestre passado', 'epicjungle-elementor' ),
				'year' => esc_html__( 'Ano passado', 'epicjungle-elementor' ),
				'exact' => esc_html__( 'Personalizado', 'epicjungle-elementor' ),
			],
			'default' => 'anytime',
			'multiple' => false,
			'condition' => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'separator' => 'before',
		];

		$fields['date_before'] = [
			'label' => esc_html__( 'Antes', 'epicjungle-elementor' ),
			'type' => Controls_Manager::DATE_TIME,
			'post_type' => '',
			'label_block' => false,
			'multiple' => false,
			'placeholder' => esc_html__( 'Escolher', 'epicjungle-elementor' ),
			'condition' => [
				'select_date' => 'exact',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'description' => esc_html__( 'Definir uma data "Antes" mostrará todas as postagens publicadas até a data escolhida (inclusive).', 'epicjungle-elementor' ),
		];

		$fields['date_after'] = [
			'label' => esc_html__( 'Depois', 'epicjungle-elementor' ),
			'type' => Controls_Manager::DATE_TIME,
			'post_type' => '',
			'label_block' => false,
			'multiple' => false,
			'placeholder' => esc_html__( 'Escolher', 'epicjungle-elementor' ),
			'condition' => [
				'select_date' => 'exact',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'description' => esc_html__( 'Definir uma data "Depois" mostrará todas as postagens publicadas desde a data escolhida (inclusive).', 'epicjungle-elementor' ),
		];

		$fields['orderby'] = [
			'label' => esc_html__( 'Ordenar por', 'epicjungle-elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'post_date',
			'options' => [
				'post_date' => esc_html__( 'Data', 'epicjungle-elementor' ),
				'post_title' => esc_html__( 'Título', 'epicjungle-elementor' ),
				'menu_order' => esc_html__( 'Ordem do menu', 'epicjungle-elementor' ),
				'rand' => esc_html__( 'Aleatório', 'epicjungle-elementor' ),
			],
			'condition' => [
				'post_type!' => 'current_query',
			],
		];

		$fields['order'] = [
			'label' => esc_html__( 'Ordenar', 'epicjungle-elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'desc',
			'options' => [
				'asc' => esc_html__( 'ASC', 'epicjungle-elementor' ),
				'desc' => esc_html__( 'DESC', 'epicjungle-elementor' ),
			],
			'condition' => [
				'post_type!' => 'current_query',
			],
		];

		$fields['posts_per_page'] = [
			'label' => esc_html__( 'Postagens por página', 'epicjungle-elementor' ),
			'type' => Controls_Manager::NUMBER,
			'default' => 3,
			'condition' => [
				'post_type!' => 'current_query',
			],
		];

		$fields['ignore_sticky_posts'] = [
			'label' => esc_html__( 'Ignorar postagens fixas', 'epicjungle-elementor' ),
			'type' => Controls_Manager::SWITCHER,
			'default' => 'yes',
			'condition' => [
				'post_type' => 'post',
			],
			'description' => esc_html__( 'A ordenação de postes fixos é visível apenas no frontend', 'epicjungle-elementor' ),
		];

		$fields['query_id'] = [
			'label' => esc_html__( 'ID da consulta', 'epicjungle-elementor' ),
			'type' => Controls_Manager::TEXT,
			'default' => '',
			'description' => esc_html__( 'Dê à sua consulta um ID exclusivo personalizado para permitir a filtragem do lado do servidor', 'epicjungle-elementor' ),
			'separator' => 'before',
		];

		static::init_presets();

		return $fields;
	}

	/**
	 * Presets: filter controls subsets to be be used by the specific Group_Control_Query instance.
	 *
	 * Possible values:
	 * 'full' : (default) all presets
	 * 'include' : the 'include' tab - by id, by taxonomy, by author
	 * 'exclude': the 'exclude' tab - by id, by taxonomy, by author
	 * 'advanced_exclude': extend the 'exclude' preset with 'avoid-duplicates' & 'offset'
	 * 'date': date query controls
	 * 'pagination': posts per-page
	 * 'order': sort & ordering controls
	 * 'query_id': allow saving a specific query for future usage.
	 *
	 * Usage:
	 * full: build a Group_Controls_Query with all possible controls,
	 * when 'full' is passed, the Group_Controls_Query will ignore all other preset values.
	 * $this->add_group_control(
	 * Group_Control_Query::get_type(),
	 * [
	 * ...
	 * 'presets' => [ 'full' ],
	 *  ...
	 *  ] );
	 *
	 * Subset: build a Group_Controls_Query with subset of the controls,
	 * in the following example, the Query controls will set only the 'include' & 'date' query args.
	 * $this->add_group_control(
	 * Group_Control_Query::get_type(),
	 * [
	 * ...
	 * 'presets' => [ 'include', 'date' ],
	 *  ...
	 *  ] );
	 */
	protected static function init_presets() {

		$tabs = [
			'query_args',
			'query_include',
			'query_exclude',
		];

		static::$presets['include'] = array_merge( $tabs, [
			'include',
			'include_ids',
			'include_term_ids',
			'include_authors',
		] );

		static::$presets['exclude'] = array_merge( $tabs, [
			'exclude',
			'exclude_ids',
			'exclude_term_ids',
			'exclude_authors',
		] );

		static::$presets['advanced_exclude'] = array_merge( static::$presets['exclude'], [
			'avoid_duplicates',
			'offset',
		] );

		static::$presets['date'] = [
			'select_date',
			'date_before',
			'date_after',
		];

		static::$presets['pagination'] = [
			'posts_per_page',
			'ignore_sticky_posts',
		];

		static::$presets['order'] = [
			'orderby',
			'order',
		];

		static::$presets['query_id'] = [
			'query_id',
		];
	}

	private function filter_by_presets( $presets, $fields ) {

		if ( in_array( 'full', $presets, true ) ) {
			return $fields;
		}

		$control_ids = [];
		foreach ( static::$presets as $key => $preset ) {
			$control_ids = array_merge( $control_ids, $preset );
		}

		foreach ( $presets as $preset ) {
			if ( array_key_exists( $preset, static::$presets ) ) {
				$control_ids = array_diff( $control_ids, static::$presets[ $preset ] );
			}
		}

		foreach ( $control_ids as $remove ) {
			unset( $fields[ $remove ] );
		}

		return $fields;

	}

	protected function prepare_fields( $fields ) {

		$args = $this->get_args();

		if ( ! empty( $args['presets'] ) ) {
			$fields = $this->filter_by_presets( $args['presets'], $fields );
		}

		$post_type_args = [];
		if ( ! empty( $args['post_type'] ) ) {
			$post_type_args['post_type'] = $args['post_type'];
		}

		$post_types = Utils::get_public_post_types( $post_type_args );

		$fields['post_type']['options'] = array_merge( $post_types, $fields['post_type']['options'] );
		$fields['post_type']['default'] = key( $post_types );
		$fields['posts_ids']['object_type'] = array_keys( $post_types );

		//skip parent, go directly to grandparent
		return Group_Control_Base::prepare_fields( $fields );
	}

	protected function get_child_default_args() {
		$args = parent::get_child_default_args();
		$args['presets'] = [ 'full' ];

		return $args;
	}

	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}