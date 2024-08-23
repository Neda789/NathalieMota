jQuery(document).ready(function($) {
    function setupFilterToggle(filterId) {
        var $filter = $('#' + filterId);
        var $selectedOption = $filter.find('.selected-option');
        var $options = $filter.find('.options');
        var $arrow = $filter.find('.arrow');

        $selectedOption.on('click', function() {
            $options.toggleClass('show');
            $arrow.toggleClass('open');
        });

        $options.find('.option').on('click', function() {
            var value = $(this).data('value');
            var text = $(this).text();
            $selectedOption.text(text + ' ');
            $arrow.removeClass('open');
            $options.removeClass('show');

            // Filtrer les photos
            filterPhotos();
        });
    }

    function filterPhotos() {
        // Récupérer les valeurs sélectionnées pour chaque filtre
        const selectedCategories = Array.from($('#categorie-filter .option.selected')).map(option => option.dataset.value);
        const selectedFormats = Array.from($('#format-filter .option.selected')).map(option => option.dataset.value);

        $('.photo').each(function() {
            const $photo = $(this);
            const photoCategories = $photo.attr('class').split(' ').filter(cls => cls.startsWith('cat-'));
            const photoFormats = $photo.attr('class').split(' ').filter(cls => cls.startsWith('format-'));

            const hasCategory = selectedCategories.length === 0 || selectedCategories.some(category => photoCategories.includes(`cat-${category}`));
            const hasFormat = selectedFormats.length === 0 || selectedFormats.some(format => photoFormats.includes(`format-${format}`));

            if (hasCategory && hasFormat) {
                $photo.show();
            } else {
                $photo.hide();
            }
        });
    }

    // Initialiser les filtres
    setupFilterToggle('categorie-filter');
    setupFilterToggle('format-filter');
    setupFilterToggle('orderby-filter');

    // Événement de sélection de filtre
    $('.custom-dropdown').on('click', '.option', function() {
        $(this).toggleClass('selected');
        filterPhotos();
    });

    // Initialiser le filtrage
    filterPhotos();
});
