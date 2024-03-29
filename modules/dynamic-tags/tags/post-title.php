<?php
namespace EpicJungleElementor\Modules\DynamicTags\Tags;

use Elementor\Core\DynamicTags\Tag;
use EpicJungleElementor\Modules\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Post_Title extends Tag {
	
	public function get_name() {
		return 'post-title';
	}

	public function get_title() {
		return esc_html__( 'Título da postagem', 'epicjungle-elementor' );
	}

	public function get_group() {
		return Module::POST_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		echo wp_kses_post( get_the_title() );
	}
}
