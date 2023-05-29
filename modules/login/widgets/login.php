<?php
namespace EpicJungleElementor\Modules\Login\Widgets;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use EpicJungleElementor\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;
use EpicJungleElementor\Modules\Login\Skins;
use Elementor\Repeater;

/**
 * epicjungle Elementor login widget.
 *
 * epicjungle Elementor widget that displays a login with the ability to control every
 * aspect of the login design.
 *
 * @since 1.0.0
 */

class Login extends Base_Widget {

    protected function register_skins() {
        $this->add_skin( new Skins\Skin_Style_1( $this ) );
        $this->add_skin( new Skins\Skin_Style_2( $this ) );
    }


    public function get_name() {
        return 'ej-login';
    }

    public function get_title() {
        return esc_html__( 'Formulários de conta de usuário', 'epicjungle-elementor' );
    }

    public function get_icon() {
        return 'eicon-site-identity';
    }

    public function get_keywords() {
        return [ 'login', 'user', 'form', 'signin', 'signup', 'register' ];
    }

    protected function register_controls() {

        $can_register = get_option( 'users_can_register' );

        $this->start_controls_section( 'section_general', [
            'label' => esc_html__( 'Geral', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'display', [
            'label'       => esc_html__( 'Exibir', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Escolha quais formulários você deseja exibir. Observe que o formulário de registro está disponível apenas se o registro estiver ativado em Configurações > Geral > Membros.', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
                'all'      => esc_html__( 'Tudo', 'epicjungle-elementor' ),
                'login'    => esc_html__( 'Entrar', 'epicjungle-elementor' ),
                'register' => esc_html__( 'Registrar-se', 'epicjungle-elementor' ),
                'forgot'   => esc_html__( 'Redefinir senha', 'epicjungle-elementor' )
            ],
            'default'     => 'all'
        ] );

        $this->add_control(
            'show_background_image',
            [
                'label'     => esc_html__( 'Mostrar imagem de fundo', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'default'   => 'yes',
                'separator' => 'before',
                'condition'  => [
                    '_skin!'  => ''
                ],
            ]
        ); 

        $this->add_control(
            'bg_image',
            [
                'label' => __( 'Imagem de fundo', 'epicjungle-elementor' ),
                'type'  => Controls_Manager::MEDIA,
                'condition' => [ 
                    'show_background_image' => 'yes',
                    '_skin!'  => '' 
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_form_option_controls();

        $this->add_login_form_controls();

        $this->add_register_form_controls();

        $this->add_password_reset_form_controls();

        $this->add_additional_options_controls();

        $this->start_controls_section( 'section_heading_style', [
            'label' => esc_html__( 'Formulário', 'epicjungle-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'form_title_heading', [
            'label'     => __( 'Título do formulário', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'condition' => [ 'show_form_title' => 'yes'],
        ] );


        $this->add_control( 'form_title_color', [
            'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .form-header__title' => 'color: {{VALUE}};'
            ],
            'condition' => [ 'show_form_title' => 'yes'],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'form_title_typography',
            'selector'  => '{{WRAPPER}} .form-header__title',
            'condition' => [ 'show_form_title' => 'yes'],
        ] );

        $this->add_control( 'form_title_alignment', [
            'label'          => esc_html__( 'Alinhamento', 'epicjungle-elementor' ),
            'type'           => Controls_Manager::CHOOSE,
            'options'        => [
                'left'       => [
                    'title'     => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                    'icon'      => 'eicon-text-align-left',
                ],
                'center'     => [
                    'title'     => esc_html__( 'Centro', 'epicjungle-elementor' ),
                    'icon'      => 'eicon-text-align-center',
                ],
                'right'      => [
                    'title'     => esc_html__( 'Direita', 'epicjungle-elementor' ),
                    'icon'      => 'eicon-text-align-right',
                ],
            ],
            'selectors'      => [
                '{{WRAPPER}} .form-header__title' => 'text-align: {{VALUE}}',
            ],
            'default'        => 'left',
            'condition'      => [ 'show_form_title'   => 'yes' ],
        ] );

        $this->add_control( 'title_css', [
            'label'     => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'title'     => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
            'default'   => 'h2',
            'condition' => [ 'show_form_title' => 'yes'],
        ] );

        $this->add_control( 'form_description_heading', [
            'label'     => __( 'Descrição do formulário', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [ 'show_form_description' => 'yes' ],
        ] );


        $this->add_control( 'form_description_color', [
            'label'     => esc_html__( 'Cor', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .form-header__desc' => 'color: {{VALUE}};',
            ],
            'condition' => [ 'show_form_description' => 'yes' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'form_description_typography',
            'selector'  => '{{WRAPPER}} .form-header__desc',
            'condition' => [ 'show_form_description' => 'yes' ],
        ] );

        $this->add_control(
            'description_alignment',
            [
                'label'          => esc_html__( 'Alinhamento da descrição', 'epicjungle-elementor' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'left'       => [
                        'title'     => esc_html__( 'Esquerda', 'epicjungle-elementor' ),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title'     => esc_html__( 'Centro', 'epicjungle-elementor' ),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'      => [
                        'title'     => esc_html__( 'Direita', 'epicjungle-elementor' ),
                        'icon'      => 'eicon-text-align-right',
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .form-header__desc' => 'text-align: {{VALUE}}',
                ],
                'default'        => 'left',
                'condition'      => [ 'show_form_description' => 'yes' ],
            ]
        );

        $this->add_control(
            'description_css', [
                'label'   => esc_html__( 'Classes CSS', 'epicjungle-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'title'   => esc_html__( 'Adicione sua classe personalizada para texto sem o ponto. ex: minha-classe', 'epicjungle-elementor' ),
                'default' => 'font-size-sm mb-4',
                'condition'   => [
                    'show_form_description'   => 'yes',
                ],
            ]
        );

        $this->add_control( 'form_footer_alignment', [
            'label'   => esc_html__( 'Alinhamento do rodapé do formulário', 'epicjungle-elementor' ),
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
            'separator' => 'before',
            'default'   => 'left',
            'selectors' => [
                '{{WRAPPER}} .form__footer' => 'text-align: {{VALUE}}',
            ],
        ] );

        $this->end_controls_section();
    }

    private function add_form_option_controls() {
         $can_register = get_option( 'users_can_register' );

        $this->start_controls_section( 'section_form_controls', [
            'label'     => esc_html__( 'Controles de formulário', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'show_form_title', [
            'label'     => esc_html__( 'Título', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'title_tag', [
            'label'    => esc_html__( 'Tag HTML do título', 'epicjungle-elementor' ),
            'type'     => Controls_Manager::SELECT,
            'options'  => [
                'h1'   => 'H1',
                'h2'   => 'H2',
                'h3'   => 'H3',
                'h4'   => 'H4',
                'h5'   => 'H5',
                'h6'   => 'H6',
                'div'  => 'div',
                'span' => 'span',
                'p'    => 'p',
            ],
            'default'  => 'h1',
            'condition'   => [
                'show_form_title' => 'yes',
            ],
        ] );

        $this->add_control( 'show_form_description', [
            'label'     => esc_html__( 'Descrição', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'show_labels', [
            'label'     => esc_html__( 'Rótulos do formulário de login', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'no',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
        ] );

        if ( $can_register ) :
            $this->add_control( 'show_register_labels', [
                'label'     => esc_html__( 'Rótulos de formulário de registro', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            ] );
        endif;   

        $this->add_control( 'button_heading', [
            'label'     => esc_html__( 'Botão enviar', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'button_type', [
            'label'   => esc_html__( 'Tipo', 'epicjungle-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'primary',
            'options' => [
                'primary'       => esc_html__( 'Primário', 'epicjungle-elementor' ),
                'secondary'     => esc_html__( 'Secundário', 'epicjungle-elementor' ),
                'success'       => esc_html__( 'Sucesso', 'epicjungle-elementor' ),
                'danger'        => esc_html__( 'Perigo', 'epicjungle-elementor' ),
                'warning'       => esc_html__( 'Aviso', 'epicjungle-elementor' ),
                'info'          => esc_html__( 'Informação', 'epicjungle-elementor' ),
                'dark'          => esc_html__( 'Escuro', 'epicjungle-elementor' ),
                'link'          => esc_html__( 'Link', 'epicjungle-elementor' ),
                'gradient'      => esc_html__( 'Degradê', 'epicjungle-elementor' ),
            ],
        ] );

        $this->add_control( 'button_size', [
            'label'          => esc_html__( 'Tamanho', 'epicjungle-elementor' ),
            'type'           => Controls_Manager::SELECT,
            'options'        => [
                'sm'    => esc_html__( 'Pequeno', 'epicjungle-elementor' ),
                ''      => esc_html__( 'Base', 'epicjungle-elementor' ),
                'lg'    => esc_html__( 'Grande', 'epicjungle-elementor' ),
                'block' => esc_html__( 'Block', 'epicjungle-elementor' ),
            ],
            'style_transfer' => true,
            'default'        => '',
        ] );


        $this->add_control( 'button_css_id', [
            'label'       => esc_html__( 'ID do botão', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'default'     => '',
            'title'       => esc_html__( 'Adicione seu ID personalizado SEM a tecla de cerquílha. ex: meu-id', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Certifique-se de que o ID seja exclusivo e não seja usado em nenhum outro lugar da página em que este formulário é exibido. Este campo permite <code>A-z 0-9</code> e caracteres de sublinhado sem espaços.', 'epicjungle-elementor' ),
            'separator'   => 'before',

        ] );

        $this->end_controls_section();
    }

    private function form_fields_render_attributes() {
        $settings = $this->get_settings();
        $unique_id = uniqid();
        $can_register = get_option( 'users_can_register' );

        $this->add_render_attribute( 'button_text', 'class', [
            'elementor-login__button',
            'btn',
            'btn-block',
            'btn-primary'
        ] );

    
        $this->add_render_attribute( 'register_button_text', 'class', [
            'ej-register__button',
            'btn',
            'btn-block',
            'btn-primary',
            'w-50'
        ] );

        $this->add_render_attribute( 'lost_button_text', 'class', [
            'ej-lost__button',
            'btn',
            'btn-primary'
        ] );

        
        if ( ! empty( $settings['button_type'] ) ) {
            $this->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_type'] );
        }

        if ( ! empty( $settings['button_radius'] ) ) {
            if ( $settings['button_radius'] == 'rounded-0' ) {
                $this->add_render_attribute( 'button_text', 'class', $settings['button_radius'] );
            } else if ( $settings['button_radius'] == 'card-btn' ) {
                $this->add_render_attribute( 'button_text', 'class', $settings['button_radius'] );
            } else {
                $this->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_radius'] );
            }
        }

        if ( ! empty( $settings['button_size'] ) ) {
            $this->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_size'] );
        }

        if ( ! empty( $settings[ 'button_classes' ] ) ) {
            $this->add_render_attribute( 'button_text', 'class', $settings['button_classes'] );
        }

        $this->add_render_attribute(
            [
                'wrapper' => [
                    'class' => [
                        'ej-form-fields-wrapper',
                    ],
                ],
                'field-group' => [
                    'class' => [
                        'elementor-field-type-text',
                        'elementor-field-group',
                        'elementor-col-100',
                        'input-group-overlay',
                        'form-group',
                    ],
                ],
                'password-field-group' => [
                    'class' => [
                        'elementor-field-type-text',
                        'elementor-field-group',
                        'elementor-col-100',
                        'input-group-overlay',
                        'cs-password-toggle',
                        'form-group',
                    ],
                ],
               
                'button' => [
                    'class' => [
                        'ej-button',
                    ],
                    'name' => 'login',
                ],
                'user_label' => [
                    'for'   => 'user-' . $unique_id,
                    
                ],
                'user_input' => [
                    'type' => 'text',
                    'name' => 'username',
                    'id'   => 'user-' . $unique_id,
                    'placeholder' => $settings['user_placeholder'],
                    'class' => [
                        'form-control prepended-form-control',
                    ],
                    'value' => (! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''
                ],
                'password_label' => [
                    'for' => 'password-' . $unique_id,
                    
                ],
                'password_input' => [
                    'type' => 'password',
                    'name' => 'password',
                    'id'   => 'password-' . $unique_id,
                    'placeholder' => $settings['password_placeholder'],
                    'class' => [
                        'form-control prepended-form-control',

                    ],
                ],
                'user_forget_password_label' => [
                    'for' => 'recoverSrEmail-' . $unique_id,
                    
                    
                ],
                
                'user_forget_password_input' => [
                    'type' => 'text',
                    'name' => 'user_login',
                    'id'   => 'recoverSrEmail-' . $unique_id,
                    'placeholder' => $settings['user_placeholder'],
                    'class' => [
                        'form-control',
                    ],
                ],

                'user_register_label' => [
                    'for'   => 'reg_username-' . $unique_id,
                    
                ],
                
                'user_register_input' => [
                    'type' => 'text',
                    'name' => 'username',
                    'id'   => 'reg_username-' . $unique_id,
                    'placeholder' => $settings['register_email_placeholder'],
                    'class' => [
                        'form-control prepended-form-control',
                    ],
                ],

                'register_password_label' => [
                    'for'   => 'signupSrPassword-' . $unique_id,
                    
                ],
                
                'register_password_input' => [
                    'type' => 'password',
                    'name' => 'password',
                    'id'   => 'signupSrPassword-' . $unique_id,
                    'placeholder' => $settings['register_password_placeholder'],
                    'class' => [
                        'form-control',
                    ],
                ],
                'email_register_label' => [
                    'for'   => 'reg_email-' . $unique_id,
                    
                ],
                
                'email_register_input' => [
                    'type' => 'email',
                    'name' => 'email',
                    'id'   => 'reg_email-' . $unique_id,
                    'placeholder' => $settings['register_email_placeholder'],
                    'class' => [
                        'form-control',
                    ],
                ],
                'register_confirm_password_label' => [
                    'for'   => 'signupSrConfirmPassword-' . $unique_id,
                    
                ],
                'register_confirm_password_input' => [
                    'type' => 'password',
                    'name' => 'confirmPassword',
                    'id'   => 'signupSrConfirmPassword-' . $unique_id,
                    'placeholder' => $settings['register_confirm_password_placeholder'],
                    'class' => [
                        'form-control',
                    ],
                ],

                
                
                //TODO: add unique ID
                'label_user' => [
                    'for' => 'user',
                    'class' => 'elementor-field-label',
                ],

                'label_password' => [
                    'for' => 'password',
                    'class' => 'elementor-field-label',
                ],
            ]
        );

        if ( ! $settings['show_labels'] ) {
            $this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
        }

        if ( ! $settings['show_register_labels'] ) {
            $this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
        }

        $this->add_render_attribute( 'field-group', 'class', 'elementor-field-required' )
             ->add_render_attribute( 'input', 'required', true )
             ->add_render_attribute( 'input', 'aria-required', 'true' );
    }

    private function add_login_form_controls() {

        $can_register = get_option( 'users_can_register' );

        $this->start_controls_section( 'section_login', [
            'label' => esc_html__( 'Formulário de login', 'epicjungle-elementor' ),
            'condition' => [
                'display' => [ 'all', 'login' ]
            ]
        ] );

        $this->add_control(
            'login_title', [
                'label'       => esc_html__( 'Título do formulário', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Entrar', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Título', 'epicjungle-elementor' ),
                'condition'   => [
                    'show_form_title' => 'yes',
                ],
            ]
        );
       
        $this->add_control(
            'login_description', [
                'label'       => esc_html__( 'Descrição do formulário', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Entre em sua conta usando o e-mail e a senha fornecidos durante o registro.', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Descrição', 'epicjungle-elementor' ),
                'condition'   => [
                    'show_form_description' => 'yes',
                ],
            ]
        );

        $this->add_control( 'user_label', [
            'label'       => esc_html__( 'Rótulo de Usuário', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'separator'   => 'before',
            'default'     => esc_html__( 'Endereço de e-mail', 'epicjungle-elementor' ),
            'condition'   => [
                'show_labels' => 'yes',
            ],
        ] );

        $this->add_control( 'user_placeholder', [
            'label'       => esc_html__( 'Espaço reservado do Usuário', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => esc_html__( 'E-mail', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'password_label', [
            'label'       => esc_html__( 'Rótulo de senha', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'separator'   => 'before',
            'default'     => esc_html__( 'Senha', 'epicjungle-elementor' ),
            'condition'   => [
                'show_labels' => 'yes',
            ],
        ] );

        $this->add_control( 'password_placeholder', [
            'label'       => esc_html__( 'Espaço reservado da senha', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => esc_html__( 'Senha', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'show_lost_password', [
            'label'     => esc_html__( 'Link de redefinição de senha', 'epicjungle-elementor' ),
            'separator' => 'before',
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'password_reset_text', [
            'label'       => esc_html__( 'Texto de redefinição de senha', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => esc_html__( 'Esqueceu sua senha?', 'epicjungle-elementor' ),
            'label_off'   => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'    => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            'condition'   => [ 'show_lost_password' => 'yes' ]
        ] );

        $this->add_control( 'password_reset_link', [
            'label'     => esc_html__( 'Página de redefinição de senha', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::URL,
            'default'   => [ 'url' => '#' ],
            'dynamic'   => [ 'active'   => true ],
            'condition' => [ 'display!' => 'all', 'show_lost_password' => 'yes' ],
        ] );

        $this->add_control( 'show_remember_me', [
            'label'     => esc_html__( 'Lembrar de mim', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'button_text', [
            'label'       => esc_html__( 'Texto do botão de login', 'epicjungle-elementor' ),
            'label_block' => true,
            'separator'   => 'before',
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Entrar', 'epicjungle-elementor' ),
        ] );

        if ( $can_register ) :

            $this->add_control( 'show_register', [
                'label'     => esc_html__( 'Link de registro', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'before',
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            ] );

            $this->add_control( 'register_link_intro', [
                'label'       => esc_html__( 'Introdução à página de registro', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Não tem uma conta?', 'epicjungle-elementor' ),
                'condition'   => [ 'show_register' => 'yes' ],
            ] );

            $this->add_control( 'register_link_text', [
                'label'       => esc_html__( 'Texto do link de registro', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Registrar-se', 'epicjungle-elementor' ),
                'condition'   => [ 'show_register' => 'yes' ],
            ] );

            $this->add_control( 'register_link', [
                'label'     => esc_html__( 'Link da página de registro', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::URL,
                'default'   => [ 'url' => '#' ],
                'dynamic'   => [ 'active'   => true ],
                'condition' => [ 'display!' => 'all', 'show_register' => 'yes' ],
            ] );

        endif;

        $this->end_controls_section();
    }

    private function add_register_form_controls() {
        $can_register = get_option( 'users_can_register' );

        if ( $can_register ) :

            $this->start_controls_section( 'section_register', [
                'label'     => esc_html__( 'Formulário de registro', 'epicjungle-elementor' ),
                'condition' => [ 'display' => [ 'all', 'register' ] ]
            ] );

            $this->add_control( 'register_title', [
                'label'       => esc_html__( 'Título do formulário', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Registrar-se', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Título', 'epicjungle-elementor' ),
                'condition'   => [ 'show_form_title' => 'yes' ],
            ] );

           
            $this->add_control( 'register_description', [
                'label'       => esc_html__( 'Descrição do formulário', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'O registro leva menos de um minuto, mas oferece controle total sobre seus pedidos.', 'epicjungle-elementor' ),
                'placeholder' => esc_html__( 'Descrição', 'epicjungle-elementor' ),
                'condition'   => [ 'show_form_description' => 'yes' ],
                'separator'   => 'after',
            ] );

            $this->add_control( 'register_email_label', [
                'label'       => esc_html__( 'Rótulo de e-mail', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Endereço de e-mail', 'epicjungle-elementor' ),
                'condition'   => [ 'show_register_labels' => 'yes' ]

            ] );

            $this->add_control( 'register_email_placeholder', [
                'label'       => esc_html__( 'Espaço reservado de e-mail', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'E-mail', 'epicjungle-elementor' ),
                'separator'   => 'after',
            ] );

            $this->add_control( 'register_password_label', [
                'label'       => esc_html__( 'Espaço reservado de senha', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Senha', 'epicjungle-elementor' ),
                'condition'   => [ 'show_register_labels' => 'yes' ]
            ] );

            $this->add_control( 'register_password_placeholder', [
                'label'       => esc_html__( 'Espaço reservado de senha', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Senha', 'epicjungle-elementor' ),
            ] );

            $this->add_control( 'register_confirm_password_placeholder', [
                'label'       => esc_html__( 'Rótulo da confirmação de senha', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Confirme sua senha', 'epicjungle-elementor' ),
                'separator'   => 'after',
            ] );

            $this->add_control( 'register_button_text', [
                'label'       => esc_html__( 'Texto do botão de registro', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Registrar-se', 'epicjungle-elementor' ),
            ] );

            $this->add_control( 'show_login', [
                'label'     => esc_html__( 'Link de login', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'before',
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
            ] );

            $this->add_control( 'login_link_intro', [
                'label'       => esc_html__( 'Introdução à página de login', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Já tem uma conta?', 'epicjungle-elementor' ),
                'condition'   => [ 'show_login' => 'yes' ],
            ] );

            $this->add_control( 'login_link_text', [
                'label'       => esc_html__( 'Texto do link de login', 'epicjungle-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Entrar', 'epicjungle-elementor' ),
                'condition'   => [ 'show_login' => 'yes' ],
            ] );

            $this->add_control( 'login_link', [
                'label'     => esc_html__( 'Link da página de login', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::URL,
                'default'   => [ 'url' => '#' ],
                'dynamic'   => [ 'active'   => true ],
                'condition' => [ 'display!' => 'all', 'show_login' => 'yes' ],
            ] );

            $this->end_controls_section();

        endif;
    }

    private function add_password_reset_form_controls() {

        $this->start_controls_section( 'section_password_reset', [
            'label'     => esc_html__( 'Formulário de redefinição de senha', 'epicjungle-elementor' ),
            'condition' => [ 'display' => [ 'all', 'forgot' ] ]
        ] );
        
        $this->add_control( 'password_title', [
            'label'       => esc_html__( 'Título do formulário', 'epicjungle-elementor' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Esqueceu sua senha?', 'epicjungle-elementor' ),
            'placeholder' => esc_html__( 'Título', 'epicjungle-elementor' ),
            'condition'   => [ 'show_form_title' => 'yes' ],
        ] );

       
        $this->add_control( 'password_description', [
            'label'       => esc_html__( 'Descrição do formulário', 'epicjungle-elementor' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => esc_html__( 'Altere sua senha em três etapas fáceis. Isso ajuda a manter sua nova senha segura.', 'epicjungle-elementor' ),
            'placeholder' => esc_html__( 'Descrição', 'epicjungle-elementor' ),
            'condition'   => [ 'show_form_description' => 'yes' ],
        ] );

        $this->add_control( 'show_change_password_steps', [
            'label'     => esc_html__( 'Mostrar etapas de alteração de senhas', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
        ] );


        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label'            => esc_html__( 'Texto da lista', 'epicjungle-elementor' ),
                'type'             => Controls_Manager::TEXT,
                'default'          => esc_html__( 'Item da lista', 'epicjungle-elementor' ),
            ]
        );

        $this->add_control(
            'steps',
            [
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'default'       => [
                    [
                        'item_text'          => esc_html__( 'Preencha seu endereço de e-mail abaixo.', 'epicjungle-elementor' ),
                    ],
                    [
                        'item_text'          => esc_html__( 'Nós lhe enviaremos um código temporário por e-mail.', 'epicjungle-elementor' ),
                    ],
                    [
                        'item_text'          => esc_html__( 'Use o código para alterar sua senha com segurança em nosso site.', 'epicjungle-elementor' ),
                    ],
                ],
                'condition'                  => [ 'show_change_password_steps' => 'yes' ],
                'title_field'                => '{{{ item_text }}}',
            ]
        );


        $this->add_control( 'reset_pasword_button_text', [
            'label'       => esc_html__( 'Texto do botão', 'epicjungle-elementor' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Obtenha uma nova senha', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'rp_show_login', [
            'label'     => esc_html__( 'Link de login', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
            'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'rp_login_link_intro', [
            'label'       => esc_html__( 'Introdução à página de login', 'epicjungle-elementor' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Lembrar da sua senha?', 'epicjungle-elementor' ),
            'condition'   => [ 'rp_show_login' => 'yes' ],
        ] );

        $this->add_control( 'rp_login_link_text', [
            'label'       => esc_html__( 'Texto do link de login', 'epicjungle-elementor' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Entrar', 'epicjungle-elementor' ),
            'condition'   => [ 'rp_show_login' => 'yes' ],
        ] );

        $this->add_control( 'rp_login_link', [
            'label'     => esc_html__( 'Link da página de login', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::URL,
            'default'   => [ 'url' => '#' ],
            'dynamic'   => [ 'active'   => true ],
            'condition' => [ 'display!' => 'all', 'rp_show_login' => 'yes' ],
        ] );

        $this->end_controls_section();
    }

    private function add_additional_options_controls() {
        $this->start_controls_section( 'section_login_content', [
            'label' => esc_html__( 'Opções adicionais', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'redirect_after_login', [
            'label'     => esc_html__( 'Redirecionar após o login', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => '',
            'label_off' => esc_html__( 'Desligado', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Ligado', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'redirect_url', [
            'type'        => Controls_Manager::URL,
            'show_label'  => false,
            'options'     => false,
            'separator'   => false,
            'placeholder' => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Obs.: Por motivos de segurança, você só pode usar seu domínio atual aqui.', 'epicjungle-elementor' ),
            'condition'   => [ 'redirect_after_login' => 'yes' ],
            'default'     => [ 'url' => '#' ],
        ] );

        $this->add_control( 'redirect_after_logout', [
            'label'     => esc_html__( 'Redirecionar após sair da conta', 'epicjungle-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => '',
            'label_off' => esc_html__( 'Desligado', 'epicjungle-elementor' ),
            'label_on'  => esc_html__( 'Ligado', 'epicjungle-elementor' ),
        ] );

        $this->add_control( 'redirect_logout_url', [
            'type'        => Controls_Manager::URL,
            'show_label'  => false,
            'options'     => false,
            'separator'   => false,
            'placeholder' => esc_html__( 'https://seu-link.com.br', 'epicjungle-elementor' ),
            'description' => esc_html__( 'Obs.: Por motivos de segurança, você só pode usar seu domínio atual aqui.', 'epicjungle-elementor' ),
            'condition'   => [ 'redirect_after_logout' => 'yes' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings          = $this->get_settings(); 
        $current_url       = remove_query_arg( 'fake_arg' );
        $logout_redirect   = $current_url;
        $show_title        = $settings['show_form_title'];
        $show_description  = $settings['show_form_description'];
        $title_tag         = $settings['title_tag'];
        $display           = $settings['display'];
        $unique_id         = uniqid();
        $login_form_id     = 'signin-view' . $unique_id;
        $register_form_id  = 'signup-view-' . $unique_id;
        $lost_pwd_form_id  = 'lost-password-' . $unique_id;

        /**
         * Add Form IDs to settings data
         */
        $settings['login_form_id']    = $login_form_id;
        $settings['register_form_id'] = $register_form_id;
        $settings['lost_pwd_form_id'] = $lost_pwd_form_id;

        
        if ( 'yes' === $settings['redirect_after_logout'] && ! empty( $settings['redirect_logout_url']['url'] ) ) {
            $logout_redirect = $settings['redirect_logout_url']['url'];
        }

        if ( is_user_logged_in() && ! Plugin::$instance->editor->is_edit_mode() ) {
            $current_user = wp_get_current_user();

            echo '<div class="elementor-login elementor-login__logged-in-message sigin-container py-5 py-md-7" style="flex: 1 0 auto;">' .
                sprintf( __( 'Você está conectado como %1$s (<a href="%2$s">Sair</a>)', 'epicjungle-elementor' ), $current_user->display_name, wp_logout_url( $logout_redirect ) ) .
                '</div>';

            return;
        }


        $this->form_fields_render_attributes();

        if ( 'register' === $display ) {
            $this->render_register_form( $settings );
            return;
        } elseif ( 'login' === $display ) {
            $this->render_login_form( $settings );
            return;
        } elseif ( 'forgot' === $display ) {
            $this->render_password_reset_form( $settings );
            return;
        } 

        $show = ( get_option( 'users_can_register' ) && 'yes' === $settings['show_register'] );

        $column_classes='';

        if ( ! $show ) {
            $column_classes=' mx-auto';
        }
        ?>

        <div class="container py-5 py-md-7">
            <div class="row align-items-center pt-2">
                <div class="col-md-6 col-lg-5 mb-5 mb-md-0<?php echo esc_attr( $column_classes ); ?>">
                    <div class="cs-view show" id="<?php echo esc_attr( $login_form_id ); ?>">
                        <div class="bg-secondary px-4 py-5 p-sm-5 rounded-lg">
                            <?php $this->render_login_form( $settings ); ?>
                        </div>
                    </div>

                    <div class="cs-view" id="<?php echo esc_attr( $lost_pwd_form_id ); ?>">
                        <?php $this->render_password_reset_form( $settings ); ?>
                    </div>
                </div>
                        
                <?php if ( get_option( 'users_can_register' ) ): ?>
                    <div class="col-md-6 offset-lg-1 style-3">
                        <?php $this->render_register_form( $settings ); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div><?php

       
    }

    private function render_form_header( $title, $desc, $settings ) {
        $show_title = ( 'yes' === $settings['show_form_title'] );
        $show_desc  = ( 'yes' === $settings['show_form_description'] );
        $title_tag  = $settings['title_tag'];

        $this->add_render_attribute( 'form_title', 'class', 'form-header__title' );

        if ( ! empty( $settings['title_css'] ) ) {
            $this->add_render_attribute( 'form_title', 'class', $settings['title_css'] );
        }

        $this->add_render_attribute( 'form_desc', 'class', 'form-header__desc' );

        if ( ! empty( $settings['description_css'] ) ) {
            $this->add_render_attribute( 'form_desc', 'class', $settings['description_css'] );
        }

        ?><?php if (  $show_title && ! empty( $title ) ): ?>
            <<?php echo $title_tag . ' ' . $this->get_render_attribute_string( 'form_title' ); ?>><?php echo esc_html( $title ); ?></<?php echo $title_tag; ?>>
        <?php endif; ?>

        <?php if (  $show_desc && ! empty( $desc ) ): ?>
            <p <?php echo $this->get_render_attribute_string( 'form_desc' ); ?>><?php echo esc_html( $desc ); ?></p>
        <?php endif;
    }

    private function render_label( $render_key, $settings, $label_key = '' ) {
        
        $show_label = ( 'yes' === $settings['show_labels'] );

        if ( ! $show_label ) {
            $this->add_render_attribute( $render_key, 'class', 'sr-only' );
        }

        if ( empty( $label_key ) ) {
            $label_key = $render_key;
        }

        ?><label <?php echo $this->get_render_attribute_string( $render_key );?>>
            <?php print( $settings[ $label_key ] ); ?>
        </label><?php
    }

    private function render_register_label( $render_key, $settings, $label_key = '' ) {
        
        $show_label = ( 'yes' === $settings['show_register_labels'] );

        if ( ! $show_label ) {
            $this->add_render_attribute( $render_key, 'class', 'sr-only' );
        }

        if ( empty( $label_key ) ) {
            $label_key = $render_key;
        }

        ?><label <?php echo $this->get_render_attribute_string( $render_key );?>>
            <?php print( $settings[ $label_key ] ); ?>
        </label><?php
    }

    private function render_lost_password_form_link( $settings ) {
        $show      = ( 'yes' === $settings['show_lost_password'] );
        $form_id   = $settings['lost_pwd_form_id'];
        $link_text = $settings['password_reset_text'];

        if ( ! $show ) {
            return;
        }

        $this->add_render_attribute( 'lost_password_form_link', [
            'id'    => 'forgot-password-tab',
            'class' => [ 'elementor-lost-password', 'nav-link-style font-size-ms' ]
        ] );

        if ( 'all' === $settings['display'] ) {
            $this->add_render_attribute( 'lost_password_form_link', 'data-view', '#' . $form_id );
            $this->add_render_attribute( 'lost_password_form_link', 'href', '#' );
            $this->add_render_attribute( 'lost_password_form_link', 'class', 'login-signup-view-switcher' );
        } else {
            $this->add_link_attributes( 'lost_password_form_link', $settings['password_reset_link'] );
        }

        printf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'lost_password_form_link' ), $link_text );
    }

    private function render_register_form_link( $settings ) {
        $show       = ( get_option( 'users_can_register' ) && 'yes' === $settings['show_register'] );
        $form_id    = $settings['register_form_id'];
        $link_intro = $settings['register_link_intro'];
        $link_text  = $settings['register_link_text'];

        if ( ! $show ) {
            return;
        }

        $this->add_render_attribute( 'register_form_link', [ 
            'class' => [ 'd-inline-block', 'login' ]
        ] );

        if ( 'all' === $settings['display'] ) {
            $this->add_render_attribute( 'register_form_link', 'data-view', '#' . $form_id );
            $this->add_render_attribute( 'register_form_link', 'href', '#' );
            $this->add_render_attribute( 'register_form_link', 'class', 'font-weight-medium' );
        } else {
            $this->add_link_attributes( 'register_form_link', $settings['register_link'] );
        }

        $link_html = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'register_form_link' ), $link_text );
        
        ?><p class="font-size-sm pt-3 mb-0 form__footer">
            <?php printf( '%s %s', $link_intro, $link_html ); ?>
        </p><?php
    }

    private function render_login_form_link( $settings ) {
        $show       = ( 'yes' === $settings['show_login'] );
        $form_id    = $settings['login_form_id'];
        $link_intro = $settings['login_link_intro'];
        $link_text  = $settings['login_link_text'];

        if ( ! $show ) {
            return;
        }

        $this->add_render_attribute( 'login_form_link', [
            'class'         => [ 'login' ]
        ] );

        if ( 'all' === $settings['display'] ) {
            $this->add_render_attribute( 'login_form_link', 'data-view', '#' . $form_id );
            $this->add_render_attribute( 'login_form_link', 'href', '#' );
            $this->add_render_attribute( 'login_form_link', 'class', 'font-weight-medium' );
        } else {
            $this->add_link_attributes( 'login_form_link', $settings['login_link'] );
        }

        $link_html = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'login_form_link' ), $link_text );

        ?><p class="font-size-sm pt-3 mb-0 form__footer">
            <?php printf( '%s %s', $link_intro, $link_html ); ?>
        </p><?php
    }

    private function render_rp_login_form_link( $settings ) {
        $show       = ( 'yes' === $settings['rp_show_login'] );
        $form_id    = $settings['login_form_id'];
        $link_intro = $settings['rp_login_link_intro'];
        $link_text  = $settings['rp_login_link_text'];

        if ( ! $show ) {
            return;
        }

        $this->add_render_attribute( 'rp_login_form_link', [
            'class'         => [ 'login' ],
            'id'            => 'signin-view'
        ] );

        if ( 'all' === $settings['display'] ) {
            $this->add_render_attribute( 'rp_login_form_link', 'data-view', '#' . $form_id );
            $this->add_render_attribute( 'rp_login_form_link', 'href', '#' );
            $this->add_render_attribute( 'rp_login_form_link', 'class', 'login-signup-view-switcher' );
        } else {
            $this->add_link_attributes( 'rp_login_form_link', $settings['rp_login_link'] );
        }

        $link_html = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'rp_login_form_link' ), $link_text );

        ?><p class="font-size-sm pt-3 mb-0 form__footer">
            <?php printf( '%s %s.', $link_intro, $link_html ); ?>
        </p><?php
    }

    private function render_login_form( $settings ) {

        $current_url = remove_query_arg( 'fake_arg' );

        if ( 'yes' === $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) {
            $redirect_url = $settings['redirect_url']['url'];   
        } else {
            $redirect_url = $current_url;
        }

        $this->render_form_header( $settings['login_title'], $settings['login_description'], $settings );

        ?>
        <form class="elementor-form ej-login-form login" method="post">
            <?php
            if ( isset( $_POST['login'] ) ) {
                    // show any error messages after form submission
                    ?><div class="mb-3"><?php epicjungle_show_error_messages(); ?></div><?php
                }
            ?>

            <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_url ); ?>">
            
            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                
                    
                <div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
                    <?php $this->render_label( 'user_label', $settings ); ?>
                    <div class="input-group">
                        <div class="input-group-prepend-overlay">
                            <span class="input-group-text"><i class="fe-mail"></i></span>
                        </div>
                        <input <?php echo $this->get_render_attribute_string( 'user_input' );?>>
                    </div>
                </div>

                
                <div <?php echo $this->get_render_attribute_string( 'password-field-group' ); ?>>
                    <?php $this->render_label( 'password_label', $settings ); ?>
                    <div class="input-group">
                        <div class="input-group-prepend-overlay">
                            <span class="input-group-text"><i class="fe-lock"></i></span>
                        </div>
                        <input <?php echo $this->get_render_attribute_string( 'password_input' ); ?>>
                        <label class="cs-password-toggle-btn">
                            <input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__('Mostrar senha', 'epicjungle-elementor');?></span>
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center form-group">
                    <?php if ( 'yes' === $settings['show_remember_me'] ) : ?>
                        <div class="custom-control custom-checkbox elementor-field-type-checkbox elementor-field-group  elementor-col-100 elementor-remember-me">
                            <input class="custom-control-input" type="checkbox" id="keep-signed-2">
                            <label class="custom-control-label p-0" for="keep-signed-2"><?php echo esc_html__( 'Mantenha-me conectado', 'epicjungle-elementor' ); ?></label>
                        </div>

                    <?php endif; ?>
                    <?php $this->render_lost_password_form_link( $settings ); ?>
                </div>


                <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                    <input type="hidden" name="epicjungle_login_nonce" value="<?php echo wp_create_nonce('epicjungle-login-nonce'); ?>"/>
                    <input type="hidden" name="epicjungle_login_check" value="1"/>

                    <button type="submit" name="login" <?php echo $this->get_render_attribute_string( 'button_text' ); ?>><?php echo $settings['button_text']; ?></button>
                <?php endif; ?>
                

                
            </div>
                
        </form><?php
    }

    private function render_register_form( $settings ) {

        $can_register = get_option( 'users_can_register' );

        if ( ! $can_register ) {
            return;
        }
        
        $this->render_form_header( $settings['register_title'], $settings['register_description'], $settings );
        
        ?>
        <form class="ej-register elementor-form register" method="post">
            
            <?php
                if ( isset( $_POST['register'] ) ) {
                    ?><div class="mb-3"><?php epicjungle_show_error_messages(); ?></div><?php
                }
            ?>

            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
                    <?php $this->render_register_label( 'email_register_label', $settings, 'register_email_label' ); ?>
                    <input <?php echo $this->get_render_attribute_string( 'email_register_input' );?>>
                </div>


                <?php if ( apply_filters( 'epicjungle_register_password_enabled', true ) ) : ?>

                
                <div <?php echo $this->get_render_attribute_string( 'password-field-group' ); ?>>
                    <?php $this->render_register_label( 'register_password_label', $settings, 'register_password_label' ); ?>
                     <div class="cs-password-toggle">
                        
                        <input <?php echo $this->get_render_attribute_string( 'register_password_input' ); ?>>
                        <label class="cs-password-toggle-btn">
                            <input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__('Mostrar senha', 'epicjungle-elementor');?></span>
                        </label>
                    </div>
                </div>

                <div <?php echo $this->get_render_attribute_string( 'password-field-group' ); ?>>
                    <?php $this->render_register_label( 'register_password_label', $settings, 'register_password_label' ); ?>
                     <div class="cs-password-toggle">
                        
                        <input <?php echo $this->get_render_attribute_string( 'register_confirm_password_input' ); ?>>
                        <label class="cs-password-toggle-btn">
                            <input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__('Mostrar senha', 'epicjungle-elementor');?></span>
                        </label>
                    </div>
                </div>

                <?php else : ?>
                    <p><?php echo esc_html__( 'Uma senha será enviada para o seu endereço de e-mail.', 'epicjungle-elementor' ); ?></p>
                <?php endif; ?>

                
                <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                    <input type="hidden" name="epicjungle_register_nonce" value="<?php echo wp_create_nonce('epicjungle-register-nonce'); ?>"/>
                    <input type="hidden" name="epicjungle_register_check" value="1"/>
                    <button type="submit" <?php echo $this->get_render_attribute_string( 'register_button_text' ); ?> name="register"><?php echo $settings['register_button_text']; ?></button>
                <?php endif; ?>
                
                
            </div>

            
        </form><?php
    }

    private function render_change_password_steps( $settings ) { ?>
        <?php if ( ! empty( $settings['steps'] ) && 'yes' === $settings['show_change_password_steps'] ) : ?>
            <ul class="list-unstyled font-size-sm pb-1 mb-4">
                <?php foreach ( $settings['steps'] as $index => $item ) :
                    $counter = $index+1;

                    $repeater_setting_key = $this->get_repeater_setting_key( 'item_text', 'steps', $index );

                    $this->add_render_attribute( $repeater_setting_key, 'class', [
                        'epicjungle-elementor-steps', ''
                    ] );   
                    $this->add_inline_editing_attributes( $repeater_setting_key );
                    ?>
                    <li class="ej-steps elementor-repeater-item-<?php echo $item['_id']; ?> d-flex">
                        <?php if ( ! empty( $item['item_text'] ) ) : ?>
                            <span class="text-primary font-weight-semibold mr-1"><?php echo esc_attr( $counter ); ?>.</span>
                            <span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['item_text']; ?></span>
                                
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>

            </ul>
        <?php endif; 
    }

    private function render_password_reset_form( $settings ) {
        
        $this->render_form_header( $settings['password_title'], $settings['password_description'], $settings ); 

        $this->render_change_password_steps( $settings ); ?>

        <div class="bg-secondary rounded-lg px-3 py-4 p-sm-4">
            <form class="ej-forget-password elementor-form forget-password p-2" name="lostpasswordform" method="post">

                <?php if ( isset( $_POST['recoverPassword'] ) ) { ?>
                    <div class="mb-3">
                        <?php epicjungle_show_error_messages(); ?>
                        <?php epicjungle_show_success_messages(); ?>
                    </div>
                <?php } ?>
               
                <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
                    <div <?php echo $this->get_render_attribute_string( 'field-group' ); ?>>
                        <?php $this->render_label( 'user_forget_password_label', $settings, 'user_label' ); ?>
                        <input <?php echo $this->get_render_attribute_string( 'user_forget_password_input' );?>>
                    </div>

                    
                    <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                        <input type="hidden" name="epicjungle_lost_password_nonce" value="<?php echo wp_create_nonce('epicjungle-lost-password-nonce'); ?>"/>
                        <input type="hidden" name="epicjungle_lost_password_check" value="1"/>
                        <?php  wp_nonce_field( 'ajax-lost-password-nonce', 'lost-password-security' );  ?>
                        <button type="submit" name="recoverPassword" <?php echo $this->get_render_attribute_string( 'lost_button_text' ); ?>><?php echo $settings['reset_pasword_button_text']; ?></button>
                    <?php endif; ?>
                    
                </div>
                
                <?php $this->render_rp_login_form_link( $settings ); ?>
                
            </form></div><?php
    }

    
    public function render_plain_content() {}
}