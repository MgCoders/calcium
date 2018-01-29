<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="main-wrap">

    <header class="site-header">

        <nav class="top-navbar" role="navigation">
            <div class="inner-wrap">
                <div class="navbar-header">

                     <?php if (has_nav_menu( 'secondary' )) { ?>
                        <a class="navbar-toggle" href="#menu-top-slide">
                             <span class="icon-bar"></span>
                             <span class="icon-bar"></span>
                             <span class="icon-bar"></span>
                         </a>

                         <?php wp_nav_menu( array(
                             'container_id'   => 'menu-top-slide',
                             'theme_location' => 'secondary'
                         ) );
                     } ?>

                </div>

                <?php if ( ! get_theme_mod( 'navbar-hide-search', capital_get_default( 'navbar-hide-search' ) ) ) : ?>
                    <div class="navbar-search">
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>

                <div id="navbar-top">

                    <?php if (has_nav_menu( 'secondary' )) {
                           wp_nav_menu( array(
                            'menu_class'     => 'nav navbar-nav dropdown sf-menu',
                            'theme_location' => 'secondary'
                        ) );
                    } ?>

                </div><!-- #navbar-top -->
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </nav><!-- .navbar -->


        <nav class="main-navbar" role="navigation">
            <div class="inner-wrap">
                 <div class="navbar-header">
                    <?php if (has_nav_menu( 'primary' )) { ?>

                       <a class="navbar-toggle" href="#menu-main-slide">
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                       </a>


                       <?php wp_nav_menu( array(
                           'container_id'   => 'menu-main-slide',
                           'theme_location' => 'primary'
                       ) );
                   }  ?>

                    <div class="navbar-brand">
                        <?php if ( ! capital_has_logo() ) echo '<h1>'; ?>

                        <a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'description' ); ?>">

                            <?php
                            if ( capital_has_logo() ) {
                                capital_logo();
                            } else {
                                bloginfo( 'name' );
                            }
                            ?>

                        </a>

                        <?php if ( ! capital_has_logo() ) echo '</h1>'; ?>

                        <?php
                        $hide_tagline = (int) get_theme_mod( 'hide-tagline', capital_get_default( 'hide-tagline' ) );
                        ?>
                        <?php if ( ! get_theme_mod( 'hide-tagline' ) ) : ?>
                            <p class="tagline"><?php bloginfo( 'description' ); ?></p>
                        <?php endif; ?>
                    </div><!-- .navbar-brand -->
                </div>

                <div id="navbar-main">

                    <?php if (has_nav_menu( 'primary' )) {
                        wp_nav_menu( array(
                            'menu_class'     => 'nav navbar-nav dropdown sf-menu',
                            'theme_location' => 'primary'
                        ) );
                    } ?>

                </div><!-- #navbar-main -->
            </div>
        </nav><!-- .navbar -->
    </header><!-- .site-header -->
