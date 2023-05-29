<?php
namespace EpicJungleElementor\Modules\Docs\Widgets;

use EpicJungleElementor\Base\Base_Widget;
use EpicJungleElementor\Modules\QueryControl\Module as Module_Query;
use EpicJungleElementor\Modules\QueryControl\Controls\Group_Control_Related;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use EpicJungleElementor\Modules\Docs\Skins;


if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}

class Docs extends Base_Widget {

    protected $_has_template_content = false;

    public function get_name() {
        return 'ej-docs';
    }

    public function get_title() {
        return __( 'Documentos', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-document-file';
    }

    protected function register_controls() {
        $this->register_query_section_controls();
    }
    
    public function on_import( $element ) {
        if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
            $element['settings']['posts_post_type'] = 'post';
        }

        return $element;
    }

    protected function register_skins() {

        $this->add_skin( new Skins\Skin_Docs_Card( $this ) );
        $this->add_skin( new Skins\Skin_Docs_List( $this ) );
    
    }

    public function register_query_section_controls() {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => esc_html__( 'Postagens por página', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 1,
                'default' => 3,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_query',
            [
                'label' => __( 'Query', 'epicjungle-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            Group_Control_Related::get_type(),
            [
                'name'    => 'posts',
                'presets' => [ 'full' ],
                'exclude' => [
                    'posts_per_page', //use the one from Layout section
                ],
            ]
        );

        $this->end_controls_section();
    }
}