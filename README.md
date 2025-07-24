# Auto Tags Smart

[🇧🇷 Português](#-português) | [🇺🇸 English](#-english)

---

## 🇧🇷 Português

Plugin WordPress para detecção automática e aplicação inteligente de tags existentes aos posts.

### ✨ Principais Recursos

- **🧠 Detecção Inteligente**: Analisa título e conteúdo dos posts para encontrar tags correspondentes
- **⚙️ Configurações Avançadas**: Controle total sobre como as tags são detectadas e aplicadas
- **📂 Filtros por Categoria**: Aplique tags automáticas apenas em categorias específicas
- **📏 Controle de Comprimento**: Defina o comprimento mínimo para tags serem consideradas
- **🔤 Sensibilidade de Maiúsculas**: Opção para distinguir entre maiúsculas e minúsculas
- **💫 Interface Moderna**: Painel de administração limpo e intuitivo
- **📊 Estatísticas**: Visualize estatísticas do seu blog diretamente no painel
- **🌐 Suporte a Traduções**: Português brasileiro e inglês incluídos

### 🔧 Recursos Técnicos

- ✅ **WordPress**: 5.0 ou superior
- ✅ **PHP**: 7.4 ou superior  
- 🔒 **Segurança**: Sanitização, validação e nonces implementados
- 🎣 **Hooks & Filtros**: Disponíveis para desenvolvedores
- 🧹 **Limpeza**: Remoção completa na desinstalação
- ⚡ **Performance**: Otimizado para velocidade

### 📦 Instalação

1. Baixe o arquivo ZIP mais recente das [Releases](../../releases)
2. Extraia para `/wp-content/plugins/auto-tags-smart/`
3. Ative o plugin no painel administrativo do WordPress
4. Configure as opções em **Posts → Auto Tags Smart**

### 🚀 Como Usar

1. **Configure as opções** na página "Auto Tags Smart" no menu Posts
2. **Escolha o escopo**: examinar títulos, conteúdo ou ambos
3. **Configure filtros** por categoria se necessário
4. **Ajuste configurações avançadas** conforme suas necessidades
5. **Salve e comece a criar posts!**

O plugin detectará automaticamente tags existentes no seu conteúdo e as aplicará aos posts.

### 🛠️ Para Desenvolvedores

#### Hooks Disponíveis
```php
do_action('at_before_tagging', $post_id);
do_action('at_after_tagging', $post_id, $applied_tags);
do_action('at_tag_found', $tag, $post_id);
do_action('at_excluded_tag', $tag, $post_id);
```

#### Filtros Disponíveis
```php
$min_length = apply_filters('at_minimum_tag_length', 3);
$content = apply_filters('at_content_to_analyze', $content, $post_id);
$tags = apply_filters('at_found_tags', $found_tags, $post_id);
```

### 📝 Changelog

#### v1.0
- 🎉 Lançamento inicial do Auto Tags Smart
- 🧠 Sistema completo de detecção automática de tags
- 🎨 Interface responsiva e moderna
- 📏 Controle de comprimento mínimo de tags
- 🔤 Opção de sensibilidade a maiúsculas/minúsculas
- 📂 Filtros por categoria
- 📊 Sistema de estatísticas integrado
- 🌐 Documentação completa em português e inglês

### 🆘 Suporte

- 📖 **Documentação**: Disponível no painel de administração
- 🐛 **Issues**: [GitHub Issues](../../issues)
- 💬 **Discussões**: [GitHub Discussions](../../discussions)

### 📄 Licença

Este projeto está licenciado sob a GPL v2 ou posterior - veja o arquivo [LICENSE](LICENSE) para detalhes.

### 👨‍💻 Desenvolvedor

Desenvolvido por [Maison da Silva](https://maisondasilva.com.br)
- GitHub: [@maisondasilva](https://github.com/maisondasilva)

---

## 🇺🇸 English

WordPress plugin for automatic detection and intelligent application of existing tags to posts.

### ✨ Key Features

- **🧠 Smart Detection**: Analyzes post titles and content to find matching tags
- **⚙️ Advanced Configuration**: Full control over how tags are detected and applied
- **📂 Category Filters**: Apply automatic tags only to specific categories
- **📏 Length Control**: Set minimum length for tags to be considered
- **🔤 Case Sensitivity**: Option to distinguish between uppercase and lowercase
- **💫 Modern Interface**: Clean and intuitive administration panel
- **📊 Statistics**: View your blog statistics directly in the panel
- **🌐 Translation Support**: Brazilian Portuguese and English included

### 🔧 Technical Features

- ✅ **WordPress**: 5.0 or higher
- ✅ **PHP**: 7.4 or higher
- 🔒 **Security**: Sanitization, validation, and nonces implemented
- 🎣 **Hooks & Filters**: Available for developers
- 🧹 **Cleanup**: Complete removal on uninstall
- ⚡ **Performance**: Optimized for speed

### 📦 Installation

1. Download the latest ZIP file from [Releases](../../releases)
2. Extract to `/wp-content/plugins/auto-tags-smart/`
3. Activate the plugin in WordPress admin panel
4. Configure options under **Posts → Auto Tags Smart**

### 🚀 How to Use

1. **Configure options** on the "Auto Tags Smart" page in the Posts menu
2. **Choose scope**: examine titles, content, or both
3. **Set up filters** by category if needed
4. **Adjust advanced settings** according to your needs
5. **Save and start creating posts!**

The plugin will automatically detect existing tags in your content and apply them to posts.

### 🛠️ For Developers

#### Available Hooks
```php
do_action('at_before_tagging', $post_id);
do_action('at_after_tagging', $post_id, $applied_tags);
do_action('at_tag_found', $tag, $post_id);
do_action('at_excluded_tag', $tag, $post_id);
```

#### Available Filters
```php
$min_length = apply_filters('at_minimum_tag_length', 3);
$content = apply_filters('at_content_to_analyze', $content, $post_id);
$tags = apply_filters('at_found_tags', $found_tags, $post_id);
```

### 📝 Changelog

#### v1.0
- 🎉 Initial release of Auto Tags Smart
- 🧠 Complete automatic tag detection system
- 🎨 Responsive and modern interface
- 📏 Minimum tag length control
- 🔤 Case sensitivity option
- 📂 Category filters
- 📊 Integrated statistics system
- 🌐 Complete documentation in Portuguese and English

### 🆘 Support

- 📖 **Documentation**: Available in the administration panel
- 🐛 **Issues**: [GitHub Issues](../../issues)
- 💬 **Discussions**: [GitHub Discussions](../../discussions)

### 📄 License

This project is licensed under GPL v2 or later - see the [LICENSE](LICENSE) file for details.

### 👨‍💻 Developer

Developed by [Maison da Silva](https://maisondasilva.com.br)
- GitHub: [@maisondasilva](https://github.com/maisondasilva)

---

## 🏷️ Tags

`wordpress` `plugin` `tags` `automatic` `smart` `detection` `php` `javascript` `i18n` `wordpress-plugin`

## ⭐ Star History

[![Star History Chart](https://api.star-history.com/svg?repos=maisondasilva/auto-tags-smart&type=Date)](https://star-history.com/#maisondasilva/auto-tags-smart&Date)
