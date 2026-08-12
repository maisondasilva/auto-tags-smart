# Auto Tags Smart

Auto Tags Smart is a WordPress plugin that automatically assigns existing tags to posts by scanning the title and/or content.

It helps you reuse the tags you already created instead of manually tagging posts one by one, and can optionally create missing tags from analyzed content.

## Features

- Automatically assigns existing tags when a post is created or updated.
- Option to scan the post title, the post content, or both.
- Optional creation of missing tags from analyzed content.
- Option to block manually added tags and replace them with detected tags.
- Optional category filter to limit which posts are processed.
- Bulk actions to select or clear all categories in the admin screen.
- Clean uninstall option to remove plugin settings from the database.
- Translation support with `languages/` files.
- Dynamic candidate limits by post size: 10, 14, 20, and max 25.

## Requirements

- WordPress 4.0 or higher
- PHP 7.0 or higher recommended

## Installation

1. Upload the `auto-tags-smart` folder to `/wp-content/plugins/`.
2. Activate the plugin from the WordPress Plugins screen.
3. Open `Posts -> Auto Tags Smart` and configure the options.

## How It Works

When a post is saved, the plugin checks the selected fields:

- Title
- Content
- Categories

If a tag already exists in the site and matches the post text, it is added automatically to the post.

If missing-tag creation is enabled, the plugin can create tags from analyzed content (title, content, or both depending on your settings).

## Translation

The plugin supports translations through the `languages/` folder.

- English is used as the code base for easier maintenance.
- Portuguese is available for `pt_BR`.
- If your site is set to Portuguese, the admin interface will display Portuguese text.

## Project Structure

- `auto-tags-smart.php` - main plugin loader
- `auto-tags-smart-core.php` - tagging logic
- `admin/auto-tags-smart-admin.php` - admin page markup
- `admin/auto-tags-smart-admin.css` - admin styles
- `admin/auto-tags-smart-admin.js` - admin behavior
- `languages/` - translation files

## Screenshots

The plugin includes a clean admin panel with:

- Toggle options for tagging behavior
- Category selection controls
- Select all / clear all actions
- Compact modern layout

## Changelog

### 1.0.4

- Release version bump and packaging sync.

### 1.0.3

- Unique plugin version constant to avoid constant collision in older environments.

### 1.0.2

- Optional creation of missing tags from analyzed content.
- Dynamic candidate limits by analyzed text size (10/14/20/25).

### 1.0.1

- Improved admin layout spacing
- Better category controls
- Version bump for cache busting

### 1.0

- Initial public release under the new branding

## License

GPLv2 or later

## Author

Maison da Silva

- Website: https://maisondasilva.com.br/
- Repository: https://github.com/maisondasilva/auto-tags-smart
