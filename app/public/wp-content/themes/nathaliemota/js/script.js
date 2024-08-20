/*****LOAD MORE-CHARGER PLUS*****/
jQuery(document).ready(function($) {
    let page = 1;

    $('#load-more').on('click', function() {
        page++;
        let button = $(this);
        let data = {
            action: 'load_more_photos',
            page: page
        };

        console.log('Sending AJAX request with data:', data);

        $.ajax({
            url: button.data('url'),
            type: 'POST',
            data: data,
            beforeSend: function(xhr) {
                button.text('Charging...');
            },
            success: function(response) {
                console.log('AJAX response:', response);
                if (response === 'empty') {
                    button.text('Pas de photos supplémentaires').prop('disabled', true);
                } else {
                    $('.catalogue_photos').append(response);
                    button.text('Charger plus');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });
});




//*****IMAGES MINIATURES*****//
jQuery(document).ready(function ($) {
    // Fonction pour changer l'image affichée
    function changeThumbnail(imageUrl) {
        $('#displayed-thumbnail').attr('src', imageUrl);
    }

    // Événements de survol pour les liens de navigation
    $('.navigation_arrows a').hover(
        function () {
            const imageUrl = $(this).data('image');
            if (imageUrl) {
                changeThumbnail(imageUrl);
            }
        },
    );
});
//**hamburger */

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');

    menuToggle.addEventListener('click', function() {
        menuToggle.classList.toggle('active');
        mobileMenu.classList.toggle('active');

        // Change aria-expanded state
        const expanded = menuToggle.getAttribute('aria-expanded') === 'true' || false;
        menuToggle.setAttribute('aria-expanded', !expanded);
    });
});


