<?php

function capital_customizer_define_typography_sections( $sections ) {
    $panel           = WPZOOM::$theme_raw_name . '_typography';
    $typography_sections = array();

    /**
     * Site Title & Tagline
     */
    $typography_sections['font-site-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Site Title &amp; Tagline', 'wpzoom' ),
        'options' => array(
            'font-family-site-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Site Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => capital_all_font_choices()
                ),
            ),
            'font-size-site-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Site Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),

            'font-family-site-tagline'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Site Tagline Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => capital_all_font_choices()
                ),
            ),
            'font-size-site-tagline'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Site Tagline Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Navigation
     */
    $typography_sections['font-nav'] = array(
        'panel'   => $panel,
        'title'   => __( 'Navigation', 'wpzoom' ),
        'options' => array(
            'font-family-nav'   => array(
                'setting' => array(
//                    'sanitize_callback' => 'capital_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Nav Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => capital_all_font_choices()
                ),
            ),
            'font-size-nav'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Nav Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Slider Title
     */
    $typography_sections['font-slider-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Slider Title', 'wpzoom' ),
        'options' => array(
            'font-family-slider-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Slider Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => capital_all_font_choices()
                ),
            ),
            'font-size-slider-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Slider Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Widgets
     */
    $typography_sections['font-widgets'] = array(
        'panel'   => $panel,
        'title'   => __( 'Widget Title', 'wpzoom' ),
        'options' => array(
            'font-family-widgets'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Widgets Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => capital_all_font_choices()
                ),
            ),
            'font-size-widgets'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Widgets Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );

    /**
     * Post Title
     */
    $typography_sections['font-post-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Post Title', 'wpzoom' ),
        'options' => array(
            'font-family-post-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Post Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => capital_all_font_choices()
                ),
            ),
            'font-size-post-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Post Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );



    /**
     * Single Post Title
     */
    $typography_sections['font-single-post-title'] = array(
        'panel'   => $panel,
        'title'   => __( 'Single Post Title', 'wpzoom' ),
        'options' => array(
            'font-family-single-post-title'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_font_choice',
                ),
                'control' => array(
                    'label'   => __( 'Single Post Title Font Family', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => capital_all_font_choices()
                ),
            ),
            'font-size-single-post-title'     => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'label' => __( 'Single Post Title Font Size (in px)', 'wpzoom' ),
                    'type'  => 'number'
                ),
            ),
        )
    );


    return array_merge( $sections, $typography_sections );
}

add_filter( 'zoom_customizer_sections', 'capital_customizer_define_typography_sections' );
