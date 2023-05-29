<?php
namespace EpicJungleElementor\Modules\Login\Skins;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use EpicJungleElementor\Core\Utils as EJ_Utils;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;


class Skin_Style_1 extends Skin_Base {

    public function __construct( Widget_Base $parent ) {
        $this->parent = $parent;

        add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
    }


	public function get_id() {
        return 'login-style-1';
    }

    public function get_title() {
        return esc_html__( 'Entrar - Imagem', 'epicjungle-elementor' );
    }


    private function form_fields_render_attributes() {
        $widget    = $this->parent;
        $settings  = $widget->get_settings_for_display(); 
        $unique_id = uniqid();

        $widget->add_render_attribute( 'button_text', 'class', [
            'elementor-login__button',
            'btn',
            'btn-block',
            'btn-primary'
        ] );

    
        $widget->add_render_attribute( 'register_button_text', 'class', [
            'ej-register__button',
            'btn',
            'btn-block',
            'btn-primary'
        ] );

        $widget->add_render_attribute( 'lost_button_text', 'class', [
            'ej-lost__button',
            'btn',
            'btn-primary'
        ] );

        
        if ( ! empty( $settings['button_type'] ) ) {
            $widget->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_type'] );
        }

        if ( ! empty( $settings['button_radius'] ) ) {
            if ( $settings['button_radius'] == 'rounded-0' ) {
                $widget->add_render_attribute( 'button_text', 'class', $settings['button_radius'] );
            } else if ( $settings['button_radius'] == 'card-btn' ) {
                $widget->add_render_attribute( 'button_text', 'class', $settings['button_radius'] );
            } else {
                $widget->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_radius'] );
            }
        }

        if ( ! empty( $settings['button_size'] ) ) {
            $widget->add_render_attribute( 'button_text', 'class', 'btn-' . $settings['button_size'] );
        }

        if ( ! empty( $settings[ 'button_classes' ] ) ) {
            $widget->add_render_attribute( 'button_text', 'class', $settings['button_classes'] );
        }

        $widget->add_render_attribute(
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
                    //'class' => 'sr-only'
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
                    //'class' => 'sr-only'
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
                    //'class' => 'sr-only'
                    
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
                    //'class' => 'sr-only'
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
                    //'class' => 'sr-only'
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
                    //'class' => 'sr-only'
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
                    //'class' => 'sr-only'
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
            $widget->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
        }

        if ( ! $settings['show_register_labels'] ) {
            $widget->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
        }

        $widget->add_render_attribute( 'field-group', 'class', 'elementor-field-required' )
             ->add_render_attribute( 'input', 'required', true )
             ->add_render_attribute( 'input', 'aria-required', 'true' );
    }

    public function render() {
        $widget            = $this->parent;
        $settings          = $widget->get_settings_for_display(); 
        $display           = $settings['display'];
        $unique_id         = uniqid();
        $login_form_id     = 'signin-view-' . $unique_id;
        $register_form_id  = 'signup-view-' . $unique_id;
        $lost_pwd_form_id  = 'lost-password-' . $unique_id;

        
        $settings['login_form_id']    = $login_form_id;
        $settings['register_form_id'] = $register_form_id;
        $settings['lost_pwd_form_id'] = $lost_pwd_form_id;

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

        if ( $settings['show_background_image'] === 'yes' && ! empty ( $settings['bg_image']['url'] ) ) {
            $column_classes= 'col-lg-4 col-md-6 offset-lg-1';
        } else {

            $column_classes='col-md-6 col-lg-5 mb-5 mb-md-0 mx-auto';
        }
        ?>
        <div class="d-none d-md-block position-absolute w-50 h-100 bg-size-cover min-vh-100" <?php if ( $settings['show_background_image'] === 'yes' && ! empty ( $settings['bg_image']['url'] ) ):?> style="top:0; right:0;background-image: url(<?php echo esc_url( $settings["bg_image"]["url"] )?> );"<?php endif; ?>></div>
        
        <section class="container d-flex align-items-center pt-7 pb-3 pb-md-4" style="flex: 1 0 auto;">
            <div class="w-100 pt-3">
                <div class="row">
                    <div class="<?php echo esc_attr($column_classes); ?>">
                        <div class="cs-view show" id="<?php echo esc_attr( $login_form_id ); ?>">
                            <?php if ( $settings['show_background_image'] !== 'yes' && empty ( $settings['bg_image']['url'] ) ) : ?>
                                <div class="bg-secondary px-4 py-5 p-sm-5 rounded-lg">
                            <?php endif; ?>

                            <?php $this->render_login_form( $settings ); ?>

                            <?php if ( $settings['show_background_image'] !== 'yes' && empty ( $settings['bg_image']['url'] ) ) : ?>
                                </div>
                            <?php endif; ?>
                        </div>
                         
                    
                        <div class="cs-view" id="<?php echo esc_attr( $lost_pwd_form_id ); ?>">
                            <?php $this->render_password_reset_form( $settings ); ?>
                        </div>

                        <?php if ( get_option( 'users_can_register' ) ): ?>
                            <div class="cs-view" id="<?php echo esc_attr( $register_form_id ); ?>">
                                <?php if ( $settings['show_background_image'] !== 'yes' && empty ( $settings['bg_image']['url'] ) ) : ?>
                                    <div class="bg-secondary px-4 py-5 p-sm-5 rounded-lg">
                                <?php endif; ?>

                                <?php $this->render_register_form( $settings ); ?>

                                 <?php if ( $settings['show_background_image'] !== 'yes' && empty ( $settings['bg_image']['url'] ) ) : ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                            
                    </div>
                </div>
            </div>
        </section><?php
    }

