<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );

function autotasm_included_categories() {
	return get_option( 'autotasm_included_categories' ) ? array_map(
		function( $cat_id ) {
			return + $cat_id;
		},
		get_option( 'autotasm_included_categories' )
	) : array();
}

function autotasm_halt() {
	$examine_post = get_option( 'autotasm_examine_post_title' ) || get_option( 'autotasm_examine_post_content' );

	return ! $examine_post || ( get_option( 'autotasm_filter_by_category' ) && empty( autotasm_included_categories() ) );
}

function autotasm_smart_tagging( $the_post_id ) {
	$post = get_post( $the_post_id );

	if ( 'post' === $post->post_type ) {
		$post_categories = ( get_the_terms( $the_post_id, 'category' ) ) ? wp_list_pluck( get_the_terms( $the_post_id, 'category' ), 'term_id' ) : array();

		$content_to_analyze = '';

		if ( get_option( 'autotasm_examine_post_title' ) ) {
			$the_post_title = get_post( $the_post_id )->post_title;
			$the_post_title = wp_strip_all_tags( $the_post_title );
			$content_to_analyze .= ' ' . $the_post_title;
		}

		if ( get_option( 'autotasm_examine_post_content' ) ) {
			$the_post_content = get_post( $the_post_id )->post_content;
			$the_post_content = wp_strip_all_tags( $the_post_content );
			$content_to_analyze .= ' ' . $the_post_content;
		}

		$existing_tags = get_terms(
			array(
				'taxonomy' => 'post_tag',
				'hide_empty' => false,
			)
		);

		if ( $existing_tags && ( ! get_option( 'autotasm_filter_by_category' ) || array_intersect( $post_categories, autotasm_included_categories() ) ) ) {
			if ( get_option( 'autotasm_block_manually_added_tags' ) ) {
				wp_delete_object_term_relationships( $the_post_id, 'post_tag' );
			}

			$minimum_length = get_option( 'autotasm_minimum_tag_length', 3 );
			$case_sensitive = get_option( 'autotasm_case_sensitive' );
			$found_tags = array();

			foreach ( $existing_tags as $newtag ) {
				// Skip tags that are too short
				if ( strlen( $newtag->name ) < $minimum_length ) {
					continue;
				}

				$pattern = preg_quote( $newtag->name, '/' );
				
				if ( $case_sensitive ) {
					$pattern = '/\b' . $pattern . '\b/u';
				} else {
					$pattern = '/\b' . $pattern . '\b/ui';
				}

				if ( preg_match( $pattern, $content_to_analyze ) ) {
					$found_tags[] = $newtag->name;
				}
			}

			// Apply found tags to the post
			if ( ! empty( $found_tags ) ) {
				wp_set_post_terms( $the_post_id, $found_tags, 'post_tag', ! get_option( 'autotasm_block_manually_added_tags' ) );
			}
		}
	}
}

// Enhanced function to analyze content relevance
function autotasm_get_content_relevance_score( $tag_name, $content ) {
	$tag_name = strtolower( trim( $tag_name ) );
	$content = strtolower( $content );
	
	// Count occurrences
	$count = substr_count( $content, $tag_name );
	
	// Calculate relevance based on content length and frequency
	$content_words = str_word_count( $content );
	$relevance = $content_words > 0 ? ( $count / $content_words ) * 100 : 0;
	
	return $relevance;
}

// Function to suggest new tags based on content
function autotasm_suggest_tags_from_content( $content, $limit = 10 ) {
	// Remove common words
	$common_words = array(
		'the', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by',
		'from', 'about', 'into', 'through', 'during', 'before', 'after', 'above',
		'below', 'up', 'down', 'out', 'off', 'over', 'under', 'again', 'further',
		'then', 'once', 'here', 'there', 'when', 'where', 'why', 'how', 'all',
		'any', 'both', 'each', 'few', 'more', 'most', 'other', 'some', 'such',
		'no', 'nor', 'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very',
		'can', 'will', 'just', 'should', 'now', 'que', 'de', 'e', 'o', 'a', 'em',
		'para', 'com', 'por', 'do', 'da', 'dos', 'das', 'um', 'uma', 'como', 'mais'
	);
	
	// Clean and prepare content
	$content = wp_strip_all_tags( $content );
	$content = preg_replace( '/[^\w\s]/', ' ', $content );
	$words = str_word_count( strtolower( $content ), 1 );
	
	// Filter words
	$filtered_words = array_filter( $words, function( $word ) use ( $common_words ) {
		return strlen( $word ) >= get_option( 'autotasm_minimum_tag_length', 3 ) && 
			   ! in_array( $word, $common_words );
	});
	
	// Count word frequency
	$word_freq = array_count_values( $filtered_words );
	arsort( $word_freq );
	
	return array_slice( array_keys( $word_freq ), 0, $limit );
}

if ( get_option( 'autotasm_turn_on' ) && ! autotasm_halt() ) {
	if ( function_exists( 'wp_after_insert_post' ) ) {
		add_action( 'wp_after_insert_post', 'autotasm_smart_tagging' );
	} else {
		add_action( 'wp_insert_post', 'autotasm_smart_tagging' );
	}
}
