<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
?>

<div class="wrap">

<h2><?php esc_html_e( 'Auto Tags Smart', 'auto-tags-smart' ); ?></h2>

<?php settings_errors(); ?>

<form action="options.php" method="post">

<?php
settings_fields( 'autotasm-settings-group' );

// Verificar se o plugin está realmente ativo
$is_plugin_enabled = get_option( 'autotasm_turn_on' );
$has_something_to_examine = !autotasm_halt();

if ( $is_plugin_enabled && $has_something_to_examine ) {
	echo '<h3 id="autotasm-status" style="color: green;" class="autotasm-status-active">' . esc_html__( 'STATUS: Active ✓', 'auto-tags-smart' ) . '</h3>';
} elseif ( $is_plugin_enabled && !$has_something_to_examine ) {
	echo '<h3 id="autotasm-status" style="color: orange;" class="autotasm-status-warning">' . esc_html__( 'STATUS: Active but nothing to examine', 'auto-tags-smart' ) . '</h3>';
} else {
	echo '<h3 id="autotasm-status" style="color: red;" class="autotasm-status-inactive">' . esc_html__( 'STATUS: Inactive', 'auto-tags-smart' ) . '</h3>';
}
?>

<table class="form-table">
<tr>
<td>
<input type="checkbox" id="autotasm-turn-on" name="autotasm_turn_on" value="1" <?php checked( get_option( 'autotasm_turn_on' ) ); ?> />
<label for="autotasm-turn-on"><strong><?php esc_html_e( 'Enable Auto Tags Smart', 'auto-tags-smart' ); ?></strong></label>
<p class="description"><?php esc_html_e( 'Enables automatic detection of existing tags in posts.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="autotasm-block-manually-added-tags" name="autotasm_block_manually_added_tags" value="1" <?php checked( get_option( 'autotasm_block_manually_added_tags' ) ); ?> />
<label for="autotasm-block-manually-added-tags"><?php esc_html_e( 'Block manually added tags', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Removes manually added tags and uses only automatically detected ones.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="autotasm-examine-post-title" name="autotasm_examine_post_title" value="1" <?php checked( get_option( 'autotasm_examine_post_title' ) ); ?> />
<label for="autotasm-examine-post-title"><?php esc_html_e( 'Examine post title', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Analyzes the post title to find tags.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="autotasm-examine-post-content" name="autotasm_examine_post_content" value="1" <?php checked( get_option( 'autotasm_examine_post_content' ) ); ?> />
<label for="autotasm-examine-post-content"><?php esc_html_e( 'Examine post content', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Analyzes the post content to find tags.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="autotasm-filter-by-category" name="autotasm_filter_by_category" value="1" <?php checked( get_option( 'autotasm_filter_by_category' ) ); ?> />
<label for="autotasm-filter-by-category"><?php esc_html_e( 'Filter by category', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Only applies tags to posts in selected categories.', 'auto-tags-smart' ); ?></p>
</td>
</tr>
</table>

<h3><?php esc_html_e( 'Tag Length', 'auto-tags-smart' ); ?></h3>

<table class="form-table">
<tr>
<td>
<input type="number" id="autotasm-minimum-tag-length" name="autotasm_minimum_tag_length" value="<?php echo esc_attr( get_option( 'autotasm_minimum_tag_length', 3 ) ); ?>" min="1" max="50" />
<p class="description"><?php esc_html_e( 'Tags with fewer characters than this will be ignored.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="autotasm-case-sensitive" name="autotasm_case_sensitive" value="1" <?php checked( get_option( 'autotasm_case_sensitive' ) ); ?> />
<label for="autotasm-case-sensitive"><?php esc_html_e( 'Case sensitive', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Whether tag matching should be case sensitive.', 'auto-tags-smart' ); ?></p>
</td>
</tr>
</table>

<div id="included-categories" class="<?php echo get_option( 'autotasm_filter_by_category' ) ? '' : 'softened'; ?>" style="margin-bottom: 8px;">
	<h3 style="margin: 0;"><?php esc_html_e( 'Included Categories', 'auto-tags-smart' ); ?></h3>
</div>

<div id="categories-container" class="<?php echo get_option( 'autotasm_filter_by_category' ) ? '' : 'softened'; ?>" style="<?php echo get_option( 'autotasm_filter_by_category' ) ? '' : 'display: none;'; ?>">

<?php
$cat_args   = array(
	'hide_empty' => 0,
);
$categories = get_categories( $cat_args );

foreach ( $categories as $key => $value ) {
	echo '<div class="category-block">' . "\n";
	echo '<input type="checkbox" class="chkbx" id="autotasm-included-categories-' . esc_attr( $value->term_id ) . '" name="autotasm_included_categories[]" value="' . esc_attr( $value->term_id ) . '"';

	// Verificar se a categoria está selecionada
	if ( in_array( $value->term_id, autotasm_included_categories(), true ) ) {
		echo ' checked="checked"';
	}

	echo ' />' . "\n";
	echo '<label for="autotasm-included-categories-' . esc_attr( $value->term_id ) . '">' . esc_html( $value->name ) . '</label>' . "\n";
	echo '</div>' . "\n";
}
?>

</div>

<h3><?php esc_html_e( 'Clean Uninstall', 'auto-tags-smart' ); ?></h3>

<table class="form-table">
<tr>
<td>
<input type="checkbox" id="autotasm-clean-uninstall" name="autotasm_clean_uninstall" value="1" <?php checked( get_option( 'autotasm_clean_uninstall' ) ); ?> />
<label for="autotasm-clean-uninstall"><?php esc_html_e( 'Remove all options from database', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'When uninstalling, remove all plugin options from the database.', 'auto-tags-smart' ); ?></p>
</td>
</tr>
</table>

<?php submit_button(); ?>

</form>

</div>
