<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );

function aets_included_categories() {
	$included = get_option( 'aets_included_categories' );

	if ( empty( $included ) ) {
		return array();
	}

	if ( is_string( $included ) ) {
		$included = array_filter( array_map( 'trim', explode( ',', $included ) ) );
	}

	if ( ! is_array( $included ) ) {
		return array();
	}

	$included = array_map( 'absint', $included );
	$included = array_filter( $included );

	return array_values( array_unique( $included ) );
}

function aets_normalize_tag_name( $tag_name ) {
	$tag_name = trim( wp_strip_all_tags( (string) $tag_name ) );
	$tag_name = preg_replace( '/\s+/', ' ', $tag_name );

	return $tag_name ? $tag_name : '';
}

function aets_extract_tag_candidates( $text ) {
	$text = strtolower( aets_normalize_tag_name( $text ) );
	$text = preg_replace( '/[^\p{L}\p{N}\s-]+/u', ' ', $text );
	$parts = preg_split( '/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY );

	if ( empty( $parts ) ) {
		return array();
	}

	$stop_words = array(
		'de', 'da', 'do', 'das', 'dos', 'e', 'em', 'no', 'na', 'nos', 'nas', 'com', 'sem', 'por', 'para', 'que', 'como', 'uma', 'um', 'uns', 'umas', 'sobre',
		'the', 'and', 'for', 'with', 'from', 'this', 'that', 'you', 'your', 'are', 'was', 'were', 'has', 'have', 'had', 'into', 'onto', 'about', 'over', 'under',
	);

	$candidates = array();

	foreach ( $parts as $part ) {
		$part = trim( $part, '-_' );

		if ( '' === $part || strlen( $part ) < 3 || is_numeric( $part ) || in_array( $part, $stop_words, true ) ) {
			continue;
		}

		$candidates[] = $part;
	}

	$candidates = array_values( array_unique( $candidates ) );

	return $candidates;
}

function aets_count_words( $text ) {
	$text  = trim( wp_strip_all_tags( (string) $text ) );
	$parts = preg_split( '/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY );

	return is_array( $parts ) ? count( $parts ) : 0;
}

function aets_dynamic_tags_limit( $sources ) {
	$total_words = 0;

	foreach ( (array) $sources as $source_text ) {
		$total_words += aets_count_words( $source_text );
	}

	if ( $total_words <= 400 ) {
		return 10;
	}

	if ( $total_words <= 900 ) {
		return 14;
	}

	if ( $total_words <= 1800 ) {
		return 20;
	}

	return 25;
}

function aets_halt() {
	$examine_post = get_option( 'aets_examine_post_title' ) || get_option( 'aets_examine_post_content' );

	return ! $examine_post || ( get_option( 'aets_filter_by_category' ) && empty( aets_included_categories() ) );
}

function aets_tagging( $the_post_id ) {
	if ( ! get_option( 'aets_turn_on' ) || aets_halt() ) {
		return;
	}

	$post = get_post( $the_post_id );

	if ( ! $post || wp_is_post_revision( $the_post_id ) || wp_is_post_autosave( $the_post_id ) ) {
		return;
	}

	if ( 'post' === $post->post_type ) {
		$post_categories = ( get_the_terms( $the_post_id, 'category' ) ) ? wp_list_pluck( get_the_terms( $the_post_id, 'category' ), 'term_id' ) : array();
		$category_match  = ! get_option( 'aets_filter_by_category' ) || array_intersect( $post_categories, aets_included_categories() );
		$search_sources  = array();

		if ( get_option( 'aets_examine_post_title' ) ) {
			$the_post_title  = wp_strip_all_tags( (string) $post->post_title );
			$search_sources[] = $the_post_title;
		}

		if ( get_option( 'aets_examine_post_content' ) ) {
			$the_post_content  = wp_strip_all_tags( (string) $post->post_content );
			$search_sources[] = $the_post_content;
		}

		$existing_tags = get_terms(
			array(
				'taxonomy'   => 'post_tag',
				'hide_empty' => false,
			)
		);

		if ( $existing_tags && $category_match ) {
			if ( get_option( 'aets_block_manually_added_tags' ) ) {
				wp_delete_object_term_relationships( $the_post_id, 'post_tag' );
			}

			foreach ( $existing_tags as $newtag ) {
				$pattern = preg_quote( aets_normalize_tag_name( $newtag->name ), '/' );
				$pattern = '/\b' . $pattern . '\b/ui';

				foreach ( $search_sources as $source_text ) {
					if ( preg_match( $pattern, $source_text ) ) {
						wp_set_post_terms( $the_post_id, $newtag->name, 'post_tag', true );
						break;
					}
				}
			}
		}

		if ( $category_match && get_option( 'aets_create_missing_tags', '1' ) && ! empty( $search_sources ) ) {
			$max_auto_tags       = aets_dynamic_tags_limit( $search_sources );
			$processed_candidates = array();
			$processed_count      = 0;

			foreach ( $search_sources as $source_text ) {
				foreach ( aets_extract_tag_candidates( $source_text ) as $candidate ) {
					if ( $processed_count >= $max_auto_tags ) {
						break 2;
					}

					if ( isset( $processed_candidates[ $candidate ] ) ) {
						continue;
					}

					$processed_candidates[ $candidate ] = true;
					$processed_count++;

					$existing_term = term_exists( $candidate, 'post_tag' );

					if ( ! $existing_term ) {
						$created_term = wp_insert_term( $candidate, 'post_tag' );

						if ( ! is_wp_error( $created_term ) && ! empty( $created_term['term_id'] ) ) {
							wp_set_post_terms( $the_post_id, array( (int) $created_term['term_id'] ), 'post_tag', true );
						}
					} elseif ( is_array( $existing_term ) && ! empty( $existing_term['term_id'] ) ) {
						wp_set_post_terms( $the_post_id, array( (int) $existing_term['term_id'] ), 'post_tag', true );
					}
				}
			}
		}
	}
}

if ( function_exists( 'wp_after_insert_post' ) ) {
	add_action( 'wp_after_insert_post', 'aets_tagging' );
} else {
	add_action( 'wp_insert_post', 'aets_tagging' );
}