    public function render_form_header( $title, $desc, $settings ) {
        $widget   = $this->parent;

        $show_title = ( 'yes' === $settings['show_form_title'] );
        $show_desc  = ( 'yes' === $settings['show_form_description'] );
        $title_tag  = $settings['title_tag'];

        $widget->add_render_attribute( 'form_title', 'class', 'form-header__title' );

        if ( ! empty( $settings['title_css'] ) ) {
            $widget->add_render_attribute( 'form_title', 'class', $settings['title_css'] );
        }

        $widget->add_render_attribute( 'form_desc', 'class', 'form-header__desc' );

        if ( ! empty( $settings['description_css'] ) ) {
            $widget->add_render_attribute( 'form_desc', 'class', $settings['description_css'] );
        }

        ?><?php if (  $show_title && ! empty( $title ) ): ?>
            <<?php echo $title_tag . ' ' . $widget->get_render_attribute_string( 'form_title' ); ?>><?php echo esc_html( $title ); ?></<?php echo $title_tag; ?>>
        <?php endif; ?>

        <?php if (  $show_desc && ! empty( $desc ) ): ?>
            <p <?php echo $widget->get_render_attribute_string( 'form_desc' ); ?>><?php echo esc_html( $desc ); ?></p>
        <?php endif;
    }

    public function render_label( $render_key, $settings, $label_key = '' ) {
        $widget   = $this->parent;

        $show_label = ( 'yes' === $settings['show_labels'] );

        if ( ! $show_label ) {
            $widget->add_render_attribute( $render_key, 'class', 'sr-only' );
        }

        if ( empty( $label_key ) ) {
            $label_key = $render_key;
        }

        ?><label <?php echo $widget->get_render_attribute_string( $render_key );?>>
            <?php print( $settings[ $label_key ] ); ?>
        </label><?php
    }

    private function render_register_label( $render_key, $settings, $label_key = '' ) {
        $widget   = $this->parent;

        $show_label = ( 'yes' === $settings['show_register_labels'] );

        if ( ! $show_label ) {
            $widget->add_render_attribute( $render_key, 'class', 'sr-only' );
        }

        if ( empty( $label_key ) ) {
            $label_key = $render_key;
        }

        ?><label <?php echo $widget->get_render_attribute_string( $render_key );?>>
            <?php print( $settings[ $label_key ] ); ?>
        </label><?php
    }

    public function render_lost_password_form_link( $settings ) {
        $widget   = $this->parent;
        $unique_id         = uniqid();

        $show      = ( 'yes' === $settings['show_lost_password'] );
        $form_id    = $settings['lost_pwd_form_id'];
        $link_text = $settings['password_reset_text'];


        if ( ! $show ) {
            return;
        }

        $widget->add_render_attribute( 'lost_password_form_link', [
            'id'    => 'forgot-password-tab',
            'class' => [ 'elementor-lost-password', 'nav-link-style font-size-ms' ]
        ] );

        if ( 'all' === $settings['display'] ) {
            $widget->add_render_attribute( 'lost_password_form_link', 'data-view', '#' . $form_id );
            $widget->add_render_attribute( 'lost_password_form_link', 'href', '#' );
            $widget->add_render_attribute( 'lost_password_form_link', 'class', 'login-signup-view-switcher' );
        } else {
            $widget->add_link_attributes( 'lost_password_form_link', $settings['password_reset_link'] );
        }

        printf( '<a %1$s>%2$s</a>', $widget->get_render_attribute_string( 'lost_password_form_link' ), $link_text );
    }

