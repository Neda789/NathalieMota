<?php get_header(); ?>
    

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
                        <?php foreach ($trierpar as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>">
                                <?php echo esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="catalogue-container">
                <div id="catalogue_photos">
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
            

            <button id="load-more" data-page="One">Charger plus</button>           

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
