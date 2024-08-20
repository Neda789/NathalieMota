<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <?php wp_head(); ?>
</head>
<header>
    <div class="menu-header">
<div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Logo.png" alt="<?php bloginfo('name'); ?>" />
            </a>
        </div>
        <div class="navigation">
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'menu_id'        => 'primary-menu',
                'menu_class'     => 'nav-menu',
            ));
            ?>
        </nav>
        </div>
        </div>
          <!-- Menu Hamburger -->
 
          <!-- Button pour menu -->
  <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
         <!-- Menu Mobile -->
    <div class="mobile-menu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'main-menu',
            'menu_id'        => 'mobile-menu',
            'menu_class'     => 'mobile-nav-menu',
        ));
        ?>
    </div>
        </header>
 