    public function render_register_form_link( $settings ) {
        $widget   = $this->parent;
        
        $show       = ( get_option( 'users_can_register' ) && 'yes' === $settings['show_register'] );


        $form_id    = $settings['register_form_id']; 
        $link_intro = $settings['register_link_intro'];
        $link_text  = $settings['register_link_text'];


        if ( ! $show ) {
            return;
        }

        $widget->add_render_attribute( 'register_form_link', [ 
            'class' => [ 'd-inline-block', 'login' ]
        ] );

        if ( 'all' === $settings['display'] ) {
            $widget->add_render_attribute( 'register_form_link', 'data-view', '#' . $form_id  );
            $widget->add_render_attribute( 'register_form_link', 'href', '#' );
            $widget->add_render_attribute( 'register_form_link', 'class', 'font-weight-medium' );
        } else {
            $widget->add_link_attributes( 'register_form_link', $settings['register_link'] );
        }

        $link_html = sprintf( '<a %1$s>%2$s</a>', $widget->get_render_attribute_string( 'register_form_link' ), $link_text );
        
        ?><p class="font-size-sm pt-3 mb-0 form__footer">
            <?php printf( '%s %s', $link_intro, $link_html ); ?>
        </p><?php
    }

    public function render_login_form_link( $settings ) {
        $widget   = $this->parent;

        $show       = ( 'yes' === $settings['show_login'] );
        $form_id    = $settings['login_form_id'];
        $link_intro = $settings['login_link_intro'];
        $link_text  = $settings['login_link_text'];

        if ( ! $show ) {
            return;
        }

        $widget->add_render_attribute( 'login_form_link', [
            'class'         => [ 'login' ]
        ] );

        if ( 'all' === $settings['display'] ) {
            $widget->add_render_attribute( 'login_form_link', 'data-view', '#' . $form_id );
            $widget->add_render_attribute( 'login_form_link', 'href', '#' );
            $widget->add_render_attribute( 'login_form_link', 'class', 'font-weight-medium' );
        } else {
            $widget->add_link_attributes( 'login_form_link', $settings['login_link'] );
        }

        $link_html = sprintf( '<a %1$s>%2$s</a>', $widget->get_render_attribute_string( 'login_form_link' ), $link_text );

        ?><p class="font-size-sm pt-3 mb-0 form__footer">
            <?php printf( '%s %s', $link_intro, $link_html ); ?>
        </p><?php
    }

    public function render_rp_login_form_link( $settings ) {
        $widget   = $this->parent;

        $show       = ( 'yes' === $settings['rp_show_login'] );
        $form_id    = $settings['login_form_id'];
        $link_intro = $settings['rp_login_link_intro'];
        $link_text  = $settings['rp_login_link_text'];

        if ( ! $show ) {
            return;
        }

        $widget->add_render_attribute( 'rp_login_form_link', [
            'class'         => [ 'login' ],
            'id'            => 'signin-view'
        ] );

        if ( 'all' === $settings['display'] ) {
            $widget->add_render_attribute( 'rp_login_form_link', 'data-view', '#' . $form_id );
            $widget->add_render_attribute( 'rp_login_form_link', 'href', '#' );
            $widget->add_render_attribute( 'rp_login_form_link', 'class', 'login-signup-view-switcher' );
        } else {
            $widget->add_link_attributes( 'rp_login_form_link', $settings['rp_login_link'] );
        }

        $link_html = sprintf( '<a %1$s>%2$s</a>', $widget->get_render_attribute_string( 'rp_login_form_link' ), $link_text );

        ?><p class="font-size-sm pt-3 mb-0 form__footer">
            <?php printf( '%s %s.', $link_intro, $link_html ); ?>
        </p><?php
    }

    public function render_login_form( $settings ) {
        $widget   = $this->parent; 

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
            
            <div <?php echo $widget->get_render_attribute_string( 'wrapper' ); ?>>
                
                    
                <div <?php echo $widget->get_render_attribute_string( 'field-group' ); ?>>
                    <?php $this->render_label( 'user_label', $settings ); ?>
                    <div class="input-group">
                        <div class="input-group-prepend-overlay">
                            <span class="input-group-text"><i class="fe-mail"></i></span>
                        </div>
                        <input <?php echo $widget->get_render_attribute_string( 'user_input' );?>>
                    </div>
                </div>

                
                <div <?php echo $widget->get_render_attribute_string( 'password-field-group' ); ?>>
                    <?php $this->render_label( 'password_label', $settings ); ?>
                    <div class="input-group">
                        <div class="input-group-prepend-overlay">
                            <span class="input-group-text"><i class="fe-lock"></i></span>
                        </div>
                        <input <?php echo $widget->get_render_attribute_string( 'password_input' ); ?>>
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

                    <button type="submit" name="login" <?php echo $widget->get_render_attribute_string( 'button_text' ); ?>><?php echo $settings['button_text']; ?></button>
                <?php endif; ?>
                

                <?php $this->render_register_form_link( $settings ); ?>
            </div>
                
        </form><?php
    }

