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
function nathaliemota_enqueue_styles() {
    wp_enqueue_style('main-styles', get_template_directory_uri() . '/css/style.css', array(), '1.0', 'all');
    
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_styles');




// Enregistrer deux actions AJAX (AJAX Handlers)
// AJAX load more photos function
function load_more_photos() {
    check_ajax_referer('load_more_nonce', 'nonce'); // Vérifier nonce pour la sécurité

    // Vérifier que tous les paramètres nécessaires sont présents
    if (isset($_POST['page']) && isset($_POST['postid'])) {
        $page = intval($_POST['page']);
        $post_id = intval($_POST['postid']);

        // Query pour charger des photos supplémentaires
        $args = array(
            'post_type' => 'photo', // Remplacez 'photo' par votre type de post
            'posts_per_page' => 8, // Nombre de posts par page
            'paged' => $page,
            'post_parent' => $post_id // Si vous avez besoin d'un ID de post spécifique
        );

        $ajaxposts = new WP_Query($args);
        $response = '';
        if ($ajaxposts->have_posts()) {
            while ($ajaxposts->have_posts()) {
                $ajaxposts->the_post();
                ob_start();
                get_template_part('photo');
                $response .= ob_get_clean();
            }
        } else {
            $response = 'Photos non trouvées';
        }
        echo $response;
    }
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Enqueue load more script
function enqueue_load_more_script() {
    wp_enqueue_script('load-more', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
    wp_localize_script('load-more', 'load_more_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');
