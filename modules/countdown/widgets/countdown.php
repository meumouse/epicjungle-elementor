<?php
namespace EpicJungleElementor\Modules\Countdown\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use EpicJungleElementor\Base\Base_Widget;
use EpicJungleElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Countdown extends Base_Widget {

    public function get_name() {
        return 'ej-countdown';
    }

    public function get_title() {
        return esc_html__( 'Contagem regressiva', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    public function get_keywords() {
        return [ 'countdown', 'number', 'timer', 'time', 'date', 'evergreen' ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'section_countdown', [
            'label' => esc_html__( 'Contagem regressiva', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'countdown_type', [
            'label'   => esc_html__( 'Tipo', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'due_date'  => esc_html__( 'Data de vencimento', 'epicjungle-elementor' ),
                'evergreen' => esc_html__( 'Temporizador de contagem regressiva', 'epicjungle-elementor' ),
            ],
            'default' => 'due_date',
        ] );

        $this->add_control( 'due_date', [
            'label'      => esc_html__( 'Data de vencimento', 'epicjungle-elementor' ),
            'type'       => Controls_Manager::DATE_TIME,
            'default'    => gmdate( 'd-m-Y H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
            /* translators: %s: Time zone. */
            'description' => sprintf( esc_html__( 'Data definida de acordo com o seu fuso horário: %s.', 'epicjungle-elementor' ), Utils::get_timezone_string() ),
            'condition'   => [
                'countdown_type' => 'due_date',
            ],
        ] );

        $this->add_control( 'evergreen_counter_hours', [
            'label'       => esc_html__( 'Horas', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 47,
            'placeholder' => esc_html__( 'Horas', 'epicjungle-elementor' ),
            'condition'   => [
                'countdown_type' => 'evergreen',
            ],
        ] );

        $this->add_control( 'evergreen_counter_minutes', [
                'label' => esc_html__( 'Minutos', 'epicjungle-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 59,
                'placeholder' => esc_html__( 'Minutos', 'epicjungle-elementor' ),
                'condition' => [
                    'countdown_type' => 'evergreen',
                ],
        ] );

        $this->add_control( 'label_display', [
                'label' => esc_html__( 'Visualizar', 'epicjungle-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'block' => esc_html__( 'Bloco', 'epicjungle-elementor' ),
                    'inline' => esc_html__( 'Em linha', 'epicjungle-elementor' ),
                ],
                'default' => 'block',
                'prefix_class' => 'cs-countdown--label-',
        ] );

        $this->add_control( 'show_days', [
            'label'     => esc_html__( 'Dias', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'default'   => 'yes',
        ] );

        $this->add_control( 'show_hours', [
            'label'     => esc_html__( 'Horas', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'default'   => 'yes',
        ] );

        $this->add_control( 'show_minutes', [
            'label'     => esc_html__( 'Minutos', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'default'   => 'yes',
        ] );

        $this->add_control( 'show_seconds', [
            'label'     => esc_html__( 'Segundos', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'default'   => 'yes',
        ] );

        $this->add_control( 'show_labels', [
            'label'     => esc_html__( 'Mostrar rótulo', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'default'   => 'yes',
            'separator' => 'before',
        ] );

        $this->add_control( 'custom_labels', [
            'label'     => esc_html__( 'Rótulo personalizado', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'condition' => [
                'show_labels!' => '',
            ],
        ] );

        $this->add_control( 'label_days', [
            'label'       => esc_html__( 'Dias', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Dias', 'epicjungle-elementor' ),
            'placeholder' => esc_html__( 'Dias', 'epicjungle-elementor' ),
            'condition'   => [
                'show_labels!'   => '',
                'custom_labels!' => '',
                'show_days'      => 'yes',
            ],
        ] );

    $this->add_control( 'label_hours', [
            'label'       => esc_html__( 'Horas', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Horas', 'epicjungle-elementor' ),
            'placeholder' => esc_html__( 'Horas', 'epicjungle-elementor' ),
            'condition'   => [
                'show_labels!'   => '',
                'custom_labels!' => '',
                'show_hours'     => 'yes',
            ],
        ] );

        $this->add_control( 'label_minutes', [
            'label'       => esc_html__( 'Minutos', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Minutos', 'epicjungle-elementor' ),
            'placeholder' => esc_html__( 'Minutos', 'epicjungle-elementor' ),
            'condition'   => [
                'show_labels!'   => '',
                'custom_labels!' => '',
                'show_minutes'   => 'yes',
            ],
        ] );

        $this->add_control( 'label_seconds', [
            'label'       => esc_html__( 'Segundos', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Segundos', 'epicjungle-elementor' ),
            'placeholder' => esc_html__( 'Segundos', 'epicjungle-elementor' ),
            'condition'   => [
                'show_labels!'   => '',
                'custom_labels!' => '',
                'show_seconds'   => 'yes',
            ],
        ] );

        $this->add_control( 'expire_actions', [
            'label'   => esc_html__( 'Ações após expirar', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SELECT2,
            'options' => [
                'redirect' => esc_html__( 'Redirecionar', 'epicjungle-elementor' ),
                'hide'     => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'message'  => esc_html__( 'Mostrar mensagem', 'epicjungle-elementor' ),
            ],
            'label_block' => true,
            'separator'   => 'before',
            'render_type' => 'none',
            'multiple'    => true,
        ] );

        $this->add_control( 'message_after_expire', [
            'label'     => esc_html__( 'Mensagem', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::TEXTAREA,
            'separator' => 'before',
            'dynamic'   => [
                'active' => true,
            ],
            'condition' => [
                'expire_actions' => 'message',
            ],
        ] );

        $this->add_control( 'expire_redirect_url', [
            'label'     => esc_html__( 'URL de redirecionamento', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::URL,
            'separator' => 'before',
            'options'   => false,
            'dynamic'   => [
                'active' => true,
            ],
            'condition' => [
                'expire_actions' => 'redirect',
            ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_box_style', [
            'label' => esc_html__( 'Caixas', 'epicjungle-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'container_width', [
            'label'   => esc_html__( 'Largura do contêiner', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SLIDER,
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'tablet_default' => [
                'unit' => '%',
            ],
            'mobile_default' => [
                'unit' => '%',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 2000,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'size_units' => [ '%', 'px' ],
            'selectors' => [
                '{{WRAPPER}} .cs-countdown' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'box_background_color', [
            'label'  => esc_html__( 'Cor de fundo', 'epicjungle-elementor' ),
            'type'   => Controls_Manager::COLOR,
            'global' => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .cs-countdown-item' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'      => 'box_border',
            'selector'  => '{{WRAPPER}} .cs-countdown-item',
            'separator' => 'before',
        ] );

        $this->add_control( 'box_border_radius', [
            'label'      => esc_html__( 'Raio da borda', 'epicjungle-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .cs-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'box_spacing', [
            'label'   => esc_html__( 'Espaço entre', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SLIDER,
            'range'   => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                'body:not(.rtl) {{WRAPPER}} .cs-countdown-item:not(:first-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                'body:not(.rtl) {{WRAPPER}} .cs-countdown-item:not(:last-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                'body.rtl {{WRAPPER}} .cs-countdown-item:not(:first-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                'body.rtl {{WRAPPER}} .cs-countdown-item:not(:last-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
            ],
        ] );

        $this->add_responsive_control( 'box_padding', [
            'label'      => esc_html__( 'Preenchimento', 'epicjungle-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .cs-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'countdown_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown', 'epicjungle-elementor' ),
            'dynamic'     => [
                'active' => true,
            ]
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_content_style', [
            'label' => esc_html__( 'Conteúdo', 'epicjungle-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'heading_item', [
            'label' => esc_html__( 'Item', 'epicjungle-elementor' ),
            'type'  => Controls_Manager::HEADING,
        ] );

        $this->add_control( 'days_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown-days', 'epicjungle-elementor' ),
            'condition'   => [ 'show_days' => 'yes' ],
            'dynamic'     => [ 'active' => true ]
        ] );

        $this->add_control( 'hours_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown-hours', 'epicjungle-elementor' ),
            'condition'   => [ 'show_hours' => 'yes' ],
            'dynamic'     => [ 'active' => true ]
        ] );

        $this->add_control( 'minutes_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown-minutes', 'epicjungle-elementor' ),
            'condition'   => [ 'show_minutes' => 'yes' ],
            'dynamic'     => [ 'active' => true ]
        ] );

        $this->add_control( 'seconds_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown-seconds', 'epicjungle-elementor' ),
            'condition'   => [ 'show_seconds' => 'yes' ],
            'dynamic'     => [ 'active' => true ]
        ] );

        $this->add_control( 'item_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown-item', 'epicjungle-elementor' ),
            'dynamic'     => [ 'active' => true ]
        ] );

        $this->add_control( 'heading_digits', [
            'label' => esc_html__( 'Dígitos', 'epicjungle-elementor' ),
            'type'  => Controls_Manager::HEADING,
        ] );

        $this->add_control( 'digits_color', [
            'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cs-countdown-value' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'digits_typography',
            'selector' => '{{WRAPPER}} .cs-countdown-value',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_TEXT,
            ],
        ] );

        $this->add_control( 'digits_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown-value', 'epicjungle-elementor' ),
            'dynamic'     => [
                'active' => true,
            ]
        ] );

        $this->add_control( 'heading_label', [
            'label'     => esc_html__( 'Rótulo', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'label_color', [
            'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cs-countdown-label' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'label_typography',
            'selector' => '{{WRAPPER}} .cs-countdown-label',
            'global'   => [
                'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
            ],
        ] );

        $this->add_control( 'label_css', [
            'label'       => esc_html__( 'Classes CSS', 'epicjungle-elementor'),
            'type'        => Controls_Manager::TEXT,
            'title'       => esc_html__( 'Adicione sua classe personalizada SEM o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Classes adicionadas a .cs-countdown-label', 'epicjungle-elementor' ),
            'dynamic'     => [
                'active' => true,
            ]
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_expire_message_style', [
            'label'     => esc_html__( 'Message', 'epicjungle-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'expire_actions' => 'message',
            ],
        ] );

        $this->add_responsive_control( 'align', [
            'label'   => esc_html__( 'Alinhamento', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__( 'Centro', 'epicjungle-elementor' ),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => esc_html__( 'Direita', 'epicjungle-elementor' ),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .cs-countdown-expire--message' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'text_color', [
            'label'     => esc_html__( 'Cor do texto', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .cs-countdown-expire--message' => 'color: {{VALUE}};',
            ],
            'global' => [
                'default' => Global_Colors::COLOR_TEXT,
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'   => 'typography',
            'global' => [
                'default' => Global_Typography::TYPOGRAPHY_TEXT,
            ],
            'selector' => '{{WRAPPER}} .cs-countdown-expire--message',
        ] );

        $this->add_responsive_control( 'message_padding', [
            'label'      => esc_html__( 'Padding', 'epicjungle-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .cs-countdown-expire--message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function get_strftime( $instance ) {
        $string = '';

        $this->add_render_attribute( 'countdown-item', 'class', 'cs-countdown-item' );
        if ( ! empty( $instance['item_css'] ) ) {
            $this->add_render_attribute( 'countdown-item', 'class', $instance['item_css'] );
        }

        $this->add_render_attribute( 'countdown-value', 'class', 'cs-countdown-value' );
        if ( ! empty( $instance['digits_css'] ) ) {
            $this->add_render_attribute( 'countdown-value', 'class', $instance['digits_css'] );
        }

        $this->add_render_attribute( 'countdown-label', 'class', 'cs-countdown-label' );
        if ( ! empty( $instance['label_css'] ) ) {
            $this->add_render_attribute( 'countdown-label', 'class', $instance['label_css'] );
        }

        if ( $instance['show_days'] ) {

            $part_class = 'cs-countdown-days';
            if ( ! empty( $instance['days_css'] ) ) {
                $part_class .= ' ' . $instance['days_css'];
            }
            $string .= $this->render_countdown_item( $instance, 'label_days', $part_class );
        }
        if ( $instance['show_hours'] ) {

            $part_class = 'cs-countdown-hours';
            if ( ! empty( $instance['hours_css'] ) ) {
                $part_class .= ' ' . $instance['hours_css'];
            }
            $string .= $this->render_countdown_item( $instance, 'label_hours', $part_class );
        }
        if ( $instance['show_minutes'] ) {
            $part_class = 'cs-countdown-minutes';
            if ( ! empty( $instance['minutes_css'] ) ) {
                $part_class .= ' ' . $instance['minutes_css'];
            }
            $string .= $this->render_countdown_item( $instance, 'label_minutes', $part_class );
        }
        if ( $instance['show_seconds'] ) {
            $part_class = 'cs-countdown-seconds';
            if ( ! empty( $instance['seconds_css'] ) ) {
                $part_class .= ' ' . $instance['seconds_css'];
            }
            $string .= $this->render_countdown_item( $instance, 'label_seconds', $part_class );
        }

        return $string;
    }

    private $_default_countdown_labels;

    private function init_default_countdown_labels() {
        $this->_default_countdown_labels = [
            'label_months'  => esc_html__( 'Meses', 'epicjungle-elementor' ),
            'label_weeks'   => esc_html__( 'Semanas', 'epicjungle-elementor' ),
            'label_days'    => esc_html__( 'Dias', 'epicjungle-elementor' ),
            'label_hours'   => esc_html__( 'Horas', 'epicjungle-elementor' ),
            'label_minutes' => esc_html__( 'Minutos', 'epicjungle-elementor' ),
            'label_seconds' => esc_html__( 'Segundos', 'epicjungle-elementor' ),
        ];
    }

    public function get_default_countdown_labels() {
        if ( ! $this->_default_countdown_labels ) {
            $this->init_default_countdown_labels();
        }

        return $this->_default_countdown_labels;
    }

    private function render_countdown_item( $instance, $label, $part_class ) {

        $this->add_render_attribute( 'countdown-item', 'class', $part_class );

        $string = '<div ' . $this->get_render_attribute_string( 'countdown-item' ) . '>';
        $string .= '<span ' . $this->get_render_attribute_string( 'countdown-value' ) . '>0</span>';

        if ( $instance['show_labels'] ) {
            $default_labels = $this->get_default_countdown_labels();
            $label   = ( $instance['custom_labels'] ) ? $instance[ $label ] : $default_labels[ $label ];
            $string .= '<span ' . $this->get_render_attribute_string( 'countdown-label' ) . '>' . esc_html( $label ) . '</span>';
        }

        $string .= '</div>';

        $this->remove_render_attribute( 'countdown-item', 'class', $part_class );

        return $string;
    }

    private function get_evergreen_interval( $instance ) {
        $hours = empty( $instance['evergreen_counter_hours'] ) ? 0 : ( $instance['evergreen_counter_hours'] * HOUR_IN_SECONDS );
        $minutes = empty( $instance['evergreen_counter_minutes'] ) ? 0 : ( $instance['evergreen_counter_minutes'] * MINUTE_IN_SECONDS );
        $evergreen_interval = $hours + $minutes;

        return $evergreen_interval;
    }

    private function get_actions( $settings ) {
        if ( empty( $settings['expire_actions'] ) || ! is_array( $settings['expire_actions'] ) ) {
            return false;
        }

        $actions = [];

        foreach ( $settings['expire_actions'] as $action ) {
            $action_to_run = [ 'type' => $action ];
            if ( 'redirect' === $action ) {
                if ( empty( $settings['expire_redirect_url']['url'] ) ) {
                    continue;
                }
                $action_to_run['redirect_url'] = $settings['expire_redirect_url']['url'];
            }
            $actions[] = $action_to_run;
        }

        return $actions;
    }

    protected function render() {
        $instance = $this->get_settings_for_display();
        $due_date = $instance['due_date'];
        $string   = $this->get_strftime( $instance );

        if ( 'evergreen' === $instance['countdown_type'] ) {
            $this->add_render_attribute( 'div', 'data-evergreen-interval', $this->get_evergreen_interval( $instance ) );
        } else {
            // Handle timezone ( we need to set GMT time )
            $gmt = get_gmt_from_date( $due_date . ':00' );
            $due_date = strtotime( $gmt );
        }

        $actions = false;

        if ( ! Plugin::elementor()->editor->is_edit_mode() ) {
            $actions = $this->get_actions( $instance );
        }

        if ( $actions ) {
            $this->add_render_attribute( 'div', 'data-expire-actions', json_encode( $actions ) );
        }

        $this->add_render_attribute( 'div', [
            'class'          => 'cs-countdown',
            'data-countdown' => date( 'd/m/Y h:i:s A', $due_date ), //'10/01/2021 07:00:00 PM'
        ] );

        if ( ! empty( $instance['countdown_css'] ) ) {
            $this->add_render_attribute( 'div', 'class', $instance['countdown_css'] );
        }

        ?>
        <div <?php echo $this->get_render_attribute_string( 'div' ); ?>>
            <?php echo $string; ?>
        </div>
        <?php
        if ( $actions && is_array( $actions ) ) {
            foreach ( $actions as $action ) {
                if ( 'message' !== $action['type'] ) {
                    continue;
                }
                echo '<div class="cs-countdown-expire--message">' . $instance['message_after_expire'] . '</div>';
            }
        }
    }
}