jQuery(function($) {
    'use strict';

    var $filterByCategory = $('#aets-filter-by-category');
    var categorySelector = '#aets-categories-container input[name="aets_included_categories[]"]';

    function getCategoryToggles() {
        return $(categorySelector);
    }

    function toggleAllCategories(checked) {
        getCategoryToggles().each(function() {
            this.checked = checked;
        });
    }

    function syncCategoryPanelState() {
        var isEnabled = $filterByCategory.is(':checked');
        var $selectAllButton = $('#aets-select-all-categories');
        var $clearAllButton = $('#aets-clear-all-categories');

        $('#aets-included-categories, #aets-categories-container').toggleClass('aets-softened', !isEnabled);
        $('#aets-categories-container-mask').toggleClass('aets-active', !isEnabled);
        $selectAllButton.prop('disabled', !isEnabled);
        $clearAllButton.prop('disabled', !isEnabled);
    }

    $(document).on('click', '#aets-select-all-categories', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!$filterByCategory.is(':checked')) {
            $filterByCategory.prop('checked', true);
            syncCategoryPanelState();
        }

        toggleAllCategories(true);
    });

    $(document).on('click', '#aets-clear-all-categories', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!$filterByCategory.is(':checked')) {
            $filterByCategory.prop('checked', true);
            syncCategoryPanelState();
        }

        toggleAllCategories(false);
    });

    // Defensive binding for environments where delegated handlers are delayed.
    $('#aets-select-all-categories').on('click', function(event) {
        event.preventDefault();
        toggleAllCategories(true);
    });

    $('#aets-clear-all-categories').on('click', function(event) {
        event.preventDefault();
        toggleAllCategories(false);
    });

    $filterByCategory.on('change', syncCategoryPanelState);
    syncCategoryPanelState();
});
