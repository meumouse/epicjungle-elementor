<?php
namespace EpicJungleElementor\Modules\Accordion\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use EpicJungleElementor\Plugin;
use Elementor\Repeater;
use EpicJungleElementor\Core\Utils as EJ_Utils;

class Skin_Accordion_Card extends Skin_Base {
    
     public function __construct( Elementor\Widget_Base $parent ) {
        parent::__construct( $parent );
        add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
        add_action( 'elementor/element/accordion/section_title/before_section_end', [ $this, 'section_title_controls' ], 10 );
        add_action( 'elementor/element/accordion/section_toggle_style_content/after_section_end', [ $this, 'style_controls' ] , 10 );
    }

    public function get_id() {
        return 'accordion-card';
    }

    public function get_title() {
        return esc_html__( 'EpicJungle', 'epicjungle-elementor' );
    }

    public function section_title_controls( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;

        $this->parent->update_control(
            'tabs', [
                'condition' => [
                    '_skin' => '',
                ],
            ]
        );
        
        $this->parent->update_control(
            'selected_icon', [
                'condition' => [
                    '_skin' => '',
                ],
            ]
        );

        $this->parent->update_control(
            'selected_active_icon', [
                'condition' => [
                    'selected_icon[value]!' => '',
                    '_skin' => '',
                ],
            ]
        );

        $this->parent->update_control(
            'title_html_tag', [
                'condition' => [
                    '_skin' => '',
                ],
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
                'default'     => esc_html__( 'Título do acordeão', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Título do acordeão', 'epicjungle-elementor' ),
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
                'default'     => esc_html__( 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Conteúdo do acordeão', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'content_settings', [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [
                        'title'    => esc_html__( 'Como faço para criar uma lista de reprodução?', 'epicjungle-elementor' ),
                    ],
                    [
                        'title'    => esc_html__( 'Só é possível reproduzir música aleatoriamente?', 'epicjungle-elementor' ),
                    ],
                    [
                        'title'    => esc_html__( 'Onde posso encontrar podcasts?', 'epicjungle-elementor' ),
                    ],
                    [
                        'title'    => esc_html__( 'Como ativar o modo de economia de dados?', 'epicjungle-elementor' ),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'enable_border',
            [
                'label' => __( 'Borda', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'enable_boxshadow',
            [
                'label' => __( 'Sombra da caixa', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default'    => 'yes',
            ]
        );
    }

    public function style_controls( Elementor\Widget_Base $widget ) {

        $this->parent = $widget;

        $widget->update_control( 'section_toggle_style_content', [
            'condition' => [ '_skin' => '' ]
        ] );

        $widget->update_control( 'section_title_style', [
            'condition' => [ '_skin' => '' ]
        ] );

        $widget->update_control( 'section_toggle_style_title', [
            'condition' => [ '_skin' => '' ]
        ] );

        $widget->update_control( 'section_toggle_style_icon', [
            'condition' => [ '_skin' => '' ]
        ] );

        $this->start_controls_section(
            'title_section', [
                'label' => esc_html__( 'Título', 'epicjungle-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color', [
                'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .accordion-heading a.collapsed' => 'color: {{VALUE}};',
                ],
                'default' => '#4a4b65',
            ]
        );

        $this->add_control(
            'title_hover_color', [
                'label'     => esc_html__( 'Cor do título ao passar o mouse', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .accordion-heading a:hover, {{WRAPPER}} .accordion-heading a' => 'color: {{VALUE}};',
                ],
                'default' => 'var(--ej-primary)',
            ]
        );

        $this->add_control(
            'card_border_color', [
                'label'     => esc_html__( 'Cor da borda do cartão', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .accordion .card.card-active' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .accordion .accordion__title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section', [
                'label' => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color', [
                'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .accordion__content' => 'color: {{VALUE}};',
                ],
                'default' => '#737491',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .accordion__content',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_control(
            'content_css', [
                'label'   => esc_html__( 'Classe CSS', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'default' => ''
            ]
        );

        $this->end_controls_section();
    }

    public function render() {     
        $widget   = $this->parent;   
        $settings = $this->parent->get_settings_for_display();
        
        $content_css = $settings[ $this->get_control_id( 'content_css' ) ];
        $widget->add_render_attribute( 'content', 'class', [
            'accordion__content',
            'card-body',
        ] );
        if ( ! empty( $content_css ) ) {
            $widget->add_render_attribute( 'content', 'class', $content_css );
        }

        $items = $settings[ $this->get_control_id( 'content_settings' ) ];
        $enable_border =  $settings[ $this->get_control_id( 'enable_border' ) ];
        $box_shadow="";
        ?>
        <div class="accordion accordion-alt" id="accordionExample">
                <?php foreach( $items as $index => $item ) :
                    $accordion_count = $index + 1;

                    if ( $settings[$this->get_control_id('enable_boxshadow' ) ] ) {
                        $box_shadow = 'box-shadow ';
                        $box_shadow .= $accordion_count === 1 ? 'card-active' : '';
                    }
                ?>
                <div class="card <?php echo esc_attr( $box_shadow ); ?><?php echo esc_attr( $enable_border !== 'yes' ? ' border-0' : '');?>">
                    <div class="card-header" id="heading<?php echo $accordion_count?>">
                        <h3 class="accordion-heading">
                            <a class="<?php if ( $accordion_count != 1 ): ?> collapsed<?php endif;?>"data-toggle="collapse" href="#collapse<?php echo $accordion_count?>" role="button" aria-expanded="false" aria-controls="collapse<?php echo $accordion_count?>">
                                <?php echo $item['title']; ?>
                                <span class="accordion-indicator"></span>
                            </a>
                        </h3>
                    </div>
                    <div class="collapse<?php if ( $accordion_count === 1 ): ?> show<?php endif;?>" id="collapse<?php echo $accordion_count?>" aria-labelledby="heading<?php echo $accordion_count?>" data-parent="#accordionExample">
                        <div <?php echo $widget->get_render_attribute_string( 'content' ); ?>>
                            <?php echo EJ_Utils::parse_text_editor( $item['content'], $settings ); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    public function skin_print_template( $content, $widget ) {
        if( 'accordion' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }
}