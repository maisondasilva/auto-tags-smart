# Auto Tags Inteligentes

Auto Tags Inteligentes is a WordPress plugin that automatically assigns existing tags to posts by scanning the title and/or content.

It helps you reuse the tags you already created instead of manually tagging posts one by one, and can optionally create a new tag from the post title when no match exists.

## Features

- Automatically assigns existing tags when a post is created or updated.
- Option to scan the post title, the post content, or both.
- Optional creation of a new tag from the post title when title analysis is enabled.
- Option to block manually added tags and replace them with detected tags.
- Optional category filter to limit which posts are processed.
- Bulk actions to select or clear all categories in the admin screen.
- Clean uninstall option to remove plugin settings from the database.
- Translation support with `languages/` files.

## Requirements

- WordPress 4.0 or higher
- PHP 7.0 or higher recommended

## Installation

1. Upload the `auto-tags-smart` folder to `/wp-content/plugins/`.
2. Activate the plugin from the WordPress Plugins screen.
3. Open `Posts -> Auto Tags Inteligentes` and configure the options.

## How It Works

When a post is saved, the plugin checks the selected fields:

- Title
- Content
- Categories

If a tag already exists in the site and matches the post text, it is added automatically to the post.

If title analysis is enabled and the new option is turned on, the plugin can create a tag from the post title when no matching tag exists yet.

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

### 1.0.1

- Improved admin layout spacing
- Better category controls
- Version bump for cache busting

### 1.0.2

- Optional creation of tags from the post title
- New admin toggle for missing tag creation

### 1.0

- Initial public release under the new branding

## License

GPLv2 or later

## Author

Maison da Silva

- Website: https://maisondasilva.com.br/
- Repository: https://github.com/maisondasilva/auto-tags-smart
