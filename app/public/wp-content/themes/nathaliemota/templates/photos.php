<div class="photo-cards">
    <?php
    // Récupérer les catégories associées à la photo
    $categoriesList = get_the_terms(get_the_ID(), 'categorie_photo');
    $category_classes = array();

    if ($categoriesList && !is_wp_error($categoriesList)) {
        foreach ($categoriesList as $category) {
            $category_classes[] = 'cat-' . $category->slug; // Utiliser le slug comme classe CSS
        }
    }
    $category_classes_string = implode(' ', $category_classes); // Convertir en chaîne de classes
    
    // Récupérer les formats associés à la photo
    $formatsList = get_the_terms(get_the_ID(), 'format'); // Remarquez le changement ici
    $format_classes = array();

    if ($formatsList && !is_wp_error($formatsList)) {
        foreach ($formatsList as $format) {
            $format_classes[] = 'format-' . $format->slug; // Utiliser le slug comme classe CSS
        }
    }
    $format_classes_string = implode(' ', $format_classes); // Convertir en chaîne de classes
    ?>

    <a href="<?php echo esc_url(get_permalink()); ?>" class="photo <?php echo esc_attr($category_classes_string . ' ' . $format_classes_string); ?>" data-href="<?php echo get_the_post_thumbnail_url(); ?>" data-category="<?php echo esc_attr(implode(', ', wp_list_pluck($categoriesList, 'name'))); ?>" data-reference="<?php echo esc_attr(get_field('reference') ? get_field('reference') : 'empty'); ?>">
        <div class="Photo-card" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">
            <div class="overlay">
                <div class="overlay-content">
                    <button class="eye">
                        <img src="<?php echo get_theme_file_uri() . '/assets/img/eye.png'; ?>" alt="oeil">
                    </button>
                    <img class="fullscreen" src="<?php echo get_theme_file_uri() . '/assets/img/fullscreen.png'; ?>" alt="plein écran">
                    <span class="ref">
                        Référence: <?php echo esc_html(get_field('reference') ? get_field('reference') : 'empty'); ?>
                    </span>
                    <span class="cat">Catégorie:  <?php $categories = get_the_terms(get_the_ID(), 'categorie_photo');
                          foreach ($categories as $categorie) {
                            echo $categorie->name;
                          }
                      ?>
                    </span>   
                </div>
            </div>
        </div>
    </a>
</div>
