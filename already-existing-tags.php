<?php
/**
 * Compatibility loader for legacy plugin file name.
 *
 * Keeps older installs working after renaming the main plugin file.
 */

defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );

require_once __DIR__ . '/auto-tags-smart.php';
