<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
?>

<div class="wrap">

<h2><?php esc_html_e( 'Auto Tags Smart', 'auto-tags-smart' ); ?></h2>

<script>
// Translated strings for JavaScript
var atStrings = {
	selectAll: '<?php echo esc_js( __( 'Select All', 'auto-tags-smart' ) ); ?>',
	deselectAll: '<?php echo esc_js( __( 'Deselect All', 'auto-tags-smart' ) ); ?>',
	statusActive: '<?php echo esc_js( __( 'STATUS: Active ✓', 'auto-tags-smart' ) ); ?>',
	statusActiveNothing: '<?php echo esc_js( __( 'STATUS: Active but nothing to examine', 'auto-tags-smart' ) ); ?>',
	statusInactive: '<?php echo esc_js( __( 'STATUS: Inactive', 'auto-tags-smart' ) ); ?>'
};
</script>

<?php settings_errors(); ?>

<form action="options.php" method="post">

<?php
settings_fields( 'at-settings-group' );

// Verificar se o plugin está realmente ativo
$is_plugin_enabled = get_option( 'at_turn_on' );
$has_something_to_examine = !at_halt();

if ( $is_plugin_enabled && $has_something_to_examine ) {
	echo '<h3 id="at-status" style="color: green;" class="at-status-active">' . esc_html__( 'STATUS: Active ✓', 'auto-tags-smart' ) . '</h3>';
} elseif ( $is_plugin_enabled && !$has_something_to_examine ) {
	echo '<h3 id="at-status" style="color: orange;" class="at-status-warning">' . esc_html__( 'STATUS: Active but nothing to examine', 'auto-tags-smart' ) . '</h3>';
} else {
	echo '<h3 id="at-status" style="color: red;" class="at-status-inactive">' . esc_html__( 'STATUS: Inactive', 'auto-tags-smart' ) . '</h3>';
}
?>

