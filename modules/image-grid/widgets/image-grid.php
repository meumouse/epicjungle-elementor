<?php
namespace EpicJungleElementor\Modules\ImageGrid\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use EpicJungleElementor\Base\Base_Widget;
use EpicJungleElementor\Modules\ImageGrid\Skins;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes;
use Elementor\Utils;



class Image_Grid extends Base_Widget {

	public function get_name() {
        return 'ej-image-grid';
    }

    public function get_title() {
        return esc_html__( 'Grade de imagens', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-gallery-justified';
    }

    protected $_has_template_content = false;

	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Grid_1( $this ) );
		$this->add_skin( new Skins\Skin_Grid_2( $this ) );
    }

	protected function register_controls () {
		$this->start_controls_section( 'section_grid', [ 'label' => __( 'Configurações da coluna 1 da grade', 'epicjungle-elementor' ) ] );

		$this->add_responsive_control(
            'column',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Coluna 1', 'epicjungle-elementor' ),
                'options' => [
                    '' => __( 'Padrão', 'epicjungle-elementor' ),
                    '1' => __( '1', 'epicjungle-elementor' ),
                    '2' => __( '2', 'epicjungle-elementor' ),
                    '3' => __( '3', 'epicjungle-elementor' ),
                    '4' => __( '4', 'epicjungle-elementor' ),
                    '5' => __( '5', 'epicjungle-elementor' ),
                    '6' => __( '6', 'epicjungle-elementor' ),
                ],
                'frontend_available' => true,
                'condition' => [
                    '_skin' => 'grid-style-2'
                ]
            ]
        );

        $this->add_responsive_control(
            'column_2',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Coluna 2', 'epicjungle-elementor' ),
                'options' => [
                    '' => __( 'Padrão', 'epicjungle-elementor' ),
                    '1' => __( '1', 'epicjungle-elementor' ),
                    '2' => __( '2', 'epicjungle-elementor' ),
                    '3' => __( '3', 'epicjungle-elementor' ),
                    '4' => __( '4', 'epicjungle-elementor' ),
                    '5' => __( '5', 'epicjungle-elementor' ),
                    '6' => __( '6', 'epicjungle-elementor' ),
                ],
                'frontend_available' => true,
                'condition' => [
                    '_skin' => 'grid-style-2'
                ]
            ]
        );

		$repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label'       => esc_html__( 'Título', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Título', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( ' Título', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'content', [
                'label'       => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Find aute irure dolor in reprehend in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Conteúdo da grade de imagens', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Escolher imagem', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'content_settings', [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [
                        'title'    => esc_html__( 'Auditoria de sites SEO', 'epicjungle-elementor' ),
                    ],
                    [
                        'title'    => esc_html__( 'E-mail marketing', 'epicjungle-elementor' ),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $repeater_2 = new Repeater();

        $repeater_2->add_control(
            'title_2', [
                'label'       => esc_html__( 'Título', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'Título', 'epicjungle-elementor' ),
            ]
        );

        $repeater_2->add_control(
            'content_2', [
                'label'       => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__( 'Find aute irure dolor in reprehend in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Conteúdo da grade de imagens', 'epicjungle-elementor' ),
            ]
        );

        $repeater_2->add_control(
            'image_2',
            [
                'label' => __( 'Escolher imagem', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'content_settings_2', [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater_2->get_controls(),
                'default'   => [
                    [
                        'title_2'    => esc_html__( 'Marketing de conteúdo', 'epicjungle-elementor' ),
                    ],
                    [
                        'title_2'    => esc_html__( 'Criação de links', 'epicjungle-elementor' ),
                    ],
                ],
                'title_field' => '{{{ title_2 }}}',
            ]
        );
		$this->end_controls_section();
	}
}

