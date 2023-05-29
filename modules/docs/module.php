<?php
namespace EpicJungleElementor\Modules\Docs;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends Module_Base {

	public function get_name() {
        return 'ej-docs';
    }

	public function get_widgets() {
		return [
			'docs',
		];
	}	

    public function get_query() {
        return $this->query;
    }

    public function __construct() {
        parent::__construct();

        add_action( 'init', [ $this, 'add_excerpt_support' ] );

    }

    public function add_excerpt_support() {
        add_post_type_support( 'docs', 'excerpt' );
    }

}