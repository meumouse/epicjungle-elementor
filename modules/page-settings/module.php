<?php
namespace EpicJungleElementor\Modules\PageSettings;

use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use Elementor\Core\Base\Module as BaseModule;
use Elementor\Core\DocumentTypes\PageBase;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Elementor page templates module.
 *
 * Elementor page templates module handler class is responsible for registering
 * and managing Elementor page templates modules.
 *
 * @since 1.0.0
 */
class Module extends BaseModule {

    protected $post_id = 0;
    protected $ej_page_options = [];
    protected $static_contents = [];

    public function __construct() {
        $this->ej_page_options = $this->ej_page_options();
        $this->static_contents = function_exists( 'epicjungle_static_content_options' ) ? epicjungle_static_content_options() : [];
        add_action( 'elementor/documents/register_controls', [ $this, 'action_register_template_control' ] );
        add_action( 'elementor/element/wp-post/section_page_style/before_section_end', [ $this, 'add_body_style_controls' ] );
        add_filter( 'update_post_metadata', [ $this, 'filter_update_meta' ], 10, 5 );
    }

    public function get_name() {
        return 'override-page-settings';
    }

    public function add_body_style_controls( $document ) {
        
        $document->add_control( 'enable_overflow', [
            'label'       => esc_html__( 'Ativar Overflow?', 'epicjungle-elementor' ),
            'type'        => Controls_Manager::SWITCHER,
            'selectors'   => [
                'body' => 'overflow-x:visible !important;'
            ]
        ] );
    }

    public function get_ej_page_settings_names() {
        return [
            // General
            'general_body_classes',

            // Header
            'header_enable_custom_header',
            'header_navbar_variant',
            'header_enable_topbar',
            'header_topbar_skin',
            'header_enable_transparent',
            'header_enable_transparent_logo',
            'header_transparent_text_color',
            'header_navbar_skin',
            'header_enable_boxshadow',
            'header_enable_button_variant_boxshadow',
            'header_enable_slanted_bg',
            'header_enable_sticky',
            'header_enable_search',
            'header_enable_account',
            'header_enable_cart',
            'header_enable_header_social_menu',
            'header_enable_action_button',

            // Footer
            'footer_enable_custom_footer',
            'footer_footer_variant',
            'footer_footer_skin',
            'footer_contact_title',
            'footer_copyright',
            'footer_footer_jumbotron',
            'footer_footer_payment_methods',
            'footer_enable_newsletter_form',
            'footer_epicjungle_newsletter_title',
            'footer_epicjungle_newsletter_desc',
            'footer_epicjungle_newsletter_form',
            'footer_epicjungle_custom_html',
            'footer_footer_static_widgets'
        ];
    }

    public function update_ej_page_option( $object_id, $special_settings ) {
        $_ej_page_options = $this->ej_page_options( $object_id );
        $ej_page_options = ! empty( $_ej_page_options ) ? $_ej_page_options : [] ;

        $general_option_key = 'general';
        $header_option_key = 'header';
        $footer_option_key = 'footer';
        $len_general_option_key = strlen( $general_option_key . '_' );
        $len_header_option_key = strlen( $header_option_key . '_' );
        $len_footer_option_key = strlen( $footer_option_key . '_' );

        foreach ( $special_settings as $key => $value ) {
            if( substr( $key, 0, $len_general_option_key ) === $general_option_key . '_' ) {
                if( ! isset( $ej_page_options[$general_option_key] ) ) {
                    $ej_page_options[$general_option_key] = [];
                }
                $ej_page_options[$general_option_key][substr($key, $len_general_option_key)] = $value;
            } elseif( substr( $key, 0, $len_header_option_key ) === $header_option_key . '_' ) {
                if( ! isset( $ej_page_options[$header_option_key] ) ) {
                    $ej_page_options[$header_option_key] = [];
                }
                $ej_page_options[$header_option_key][substr($key, $len_header_option_key)] = $value;
            } elseif( substr( $key, 0, $len_footer_option_key ) === $footer_option_key . '_' ) {
                if( ! isset( $ej_page_options[$footer_option_key] ) ) {
                    $ej_page_options[$footer_option_key] = [];
                }

                if( is_array( $value ) && isset( $value['id'] ) ) {
                    $ej_page_options[$footer_option_key][substr($key, $len_footer_option_key)] = $value['id'];
                } else {
                    $ej_page_options[$footer_option_key][substr($key, $len_footer_option_key)] = $value;
                }
            } else {
                $ej_page_options[$key] = $value;
            }
        }

        if( ! empty( $ej_page_options ) ) {
            $this->ej_page_options = $ej_page_options;
            update_metadata( 'post', $object_id, '_ej_page_options', $ej_page_options );
        }
    }

