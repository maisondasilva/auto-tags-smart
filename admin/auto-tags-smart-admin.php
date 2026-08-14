<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
?>

<div class="wrap">

<div class="aets-admin">
	<div class="aets-hero">
		<h1><?php esc_html_e( 'Auto Tags Smart', 'auto-tags-smart' ); ?></h1>
		<p><?php esc_html_e( 'Automatically tag posts using existing tags.', 'auto-tags-smart' ); ?></p>
	</div>

	<?php settings_errors(); ?>

	<form action="options.php" method="post" class="aets-form">

	<?php
	settings_fields( 'aets_settings_group' );

	if ( get_option( 'aets_turn_on' ) && ! aets_halt() ) {
		$aets_status_class = 'enabled';
		$aets_status_text  = __( 'Enabled', 'auto-tags-smart' );
	} elseif ( get_option( 'aets_turn_on' ) && aets_halt() ) {
		$aets_status_class = 'warning';
		$aets_status_text  = __( 'Enabled, but there is nothing to examine', 'auto-tags-smart' );
	} else {
		$aets_status_class = 'disabled';
		$aets_status_text  = __( 'Disabled', 'auto-tags-smart' );
	}
	?>

	<div class="aets-status aets-status-<?php echo esc_attr( $aets_status_class ); ?>">
		<strong><?php esc_html_e( 'Status', 'auto-tags-smart' ); ?>:</strong>
		<span><?php echo esc_html( $aets_status_text ); ?></span>
	</div>

	<section class="aets-card">
		<h2><?php esc_html_e( 'Main Settings', 'auto-tags-smart' ); ?></h2>
		<table class="form-table">
			<tr>
				<td>
					<input type="checkbox" id="aets-turn-on" name="aets_turn_on" value="1" <?php checked( get_option( 'aets_turn_on' ) ); ?> />
					<label for="aets-turn-on"><?php esc_html_e( 'Turn on plugin.', 'auto-tags-smart' ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aets-block-manually-added-tags" name="aets_block_manually_added_tags" value="1" <?php checked( get_option( 'aets_block_manually_added_tags' ) ); ?> />
					<label for="aets-block-manually-added-tags"><?php esc_html_e( 'Block manually added tags (previous tags are removed on update).', 'auto-tags-smart' ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aets-examine-post-title" name="aets_examine_post_title" value="1" <?php checked( get_option( 'aets_examine_post_title' ) ); ?> />
					<label for="aets-examine-post-title"><?php esc_html_e( 'Examine post title.', 'auto-tags-smart' ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aets-examine-post-content" name="aets_examine_post_content" value="1" <?php checked( get_option( 'aets_examine_post_content' ) ); ?> />
					<label for="aets-examine-post-content"><?php esc_html_e( 'Examine post content.', 'auto-tags-smart' ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aets-filter-by-category" name="aets_filter_by_category" value="1" <?php checked( get_option( 'aets_filter_by_category' ) ); ?> />
					<label for="aets-filter-by-category"><?php esc_html_e( 'Filter by category.', 'auto-tags-smart' ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aets-create-missing-tags" name="aets_create_missing_tags" value="1" <?php checked( get_option( 'aets_create_missing_tags' ) ); ?> />
					<label for="aets-create-missing-tags"><?php esc_html_e( 'Create missing tags from analyzed content.', 'auto-tags-smart' ); ?></label>
				</td>
			</tr>
		</table>
	</section>

	<section class="aets-card">
		<div class="aets-categories-header">
			<h2 id="aets-included-categories" class="<?php echo get_option( 'aets_filter_by_category' ) ? '' : 'aets-softened'; ?>"><?php esc_html_e( 'Included Categories', 'auto-tags-smart' ); ?></h2>
			<div class="aets-category-actions">
				<button type="button" id="aets-select-all-categories" class="button button-secondary"><?php esc_html_e( 'Select all', 'auto-tags-smart' ); ?></button>
				<button type="button" id="aets-clear-all-categories" class="button button-secondary"><?php esc_html_e( 'Clear all', 'auto-tags-smart' ); ?></button>
			</div>
		</div>

		<div id="aets-categories-container" class="<?php echo get_option( 'aets_filter_by_category' ) ? '' : 'aets-softened'; ?>">

		<?php
		$aets_cat_args = array(
			'hide_empty' => 0,
		);
		$aets_categories = get_categories( $aets_cat_args );

		foreach ( $aets_categories as $aets_category ) {
			echo '<div class="aets-category-block">' . "\n";
			echo '<input type="checkbox" class="aets-chkbx" id="aets-included-categories-' . esc_attr( $aets_category->term_id ) . '" name="aets_included_categories[]" value="' . esc_attr( $aets_category->term_id ) . '"';

			if ( in_array( $aets_category->term_id, aets_included_categories(), true ) ) {
				echo ' checked="checked"';
			}

			echo ' />' . "\n";
			echo '<label for="aets-included-categories-' . esc_attr( $aets_category->term_id ) . '">' . esc_html( $aets_category->name ) . '</label>' . "\n";
			echo '</div>' . "\n";
		}
		?>

		<div id="aets-categories-container-mask" class="<?php echo get_option( 'aets_filter_by_category' ) ? '' : 'aets-active'; ?>"></div>
		</div>
	</section>

	<section class="aets-card">
		<h2><?php esc_html_e( 'Clean Uninstall', 'auto-tags-smart' ); ?></h2>
		<table class="form-table">
			<tr>
				<td>
					<input type="checkbox" id="aets-clean-uninstall" name="aets_clean_uninstall" value="1" <?php checked( get_option( 'aets_clean_uninstall' ) ); ?> />
					<label for="aets-clean-uninstall"><?php esc_html_e( 'Delete all options from database when deleting this plugin.', 'auto-tags-smart' ); ?></label>
				</td>
			</tr>
		</table>
	</section>

	<div class="aets-submit-wrap">
		<?php submit_button( __( 'Save Changes', 'auto-tags-smart' ) ); ?>
	</div>

	</form>

	<div class="aets-footer-note">
		<h3><?php esc_html_e( 'Do you like this plugin?', 'auto-tags-smart' ); ?></h3>
		<p>
			<a href="https://github.com/maisondasilva/auto-tags-smart" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Rate it on the repository.', 'auto-tags-smart' ); ?></a>
		</p>
		<p><?php esc_html_e( 'Thank you!', 'auto-tags-smart' ); ?></p>
		<p>Versão <?php echo esc_html( AETS_PLUGIN_VER ); ?> | Por <a href="https://maisondasilva.com.br/" target="_blank" rel="noopener noreferrer">Maison da Silva</a></p>
	</div>
</div>

</div>
