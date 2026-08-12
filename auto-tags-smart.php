<?php
/*
Plugin Name: Auto Tags Inteligentes
Plugin URI: https://github.com/maisondasilva/auto-tags-smart
Description: Looks for already existing tags within your posts.
Version: 1.0.1
Author: Maison da Silva
Author URI: https://maisondasilva.com.br/
License: GPLv2 or later
Text Domain: auto-tags-smart
Domain Path: /languages
*/

defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
defined( 'AET_PLUGIN_VER' ) || define( 'AET_PLUGIN_VER', '1.0.1' );
defined( 'AET_TEXT_DOMAIN' ) || define( 'AET_TEXT_DOMAIN', 'auto-tags-smart' );

function aet_load_textdomain() {
	load_plugin_textdomain( AET_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'aet_load_textdomain' );

function aet_is_portuguese_locale() {
	$locale = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
	$locale = strtolower( (string) $locale );

	return 0 === strpos( $locale, 'pt' );
}

function aet_portuguese_fallback( $translated, $text, $domain ) {
	if ( AET_TEXT_DOMAIN !== $domain || ! aet_is_portuguese_locale() ) {
		return $translated;
	}

	$map = array(
		'Auto Tags Inteligentes' => 'Auto Tags Inteligentes',
		'Settings' => 'Configuracoes',
		'Automatically tag posts using existing tags.' => 'Marque automaticamente com tags existentes.',
		'Enabled' => 'Ativo',
		'Enabled, but there is nothing to examine' => 'Ativo, mas nao ha nada para analisar',
		'Disabled' => 'Desativado',
		'Status' => 'Status',
		'Main Settings' => 'Configuracao Principal',
		'Turn on plugin.' => 'Ativar plugin.',
		'Block manually added tags (previous tags are removed on update).' => 'Bloquear tags manuais (tags anteriores sao removidas ao atualizar).',
		'Examine post title.' => 'Analisar titulo do post.',
		'Examine post content.' => 'Analisar conteudo do post.',
		'Filter by category.' => 'Filtrar por categoria.',
		'Included Categories' => 'Categorias Incluidas',
		'Select all' => 'Selecionar todas',
		'Clear all' => 'Limpar selecao',
		'Clean Uninstall' => 'Limpeza na Desinstalacao',
		'Delete all options from database when deleting this plugin.' => 'Excluir todas as opcoes do banco ao remover este plugin.',
		'Save Changes' => 'Salvar Alteracoes',
		'Do you like this plugin?' => 'Gostou do plugin?',
		'Rate it on the repository.' => 'Avalie no repositorio.',
		'Thank you!' => 'Obrigado!',
	);

	if ( isset( $map[ $text ] ) ) {
		return $map[ $text ];
	}

	return $translated;
}
add_filter( 'gettext', 'aet_portuguese_fallback', 10, 3 );

function aet_register_the_settings() {
	register_setting( 'aet-settings-group', 'aet_turn_on' );
	register_setting( 'aet-settings-group', 'aet_block_manually_added_tags' );
	register_setting( 'aet-settings-group', 'aet_examine_post_title' );
	register_setting( 'aet-settings-group', 'aet_examine_post_content' );
	register_setting( 'aet-settings-group', 'aet_filter_by_category' );
	register_setting( 'aet-settings-group', 'aet_included_categories' );
	register_setting( 'aet-settings-group', 'aet_clean_uninstall' );
}
add_action( 'admin_init', 'aet_register_the_settings' );

function aet_enqueue_assets() {
	wp_enqueue_style( 'aet-admin-css', plugins_url( 'admin/auto-tags-smart-admin.css', __FILE__ ), array(), AET_PLUGIN_VER );
	wp_enqueue_script( 'aet-admin-js', plugins_url( 'admin/auto-tags-smart-admin.js', __FILE__ ), array( 'jquery' ), AET_PLUGIN_VER, true );
}
add_action( 'admin_enqueue_scripts', 'aet_enqueue_assets' );

function aet_settings_page() {
	require 'admin/auto-tags-smart-admin.php';
}

function aet_submenu() {
	add_submenu_page(
		'edit.php',
		__( 'Auto Tags Inteligentes', AET_TEXT_DOMAIN ),
		__( 'Auto Tags Inteligentes', AET_TEXT_DOMAIN ),
		'manage_options',
		'already-existing-tags',
		'aet_settings_page'
	);
}
add_action( 'admin_menu', 'aet_submenu' );

function aet_add_settings_link( $links ) {
	$settings_link = '<a href="edit.php?page=already-existing-tags">' . esc_html__( 'Settings', AET_TEXT_DOMAIN ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'aet_add_settings_link' );

function aet_update_db_check() {
	if ( get_option( 'aet_automatic_tagging_included_categories' ) !== false ) {
		add_option( 'aet_included_categories', get_option( 'aet_automatic_tagging_included_categories' ) );
		delete_option( 'aet_automatic_tagging_included_categories' );
	}
	if ( get_option( 'aet_automatic_tagging' ) !== false ) {
		add_option( 'aet_turn_on', get_option( 'aet_automatic_tagging' ) );
		delete_option( 'aet_automatic_tagging' );
	}
}
add_action( 'plugins_loaded', 'aet_update_db_check' );

function aet_activation() {
	add_option( 'aet_turn_on', '' );
	add_option( 'aet_block_manually_added_tags', '' );
	add_option( 'aet_examine_post_title', '' );
	add_option( 'aet_examine_post_content', '1' );
	add_option( 'aet_filter_by_category', '1' );
	add_option( 'aet_included_categories', '' );
	add_option( 'aet_clean_uninstall', '1' );
}

function aet_deactivation() {
	unregister_setting( 'aet-settings-group', 'aet_turn_on' );
	unregister_setting( 'aet-settings-group', 'aet_block_manually_added_tags' );
	unregister_setting( 'aet-settings-group', 'aet_examine_post_title' );
	unregister_setting( 'aet-settings-group', 'aet_examine_post_content' );
	unregister_setting( 'aet-settings-group', 'aet_filter_by_category' );
	unregister_setting( 'aet-settings-group', 'aet_included_categories' );
	unregister_setting( 'aet-settings-group', 'aet_clean_uninstall' );
}

function aet_uninstall() {
	if ( get_option( 'aet_clean_uninstall' ) ) {
		delete_option( 'aet_turn_on' );
		delete_option( 'aet_block_manually_added_tags' );
		delete_option( 'aet_examine_post_title' );
		delete_option( 'aet_examine_post_content' );
		delete_option( 'aet_filter_by_category' );
		delete_option( 'aet_included_categories' );
		delete_option( 'aet_clean_uninstall' );
	}
}

register_activation_hook( __FILE__, 'aet_activation' );
register_deactivation_hook( __FILE__, 'aet_deactivation' );
register_uninstall_hook( __FILE__, 'aet_uninstall' );

require 'auto-tags-smart-core.php';