    public function get_ej_page_options( $option_name, $option_group='', $dafault='' ) {
        $ej_page_options = $this->ej_page_options();

        if( ! empty( $option_group ) && ! empty( $option_name ) ) {
            if( isset( $ej_page_options[$option_group] ) && isset( $ej_page_options[$option_group][$option_name] ) ) {
                return $ej_page_options[$option_group][$option_name];
            }
        } elseif( empty( $option_group ) && ! empty( $option_name ) ) {
            if( isset( $ej_page_options[$option_name] ) ) {
                return $ej_page_options[$option_name];
            }
        }
        return $dafault;
    }

    public function ej_page_options( $post_id=null ) {
        if( ! empty( $this->ej_page_options ) ) {
            return $this->ej_page_options;
        }

        if( ! $post_id ) {
            $post_id = $this->post_id;
        }

        $clean_meta_data = get_post_meta( $post_id, '_ej_page_options', true );
        $ej_page_options = maybe_unserialize( $clean_meta_data );

        if( empty( $ej_page_options ) ) {
            $ej_page_options = [];
        } elseif ( ! empty( $ej_page_options ) && ! is_array( $ej_page_options ) ) {
            $ej_page_options = [];
        }

        $this->ej_page_options = $ej_page_options;
        return $ej_page_options;
    }

    /**
     * Register template control.
     *
     * Adds custom controls to any given document.
     *
     * Fired by `update_post_metadata` action.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Document $document The document instance.
     */
    public function action_register_template_control( $document ) {
        $post_types = function_exists( 'epicjungle_option_enabled_post_types' ) ? epicjungle_option_enabled_post_types() : ['post', 'page'];
        if ( $document instanceof PageBase && is_a( $document->get_main_post(), 'WP_Post') && in_array( $document->get_main_post()->post_type, $post_types ) ) {
            $this->post_id = $document->get_main_post()->ID;
            $this->register_template_control( $document );
        }
    }

    /**
     * Register template control.
     *
     * Adds custom controls to any given document.
     *
     * @since 1.0.0
     * @access public
     *
     * @param Document $page   The document instance.
     * @param string   $option_group Optional.
     */
    public function register_template_control( $page ) {
        $this->add_general_controls( $page, 'general' );
        $this->add_header_controls( $page, 'header' );
        $this->add_footer_controls( $page, 'footer' );
    }

