<div class="photo-cards">
    <a href="<?php echo esc_url(get_permalink()); ?>" class="photo" data-href="<?php echo get_the_post_thumbnail_url(); ?>" data-category="<?php $categories = get_the_terms(get_the_ID(), 'categorie_photo');
                          foreach ($categories as $categorie) {
                            echo $categorie->name;
                          }
                      ?>" data-reference="<?php $value = get_field("reference");
                          if ($value) {
                            echo wp_kses_post($value);
                          } else {
                            echo 'empty';
                          }
                      ?> ">
        <div class="Photo-card" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">
            <div class="overlay">
                <div class="overlay-content">
                <button class="eye" style="widtheye"> <img src="<?php echo get_theme_file_uri() . '/assets/img/eye.png'; ?>" alt="oeil"></button>
                    <img class="fullscreen" src="<?php echo get_theme_file_uri() . '/assets/img/fullscreen.png'; ?>" alt="plein écran">
                    <span class="ref">Référence: <?php $value = get_field("reference");
                          if ($value) {
                            echo wp_kses_post($value);
                          } else {
                            echo 'empty';
                          }
                      ?> 
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