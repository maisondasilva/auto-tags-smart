<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
?>

<div class="wrap">

<div class="aet-admin">
	<div class="aet-hero">
		<h1><?php esc_html_e( 'Auto Tags Inteligentes', AET_TEXT_DOMAIN ); ?></h1>
		<p><?php esc_html_e( 'Automatically tag posts using existing tags.', AET_TEXT_DOMAIN ); ?></p>
	</div>

	<?php settings_errors(); ?>

	<form action="options.php" method="post" class="aet-form">

	<?php
	settings_fields( 'aet-settings-group' );

	if ( get_option( 'aet_turn_on' ) && ! aet_halt() ) {
		$status_class = 'enabled';
		$status_text  = __( 'Enabled', AET_TEXT_DOMAIN );
	} elseif ( get_option( 'aet_turn_on' ) && aet_halt() ) {
		$status_class = 'warning';
		$status_text  = __( 'Enabled, but there is nothing to examine', AET_TEXT_DOMAIN );
	} else {
		$status_class = 'disabled';
		$status_text  = __( 'Disabled', AET_TEXT_DOMAIN );
	}
	?>

	<div class="aet-status aet-status-<?php echo esc_attr( $status_class ); ?>">
		<strong><?php esc_html_e( 'Status', AET_TEXT_DOMAIN ); ?>:</strong>
		<span><?php echo esc_html( $status_text ); ?></span>
	</div>

	<section class="aet-card">
		<h2><?php esc_html_e( 'Main Settings', AET_TEXT_DOMAIN ); ?></h2>
		<table class="form-table">
			<tr>
				<td>
					<input type="checkbox" id="aet-turn-on" name="aet_turn_on" value="1" <?php checked( get_option( 'aet_turn_on' ) ); ?> />
					<label for="aet-turn-on"><?php esc_html_e( 'Turn on plugin.', AET_TEXT_DOMAIN ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aet-block-manually-added-tags" name="aet_block_manually_added_tags" value="1" <?php checked( get_option( 'aet_block_manually_added_tags' ) ); ?> />
					<label for="aet-block-manually-added-tags"><?php esc_html_e( 'Block manually added tags (previous tags are removed on update).', AET_TEXT_DOMAIN ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aet-examine-post-title" name="aet_examine_post_title" value="1" <?php checked( get_option( 'aet_examine_post_title' ) ); ?> />
					<label for="aet-examine-post-title"><?php esc_html_e( 'Examine post title.', AET_TEXT_DOMAIN ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aet-examine-post-content" name="aet_examine_post_content" value="1" <?php checked( get_option( 'aet_examine_post_content' ) ); ?> />
					<label for="aet-examine-post-content"><?php esc_html_e( 'Examine post content.', AET_TEXT_DOMAIN ); ?></label>
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" id="aet-filter-by-category" name="aet_filter_by_category" value="1" <?php checked( get_option( 'aet_filter_by_category' ) ); ?> />
					<label for="aet-filter-by-category"><?php esc_html_e( 'Filter by category.', AET_TEXT_DOMAIN ); ?></label>
				</td>
			</tr>
		</table>
	</section>

	<section class="aet-card">
		<div class="aet-categories-header">
			<h2 id="included-categories" class="<?php echo get_option( 'aet_filter_by_category' ) ? '' : 'softened'; ?>"><?php esc_html_e( 'Included Categories', AET_TEXT_DOMAIN ); ?></h2>
			<div class="aet-category-actions">
				<button type="button" id="aet-select-all-categories" class="button button-secondary"><?php esc_html_e( 'Select all', AET_TEXT_DOMAIN ); ?></button>
				<button type="button" id="aet-clear-all-categories" class="button button-secondary"><?php esc_html_e( 'Clear all', AET_TEXT_DOMAIN ); ?></button>
			</div>
		</div>

		<div id="categories-container" class="<?php echo get_option( 'aet_filter_by_category' ) ? '' : 'softened'; ?>">

		<?php
		$cat_args   = array(
			'hide_empty' => 0,
		);
		$categories = get_categories( $cat_args );

		foreach ( $categories as $value ) {
			echo '<div class="category-block">' . "\n";
			echo '<input type="checkbox" class="chkbx" id="aet-included-categories-' . esc_attr( $value->term_id ) . '" name="aet_included_categories[]" value="' . esc_attr( $value->term_id ) . '"';

			if ( in_array( $value->term_id, aet_included_categories(), true ) ) {
				echo ' checked="checked"';
			}

			echo ' />' . "\n";
			echo '<label for="aet-included-categories-' . esc_attr( $value->term_id ) . '">' . esc_html( $value->name ) . '</label>' . "\n";
			echo '</div>' . "\n";
		}
		?>

		<div id="categories-container-mask" class="<?php echo get_option( 'aet_filter_by_category' ) ? '' : 'active'; ?>"></div>
		</div>
	</section>

	<section class="aet-card">
		<h2><?php esc_html_e( 'Clean Uninstall', AET_TEXT_DOMAIN ); ?></h2>
		<table class="form-table">
			<tr>
				<td>
					<input type="checkbox" id="aet-clean-uninstall" name="aet_clean_uninstall" value="1" <?php checked( get_option( 'aet_clean_uninstall' ) ); ?> />
					<label for="aet-clean-uninstall"><?php esc_html_e( 'Delete all options from database when deleting this plugin.', AET_TEXT_DOMAIN ); ?></label>
				</td>
			</tr>
		</table>
	</section>

	<div class="aet-submit-wrap">
		<?php submit_button( __( 'Save Changes', AET_TEXT_DOMAIN ) ); ?>
	</div>

	</form>

	<div class="aet-footer-note">
		<h3><?php esc_html_e( 'Do you like this plugin?', AET_TEXT_DOMAIN ); ?></h3>
		<p>
			<a href="https://github.com/maisondasilva/auto-tags-smart" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Rate it on the repository.', AET_TEXT_DOMAIN ); ?></a>
		</p>
		<p><?php esc_html_e( 'Thank you!', AET_TEXT_DOMAIN ); ?></p>
		<p>Versão 1.0 | Por <a href="https://maisondasilva.com.br/" target="_blank" rel="noopener noreferrer">Maison da Silva</a></p>
	</div>
</div>

</div>
