<?php
namespace EpicJungleElementor\Modules\DynamicTags;

use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends TagsModule {

	const AUTHOR_GROUP = 'author';

	const POST_GROUP = 'post';

	const COMMENTS_GROUP = 'comments';

	const SITE_GROUP = 'site';

	const ARCHIVE_GROUP = 'archive';

	const MEDIA_GROUP = 'media';

	const ACTION_GROUP = 'action';

	public function get_name() {
		return 'ar-tags';
	}

	public function get_tag_classes_names() {
		return [
			'Post_Title',
		];
	}

	public function get_groups() {
		return [
			self::POST_GROUP => [
				'title' => esc_html__( 'Postagem', 'epicjungle-elementor' ),
			]
		];
	}
}
