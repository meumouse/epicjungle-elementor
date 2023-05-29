<?php
namespace EpicJungleElementor\Modules\PostTitle\Widgets;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Post_Title extends Title_Widget_Base {

	public function get_name() {
		// `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
		return 'ej-post-title';
	}

	public function get_title() {
		return esc_html__( 'Título da postagem', 'epicjungle-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-title';
	}

	public function get_keywords() {
		return [ 'title', 'heading', 'post' ];
	}

	protected function get_dynamic_tag_name() {
		return 'post-title';
	}

	public function get_common_args() {
		return [
			'_css_classes' => [
				'default' => 'entry-title',
			],
		];
	}
}
