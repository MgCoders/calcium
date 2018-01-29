<?php

/**
 * @param WP_Customize_Manager $wp_customize
 */
function capital_customizer_navigation( $wp_customize ) {
    $section_id = 'nav';

    // The Navigation section only exists if custom menus have been created.
    if ( ! isset( $wp_customize->get_section( $section_id )->title ) ) {
        $wp_customize->add_section( $section_id );
    }

    $section = $wp_customize->get_section( $section_id );

    // Move Navigation section to Header panel
    $section->panel = WPZOOM::$theme_raw_name . '_header';
}

add_action( 'customize_register', 'capital_customizer_navigation', 20 );
