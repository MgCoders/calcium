<?php

function capital_customizer_define_general_sections( $sections ) {
    $panel            = WPZOOM::$theme_raw_name . '_general';
    $general_sections = array();

    $theme_prefix = WPZOOM::$theme_raw_name . '_';

    /**
     * Logo
     */
    $general_sections['logo'] = array(
        'panel'   => $panel,
        'title'   => __( 'Logo', 'wpzoom' ),
        'options' => array(
            'logo'              => array(
                'setting' => array(
                    'sanitize_callback' => 'esc_url_raw',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Image_Control',
                    'label'        => __( 'Logo', 'wpzoom' ),
                    'context'      => $theme_prefix . 'logo',
                ),
            ),
            'logo-retina-ready' => array(
                'setting' => array(
                    'sanitize_callback' => 'absint',
                ),
                'control' => array(
                    'type'  => 'checkbox',
                    'label' => __( 'Retina Ready?', 'wpzoom' )
                )
            ),
            'logo-favicon'      => array(
                'setting' => array(
                    'sanitize_callback' => 'esc_url_raw',
                ),
                'control' => array(
                    'control_type' => 'WP_Customize_Image_Control',
                    'label'        => __( 'Favicon', 'wpzoom' ),
                    'description'  => __( 'File must be <strong>.png</strong> or <strong>.ico</strong> format. Optimal dimensions: <strong>32px x 32px</strong>.', 'wpzoom' ),
                    'context'      => $theme_prefix . 'logo-favicon',
                    'extensions'   => array( 'png', 'ico' ),
                ),
            ),
        ),
    );

    return array_merge( $sections, $general_sections );
}

add_filter( 'zoom_customizer_sections', 'capital_customizer_define_general_sections' );
