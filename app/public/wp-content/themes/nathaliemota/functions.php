<?php
function nathaliemota_setup() {
    if (function_exists('add_theme_support')) {
        // support pour title tag
        add_theme_support('title-tag');

        // support pour custom logo
        add_theme_support('custom-logo');

        // support pour post thumbnails
        add_theme_support('post-thumbnails');
    }

    // Registration pour main menu
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'nathaliemota')
    ));
}
add_action('after_setup_theme', 'nathaliemota_setup');

function register_my_menus() {
    register_nav_menus(
        array(
            'footer' => __('footer-menu')
        )
    );
}
add_action('init', 'register_my_menus');


// Enqueue styles
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'nathaliemota-style', get_stylesheet_directory_uri() . '/css/style.css'); 
    wp_enqueue_script( 'nathaliemota-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), null, true);
    wp_enqueue_script( 'modal-script', get_template_directory_uri() . '/js/modal.js', array( 'jquery' ), null, true);
    wp_enqueue_script( 'lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array( 'jquery' ), null, true);
    wp_enqueue_script( 'filtres-script', get_template_directory_uri() . '/js/filtres.js', array( 'jquery' ), null, true);
    wp_enqueue_script( 'loadmore-script', get_template_directory_uri()     . '/js/load-more.js', array( 'jquery' ), null, true);
}


//**Ajax */
function load_more_photos() {
    // Vérification de la variable page
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Récupération des filtres
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'desc';

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'order'          => strtoupper($orderby),
    );

    // Initialiser le tableau 'tax_query' pour éviter les erreurs si aucun filtre n'est appliqué
    $tax_query = array();

    // Ajout des filtres de taxonomie si disponibles
    if ($category) {
        $tax_query[] = array(
            'taxonomy' => 'categorie_photo',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    // Si des filtres sont définis, les ajouter aux arguments de la requête
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);
    $response = '';

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ob_start();
            get_template_part('templates/photos');
            $response .= ob_get_clean();
        endwhile;
    else:
        $response = 'Pas de photos supplémentaires';
    endif;

    wp_reset_postdata();
    echo $response;
    exit;
}

// Enregistrement des actions AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Réutilisation de la même fonction pour filtrer les photos
add_action('wp_ajax_filter_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_filter_photos', 'load_more_photos');
