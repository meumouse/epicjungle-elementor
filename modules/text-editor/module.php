<?php

namespace EpicJungleElementor\Modules\TextEditor;

use EpicJungleElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use EpicJungleElementor\Plugin;
use EpicJungleElementor\Core\Controls_Manager as EJ_Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module extends Module_Base {

    public function __construct() {
        parent::__construct();

        $this->add_actions();
    }

    public function get_name() {
        return 'override-text-editor';
    }

    public function add_actions() {
        add_action( 'elementor/element/text-editor/section_editor/before_section_end', [ $this, 'add_size_control' ] );
        add_action( 'epicjungle-elementor/widget/text-editor/before_render_content', [ $this, 'before_render' ], 10 );
        add_action( 'epicjungle-elementor/widget/text-editor/print_template', [ $this, 'print_template' ], 10 );
    }

    public function print_template( $content ) {
        ob_start();
        $this->content_template();
        return ob_get_clean();
    }

    public function content_template() {
        ?>
        <#
        view.addRenderAttribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );

        if ( '' !== settings.size ) {
            view.addRenderAttribute( 'editor', 'class', settings.size );
        }

        view.addInlineEditingAttributes( 'editor', 'advanced' );
        #>
        <div {{{ view.getRenderAttributeString( 'editor' ) }}}>{{{ settings.editor }}}</div>
        <?php
    }

    public function before_render( $element ) {        
        if ( 'default' !== $element->get_settings( 'size' ) ) {
            $element->add_render_attribute( 'editor', 'class', $element->get_settings( 'size' ) );    
        }
    }

    public function add_size_control( $element ) {
        $element->add_control(
           'size',
            [
                'label'   => esc_html__( 'Tamanho', 'epicjungle-elementor' ),
                'type'    => EJ_Controls_Manager::FONT_SIZE,
                'default' => 'default',
            ]
        );
    }
}