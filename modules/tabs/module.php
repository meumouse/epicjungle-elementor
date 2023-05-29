<?php
namespace EpicJungleElementor\Modules\Tabs;

use EpicJungleElementor\Base\Module_Base;
use EpicJungleElementor\Core\Controls_Manager as EJ_Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {


    public function __construct() {
        parent::__construct();
        $this->add_actions();
    }

    public function get_name() {
        return 'override-tabs';
    }

    public function add_actions() {
        add_action( 'elementor/widget/tabs/skins_init', [ $this, 'init_skins' ], 10 );
        add_action( 'elementor/element/tabs/section_tabs/before_section_end', [ $this, 'add_css_classes_controls' ], 10 );
    } 

    public function add_css_classes_controls( $element ) {

        $element->add_control( 'image_class', [
           'label'        => esc_html__( 'Classe CSS da imagem', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada para a tag <img> sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'label_block' => true,
            'default'     => 'flex-shrink-0 rounded w-60px',
            'description' => esc_html__( 'Classe CSS adicional que você deseja aplicar à tag img', 'epicjungle-elementor' ),
        ] );
    }

    public function init_skins( $widget ) { 
        $widget->add_skin( new Skins\Skin_Tabs_Landing( $widget ) );
        $widget->add_skin( new Skins\Skin_Tabs_Schedule( $widget ) );
        $widget->add_skin( new Skins\Skin_Tabs_Shop( $widget ) );
    }
}