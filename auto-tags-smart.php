<?php
/*
Plugin Name: Auto Tags Smart
Plugin URI: https://github.com/maisondasilva/auto-tags-smart
Description: Looks for existing tags within your posts and can optionally create a tag from the post title.
Version: 1.0.2
Author: Maison da Silva
Author URI: https://maisondasilva.com.br/
License: GPLv2 or later
Text Domain: auto-tags-smart
Domain Path: /languages
*/

defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
defined( 'AET_PLUGIN_VER' ) || define( 'AET_PLUGIN_VER', '1.0.2' );
defined( 'AET_TEXT_DOMAIN' ) || define( 'AET_TEXT_DOMAIN', 'auto-tags-smart' );

function aet_load_textdomain() {
	load_plugin_textdomain( AET_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'aet_load_textdomain' );

function aet_register_the_settings() {
	register_setting(
		'aet-settings-group',
		'aet_turn_on',
		array(
			'sanitize_callback' => 'aet_sanitize_checkbox',
		)
	);
	register_setting(
		'aet-settings-group',
		'aet_block_manually_added_tags',
		array(
			'sanitize_callback' => 'aet_sanitize_checkbox',
		)
	);
	register_setting(
		'aet-settings-group',
		'aet_examine_post_title',
		array(
			'sanitize_callback' => 'aet_sanitize_checkbox',
		)
	);
	register_setting(
		'aet-settings-group',
		'aet_examine_post_content',
		array(
			'sanitize_callback' => 'aet_sanitize_checkbox',
		)
	);
	register_setting(
		'aet-settings-group',
		'aet_filter_by_category',
		array(
			'sanitize_callback' => 'aet_sanitize_checkbox',
		)
	);
	register_setting(
		'aet-settings-group',
		'aet_create_missing_tags',
		array(
			'sanitize_callback' => 'aet_sanitize_checkbox',
		)
	);
	register_setting(
		'aet-settings-group',
		'aet_included_categories',
		array(
			'sanitize_callback' => 'aet_sanitize_included_categories',
		)
	);
	register_setting(
		'aet-settings-group',
		'aet_clean_uninstall',
		array(
			'sanitize_callback' => 'aet_sanitize_checkbox',
		)
	);
}
add_action( 'admin_init', 'aet_register_the_settings' );

function aet_sanitize_checkbox( $value ) {
	return $value ? '1' : '';
}

function aet_sanitize_included_categories( $values ) {
	if ( ! is_array( $values ) ) {
		return array();
	}

	$values = array_map( 'absint', $values );
	$values = array_filter( $values );

	return array_values( array_unique( $values ) );
}

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
		__( 'Auto Tags Smart', 'auto-tags-smart' ),
		__( 'Auto Tags Smart', 'auto-tags-smart' ),
		'manage_options',
		'already-existing-tags',
		'aet_settings_page'
	);
}
add_action( 'admin_menu', 'aet_submenu' );

function aet_add_settings_link( $links ) {
	$settings_link = '<a href="edit.php?page=already-existing-tags">' . esc_html__( 'Settings', 'auto-tags-smart' ) . '</a>';
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

	if ( false === get_option( 'aet_create_missing_tags' ) ) {
		add_option( 'aet_create_missing_tags', '1' );
	}
}
add_action( 'plugins_loaded', 'aet_update_db_check' );

function aet_activation() {
	add_option( 'aet_turn_on', '' );
	add_option( 'aet_block_manually_added_tags', '' );
	add_option( 'aet_examine_post_title', '' );
	add_option( 'aet_examine_post_content', '1' );
	add_option( 'aet_filter_by_category', '1' );
	add_option( 'aet_create_missing_tags', '1' );
	add_option( 'aet_included_categories', '' );
	add_option( 'aet_clean_uninstall', '1' );
}

function aet_deactivation() {
	unregister_setting( 'aet-settings-group', 'aet_turn_on' );
	unregister_setting( 'aet-settings-group', 'aet_block_manually_added_tags' );
	unregister_setting( 'aet-settings-group', 'aet_examine_post_title' );
	unregister_setting( 'aet-settings-group', 'aet_examine_post_content' );
	unregister_setting( 'aet-settings-group', 'aet_filter_by_category' );
	unregister_setting( 'aet-settings-group', 'aet_create_missing_tags' );
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
		delete_option( 'aet_create_missing_tags' );
		delete_option( 'aet_included_categories' );
		delete_option( 'aet_clean_uninstall' );
	}
}

register_activation_hook( __FILE__, 'aet_activation' );
register_deactivation_hook( __FILE__, 'aet_deactivation' );
register_uninstall_hook( __FILE__, 'aet_uninstall' );

require 'auto-tags-smart-core.php';
