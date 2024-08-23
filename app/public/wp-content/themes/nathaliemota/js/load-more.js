jQuery(document).ready(function($) {
    var ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var page = 1;
    var filters = {
        category: '',
        format: '',
        orderby: ''
    };

    function loadPhotos() {
        page++;
        var data = {
            'action': 'load_more_photos',
            'page': page,
            'category': filters.category,
            'format': filters.format,
            'orderby': filters.orderby
        };

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('#catalogue_photos').append(response);
            }
        });
    }

    function filterPhotos() {
        var data = {
            'action': 'filter_photos',
            'category': filters.category,
            'format': filters.format,
            'orderby': filters.orderby
        };

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('#catalogue_photos').html(response);
            }
        });
    }

    $('#load-more').on('click', loadPhotos);

    $('.filter').on('click', '.option', function() {
        var filterType = $(this).parent().attr('id').replace('-filter', '');
        var value = $(this).data('value');

        filters[filterType] = value;
        $(this).closest('.filter').find('.selected-option').text($(this).text());

        filterPhotos();
    });

    $('#orderby .option').on('click', function() {
        filters.orderby = $(this).data('value');
        $(this).closest('.filter').find('.selected-option').text($(this).text());

        filterPhotos();
    });
});
