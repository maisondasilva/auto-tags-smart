<?php
/*
Plugin Name: Auto Tags Smart
Plugin URI: https://github.com/maisondasilva/auto-tags-smart
Description: Automatically detects and assigns existing tags to posts using smart content analysis.
Version: 1.0
Author: Maison da Silva
Author URI: https://maisondasilva.com.br
License: GPLv2 or later
Text Domain: auto-tags-smart
Domain Path: /languages
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
*/

defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );

define( 'AUTOTASM_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AUTOTASM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include core functions
include_once AUTOTASM_PLUGIN_DIR_PATH . 'auto-tags-smart-core.php';

// Sanitization functions
function autotasm_sanitize_categories( $input ) {
	if ( ! is_array( $input ) ) {
		return array();
	}
	
	$sanitized = array();
	foreach ( $input as $cat_id ) {
		$cat_id = absint( $cat_id );
		if ( $cat_id > 0 ) {
			$sanitized[] = $cat_id;
		}
	}
	
	return $sanitized;
}

function autotasm_sanitize_minimum_length( $input ) {
	$value = absint( $input );
	return max( 1, min( 50, $value ) ); // Between 1 and 50
}

function autotasm_register_the_settings() {
	register_setting( 'autotasm-settings-group', 'autotasm_turn_on', array(
		'type' => 'boolean',
		'sanitize_callback' => 'rest_sanitize_boolean',
		'default' => false
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_examine_post_title', array(
		'type' => 'boolean',
		'sanitize_callback' => 'rest_sanitize_boolean',
		'default' => true
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_examine_post_content', array(
		'type' => 'boolean',
		'sanitize_callback' => 'rest_sanitize_boolean',
		'default' => true
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_filter_by_category', array(
		'type' => 'boolean',
		'sanitize_callback' => 'rest_sanitize_boolean',
		'default' => true
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_included_categories', array(
		'type' => 'array',
		'sanitize_callback' => 'autotasm_sanitize_categories',
		'default' => array()
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_case_sensitive', array(
		'type' => 'boolean',
		'sanitize_callback' => 'rest_sanitize_boolean',
		'default' => false
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_block_manually_added_tags', array(
		'type' => 'boolean',
		'sanitize_callback' => 'rest_sanitize_boolean',
		'default' => false
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_minimum_tag_length', array(
		'type' => 'integer',
		'sanitize_callback' => 'autotasm_sanitize_minimum_length',
		'default' => 3
	) );
	register_setting( 'autotasm-settings-group', 'autotasm_clean_uninstall', array(
		'type' => 'boolean',
		'sanitize_callback' => 'rest_sanitize_boolean',
		'default' => true
	) );
}

function autotasm_main_menu() {
	add_submenu_page(
		'edit.php',
		__( 'Auto Tags Smart', 'auto-tags-smart' ),
		__( 'Auto Tags Smart', 'auto-tags-smart' ),
		'manage_options',
		'autotasm-tags',
		'autotasm_main_menu_page'
	);
}

function autotasm_main_menu_page() {
	include_once AUTOTASM_PLUGIN_DIR_PATH . 'admin/auto-tags-smart-admin.php';
}

function autotasm_settings_link( $links ) {
	$settings_link = '<a href="edit.php?page=autotasm-tags">' . __( 'Settings', 'auto-tags-smart' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}

function autotasm_enqueue_admin_scripts( $hook ) {
	if ( 'posts_page_autotasm-tags' !== $hook ) {
		return;
	}

	wp_enqueue_script(
		'auto-tags-smart-admin',
		AUTOTASM_PLUGIN_URL . 'admin/auto-tags-smart-admin.min.js',
		array( 'jquery' ),
		'1.0',
		true
	);

	// Localizar strings para JavaScript
	wp_localize_script( 'auto-tags-smart-admin', 'atStrings', array(
		'selectAll' => __( 'Select All', 'auto-tags-smart' ),
		'deselectAll' => __( 'Deselect All', 'auto-tags-smart' ),
		'statusActive' => __( 'STATUS: Active ✓', 'auto-tags-smart' ),
		'statusActiveNothing' => __( 'STATUS: Active but nothing to examine', 'auto-tags-smart' ),
		'statusInactive' => __( 'STATUS: Inactive', 'auto-tags-smart' ),
		'errorExamineOption' => __( 'You must select at least one option: "Examine title" or "Examine content".', 'auto-tags-smart' ),
		'errorCategoryFilter' => __( 'If you enable category filter, you must select at least one category.', 'auto-tags-smart' ),
		'errorMinLength' => __( 'Tag minimum length must be at least 1.', 'auto-tags-smart' ),
		'errorMaxLength' => __( 'Tag minimum length cannot be greater than 50.', 'auto-tags-smart' ),
		'confirmCleanUninstall' => __( 'Are you sure? This option will remove ALL plugin settings when it is uninstalled.', 'auto-tags-smart' )
	) );

	wp_enqueue_style(
		'auto-tags-smart-admin',
		AUTOTASM_PLUGIN_URL . 'admin/auto-tags-smart-admin.min.css',
		array(),
		'1.0'
	);
}

function autotasm_post_updated( $post_id ) {
	if ( ! get_option( 'autotasm_turn_on' ) || autotasm_halt() ) {
		return;
	}

	autotasm_smart_tagging( $post_id );
}

// Activation function - sets default values
function autotasm_activation_hook() {
	// Clean any previous installations
	autotasm_clean_previous_installations();
	
	// Set default values only if they don't exist
	if ( get_option( 'autotasm_turn_on' ) === false ) {
		add_option( 'autotasm_turn_on', false );
	}
	if ( get_option( 'autotasm_examine_post_title' ) === false ) {
		add_option( 'autotasm_examine_post_title', true );
	}
	if ( get_option( 'autotasm_examine_post_content' ) === false ) {
		add_option( 'autotasm_examine_post_content', true );
	}
	if ( get_option( 'autotasm_minimum_tag_length' ) === false ) {
		add_option( 'autotasm_minimum_tag_length', 3 );
	}
	if ( get_option( 'autotasm_filter_by_category' ) === false ) {
		add_option( 'autotasm_filter_by_category', true );
	}
	if ( get_option( 'autotasm_case_sensitive' ) === false ) {
		add_option( 'autotasm_case_sensitive', false );
	}
	if ( get_option( 'autotasm_block_manually_added_tags' ) === false ) {
		add_option( 'autotasm_block_manually_added_tags', false );
	}
	if ( get_option( 'autotasm_clean_uninstall' ) === false ) {
		add_option( 'autotasm_clean_uninstall', true );
	}
}

function autotasm_clean_previous_installations() {
	// Remove old 'at_' prefixed options
	delete_option( 'at_turn_on' );
	delete_option( 'at_examine_post_title' );
	delete_option( 'at_examine_post_content' );
	delete_option( 'at_filter_by_category' );
	delete_option( 'at_included_categories' );
	delete_option( 'at_case_sensitive' );
	delete_option( 'at_block_manually_added_tags' );
	delete_option( 'at_minimum_tag_length' );
	delete_option( 'at_clean_uninstall' );
}

function autotasm_deactivation_hook() {
	// Nothing to do on deactivation
}

function autotasm_uninstall_hook() {
	if ( get_option( 'autotasm_clean_uninstall' ) ) {
		delete_option( 'autotasm_turn_on' );
		delete_option( 'autotasm_examine_post_title' );
		delete_option( 'autotasm_examine_post_content' );
		delete_option( 'autotasm_filter_by_category' );
		delete_option( 'autotasm_included_categories' );
		delete_option( 'autotasm_case_sensitive' );
		delete_option( 'autotasm_block_manually_added_tags' );
		delete_option( 'autotasm_minimum_tag_length' );
		delete_option( 'autotasm_clean_uninstall' );
	}
}

// WordPress Hooks
add_action( 'admin_init', 'autotasm_register_the_settings' );
add_action( 'admin_menu', 'autotasm_main_menu' );
add_action( 'admin_enqueue_scripts', 'autotasm_enqueue_admin_scripts' );
add_action( 'post_updated', 'autotasm_post_updated' );

// Plugin activation/deactivation hooks
register_activation_hook( __FILE__, 'autotasm_activation_hook' );
register_deactivation_hook( __FILE__, 'autotasm_deactivation_hook' );
register_uninstall_hook( __FILE__, 'autotasm_uninstall_hook' );

// Add settings link to plugin page
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'autotasm_settings_link' );
