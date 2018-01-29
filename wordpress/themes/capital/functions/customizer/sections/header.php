<?php

function capital_customizer_define_header_sections( $sections ) {
    $panel           = WPZOOM::$theme_raw_name . '_header';
    $header_sections = array();

    $theme_prefix = WPZOOM::$theme_raw_name . '_';

    /**
     * Navbar
     */
    $header_sections['navbar'] = array(
        'panel'   => $panel,
        'title'   => __( 'Navbar', 'wpzoom' ),
        'options' => array(
            'navbar-hide-search' => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Hide Search Field', 'wpzoom' ),
                    'type'  => 'checkbox'
                )
            )
        )
    );

    /**
     * Background Image
     */
    $header_sections['header-background'] = array(
        'panel'   => $panel,
        'title'   => __( 'Background Image', 'wpzoom' ),
        'options' => array(
            'header-background-image'    => array(
                'setting' => array(
                    'sanitize_callback' => 'esc_url_raw',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Image_Control',
                    'label'        => __( 'Header Background Image', 'wpzoom' ),
                    'context'      => $theme_prefix . 'header-background-image',
                ),
            ),
            'header-background-repeat'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Header Background Repeat', 'wpzoom' ),
                    'type'    => 'radio',
                    'choices' => array(
                        'no-repeat' => __( 'No Repeat', 'wpzoom' ),
                        'repeat'    => __( 'Tile', 'wpzoom' ),
                        'repeat-x'  => __( 'Tile Horizontally', 'wpzoom' ),
                        'repeat-y'  => __( 'Tile Vertically', 'wpzoom' )
                    )
                ),
            ),
            'header-background-position' => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Header Background Position', 'wpzoom' ),
                    'type'    => 'radio',
                    'choices' => array(
                        'left'   => __( 'Left', 'wpzoom' ),
                        'center' => __( 'Center', 'wpzoom' ),
                        'right'  => __( 'Right', 'wpzoom' )
                    )
                ),
            ),
            'header-background-size'     => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Header Background Size', 'wpzoom' ),
                    'type'    => 'radio',
                    'choices' => array(
                        'auto'    => __( 'Auto', 'wpzoom' ),
                        'cover'   => __( 'Cover', 'wpzoom' ),
                        'contain' => __( 'Contain', 'wpzoom' )
                    )
                ),
            ),
        ),
    );

    return array_merge( $sections, $header_sections );
}

add_filter( 'zoom_customizer_sections', 'capital_customizer_define_header_sections' );