    public function render_register_form( $settings ) {
        $widget   = $this->parent;

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

            <div <?php echo $widget->get_render_attribute_string( 'wrapper' ); ?>>
                <div <?php echo $widget->get_render_attribute_string( 'field-group' ); ?>>
                    <?php $this->render_register_label( 'email_register_label', $settings, 'register_email_label' ); ?>
                    <input <?php echo $widget->get_render_attribute_string( 'email_register_input' );?>>
                </div>


                <?php if ( apply_filters( 'epicjungle_register_password_enabled', true ) ) : ?>

                
                <div <?php echo $widget->get_render_attribute_string( 'password-field-group' ); ?>>
                    <?php $this->render_register_label( 'register_password_label', $settings, 'register_password_label' ); ?>
                     <div class="cs-password-toggle form-group">
                        
                        <input <?php echo $widget->get_render_attribute_string( 'register_password_input' ); ?>>
                        <label class="cs-password-toggle-btn">
                            <input class="custom-control-input" type="checkbox"><i class="fe-eye cs-password-toggle-indicator"></i><span class="sr-only"><?php echo esc_html__('Mostrar senha', 'epicjungle-elementor');?></span>
                        </label>
                    </div>
                </div>

                <div <?php echo $widget->get_render_attribute_string( 'password-field-group' ); ?>>
                    <?php $this->render_register_label( 'register_password_label', $settings, 'register_password_label' ); ?>
                     <div class="cs-password-toggle form-group">
                        
                        <input <?php echo $widget->get_render_attribute_string( 'register_confirm_password_input' ); ?>>
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
                    <button type="submit" <?php echo $widget->get_render_attribute_string( 'button_text' ); ?> name="register"><?php echo $settings['register_button_text']; ?></button>
                <?php endif; ?>
                
                
            </div>

            <?php $this->render_login_form_link( $settings ); ?>
                         
        </form><?php
    }

    public function render_change_password_steps( $settings ) { ?>
        <?php if ( ! empty( $settings['steps'] ) && 'yes' === $settings['show_change_password_steps'] ) : ?>
            <ul class="list-unstyled font-size-sm pb-1 mb-4">
                <?php foreach ( $settings['steps'] as $index => $item ) :
                    $counter = $index+1;

                    $repeater_setting_key = $this->parent->get_repeater_setting_key( 'item_text', 'steps', $index );

                    $this->parent->add_render_attribute( $repeater_setting_key, 'class', [
                        'epicjungle-elementor-steps', ''
                    ] );   
                    $this->parent->add_inline_editing_attributes( $repeater_setting_key );
                    ?>
                    <li class="ej-steps elementor-repeater-item-<?php echo $item['_id']; ?> d-flex">
                        <?php if ( ! empty( $item['item_text'] ) ) : ?>
                            <span class="text-primary font-weight-semibold mr-1"><?php echo esc_attr( $counter ); ?>.</span>
                            <span <?php echo $this->parent->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['item_text']; ?></span>
                                
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>

            </ul>
        <?php endif; 
    }

    public function render_password_reset_form( $settings ) {
        $widget   = $this->parent;

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
               
                <div <?php echo $widget->get_render_attribute_string( 'wrapper' ); ?>>
                    <div <?php echo $widget->get_render_attribute_string( 'field-group' ); ?>>
                        <?php $this->render_label( 'user_forget_password_label', $settings, 'user_label' ); ?>
                        <input <?php echo $widget->get_render_attribute_string( 'user_forget_password_input' );?>>
                    </div>

                    
                    <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                        <input type="hidden" name="epicjungle_lost_password_nonce" value="<?php echo wp_create_nonce('epicjungle-lost-password-nonce'); ?>"/>
                        <input type="hidden" name="epicjungle_lost_password_check" value="1"/>
                        <?php  wp_nonce_field( 'ajax-lost-password-nonce', 'lost-password-security' );  ?>
                        <button type="submit" name="recoverPassword" <?php echo $widget->get_render_attribute_string( 'lost_button_text' ); ?>><?php echo $settings['reset_pasword_button_text']; ?></button>
                    <?php endif; ?>
                    
                </div>
                
                <?php $this->render_rp_login_form_link( $settings ); ?>
                
            </form>
        </div><?php
    }

    public function skin_print_template( $content, $widget ) {
        if( 'ej-login' == $widget->get_name() ) {
            return '';
        }
        return $content;
    }

	
}