    public function add_general_controls( Document $page, $option_group='' ) {
        $page->start_injection( [
            'of' => 'post_status',
            'fallback' => [
                'of' => 'post_title',
            ],
        ] );

        $page->add_control(
            'general_body_classes', [
                'label'     => esc_html__( 'Classes CSS Body', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => $this->get_ej_page_options( 'body_classes', $option_group ),
            ]
        );

        $page->end_injection();
    }

    public function add_header_controls( Document $page, $option_group='' ) {
        $page->start_controls_section(
            'document_settings_header', [
                'label'     => esc_html__( 'Cabeçalhos', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $page->add_control(
            'header_enable_custom_header', [
                'label'     => esc_html__( 'Cabeçalho personalizado', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_custom_header', 'header' ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
            ]
        );

        $page->add_control(
            'header_navbar_variant', [
                'label'     => esc_html__( 'Variante da barra de navegação', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'solid'      => esc_html__( 'Sólido', 'epicjungle-elementor' ),
                    'dashboard'  => esc_html__( 'Painel', 'epicjungle-elementor' ),
                    'shop'       => esc_html__( 'Loja', 'epicjungle-elementor' ),
                    'button'     => esc_html__( 'Simples', 'epicjungle-elementor' ),
                    'social'     => esc_html__( 'Social', 'epicjungle-elementor' ),

                ],
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                ],
                'default'   => $this->get_ej_page_options( 'navbar_variant', $option_group, 'solid' ),
            ]
        );

        $page->add_control(
            'header_enable_topbar', [
                'label'     => esc_html__( 'Ativar barra superior', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_topbar', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => 'shop',
                ],
            ]
        );

        $page->add_control(
            'header_topbar_skin', [
                'label'     => esc_html__( 'Estilo da barra superior', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'light' => esc_html__( 'Claro', 'epicjungle-elementor'),
                    'dark'  => esc_html__( 'Escuro', 'epicjungle-elementor'),
                ],
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => 'shop',
                    'header_enable_topbar'          => 'yes',
                ],
                'default'   => $this->get_ej_page_options( 'topbar_skin', $option_group, 'dark' ),
            ]
        );

        $page->add_control(
            'header_enable_transparent', [
                'label'     => esc_html__( 'Ativar transparência', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_transparent', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => [ 'solid', 'button' ],
                ],
            ]
        );

        $page->add_control(
            'header_enable_transparent_logo', [
                'label'     => esc_html__( 'Ativar logotipo transparente', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_transparent', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => [ 'solid', 'button' ],
                    'header_enable_transparent'     => 'yes',
                ],
            ]
        );

        

        $page->add_control(
            'header_transparent_text_color', [
                'label'     => esc_html__( 'Cor do texto (Fundo transparente)', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'light' => esc_html__( 'Claro', 'epicjungle-elementor'),
                    'dark'  => esc_html__( 'Escuro', 'epicjungle-elementor'),
                ],
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => [ 'solid', 'button' ],
                    'header_enable_transparent'     => 'yes',
                ],
                'default'   => $this->get_ej_page_options( 'transparent_text_color', $option_group, 'dark' ),
            ]
        );

        $page->add_control(
            'header_navbar_skin', [
                'label'     => esc_html__( 'Estiloda barra de navegação', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'dark'         => esc_html__( 'Escuro', 'epicjungle-elementor' ),
                    'primary'      => esc_html__( 'Primário', 'epicjungle-elementor' ),
                    'secondary'    => esc_html__( 'Cinza', 'epicjungle-elementor' ),
                    'light'        => esc_html__( 'Claro', 'epicjungle-elementor' ),
                ],
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => [ 'solid', 'shop', 'social' ],
                    'header_enable_transparent!'    => 'yes',
                ],
                'default'   => $this->get_ej_page_options( 'navbar_skin', $option_group, 'light' ),
            ]
        );

        $page->add_control(
            'header_enable_boxshadow', [
                'label'     => esc_html__( 'Ativar sombra da caixa', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_boxshadow', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => [ 'solid', 'shop', 'social' ],
                    'header_enable_transparent!'    => 'yes',
                ],
            ]
        );


        $page->add_control(
            'header_enable_button_variant_boxshadow', [
                'label'     => esc_html__( 'Ativar sombra da caixa', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_button_variant_boxshadow', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => [ 'button' ],
                    'header_enable_transparent!'    => 'yes',
                ],
            ]
        );

        $page->add_control(
            'header_enable_sticky', [
                'label'     => esc_html__( 'Ativar fixo', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_sticky', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                ],
            ]
        );

        $page->add_control(
            'header_enable_search', [
                'label'     => esc_html__( 'Ativar pesquisa', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_search', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => [ 'shop', 'social' ],
                ],
            ]
        );

        $page->add_control(
            'header_enable_header_social_menu', [
                'label'     => esc_html__( 'Ativar links sociais', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_header_social_menu', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => 'social',
                ],
            ]
        );

        if( function_exists( 'epicjungle_is_woocommerce_activated' ) && epicjungle_is_woocommerce_activated() ) {
            $page->add_control(
                'header_enable_account', [
                    'label'     => esc_html__( 'Ativar conta', 'epicjungle-elementor' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'default'   => $this->get_ej_page_options( 'enable_account', $option_group ),
                    'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                    'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                    'condition' => [
                        'header_enable_custom_header'   => 'yes',
                        'header_navbar_variant'         => [ 'solid', 'shop', 'dashboard' ],
                    ],
                ]
            );

            $page->add_control(
                'header_enable_cart', [
                    'label'     => esc_html__( 'Ativar carrinho', 'epicjungle-elementor' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'default'   => $this->get_ej_page_options( 'enable_cart', $option_group ),
                    'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                    'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                    'condition' => [
                        'header_enable_custom_header'   => 'yes',
                        'header_navbar_variant'         => 'shop',
                    ],
                ]
            );
        }

        $page->add_control(
            'header_enable_action_button', [
                'label'     => esc_html__( 'Exibir botão?', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_action_button', $option_group ),
                'label_on'  => esc_html__( 'Mostrar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Ocultar', 'epicjungle-elementor' ),
                'condition' => [
                    'header_enable_custom_header'   => 'yes',
                    'header_navbar_variant'         => 'button',
                ],
            ]
        );

        $page->end_controls_section();
    }

    public function add_footer_controls( Document $page, $option_group='' ) {
        $page->start_controls_section(
            'document_settings_footer', [
                'label'     => esc_html__( 'Rodapé', 'epicjungle-elementor' ),
                'tab'       => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $page->add_control(
            'footer_enable_custom_footer', [
                'label'     => esc_html__( 'Rodapé personalizado', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_custom_footer', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
            ]
        );

        $page->add_control(
            'footer_footer_variant', [
                'label'     => esc_html__( 'Variante de rodapé', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'default'      => esc_html__( 'Padrão', 'epicjungle-elementor' ),
                    'simple'       => esc_html__( 'Rodapé simples', 'epicjungle-elementor' ),
                    'simple-2'     => esc_html__( 'Ícones sociais do rodapé', 'epicjungle-elementor' ),
                    'shop'         => esc_html__( 'Rodapé da loja', 'epicjungle-elementor' ),
                    'blog'         => esc_html__( 'Rodapé do blog', 'epicjungle-elementor' ),
                    'v6'           => esc_html__( 'Rodapé v6', 'epicjungle-elementor' ),
                    'v7'           => esc_html__( 'Rodapé v7', 'epicjungle-elementor' ),
                    'v8'           => esc_html__( 'Rodapé v8', 'epicjungle-elementor' ),
                    'v9'           => esc_html__( 'Rodapé v9', 'epicjungle-elementor' ),

                ],
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                ],
                'default'   => $this->get_ej_page_options( 'footer_variant', $option_group, 'default' ),
            ]
        );

        $page->add_control(
            'footer_footer_skin', [
                'label'     => esc_html__( 'Estilo do rodapé', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'dark'      => esc_html__( 'Escuro', 'epicjungle-elementor' ),
                    'light'     => esc_html__( 'Claro', 'epicjungle-elementor' ),
                ],
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => [ 'default', 'simple', 'v7', 'v8', 'v9' ],
                ],
                'default'   => $this->get_ej_page_options( 'footer_skin', $option_group, 'dark' ),
            ]
        );

        $page->add_control(
            'footer_contact_title', [
                'label'     => esc_html__( 'Título do contato', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => $this->get_ej_page_options( 'contact_title', $option_group, esc_html__( 'Contatos', 'epicjungle-elementor' ) ),
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => 'v7',
                ],
            ]
        );

        $page->add_control(
            'footer_copyright', [
                'label'       => esc_html__( 'Direitos autorais', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => $this->get_ej_page_options( 'copyright', $option_group ),
                'condition'   => [
                    'footer_enable_custom_footer'   => 'yes',
                ],
            ]
        );


        if ( function_exists( 'epicjungle_is_mas_static_content_activated' ) && epicjungle_is_mas_static_content_activated() ) {
            $page->add_control(
                'footer_footer_static_widgets', [
                    'label'     => esc_html__( 'Widgets estáticos de rodapé', 'epicjungle-elementor' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $this->static_contents,
                    'condition' => [
                        'footer_enable_custom_footer'   => 'yes',
                        'footer_footer_variant'         => [ 'default', 'v6', 'v7','shop', 'blog' ],
                    ],
                    'default'   => $this->get_ej_page_options( 'footer_static_widgets', $option_group ),
                ]
            );

            $page->add_control(
                'footer_footer_jumbotron', [
                    'label'     => esc_html__( 'Conteúdo estático do rodapé', 'epicjungle-elementor' ),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $this->static_contents,
                    'condition' => [
                        'footer_enable_custom_footer'   => 'yes',
                        'footer_footer_variant'         => [ 'shop', 'v8' ],
                    ],
                    'default'   => $this->get_ej_page_options( 'footer_jumbotron', $option_group ),
                ]
            );
        }


        $page->add_control(
            'footer_footer_payment_methods',
            [
                'label'     => __( 'Formas de pagamento', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'dynamic'   => [
                    'active'    => true,
                ],
                'default'   => [
                    'id'    => $this->get_ej_page_options( 'footer_payment_methods', $option_group ),
                    'url'   => (string) wp_get_attachment_image_url( $this->get_ej_page_options( 'footer_payment_methods', $option_group ) ),
                ],
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => 'shop',
                ],
            ]
        );

        $page->add_control(
            'footer_enable_newsletter_form', [
                'label'     => esc_html__( 'Ativar formulário de boletim informativo', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => $this->get_ej_page_options( 'enable_custom_footer', $option_group ),
                'label_on'  => esc_html__( 'Ativar', 'epicjungle-elementor' ),
                'label_off' => esc_html__( 'Desativar', 'epicjungle-elementor' ),
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => 'blog',
                ],
                'default'   => $this->get_ej_page_options( 'enable_newsletter_form', $option_group, '' ),
            ]
        );

        $page->add_control(
            'footer_epicjungle_newsletter_title', [
                'label'     => esc_html__( 'Título do boletim informativo', 'epicjungle-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => $this->get_ej_page_options( 'epicjungle_newsletter_title', $option_group ),
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => 'blog',
                    'footer_enable_newsletter_form' => 'yes',
                ],
            ]
        );

        $page->add_control(
            'footer_epicjungle_newsletter_desc', [
                'label'       => esc_html__( 'Descrição do boletim informativo', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => $this->get_ej_page_options( 'epicjungle_newsletter_desc', $option_group ),
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => 'blog',
                    'footer_enable_newsletter_form' => 'yes',
                ],
            ]
        );

        $page->add_control(
            'footer_epicjungle_newsletter_form', [
                'label'       => esc_html__( 'Formulário de boletim informativo', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => $this->get_ej_page_options( 'epicjungle_newsletter_form', $option_group ),
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => 'blog',
                    'footer_enable_newsletter_form' => 'yes',
                ],
            ]
        );

        $page->add_control(
            'footer_epicjungle_custom_html', [
                'label'       => esc_html__( 'Baixe nosso aplicativo', 'epicjungle-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => $this->get_ej_page_options( 'epicjungle_custom_html', $option_group ),
                'condition' => [
                    'footer_enable_custom_footer'   => 'yes',
                    'footer_footer_variant'         => 'blog',
                ],
            ]
        );

        $page->end_controls_section();
    }

    /**
     * Filter metadata update.
     *
     * Filters whether to update metadata of a specific type.
     *
     * Elementor don't allow WordPress to update the parent page template
     * during `wp_update_post`.
     *
     * Fired by `update_{$meta_type}_metadata` filter.
     *
     * @since 1.0.0
     * @access public
     *
     * @param bool   $check     Whether to allow updating metadata for the given type.
     * @param int    $object_id Object ID.
     * @param string $meta_key  Meta key.
     *
     * @return bool Whether to allow updating metadata of a specific type.
     */
    public function filter_update_meta( $check, $object_id, $meta_key, $meta_value, $prev_value ) {
        if ( '_elementor_page_settings' === $meta_key ) {
            $current_check = $check;
            if ( ! empty( $meta_value ) && is_array( $meta_value ) ) {
                $special_settings_names = $this->get_ej_page_settings_names();
                $special_settings = [];
                foreach ( $special_settings_names as $name ) {
                    if( isset( $meta_value[$name] ) ) {
                        $special_settings[$name] = $meta_value[$name];
                        unset(  $meta_value[$name] );
                        $current_check = false;
                    }
                }
                if( $current_check === false ) {
                    update_metadata( 'post', $object_id, $meta_key, $meta_value, $prev_value );
                    $this->update_ej_page_option( $object_id, $special_settings );
                    return $current_check;
                }
            }
        }

        return $check;
    }
}
