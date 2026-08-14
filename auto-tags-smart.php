<?php
/*
Plugin Name: Auto Tags Smart
Plugin URI: https://github.com/maisondasilva/auto-tags-smart
Description: Looks for existing tags within your posts and can optionally create a tag from the post title.
Version: 1.0.7
Author: Maison da Silva
Author URI: https://maisondasilva.com.br/
License: GPLv2 or later
Text Domain: auto-tags-smart
Domain Path: /languages
*/

defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
defined( 'AETS_PLUGIN_VER' ) || define( 'AETS_PLUGIN_VER', '1.0.7' );
defined( 'AETS_TEXT_DOMAIN' ) || define( 'AETS_TEXT_DOMAIN', 'auto-tags-smart' );
defined( 'AETS_LEGACY_OPTION_PREFIX' ) || define( 'AETS_LEGACY_OPTION_PREFIX', 'aet_' );

function aets_load_textdomain() {
	load_plugin_textdomain( AETS_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'aets_load_textdomain' );

function aets_register_the_settings() {
	register_setting(
		'aets_settings_group',
		'aets_turn_on',
		array(
			'sanitize_callback' => 'aets_sanitize_checkbox',
		)
	);
	register_setting(
		'aets_settings_group',
		'aets_block_manually_added_tags',
		array(
			'sanitize_callback' => 'aets_sanitize_checkbox',
		)
	);
	register_setting(
		'aets_settings_group',
		'aets_examine_post_title',
		array(
			'sanitize_callback' => 'aets_sanitize_checkbox',
		)
	);
	register_setting(
		'aets_settings_group',
		'aets_examine_post_content',
		array(
			'sanitize_callback' => 'aets_sanitize_checkbox',
		)
	);
	register_setting(
		'aets_settings_group',
		'aets_filter_by_category',
		array(
			'sanitize_callback' => 'aets_sanitize_checkbox',
		)
	);
	register_setting(
		'aets_settings_group',
		'aets_create_missing_tags',
		array(
			'sanitize_callback' => 'aets_sanitize_checkbox',
		)
	);
	register_setting(
		'aets_settings_group',
		'aets_included_categories',
		array(
			'sanitize_callback' => 'aets_sanitize_included_categories',
		)
	);
	register_setting(
		'aets_settings_group',
		'aets_clean_uninstall',
		array(
			'sanitize_callback' => 'aets_sanitize_checkbox',
		)
	);
}
add_action( 'admin_init', 'aets_register_the_settings' );

function aets_sanitize_checkbox( $value ) {
	return $value ? '1' : '';
}

function aets_sanitize_included_categories( $values ) {
	if ( ! is_array( $values ) ) {
		return array();
	}

	$values = array_map( 'absint', $values );
	$values = array_filter( $values );

	return array_values( array_unique( $values ) );
}

function aets_enqueue_assets() {
	wp_enqueue_style( 'aets-admin-css', plugins_url( 'admin/auto-tags-smart-admin.css', __FILE__ ), array(), AETS_PLUGIN_VER );
	wp_enqueue_script( 'aets-admin-js', plugins_url( 'admin/auto-tags-smart-admin.js', __FILE__ ), array( 'jquery' ), AETS_PLUGIN_VER, true );
}
add_action( 'admin_enqueue_scripts', 'aets_enqueue_assets' );

function aets_settings_page() {
	require 'admin/auto-tags-smart-admin.php';
}

function aets_submenu() {
	add_submenu_page(
		'edit.php',
		__( 'Auto Tags Smart', 'auto-tags-smart' ),
		__( 'Auto Tags Smart', 'auto-tags-smart' ),
		'manage_options',
		'aets-settings',
		'aets_settings_page'
	);
}
add_action( 'admin_menu', 'aets_submenu' );

function aets_add_settings_link( $links ) {
	$settings_link = '<a href="edit.php?page=aets-settings">' . esc_html__( 'Settings', 'auto-tags-smart' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'aets_add_settings_link' );

function aets_update_db_check() {
	$option_names = array(
		'turn_on',
		'block_manually_added_tags',
		'examine_post_title',
		'examine_post_content',
		'filter_by_category',
		'create_missing_tags',
		'included_categories',
		'clean_uninstall',
	);

	foreach ( $option_names as $option_name ) {
		$old_name = AETS_LEGACY_OPTION_PREFIX . $option_name;
		$new_name = 'aets_' . $option_name;

		if ( false !== get_option( $old_name ) && false === get_option( $new_name ) ) {
			add_option( $new_name, get_option( $old_name ) );
		}
	}

	$legacy_categories_option = AETS_LEGACY_OPTION_PREFIX . 'automatic_tagging_included_categories';
	$legacy_tagging_option    = AETS_LEGACY_OPTION_PREFIX . 'automatic_tagging';

	if ( get_option( $legacy_categories_option ) !== false ) {
		add_option( 'aets_included_categories', get_option( $legacy_categories_option ) );
		delete_option( $legacy_categories_option );
	}
	if ( get_option( $legacy_tagging_option ) !== false ) {
		add_option( 'aets_turn_on', get_option( $legacy_tagging_option ) );
		delete_option( $legacy_tagging_option );
	}

	if ( false === get_option( 'aets_create_missing_tags' ) ) {
		add_option( 'aets_create_missing_tags', '1' );
	}
}
add_action( 'plugins_loaded', 'aets_update_db_check' );

function aets_activation() {
	add_option( 'aets_turn_on', '' );
	add_option( 'aets_block_manually_added_tags', '' );
	add_option( 'aets_examine_post_title', '' );
	add_option( 'aets_examine_post_content', '1' );
	add_option( 'aets_filter_by_category', '1' );
	add_option( 'aets_create_missing_tags', '1' );
	add_option( 'aets_included_categories', '' );
	add_option( 'aets_clean_uninstall', '1' );
}

function aets_deactivation() {
	unregister_setting( 'aets_settings_group', 'aets_turn_on' );
	unregister_setting( 'aets_settings_group', 'aets_block_manually_added_tags' );
	unregister_setting( 'aets_settings_group', 'aets_examine_post_title' );
	unregister_setting( 'aets_settings_group', 'aets_examine_post_content' );
	unregister_setting( 'aets_settings_group', 'aets_filter_by_category' );
	unregister_setting( 'aets_settings_group', 'aets_create_missing_tags' );
	unregister_setting( 'aets_settings_group', 'aets_included_categories' );
	unregister_setting( 'aets_settings_group', 'aets_clean_uninstall' );
}

function aets_uninstall() {
	if ( get_option( 'aets_clean_uninstall' ) ) {
		delete_option( 'aets_turn_on' );
		delete_option( 'aets_block_manually_added_tags' );
		delete_option( 'aets_examine_post_title' );
		delete_option( 'aets_examine_post_content' );
		delete_option( 'aets_filter_by_category' );
		delete_option( 'aets_create_missing_tags' );
		delete_option( 'aets_included_categories' );
		delete_option( 'aets_clean_uninstall' );
		$legacy_options = array(
			'turn_on',
			'block_manually_added_tags',
			'examine_post_title',
			'examine_post_content',
			'filter_by_category',
			'create_missing_tags',
			'included_categories',
			'clean_uninstall',
		);

		foreach ( $legacy_options as $legacy_option ) {
			delete_option( AETS_LEGACY_OPTION_PREFIX . $legacy_option );
		}
	}
}

register_activation_hook( __FILE__, 'aets_activation' );
register_deactivation_hook( __FILE__, 'aets_deactivation' );
register_uninstall_hook( __FILE__, 'aets_uninstall' );

require 'auto-tags-smart-core.php';
