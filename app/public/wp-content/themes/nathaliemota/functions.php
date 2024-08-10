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

// Enqueue styles
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'nathaliemota-style', get_stylesheet_directory_uri() . '/css/style.css'); 
    wp_enqueue_script( 'nathaliemota-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), null, true);
    wp_enqueue_script( 'modal-script', get_template_directory_uri() . '/js/modal.js', array( 'jquery' ), null, true);
}
function load_more_photos() {
    // Vérification de la variable page
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Récupération des filtres
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'desc';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'order' => strtoupper($orderby),
    );

    // Ajout des filtres de taxonomie si disponibles
    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie_photo',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
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



