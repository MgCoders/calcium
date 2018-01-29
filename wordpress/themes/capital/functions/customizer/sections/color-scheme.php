<?php

function capital_customizer_define_color_scheme_sections( $sections ) {
    $panel           = WPZOOM::$theme_raw_name . '_color-scheme';
    $colors_sections = array();

    $colors_sections['color'] = array(
        'panel'   => $panel,
        'title'   => __( 'General', 'wpzoom' ),
        'options' => array(
            'color-link' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Link', 'wpzoom' ),
                ),
            ),

            'color-text'  => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Text', 'wpzoom' ),
                ),
            ),

            'color-widget-title' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Widget Title', 'wpzoom' ),
                ),
            ),
        )
    );

    $colors_sections['color-background'] = array(
        'panel'   => $panel,
        'title'   => __( 'Background', 'wpzoom' ),
        'options' => array(
            'color-background-top-menu' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Top Menu Background', 'wpzoom' ),
                ),
            ),

            'color-background-header' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Header Background', 'wpzoom' ),
                ),
            ),

            'color-background-dark-widget-area' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Dark Widget Area Background', 'wpzoom' ),
                ),
            ),
        )
    );

    $colors_sections['color-footer'] = array(
        'panel'   => $panel,
        'title'   => __( 'Footer', 'wpzoom' ),
        'options' => array(
            'color-footer-widget-area-background' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Widget Area Background', 'wpzoom' ),
                ),
            ),

            'color-footer-text' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Text', 'wpzoom' ),
                ),
            ),

            'color-footer-copyright-background' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Copyright Background', 'wpzoom' ),
                ),
            ),

            'color-footer-copyright-text' => array(
                'setting' => array(
                    'sanitize_callback' => 'maybe_hash_hex_color',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Color_Control',
                    'label'        => __( 'Copyright Text', 'wpzoom' ),
                ),
            ),
        )
    );

    return array_merge( $sections, $colors_sections );
}

add_filter( 'zoom_customizer_sections', 'capital_customizer_define_color_scheme_sections' );
