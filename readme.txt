=== Auto Tags Smart ===

Contributors: maisondasilva
Tags: automatic tags, auto tagger, auto tagging, tagging, tags
Requires at least: 4.0
Tested up to: 7.0
Stable tag: 1.0.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically assign existing tags to posts based on their title and/or content.


== Description ==

Auto Tags Inteligentes scans posts when they are created or updated and automatically adds matching tags that already exist on your site.

The plugin is designed to keep your tagging workflow fast and consistent while avoiding duplicate tag creation. When title analysis is enabled, it can also create a tag from the post title if no match exists.

= Features =

* Automatically assigns existing tags to posts.
* Scan the post title, the content, or both.
* Optional creation of a new tag from the post title.
* Option to replace manually added tags with detected tags.
* Optional category filter to limit which posts are processed.
* Select all / clear all category controls in the admin screen.
* Clean uninstall option to remove plugin options from the database.
* English code base with translation support through the `languages/` folder.


== Installation ==

1. Upload the `auto-tags-smart` folder to `/wp-content/plugins/`.
2. Activate the plugin in the WordPress Plugins screen.
3. Open `Posts -> Auto Tags Inteligentes` and configure the settings.


== Frequently Asked Questions ==

= Will the automatic tagging start immediately after activation? =
No. By default, the plugin ships with the main toggle disabled.

= What happens if category filtering is enabled but no categories are selected? =
The plugin will not process posts until at least one category is selected.

= Can I use the plugin with non-Latin characters? =
Yes. The plugin works with valid UTF-8 characters.


== Screenshots ==

1. Auto Tags Inteligentes - administration panel


== Changelog ==

= 1.0.1 =
* Improved admin layout spacing
* Better category controls
* Added cache-busting version bump
* Updated translation handling

= 1.0.4 =
* Version bump for release packaging.

= 1.0.3 =
* Updated plugin version constant to avoid conflicts with older installs or other plugins.

= 1.0.2 =
* Optional creation of tags from the post title
* New admin toggle for missing tag creation

= 1.0 =
* Initial public release under the new branding
