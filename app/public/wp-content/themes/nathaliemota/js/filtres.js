//***Filters */
jQuery(document).ready(function($) {
    var ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";

    // Filtrage
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