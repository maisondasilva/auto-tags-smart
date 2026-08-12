=== Auto Tags Inteligentes ===

Contributors: maisondasilva
Tags:  automatic tags, auto tagger, auto tagging, tagging, tags
Requires at least: 4.0
Tested up to: 5.7
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Looks for already existing tags within your posts.


== Description ==

This plugin detects your 'already existing tags' into your post each time you create or edit/save one. The found tags will be automatically assigned.

= Features =

* Easy configuration.
* Allow or block manually added tags; the choice is yours.
* You can choose if the plugin examines the title, the content or both.
* You can activate a filter and select which categories will be affected and which ones will be ignored by the plugin.
* Clean uninstall option: If this option is enabled, the plugin will leave absolutely no traces when uninstalling.
* Visit [digitalemphasis.com](https://digitalemphasis.com) for more info.


== Installation ==

1. Upload the 'auto-tags-smart' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the plugin through the 'Posts -> Auto Tags Inteligentes' administration panel.


== Frequently Asked Questions ==

= Will the automatic tagging function start once the plugin is installed and activated? =
No. By default, 'Turn on' is unchecked and no category is selected.

= From now on I want to examine just the tittle or just the content, but after editing the post all the previous tags are still there, why? =
Because the 'Block manually added tags' option is disabled. With this option enabled, all the previous tags are removed before adding the new ones.

= My language uses non-latin characters. Can I use this plugin? =
Yes. As long as you use valid UTF-8 characters, the plugin will work.


== Screenshots ==

1. Auto Tags Inteligentes - administration panel


== Changelog ==

= 2.4 =
* Fixed: the plugin should work with all posts when 'Filter by category' is disabled regardless of the previous selected categories when 'Filter by category' was enabled.

= 2.3 =
* Ensure compatibility with WordPress 5.7
* New option: examine post content is optional from now on.
* Slight changes at the administration panel.

= 2.2 =
* Ensure compatibility with WordPress 5.2, 5.3, 5.4, 5.5 and 5.6
* From now on, the plugin uses the new 'wp_after_insert_post' function (WordPress >= 5.6) if available.
* Better explained settings.
* Code optimization.

= 2.1 =
* Ensure compatibility with WordPress 5.0 and 5.1
* New option: filter by category is optional from now on.
* Code optimization.

= 2.0 =
* Ensure compatibility with WordPress 4.8 and 4.9
* Improved adherence to WordPress Coding Standards.

= 1.9 =
* Ensure compatibility with WordPress 4.6 and 4.7
* New option: block manually added tags. From now on, manually added tags are allowed by default. Check the new option if you prefer the old behaviour.
* Improved adherence to WordPress Coding Standards.
* Code optimization.

= 1.8 =
* Fixed: moving data from 'aet_automatic_tagging_included_categories' to 'aet_included_categories'.

= 1.7 =
* Ensure compatibility with WordPress 4.5
* New option: examine post title.
* Improved security: data escaping on output.
* Improved the HTML output.
* Code optimization.

= 1.6 =
* Ensure compatibility with WordPress 4.4
* Added Unicode support.

= 1.5 =
* Ensure compatibility with WordPress 4.3
* Improved adherence to WordPress Coding Standards.
* Improved regex performance.

= 1.4 =
* Ensure compatibility with WordPress 4.2
* Added 'check/uncheck' all categories and other slight changes at the administration panel.

= 1.3 =
* Ensure compatibility with WordPress 4.1
* Added support for 'QUICK' and 'BULK' edit modes.
* Slight changes at the administration panel.

= 1.2 =
* Ensure compatibility with WordPress 4.0
* Added 'Do you like this plugin?' section to the administration panel.

= 1.1 =
* From now on, the .php files of the plugin are protected from direct access.
* Fixed a bug with the .css style of the administration panel in some environments.
* Fixed some other small bugs when WP_DEBUG is enabled.

= 1.0 =
* Initial release.
