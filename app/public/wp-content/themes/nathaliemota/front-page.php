<?php get_header(); ?>
    
<main>
    <article>
        <?php
        // Random photo display
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
                        <img class="titre" src="<?php echo get_theme_file_uri() . '/assets/img/photographe-event.png'; ?>" alt="event">
                    </div>
                </a>
            <?php endwhile;
        endif;

        wp_reset_postdata();
        ?>
<div class="One">
<div class="selection">
    <?php
    // Get categories
    $categoriesList = get_terms(array(
        'taxonomy'   => 'categorie_photo',
        'hide_empty' => false,
    ));

    // Get formats
    $formatsList = get_terms(array(
        'taxonomy'   => 'format',
        'hide_empty' => false,
    ));

    // Sorting options
    $trierparList = array(
        'asc'  => 'plus anciennes',
        'desc' => 'plus récentes',
    );
    ?>
<!-- Catégorie Filter -->
<div id="categorie-filter" class="custom-dropdown">
    <div class="selected-option">CATÉGORIES <span class="arrow"></span></div>
    <ul class="options">
        <?php foreach ($categoriesList as $categorie) : ?>
            <li class="option" data-value="<?php echo esc_attr($categorie->slug); ?>">
                <?php echo esc_html($categorie->name); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- Format Filter -->
<div id="format-filter" class="custom-dropdown">
    <div class="selected-option">FORMATS <span class="arrow"></span></div>
    <ul class="options">
        <?php foreach ($formatsList as $format) : ?>
            <li class="option" data-value="<?php echo esc_attr($format->slug); ?>">
                <?php echo esc_html($format->name); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
        </div>
<!-- Trier Par -->
<div id="orderby-filter" class="custom-dropdown">
    <div class="selected-option">TRIER PAR <span class="arrow"></span></div>
    <ul class="options">
        <?php foreach ($trierparList as $value => $label) : ?>
            <li class="option" data-value="<?php echo esc_attr($value); ?>">
                <?php echo esc_html($label); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
        </div>
        </div>   
       

        <div class="catalogue-container">
            <div class="catalogue_photos" id="catalogue_photos">
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


        <button id="load-more" data-="One">Charger plus</button>           

    </article>
</main>

<?php get_footer(); ?>

<script>
    jQuery(document).ready(function($) {
        var ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
        var page = 1;

        $('#load-more').on('click', function() {
            page++;
            var data = {
                'action': 'load_more_photos',
                'page': page
            };

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#catalogue_photos').append(response);
                }
            });
        });

        $('.filter').on('change', function() {
            var category = $('#categorie').val();
            var format = $('#format').val();
            var orderby = $('#orderby').val();

            var data = {
                'action': 'filter_photos',
                'category': category,
                'format': format,
                'orderby': orderby
            };

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#catalogue_photos').html(response);
                }
            });
        });
    });
</script>

</body>
</html>