<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NathalieMota</title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <?php get_header(); ?>
    </header>

    <main>
        <article>
            <?php
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 1,
                'orderby' => 'rand',
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>        
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <div class="photoContainer" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>');">
                            <h2 class="title-one">Photographe Event</h2>
                        </div>
                    </a>
                <?php endwhile;
            endif;

            wp_reset_postdata();
            ?>

            <div class="One"></div>
            <div class="selection">
                <?php
                $categoriesList = get_terms(array(
                    'taxonomy'   => 'categorie_photo',
                    'hide_empty' => false,
                ));
                
                $formatsList = get_terms(array(
                    'taxonomy'   => 'format',
                    'hide_empty' => false,
                ));
                
                $trierparsList = array(
                    'asc'  => 'plus anciennes',
                    'desc' => 'plus récentes',
                );
                ?>

                <div class="tax">
                    <select class="filter" id="categorie">
                        <option value="">CATÉGORIES</option>
                        <?php foreach ($categoriesList as $categorie) : ?>
                            <option value="<?php echo esc_attr($categorie->slug); ?>">
                                <?php echo esc_html($categorie->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select class="filter" id="format">
                        <option value="">FORMATS</option>
                        <?php foreach ($formatsList as $format) : ?>
                            <option value="<?php echo esc_attr($format->slug); ?>">
                                <?php echo esc_html($format->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="order-by">
                    <select class="filter" id="orderby">
                        <option value="">TRIER PAR</option>
                        <?php foreach ($trierparsList as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="catalogue-container">
                <div class="catalogue_photos">
                    <?php
                    $args = array(
                        'post_type' => 'photo',
                        'posts_per_page' => 8,
                        'paged' => 1,
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            get_template_part('templates/photos');
                        endwhile;
                    endif;

                    wp_reset_postdata();
                    ?>
                </div>
            </div>

            <button id="load-more" data-page="1" data-url="<?php echo admin_url('admin-ajax.php'); ?>">Charger plus</button>           


        </article>
    </main>

    <?php get_footer(); ?>
    
</body>
</html>

   