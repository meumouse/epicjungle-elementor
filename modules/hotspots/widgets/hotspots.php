<?php
namespace EpicJungleElementor\Modules\Hotspots\Widgets;

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



class Hotspots extends Base_Widget {

    public function get_name() {
        return 'ej-hotspots';
    }

    public function get_title() {
        return esc_html__( 'Pontos de acesso', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-hotspot';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_hotspot', [
                'label' => esc_html__( 'Pontos de acesso', 'epicjungle-elementor' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Escolha a imagem', 'epicjungle-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        

        $repeater->add_control(
            'position-top',
            [
                'label' => __( 'Posição superior', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'min' => 10,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cs-hotspot' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'position-right',
            [
                'label' => esc_html__( 'Posição à direita', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'default'      => [ 
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'min' => 10,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cs-hotspot' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'position-left',
            [
                'label' => esc_html__( 'Posição à esquerda', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'default'      => [ 
                    'unit' => '%'
                ],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'min' => 10,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cs-hotspot' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Título dos dados', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Título', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__( 'Conteúdo de dados', 'epicjungle-elementor' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'conteúdo', 'epicjungle-elementor' ),
                'default'   =>  esc_html__( 'Vivamus sagittis lacus vel augue laoreet rutrum faucibus ornare sem.', 'epicjungle-elementor' ),
            ]
        );

        $repeater->add_control(
            'control_color',
            [
                'label' => __( 'Controlar a cor de fundo', 'epicjungle-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .cs-color-swatch' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_settings', [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [
                        'title'         => esc_html__( 'Punho antiderrapante macio', 'epicjungle-elementor' ),
                        'control_color' => '#ff3dbe',
                    ],
                    [
                        'title'    => esc_html__( 'Botão liga/desliga com 3 modos', 'epicjungle-elementor' ),
                        'control_color' => '#00a1f0',
                    ],
                    [
                        'title'    => esc_html__( 'Cabeça intercambiável', 'epicjungle-elementor' ),
                        'control_color' => '#fa6000',
                    ],
                    [
                        'title'    => esc_html__( 'Poderosa bateria de íons de lítio', 'epicjungle-elementor' ),
                        'control_color' => '#00b22c',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );


    }

    
    /**
     * Render Dividers widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */

  
    protected function render() {
        $settings = $this->get_settings_for_display();
        $count    = count( $settings[ 'content_settings' ] );
        $items    = $settings[ 'content_settings'];

        ?><div class="cs-hotspots mx-auto" id="hotspots-container" style="max-width: 45rem;">
            <?php foreach( $items as $index => $item ) :
                $count = $index + 1; 
                $tab_class = 'radio-tab-pane ';
                $tab_class .= $count === 1 ? 'active' : '';
            
                ?><div class="elementor-hotspot-wrapper elementor-repeater-item-<?php echo esc_attr( $item['_id'] ) ?>">
                    <div class="<?php echo esc_attr($tab_class) ?>" id="color<?php echo esc_attr( $count ) ?>" role="tabpanel">
                        <img alt= "<?php echo esc_html__('Imagem', 'epicjungle-elementor') ?>" src=<?php echo esc_url( $item['image']['url'] ) ?> />
                    </div>
                    <span class="cs-hotspot" data-container="#hotspots-container" data-toggle="popover" data-placement="top" data-trigger="hover" title="<?php echo esc_attr( $item['title'] ) ?>" data-content="<?php echo esc_attr( $item['content'] ) ?>"></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center pt-grid-gutter">
            <div class="d-inline-flex bg-light rounded py-2 px-3">
                <?php foreach( $items as $index => $item ) :
                    $count = $index + 1;

                    ?><div class="custom-control cs-custom-color-option custom-control-inline mx-1 my-1">
                      <input class="custom-control-input" type="radio" name="color" id="c-color<?php echo esc_attr($count) ?>" value="color<?php echo esc_attr( $count ) ?>">
                      <label class="cs-custom-option-label elementor-repeater-item-<?php echo esc_attr( $item['_id'] )?>" for="c-color<?php echo esc_attr( $count ) ?>" data-toggle="radioTab" data-target="#color<?php echo esc_attr( $count ) ?>" data-parent="#hotspots-container"><span class="cs-color-swatch"></span></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div><?php
    }
}