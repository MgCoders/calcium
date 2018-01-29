<?php

function capital_customizer_define_homepage_sections( $sections ) {
    $panel             = WPZOOM::$theme_raw_name . '_homepage';
    $homepage_sections = array();

    $theme_prefix = WPZOOM::$theme_raw_name . '_';

    /**
     * Homepage Templates
     */
    $homepage_sections['homepage-template'] = array(
        'panel'   => $panel,
        'title'   => __( 'Homepage Template', 'wpzoom' ),
        'options' => array(
            'home-dark-widget-columns'   => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Number of Columns in Dark Widgetized Area', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => array( '0', '1', '2', '3', '4' ),
                )
            ),
            'home-footer-widget-columns' => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Number of Columns in Footer Widgetized Area', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => array( '0', '1', '2', '3', '4' ),
                )
            )
        )
    );

    return array_merge( $sections, $homepage_sections );
}

add_filter( 'zoom_customizer_sections', 'capital_customizer_define_homepage_sections' );
