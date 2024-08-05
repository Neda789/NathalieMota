<div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/Logo.png" alt="<?php bloginfo('name'); ?>" />
            </a>
        </div>
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'menu_id'        => 'primary-menu',
                'menu_class'     => 'nav-menu',
            ));
            ?>
        </nav>
 