<table class="form-table">
<tr>
<td>
<input type="checkbox" id="at-turn-on" name="at_turn_on" value="1" <?php checked( get_option( 'at_turn_on' ) ); ?> />
<label for="at-turn-on"><strong><?php esc_html_e( 'Enable Auto Tags Smart', 'auto-tags-smart' ); ?></strong></label>
<p class="description"><?php esc_html_e( 'Enables automatic detection of existing tags in posts.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="at-block-manually-added-tags" name="at_block_manually_added_tags" value="1" <?php checked( get_option( 'at_block_manually_added_tags' ) ); ?> />
<label for="at-block-manually-added-tags"><?php esc_html_e( 'Block manually added tags', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Removes manually added tags and uses only automatically detected ones.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="at-examine-post-title" name="at_examine_post_title" value="1" <?php checked( get_option( 'at_examine_post_title' ) ); ?> />
<label for="at-examine-post-title"><?php esc_html_e( 'Examine post title', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Search for tags in the post title.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="at-examine-post-content" name="at_examine_post_content" value="1" <?php checked( get_option( 'at_examine_post_content' ) ); ?> />
<label for="at-examine-post-content"><?php esc_html_e( 'Examine post content', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Search for tags in the post content.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="at-filter-by-category" name="at_filter_by_category" value="1" <?php checked( get_option( 'at_filter_by_category' ) ); ?> />
<label for="at-filter-by-category"><?php esc_html_e( 'Filter by category', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Apply automatic tags only to specific categories.', 'auto-tags-smart' ); ?></p>
</td>
</tr>
</table>

<h3><?php esc_html_e( 'Minimum tag length', 'auto-tags-smart' ); ?></h3>

<table class="form-table">
<tr>
<td>
<input type="number" id="at-minimum-tag-length" name="at_minimum_tag_length" value="<?php echo esc_attr( get_option( 'at_minimum_tag_length', 3 ) ); ?>" min="1" max="50" />
<p class="description"><?php esc_html_e( 'Tags with fewer characters than this will be ignored.', 'auto-tags-smart' ); ?></p>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="at-case-sensitive" name="at_case_sensitive" value="1" <?php checked( get_option( 'at_case_sensitive' ) ); ?> />
<label for="at-case-sensitive"><?php esc_html_e( 'Case sensitive', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'If enabled, "PHP" and "php" will be treated as different tags.', 'auto-tags-smart' ); ?></p>
</td>
</tr>
</table>

<div id="included-categories" class="<?php echo get_option( 'at_filter_by_category' ) ? '' : 'softened'; ?>" style="display: flex; align-items: center; margin-bottom: 8px;">
	<h3 style="margin: 0; margin-right: 15px;"><?php esc_html_e( 'Included Categories', 'auto-tags-smart' ); ?></h3>
</div>

<div id="categories-container" class="<?php echo get_option( 'at_filter_by_category' ) ? '' : 'softened'; ?>" style="<?php echo get_option( 'at_filter_by_category' ) ? '' : 'display: none;'; ?>">

<?php
$cat_args   = array(
	'hide_empty' => 0,
);
$categories = get_categories( $cat_args );

foreach ( $categories as $key => $value ) {
	echo '<div class="category-block">' . "\n";
	echo '<input type="checkbox" class="chkbx" id="at-included-categories-' . esc_attr( $value->term_id ) . '" name="at_included_categories[]" value="' . esc_attr( $value->term_id ) . '"';

	// Verificar se a categoria está selecionada
	if ( in_array( $value->term_id, at_included_categories(), true ) ) {
		echo ' checked="checked"';
	}

	echo ' />' . "\n";
	echo '<label for="at-included-categories-' . esc_attr( $value->term_id ) . '">' . esc_html( $value->name ) . '</label>' . "\n";
	echo '</div>' . "\n";
}
?>

</div>

<h3><?php esc_html_e( 'Clean Uninstall', 'auto-tags-smart' ); ?></h3>

<table class="form-table">
<tr>
<td>
<input type="checkbox" id="at-clean-uninstall" name="at_clean_uninstall" value="1" <?php checked( get_option( 'at_clean_uninstall' ) ); ?> />
<label for="at-clean-uninstall"><?php esc_html_e( 'Remove all options from database', 'auto-tags-smart' ); ?></label>
<p class="description"><?php esc_html_e( 'Removes all plugin settings when uninstalled (not on deactivation).', 'auto-tags-smart' ); ?></p>
</td>
</tr>
</table>

<?php submit_button( esc_html__( 'Save Settings', 'auto-tags-smart' ) ); ?>

</form>

<div style="margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-left: 4px solid #0073aa; font-size: 14px;">
	<p style="margin: 0; color: #555;">
		<?php esc_html_e( 'Developed by', 'auto-tags-smart' ); ?> 
		<a href="https://maisondasilva.com.br" target="_blank" rel="noopener noreferrer" style="color: #0073aa; text-decoration: none; font-weight: bold;">
			Maison da Silva
		</a>
	</p>
</div>

</div>

<style>
.softened {
	opacity: 0.3;
}

#categories-container {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
	gap: 8px;
	margin: 15px 0;
	padding: 0;
	background: transparent;
	border: none;
}

#categories-container-mask {
	display: none;
}

#categories-container-mask.active {
	display: none;
}

.category-block {
	background: transparent;
	border: none;
	padding: 3px 0;
	display: flex;
	align-items: center;
	font-size: 13px;
}

.category-block input[type="checkbox"] {
	margin: 0 6px 0 0;
}

.category-block label {
	cursor: pointer;
	flex: 1;
	margin: 0;
	font-size: 13px;
	color: #444;
}

.form-table td {
	padding: 15px 10px;
}

.description {
	font-style: italic;
	color: #666;
	margin-top: 5px;
}

/* Responsive adjustments */
@media (max-width: 782px) {
	#categories-container {
		grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
	}
}</style>
