=== Auto Tags Smart ===

Contributors: maisondasilva
Donate link: https://maisondasilva.com.br
Tags: automatic tags, auto tagging, smart tagging, tags, content
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically detects and assigns existing tags to posts using smart content analysis with advanced filtering options.

== Description ==

Auto Tags Smart is an advanced automatic tagging system that intelligently detects and assigns existing tags to your posts.

= Key Features =

* **Smart Detection**: Analyzes post titles and content to find matching tags
* **Advanced Settings**: Full control over how tags are detected and applied
* **Category Filters**: Apply automatic tags only to specific categories
* **Length Control**: Set minimum length for tags to be considered
* **Case Sensitivity**: Option to distinguish between uppercase and lowercase
* **Modern Interface**: Clean and intuitive admin panel
* **Statistics**: View your blog statistics directly in the dashboard

= Advanced Features =

* Block manual tags (optional)
* Content relevance analysis
* Automatic suggestion of new tags based on content
* Complete cleanup on uninstall
* Compatibility with latest WordPress hooks

= How It Works =

1. Install and activate the plugin
2. Configure options in the "Auto Tags" page under Posts menu
3. Choose whether to examine titles, content, or both
4. Set up category filters if needed
5. Adjust advanced settings according to your needs
6. Save settings and start creating posts!

The plugin will automatically detect existing tags in your content and apply them to posts.

= Requirements =

* WordPress 5.0 or higher
* PHP 7.4 or higher
* Minimum memory: 64MB

== Installation ==

1. Upload the 'auto-tags' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Posts > Auto Tags to configure options
4. Configure options according to your needs
5. Save settings and start using!

= Manual Installation =

1. Download the plugin zip file
2. Extract files to '/wp-content/plugins/auto-tags'
3. Activate the plugin in the admin panel
4. Configure options in Posts > Auto Tags

== Frequently Asked Questions ==

= O plugin funciona com posts já existentes? =

Sim! O plugin funciona quando você edita e salva posts existentes. Para aplicar tags a todos os posts existentes de uma vez, você pode usar a funcionalidade de atualização em massa do WordPress.

= Posso escolher quais categorias serão afetadas? =

Sim! Você pode ativar o filtro por categoria e selecionar exatamente quais categorias devem ter tags aplicadas automaticamente.

= O plugin cria novas tags? =

Não, o plugin apenas detecta e aplica tags que já existem no seu blog. Ele não cria novas tags automaticamente.

= Como posso ver quais tags foram aplicadas? =

Você pode ver as tags aplicadas na área de edição do post, assim como qualquer outra tag. O plugin também mantém estatísticas no painel de administração.

= O plugin afeta a performance do site? =

O plugin é otimizado para performance e só executa durante a criação/edição de posts. Não afeta a velocidade de carregamento das páginas para visitantes.

= Can I temporarily disable the plugin? =

Yes! You can uncheck the "Enable Auto Tags" option in settings to temporarily disable without uninstalling the plugin.

= Are settings lost when uninstalling? =

This depends on the "Clean Uninstall" setting. If enabled, all settings will be removed. If not, they will remain in the database.

== Screenshots ==

1. Main Auto Tags settings panel
2. Advanced settings and category filters
3. Plugin statistics and information
4. Real-time operation status

== Changelog ==

= 1.0 =
* Initial release of Auto Tags Smart
* Smart detection of existing tags with WordPress.org compliance
* Proper wp_enqueue_script() and wp_enqueue_style() implementation
* Secure function prefixes (autotasm_) meeting 4+ character requirement
* Advanced filter settings with category selection
* Modern and responsive interface
* Minimum tag length control
* Case sensitivity option
* Translation support via wp_localize_script()
* Statistics system
* Complete cleanup on uninstall

== Upgrade Notice ==

= 1.0 =
First release of Auto Tags Smart with full WordPress.org compliance. Features smart tag detection, advanced filtering, and modern interface with proper security implementation.

== Developer Notes ==

Auto Tags Smart was developed following WordPress best practices:

* Uses appropriate hooks and filters
* Well-documented and organized code
* Compatible with latest WordPress versions
* Performance optimized
* Responsive interface
* Security implemented (nonces, sanitization, validation)

= Available Hooks =

* `at_before_tagging` - Executed before tag application
* `at_after_tagging` - Executed after tag application
* `at_tag_found` - Executed when a tag is found
* `at_excluded_tag` - Executed when a tag is excluded

= Available Filters =

* `at_minimum_tag_length` - Modifies minimum tag length
* `at_content_to_analyze` - Modifies content to be analyzed
* `at_found_tags` - Modifies found tags before application

== Support ==

For support, questions or suggestions:

* Documentation: Available in admin panel
* GitHub: https://github.com/maisondasilva/auto-tags-smart
* WordPress: https://wordpress.org/plugins/auto-tags-smart

== License ==

This plugin is licensed under GPL v2 or later.

Copyright (C) 2025 Auto Tags Smart

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
