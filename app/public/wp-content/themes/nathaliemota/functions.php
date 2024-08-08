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
function nathaliemota_load_filter() {
    // Vérification de sécurité
    if (
        ! isset($_REQUEST['nonce']) ||
        ! wp_verify_nonce($_REQUEST['nonce'], 'nathaliemota_nonce')
    ) {
        wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
    }

    $categorie_photo = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format_photo = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : '';

    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 8,
    ];

    if ($categorie_photo) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie_photo',
            'field' => 'slug',
            'terms' => $categorie_photo,
        ];
    }

    if ($format_photo) {
        $args['tax_query'][] = [
            'taxonomy' => 'format_photo',
            'field' => 'slug',
            'terms' => $format_photo,
        ];
    }

    if ($orderby) {
        $args['order'] = $orderby === 'asc' ? 'ASC' : 'DESC';
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'annee_photo';
    }

    $ajaxposts = new WP_Query($args);
    $response = '';

    if ($ajaxposts->have_posts()) {
        while ($ajaxposts->have_posts()) {
            $ajaxposts->the_post();
            ob_start();
            get_template_part('templates/photo');
            $response .= ob_get_clean();
        }
    } else {
        $response = 'Photos non trouvées';
    }

    echo $response;
    wp_die();
}
add_action('wp_ajax_nathaliemota_load_filter', 'nathaliemota_load_filter');
add_action('wp_ajax_nopriv_nathaliemota_load_filter', 'nathaliemota_load_filter');


/****BOUTON LOAD MORE*****/
function load_more_photos() {
    // Vérification de la variable page
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    error_log('Loading page: ' . $paged); // Ajout d'un log pour le debug

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

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
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


