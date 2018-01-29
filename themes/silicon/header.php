<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Silicon
 * @since 1.0
 * @version 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <!--meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"-->
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php bloginfo( 'name' ); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">


    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<button onclick="topFunction()" id="myBtn" title="Go to top">Inicio</button>

<div class="container-fluid">

    <div id="row_logos" class="row">
        <div class="col-sm-2 col-md-4"> </div>
        <div class="col-sm-8 col-md-4">
            <?php get_template_part('template-parts/header/site', 'branding'); ?>
        </div>
        <div class="col-md-3 col-sm-12">
            <a href="http://www.coop" target="_blank">
            <img class="coop-img hidden-sm-down"
                 src="<?php echo get_bloginfo('template_url') ?>/resources/img/coop_blue-01.png"/>
            </a>
        </div>
    </div>


</div> <!-- .container-fluid -->

<div id="header-menu" class="navbar navbar-light">
    <div class="row"> <!-- TODO change hamburger color to black instead of grey -->
        <div class="col">
            <nav class="navbar-inner navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="font-menu">MENÚ</span>
                </button>
            </nav>

        </div>

        <div id="menu-top-right" class="col-12 col-md-auto"> <!-- TODO pasarlo a menu-->
            <ul class="nav nav-links">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" data-target="#floatingLoginWidget"
                       aria-expanded="false" aria-controls="floatingLoginWidget"
                       role="button"><?php wpb_mostrar_texto_boton_ingreso() ?></a>
                </li>
                <span class="separator">|</span>
                <li class="nav-item si-a"><a class="nav-link" href="<?php echo home_url(); ?>/contacto" >CONTACTO</a></li>
                <span class="separator">|</span>
                <li class="nav-item"><a class="nav-link" data-toggle="collapse" data-target="#areaBuscador"
                                        aria-expanded="false" aria-controls="areaBuscador"
                                        role="button">
                        <i class="fa fa-search" aria-hidden="true"></i></a></li>
                <span class="separator">|</span>
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Social Icons Area")) ; ?>
            </ul>
        </div>
    </div>
</div>

<!-- main-menu -->
<div class="collapse si-light-grey" id="navbarToggleExternalContent">
    <div class="container-fluid" >
            <?php if (function_exists(main_menu())) { main_menu(); } ?>
    </div>
</div>


<!-- Menu logueados -->
<div id="floatingLoginWidget" class="collapse">
    <div class="container-fluid">
        <div class="row widget-login-flotante">
            <?php if (is_active_sidebar('floating-area')) : ?>
                <div class="col"></div>
                <div id="floating-area" class="col-md-3" role="complementary">
                    <?php dynamic_sidebar('floating-area'); ?>
                </div>
                <div class="col"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Buscador -->
<div id="areaBuscador" class="collapse">
    <div class="container-fluid si-light-grey">
        <div class="row">
            <div class="boton-cerrar-buscador">
                <button type="button" class="close" aria-label="Close" data-toggle="collapse"
                        data-target="#areaBuscador">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <h2 class="si-text-purple col titulo-buscador">Buscador</h2>
        </div>
        <div class="row area-buscador">
            <div class="col"></div>
            <div class="col-md-10">
                <?php get_search_form(); ?>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
<?php

// Carousel with color picker for insights

if (is_front_page()) {
    wpb_carrousel_aux();
}

?>
<?php

// Carousel with color picker for insights

if (is_front_page()) {
    if (function_exists(clean_custom_menus())) clean_custom_menus();
}

?>
<?php /*wp_nav_menu( array(
                'theme_location' => 'middle',
                'menu_class' => 'nav justify-content-center',
                'items_wrap'      => '<ul id=\"%1$s\" class=\"%2$s\">%3$s</ul>',

        ) ); */
?>


</body> <!-- FIXME this is wrong, i put here because IDE -->