jQuery(function($) {
    'use strict';

    var $filterByCategory = $('#aet-filter-by-category');
    var categorySelector = '#categories-container input[name="aet_included_categories[]"]';

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
        var $selectAllButton = $('#aet-select-all-categories');
        var $clearAllButton = $('#aet-clear-all-categories');

        $('#included-categories, #categories-container').toggleClass('softened', !isEnabled);
        $('#categories-container-mask').toggleClass('active', !isEnabled);
        $selectAllButton.prop('disabled', !isEnabled);
        $clearAllButton.prop('disabled', !isEnabled);
    }

    $(document).on('click', '#aet-select-all-categories', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!$filterByCategory.is(':checked')) {
            $filterByCategory.prop('checked', true);
            syncCategoryPanelState();
        }

        toggleAllCategories(true);
    });

    $(document).on('click', '#aet-clear-all-categories', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!$filterByCategory.is(':checked')) {
            $filterByCategory.prop('checked', true);
            syncCategoryPanelState();
        }

        toggleAllCategories(false);
    });

    // Defensive binding for environments where delegated handlers are delayed.
    $('#aet-select-all-categories').on('click', function(event) {
        event.preventDefault();
        toggleAllCategories(true);
    });

    $('#aet-clear-all-categories').on('click', function(event) {
        event.preventDefault();
        toggleAllCategories(false);
    });

    $filterByCategory.on('change', syncCategoryPanelState);
    syncCategoryPanelState();
});
