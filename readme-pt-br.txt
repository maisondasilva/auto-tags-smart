=== Auto Tags Smart ===

Contributors: maisondasilva
Donate link: https://maisondasilva.com.br
Tags: automatic tags, auto tagger, auto tagging, smart tagging, tags, wordpress tags
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Detecta e atribui automaticamente tags existentes aos posts usando análise inteligente de conteúdo com opções avançadas de filtragem.

== Description ==

Auto Tags Smart é um sistema avançado de tags automáticas que detecta e atribui tags existentes aos seus posts de forma inteligente.

= Principais Recursos =

* **Detecção Inteligente**: Analisa o título e conteúdo dos posts para encontrar tags correspondentes
* **Configurações Avançadas**: Controle total sobre como as tags são detectadas e aplicadas
* **Filtros por Categoria**: Aplique tags automáticas apenas em categorias específicas
* **Controle de Comprimento**: Defina o comprimento mínimo para tags serem consideradas
* **Sensibilidade de Maiúsculas**: Opção para distinguir entre maiúsculas e minúsculas
* **Interface Moderna**: Painel de administração limpo e intuitivo
* **Estatísticas**: Visualize estatísticas do seu blog diretamente no painel

= Recursos Avançados =

* Bloqueio de tags manuais (opcional)
* Análise de relevância de conteúdo
* Sugestão automática de novas tags baseada no conteúdo
* Limpeza completa na desinstalação
* Compatibilidade com os hooks mais recentes do WordPress

= Como Funciona =

1. Instale e ative o plugin
2. Configure as opções na página "Auto Tags" no menu Posts
3. Escolha se deve examinar títulos, conteúdo ou ambos
4. Configure filtros por categoria se necessário
5. Ajuste as configurações avançadas conforme suas necessidades
6. Salve as configurações e comece a criar posts!

O plugin irá automaticamente detectar tags existentes no seu conteúdo e aplicá-las aos posts.

= Requisitos =

* WordPress 5.0 ou superior
* PHP 7.4 ou superior
* Memória mínima: 64MB

== Installation ==

1. Faça upload da pasta 'auto-tags' para o diretório '/wp-content/plugins/'
2. Ative o plugin através do menu 'Plugins' no WordPress
3. Vá para Posts > Auto Tags para configurar as opções
4. Configure as opções conforme suas necessidades
5. Salve as configurações e comece a usar!

= Instalação Manual =

1. Baixe o arquivo zip do plugin
2. Extraia os arquivos para '/wp-content/plugins/auto-tags'
3. Ative o plugin no painel de administração
4. Configure as opções em Posts > Auto Tags

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

= Posso desativar o plugin temporariamente? =

Sim! Você pode desmarcar a opção "Ativar Auto Tags" nas configurações para desativar temporariamente sem desinstalar o plugin.

= As configurações são perdidas ao desinstalar? =

Isso depende da configuração "Limpeza na Desinstalação". Se estiver ativada, todas as configurações serão removidas. Se não, elas permanecerão no banco de dados.

== Screenshots ==

1. Painel principal de configurações do Auto Tags
2. Configurações avançadas e filtros por categoria
3. Estatísticas e informações do plugin
4. Status de funcionamento em tempo real

== Changelog ==

= 1.0 =
* Lançamento inicial do Auto Tags Smart
* Detecção inteligente de tags existentes
* Configurações avançadas de filtros
* Interface moderna e responsiva
* Controle de comprimento mínimo de tags
* Opção de sensibilidade a maiúsculas/minúsculas
* Filtros por categoria
* Sistema de estatísticas
* Limpeza completa na desinstalação

== Upgrade Notice ==

= 1.0 =
Primeira versão do Auto Tags Smart. Uma evolução dos sistemas tradicionais de tags automáticas com recursos avançados e interface moderna.

== Developer Notes ==

O Auto Tags Smart foi desenvolvido seguindo as melhores práticas do WordPress:

* Usa hooks e filtros apropriados
* Código bem documentado e organizado
* Compatível com as últimas versões do WordPress
* Otimizado para performance
* Interface responsiva
* Segurança implementada (nonces, sanitização, validação)

= Hooks Disponíveis =

* `at_before_tagging` - Executado antes da aplicação de tags
* `at_after_tagging` - Executado após a aplicação de tags
* `at_tag_found` - Executado quando uma tag é encontrada
* `at_excluded_tag` - Executado quando uma tag é excluída

= Filtros Disponíveis =

* `at_minimum_tag_length` - Modifica o comprimento mínimo das tags
* `at_content_to_analyze` - Modifica o conteúdo a ser analisado
* `at_found_tags` - Modifica as tags encontradas antes da aplicação

== Support ==

Para suporte, dúvidas ou sugestões:

* Documentação: Disponível no painel de administração
* GitHub: https://github.com/maisondasilva/auto-tags-smart
* WordPress: https://wordpress.org/plugins/auto-tags-smart

== License ==

Este plugin é licenciado sob GPL v2 ou posterior.

Copyright (C) 2025 Auto Tags Smart

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
