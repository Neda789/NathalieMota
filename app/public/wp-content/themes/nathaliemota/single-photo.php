<?php
/*
  Template Name: Photo
*/
get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>    
<article class="post-container">
    <div class="post-infos">
        <section class="infos-photo">
            <h1 class="title"><?php the_title(); ?></h1>
            <div class="taxonomies">
                <p>Référence: <?php $value = get_field("reference");
                    if ($value) {
                        echo wp_kses_post($value);
                    } else {
                        echo 'empty';
                    }
                ?></p>
                <p>Catégorie: <?php
                    $categories = get_the_terms(get_the_ID(), 'categorie_photo');
                    if ($categories && !is_wp_error($categories)) {
                        foreach ($categories as $categorie) {
                            echo esc_html($categorie->name) . ' ';
                        }
                    } else {
                        echo 'empty';
                    }
                ?></p>
                <p>Format: <?php
                    $formats = get_the_terms(get_the_ID(), 'format');
                    if ($formats && !is_wp_error($formats)) {
                        foreach ($formats as $format) {
                            echo esc_html($format->name) . ' ';
                        }
                    } else {
                        echo 'empty';
                    }
                ?></p>
                <p>Type: <?php echo esc_html(get_field('type')); ?></p>
                <p>Année: <?php echo esc_html(get_field('annee_photo')); ?></p>
            </div>
            <hr class="line">
        </section>
        <section class="image-post">
            <?php the_content(); ?>
        </section>
    </div>
    <div class="bloc-infos">
        <div class="contact-bloc">
            <p class="p1">Cette photo vous intéresse?</p>
            <button id="ctaContact" data-ref-photo="<?php $value = get_field("reference_photo");
                if ($value) {
                    echo wp_kses_post($value);
                } else {
                    echo 'empty';
                }
            ?>">Contact</button>
        </div>
        <div class="thumbnail_container">
            <div class="current_thumbnail">
                <?php
                // Récupérer le post actuel, le post précédent et le post suivant
                $current_post = get_post();
                $prev_post = get_previous_post();
                $next_post = get_next_post();

                // Récupérer les URL des miniatures
                $current_thumbnail = $current_post ? get_the_post_thumbnail_url($current_post->ID, 'thumbnail') : '';
                $prev_thumbnail = $prev_post ? get_the_post_thumbnail_url($prev_post->ID, 'thumbnail') : '';
                $next_thumbnail = $next_post ? get_the_post_thumbnail_url($next_post->ID, 'thumbnail') : '';
                ?>
                <!-- Conteneur pour afficher la miniature actuelle sans l'attribut alt -->
                <img id="displayed-thumbnail" src="<?php echo esc_url($current_thumbnail); ?>">
                <nav class="navigation_arrows">
                    <?php if ($prev_post) : ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="prev-link" data-image="<?php echo esc_url($prev_thumbnail); ?>">←</a>
                    <?php endif; ?>
                    <?php if ($next_post) : ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="next-link" data-image="<?php echo esc_url($next_thumbnail); ?>">→</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>
</article>
<article class="photos-container">
    <p class="p2">Vous aimerez aussi</p><br>
    <div class="imagesContainer">
        <div class="cardsContainer">
            <?php
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'orderby' => 'rand',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie_photo',
                        'field' => 'slug',
                        'terms' => array('concert', 'mariage', 'reception', 'television'),
                    )
                )
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    get_template_part('templates/phots');
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
