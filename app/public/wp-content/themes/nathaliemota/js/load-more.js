jQuery(document).ready(function($) {
    var ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var page = 1;

    $('#load-more').on('click', function() {
        page++;
        var data = {
            'action': 'load_more_photos',
            'page': page
        };

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('#catalogue_photos').append(response);
            }
        });
    });

    $('.filter').on('change', function() {
        var category = $('#categorie').val();
        var format = $('#format').val();
        var orderby = $('#orderby').val();

        var data = {
            'action': 'filter_photos',
            'category': category,
            'format': format,
            'orderby': orderby
        };

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('#catalogue_photos').html(response);
            }
        });
    });
});