/* Auto Tags Smart Admin JavaScript */

jQuery(document).ready(function($) {
    
    // Prevent any auto-save functionality
    $(document).off('change.autosave');
    $(document).off('input.autosave');
    
    // Override any potential auto-save functions
    if (typeof wp !== 'undefined' && wp.autosave) {
        wp.autosave.server.suspend();
    }
    
    // Toggle categories container based on filter checkbox
    function toggleCategoriesContainer() {
        var isChecked = $('#at-filter-by-category').is(':checked');
        var $container = $('#categories-container');
        var $heading = $('#included-categories');
        var $selectAllBtn = $('.at-select-all');
        var $deselectAllBtn = $('.at-deselect-all');
        
        if (isChecked) {
            $container.removeClass('softened').fadeIn();
            $heading.removeClass('softened');
            // Show buttons if they exist and update their text
            if ($selectAllBtn.length && typeof updateButtonText === 'function') {
                updateButtonText();
            } else if ($selectAllBtn.length) {
                $selectAllBtn.show();
                $deselectAllBtn.show();
            }
        } else {
            $container.addClass('softened').fadeOut(300);
            $heading.addClass('softened');
            // Hide buttons if they exist
            if ($selectAllBtn.length) $selectAllBtn.hide();
            if ($deselectAllBtn.length) $deselectAllBtn.hide();
        }
    }
    
    // Initialize categories container state
    toggleCategoriesContainer();
    
    // Handle filter by category checkbox change
    // (Already handled above to prevent auto-save)
    
    // Add select all / deselect all functionality for categories
    if ($('#categories-container').length) {
        // Get translated strings (fallback to Portuguese if not available)
        var selectAllText = (typeof atStrings !== 'undefined' && atStrings.selectAll) ? atStrings.selectAll : 'Selecionar Todas';
        var deselectAllText = (typeof atStrings !== 'undefined' && atStrings.deselectAll) ? atStrings.deselectAll : 'Desmarcar Todas';
        
        var $selectAllBtn = $('<button type="button" class="button button-small at-select-all">' + selectAllText + '</button>');
        var $deselectAllBtn = $('<button type="button" class="button button-small at-deselect-all" style="margin-left: 5px;">' + deselectAllText + '</button>');
        
        $('#included-categories').after($selectAllBtn).after($deselectAllBtn);
        
        // Initially hide them if filter is not checked
        if (!$('#at-filter-by-category').is(':checked')) {
            $selectAllBtn.hide();
            $deselectAllBtn.hide();
        }
        
        $selectAllBtn.on('click', function() {
            $('#categories-container input[type="checkbox"]').prop('checked', true);
            updateButtonText();
        });
        
        $deselectAllBtn.on('click', function() {
            $('#categories-container input[type="checkbox"]').prop('checked', false);
            updateButtonText();
        });
        
        // Function to update button text based on current state
        function updateButtonText() {
            var $checkboxes = $('#categories-container input[type="checkbox"]');
            var checkedCount = $checkboxes.filter(':checked').length;
            var totalCount = $checkboxes.length;
            
            // Sempre mostrar "Selecionar Todas" quando nem todas estão marcadas
            // Mostrar "Desmarcar Todas" apenas quando TODAS estão marcadas
            if (checkedCount === totalCount && totalCount > 0) {
                $selectAllBtn.hide();
                $deselectAllBtn.text(deselectAllText).show();
            } else {
                $selectAllBtn.text(selectAllText).show();
                $deselectAllBtn.hide();
            }
        }
        
        // Make updateButtonText available globally for toggleCategoriesContainer
        window.updateButtonText = updateButtonText;
        
        // Update button text when individual checkboxes change
        $('#categories-container').on('change', 'input[type="checkbox"]', function() {
            updateButtonText();
        });
        
        // Initialize button text
        updateButtonText();
    }
    
    // Validate minimum tag length
    $('#at-minimum-tag-length').on('change', function() {
        var value = parseInt($(this).val());
        if (value < 1) {
            $(this).val(1);
            showNotice('O comprimento mínimo da tag deve ser pelo menos 1.', 'warning');
        } else if (value > 50) {
            $(this).val(50);
            showNotice('O comprimento mínimo da tag não pode ser maior que 50.', 'warning');
        }
    });
    
    // Add tooltips to help icons
    $('.at-info-icon').on('mouseenter', function() {
        var helpText = $(this).data('help');
        if (helpText) {
            showTooltip($(this), helpText);
        }
    }).on('mouseleave', function() {
        hideTooltip();
    });
    
    // Form validation before submit
    $('form').on('submit', function(e) {
        var examineTitle = $('#at-examine-post-title').is(':checked');
        var examineContent = $('#at-examine-post-content').is(':checked');
        var isEnabled = $('#at-turn-on').is(':checked');
        
        if (isEnabled && !examineTitle && !examineContent) {
            e.preventDefault();
            showNotice('Você deve selecionar pelo menos uma opção: "Examinar título" ou "Examinar conteúdo".', 'error');
            return false;
        }
        
        var filterByCategory = $('#at-filter-by-category').is(':checked');
        var hasSelectedCategories = $('#categories-container input[type="checkbox"]:checked').length > 0;
        
        if (isEnabled && filterByCategory && !hasSelectedCategories) {
            e.preventDefault();
            showNotice('Se você ativar o filtro por categoria, deve selecionar pelo menos uma categoria.', 'error');
            return false;
        }
    });
    
    // Utility functions
    function showNotice(message, type, duration) {
        type = type || 'info';
        duration = duration || 4000;
        
        var $notice = $('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
        $('.wrap h2').after($notice);
        
        setTimeout(function() {
            $notice.fadeOut(function() {
                $(this).remove();
            });
        }, duration);
    }
    
    var $tooltip;
    function showTooltip($element, text) {
        hideTooltip();
        $tooltip = $('<div class="at-tooltip">' + text + '</div>');
        $('body').append($tooltip);
        
        var offset = $element.offset();
        $tooltip.css({
            position: 'absolute',
            top: offset.top - $tooltip.outerHeight() - 5,
            left: offset.left + ($element.outerWidth() / 2) - ($tooltip.outerWidth() / 2),
            background: '#333',
            color: '#fff',
            padding: '5px 10px',
            borderRadius: '3px',
            fontSize: '12px',
            zIndex: 9999,
            whiteSpace: 'nowrap'
        });
    }
    
    function hideTooltip() {
        if ($tooltip) {
            $tooltip.remove();
            $tooltip = null;
        }
    }
    
    // Initialize status indicators
    updateStatusIndicators();
    
    // Prevent WordPress auto-save on settings changes
    $('input, select, textarea').off('change.wp-auto-save input.wp-auto-save');
    
    // Remove any existing auto-save handlers
    $(document).off('change', 'input, select, textarea');
    
    // Add our own change handlers that DON'T auto-save
    $('#at-turn-on, #at-examine-post-title, #at-examine-post-content').on('change', function() {
        updateStatusIndicators();
        // Trigger change immediately for real-time status update
        setTimeout(updateStatusIndicators, 10);
    });
    
    $('#at-filter-by-category').on('change', function() {
        toggleCategoriesContainer();
    });
    
    function updateStatusIndicators() {
        var isEnabled = $('#at-turn-on').is(':checked');
        var examineTitle = $('#at-examine-post-title').is(':checked');
        var examineContent = $('#at-examine-post-content').is(':checked');
        
        var $statusElement = $('#at-status');
        
        if (isEnabled && (examineTitle || examineContent)) {
            $statusElement.removeClass('at-status-inactive at-status-warning').addClass('at-status-active');
            $statusElement.css('color', 'green').text(atStrings.statusActive);
        } else if (isEnabled && (!examineTitle && !examineContent)) {
            $statusElement.removeClass('at-status-active at-status-inactive').addClass('at-status-warning');
            $statusElement.css('color', 'orange').text(atStrings.statusActiveNothing);
        } else {
            $statusElement.removeClass('at-status-active at-status-warning').addClass('at-status-inactive');
            $statusElement.css('color', 'red').text(atStrings.statusInactive);
        }
    }
    
    // Update status when relevant checkboxes change
    // (Already handled above to prevent auto-save)
    
    // Add smooth scrolling to anchor links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var target = $($(this).attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 50
            }, 500);
        }
    });
    
    // Add confirmation for clean uninstall option
    $('#at-clean-uninstall').on('change', function() {
        if ($(this).is(':checked')) {
            var confirmed = confirm('Tem certeza? Esta opção removerá TODAS as configurações do plugin quando ele for desinstalado.');
            if (!confirmed) {
                $(this).prop('checked', false);
            }
        }
    });
    
    // Performance monitoring (development only)
    if (typeof console !== 'undefined' && window.location.href.indexOf('debug=1') > -1) {
        console.log('Auto Tags Smart Admin JS loaded successfully');
        
        // Monitor form interactions
        $('input, select, textarea').on('change', function() {
            console.log('Setting changed:', $(this).attr('name'), '=', $(this).val());
        });
    }
    
});
