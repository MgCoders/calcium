<?php

function capital_option_defaults() {
    $defaults = array(
        /**
         * General
         */
        // Site Title & Tagline
        'hide-tagline'                        => 0,
        // Logo
        'logo'                                => '',
        'logo-retina-ready'                   => 0,
        'logo-favicon'                        => 0,
        /**
         * Typography
         */
        // Site Title & Tag Line
        'font-family-site-title'              => 'Source Sans Pro',
        'font-size-site-title'                => 32,
        'font-family-site-tagline'            => 'Source Sans Pro',
        'font-size-site-tagline'              => 16,
        // Navigation
        'font-family-nav'                     => 'Source Sans Pro',
        'font-size-nav'                       => 16,
        // Slider Title
        'font-family-slider-title'            => 'Source Sans Pro',
        'font-size-slider-title'              => 28,
        // Widgets
        'font-family-widgets'                 => 'Source Sans Pro',
        'font-size-widgets'                   => 20,
        // Post Title
        'font-family-post-title'              => 'Source Sans Pro',
        'font-size-post-title'                => 38,
        // Single Post Title
        'font-family-single-post-title'       => 'Source Sans Pro',
        'font-size-single-post-title'         => 38,
        /**
         * Homepage
         */
        // Homepage Template
        'home-dark-widget-columns'            => 4,
        'home-footer-widget-columns'          => 4,
        /**
         * Color Scheme
         */
        // General
        'color-link'                          => '#2d87cc',
        'color-text'                          => '#444444',
        'color-widget-title'                  => '#222222',
        // Background
        'color-background-top-menu'           => '#2d87cc',
        'color-background-header'             => '#ffffff',
        'color-background-dark-widget-area'   => '#15191c',
        // Footer
        'color-footer-widget-area-background' => '#f8f8f8',
        'color-footer-text'                   => '#444444',
        'color-footer-copyright-background'   => '#ffffff',
        'color-footer-copyright-text'         => '#6c7a84',
        /**
         * Header
         */
        // Navbar
        'navbar-hide-search'                  => 0,
        // Background Image
        'header-background-image'             => '',
        'header-background-repeat'            => 'no-repeat',
        'header-background-position'          => 'center',
        'header-background-size'              => 'cover',
        /**
         * Footer
         */
        // Widget Areas
        'footer-widget-areas'                 => 4,
        // Copyright
        'footer-text'                         => sprintf( __( 'Copyright &copy; %1$s &mdash; %2$s. All Rights Reserved', 'wpzoom' ), date( 'Y' ), get_bloginfo( 'name' ) ),
    );

    return $defaults;
}

function capital_get_default( $option ) {
    $defaults = capital_option_defaults();
    $default  = ( isset( $defaults[ $option ] ) ) ? $defaults[ $option ] : false;

    return $default;
}
