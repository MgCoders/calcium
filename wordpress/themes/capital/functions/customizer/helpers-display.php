<?php

/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * This function reads in the options from theme mods and determines whether a CSS rule is needed to implement an
 * option. CSS is only written for choices that are non-default in order to avoid adding unnecessary CSS. All options
 * are also filterable allowing for more precise control via a child theme or plugin.
 *
 * Note that all CSS for options is present in this function except for the CSS for fonts and the logo, which require
 * a lot more code to implement.
 *
 * @return void
 */
function capital_css_add_rules() {
    /**
     * Colors section
     */
    // General
    capital_css_add_simple_color_rule( 'color-link', 'a', 'color' );
    capital_css_add_simple_color_rule( 'color-text', 'body', 'color' );
    capital_css_add_simple_color_rule( 'color-widget-title', '.widget h3.title', 'color' );

    // Background
    capital_css_add_simple_color_rule( 'color-background-top-menu', '.top-navbar', 'background' );
    capital_css_add_simple_color_rule( 'color-background-header', '.site-header', 'background' );
    capital_css_add_simple_color_rule( 'color-background-dark-widget-area', '.home_widgets_dark', 'background' );

    // Footer
    capital_css_add_simple_color_rule( 'color-footer-widget-area-background', '.footer-widgets', 'background' );
    capital_css_add_simple_color_rule( 'color-footer-text', '.footer-widgets', 'color' );
    capital_css_add_simple_color_rule( 'color-footer-copyright-background', '.site-info', 'background' );
    capital_css_add_simple_color_rule( 'color-footer-copyright-text', '.site-info', 'color' );

    /**
     * Header Background Image
     */
    $header_background_image = get_theme_mod( 'header-background-image', capital_get_default( 'header-background-image' ) );
    if ( ! empty( $header_background_image ) ) {
        $header_background_image    = addcslashes( esc_url_raw( $header_background_image ), '"' );
        $header_background_size     = get_theme_mod( 'header-background-size', capital_get_default( 'header-background-size' ) );
        $header_background_repeat   = get_theme_mod( 'header-background-repeat', capital_get_default( 'header-background-repeat' ) );
        $header_background_position = get_theme_mod( 'header-background-position', capital_get_default( 'header-background-position' ) );

        capital_get_css()->add( array(
            'selectors'    => array( '.site-header' ),
            'declarations' => array(
                'background-image'    => 'url("' . $header_background_image . '")',
                'background-size'     => $header_background_size,
                'background-repeat'   => $header_background_repeat,
                'background-position' => $header_background_position . ' center'
            )
        ) );
    }
}

add_action( 'capital_css', 'capital_css_add_rules' );

function capital_css_add_simple_color_rule( $setting_id, $selectors, $declarations ) {
    $value = maybe_hash_hex_color( get_theme_mod( $setting_id, capital_get_default( $setting_id ) ) );

    if ( $value === capital_get_default( $setting_id ) ) {
        return;
    }

    if ( is_string( $selectors ) ) {
        $selectors = array( $selectors );
    }

    if ( is_string( $declarations ) ) {
        $declarations = array(
            $declarations => $value
        );
    }

    capital_get_css()->add( array(
        'selectors'    => $selectors,
        'declarations' => $declarations
    ) );
}
