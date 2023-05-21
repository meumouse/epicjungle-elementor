<?php
/**
 * Plugin Name: EpicJungle Elementor Widgets
 * Description: Widgets para Elementor exclusivos para o tema WordPress EpicJungle.
 * Plugin URI:  https://epicjunglewp.com.br/
 * Version:     1.2.0
 * Author:      MeuMouse.com
 * Elementor tested up to: 3.6.0
 * Author URI:  https://meumouse.com/
 * Text Domain: epicjungle-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'EPICJUNGLE_ELEMENTOR_VERSION', '0.0.293' );
define( 'EPICJUNGLE_ELEMENTOR_PREVIOUS_STABLE_VERSION', '0.0.293' );

define( 'EPICJUNGLE_ELEMENTOR__FILE__', __FILE__ );
define( 'EPICJUNGLE_ELEMENTOR_PLUGIN_BASE', plugin_basename( EPICJUNGLE_ELEMENTOR__FILE__ ) );
define( 'EPICJUNGLE_ELEMENTOR_PATH', plugin_dir_path( EPICJUNGLE_ELEMENTOR__FILE__ ) );
define( 'EPICJUNGLE_ELEMENTOR_ASSETS_PATH', EPICJUNGLE_ELEMENTOR_PATH . 'assets/' );
define( 'EPICJUNGLE_ELEMENTOR_MODULES_PATH', EPICJUNGLE_ELEMENTOR_PATH . 'modules/' );
define( 'EPICJUNGLE_ELEMENTOR_INCLUDES_PATH', EPICJUNGLE_ELEMENTOR_PATH . 'includes/' );
define( 'EPICJUNGLE_ELEMENTOR_TEMPLATES_PATH', EPICJUNGLE_ELEMENTOR_PATH . 'templates/' );
define( 'EPICJUNGLE_ELEMENTOR_URL', plugins_url( '/', EPICJUNGLE_ELEMENTOR__FILE__ ) );
define( 'EPICJUNGLE_ELEMENTOR_ASSETS_URL', EPICJUNGLE_ELEMENTOR_URL . 'assets/' );
define( 'EPICJUNGLE_ELEMENTOR_MODULES_URL', EPICJUNGLE_ELEMENTOR_URL . 'modules/' );
define( 'EPICJUNGLE_ELEMENTOR_INCLUDES_URL', EPICJUNGLE_ELEMENTOR_URL . 'includes/' );

/**
 * Load gettext translate for our text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function epicjungle_elementor_load_plugin() {
	load_plugin_textdomain( 'epicjungle-elementor' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'epicjungle_elementor_fail_load' );

		return;
	}

	$elementor_version_required = '3.0.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'epicjungle_elementor_fail_load_out_of_date' );

		return;
	}

	$elementor_version_recommendation = '3.0.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_recommendation, '>=' ) ) {
		add_action( 'admin_notices', 'epicjungle_elementor_admin_notice_upgrade_recommendation' );
	}

	require EPICJUNGLE_ELEMENTOR_PATH . 'plugin.php';
}

add_action( 'plugins_loaded', 'epicjungle_elementor_load_plugin' );
add_action( 'plugins_loaded', 'epicjungle_elementor_update_checker' );

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @since 1.0.0
 *
 * @return void
 */
function epicjungle_elementor_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

		$message  = '<p>' . esc_html__( 'EpicJungle Elementor não está funcionando porque você precisa ativar o plugin Elementor.', 'epicjungle-elementor' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Ativar Elementor agora', 'epicjungle-elementor' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

		$message  = '<p>' . esc_html__( 'EpicJungle Elementor não está funcionando porque você precisa instalar o plugin Elementor.', 'epicjungle-elementor' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Instale o Elementor agora', 'epicjungle-elementor' ) ) . '</p>';
	}

	echo '<div class="error"><p>' . wp_kses_post( $message ) . '</p></div>';
}

/**
 * Display error message if using out of date Elementor.
 */
function epicjungle_elementor_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message      = '<p>' . esc_html__( 'EpicJungle Elementor não está funcionando porque você está usando uma versão antiga do Elementor.', 'epicjungle-elementor' ) . '</p>';
	$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, esc_html__( 'Atualizar Elementor agora', 'epicjungle-elementor' ) ) . '</p>';

	echo '<div class="error">' . wp_kses_post( $message ) . '</div>';
}

/**
 * Display error message to update Elementor.
 */
function epicjungle_elementor_admin_notice_upgrade_recommendation() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message      = '<p>' . esc_html__( 'Uma nova versão do Elementor está disponível. Para melhor desempenho e compatibilidade do EpicJungle Elementor, recomendamos atualizar para a versão mais recente.', 'epicjungle-elementor' ) . '</p>';
	$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, esc_html__( 'Atualizar Elementor agora', 'epicjungle-elementor' ) ) . '</p>';

	echo '<div class="error">' . wp_kses_post( $message ) . '</div>';
}

if ( ! function_exists( '_is_elementor_installed' ) ) {
	/**
	 * Check if Elementor is installed.
	 *
	 * @return bool
	 */
	function _is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

/**
 * Update checker (DON'T TOUCH HERE!)
 */
function epicjungle_elementor_update_checker(){
	require EPICJUNGLE_ELEMENTOR_PATH . 'core/update-checker/plugin-update-checker.php';
	$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker( 'https://raw.githubusercontent.com/meumouse/epicjungle-elementor/main/epicjungle-elementor-update-checker.json', __FILE__, 'epicjungle-elementor' );
}