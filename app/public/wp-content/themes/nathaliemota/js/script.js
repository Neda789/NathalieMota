(function ($) {
    $(document).ready(function () {
        // Chargement des commentaires en Ajax lorsque le bouton est cliqué
        $('#load-more').click(function (e) {
            // Empêcher l'action par défaut du bouton
            e.preventDefault();
 
            // Les données de notre formulaire
            const data = {
                action: 'load_more_photos',
                nonce: load_more_params.nonce, // Utiliser nonce passé par PHP
                page: $(this).data('page'),
                postid: $('#post-id').val()
            };
            // Pour vérifier qu'on a bien récupéré les données
            console.log(load_more_params.ajaxurl);
            console.log(data);
            // Requête Ajax en JS natif via Fetch
            fetch(load_more_params.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                body: new URLSearchParams(data),
            })
            .then(response => response.json())
            .then(body => {
                console.log(body);
 
                // En cas d'erreur
                if (!body.success) {
                    alert(body.data);
                    return;
                }
 
                // Et en cas de réussite
                $('#load-more').data('page', parseInt(data.page) + 1); // Incrémenter le numéro de la page
                $('.photo-container').append(body.data); // Et ajouter le HTML des nouveaux commentaires
            });
        });
    });
})(jQuery);