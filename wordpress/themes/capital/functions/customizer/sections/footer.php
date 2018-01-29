<?php

function capital_customizer_define_footer_sections( $sections ) {
    $panel           = WPZOOM::$theme_raw_name . '_footer';
    $footer_sections = array();

    $theme_prefix = WPZOOM::$theme_raw_name . '_';

    /**
     * Widget Areas
     */
    $footer_sections['footer-widget'] = array(
        'panel'   => $panel,
        'title'   => __( 'Widget Areas', 'wpzoom' ),
        'options' => array(
            'footer-widget-areas' => array(
                'setting' => array(
                    'sanitize_callback' => 'capital_sanitize_choice',
                ),
                'control' => array(
                    'label'   => __( 'Number of Widget Areas', 'wpzoom' ),
                    'type'    => 'select',
                    'choices' => array( '0', '1', '2', '3', '4' ),
                ),
            ),
        ),
    );

    /**
     * Copyright
     */
    $footer_sections['copyright'] = array(
        'panel'   => $panel,
        'title'   => __( 'Copyright' ),
        'options' => array(
            'footer-text' => array(
                'setting' => array(
                    'sanitize_callback'	=> 'capital_sanitize_text',
                ),
                'control' => array(
                    'label'				=> __( 'Footer Text', 'wpzoom' ),
                    'type'				=> 'text',
                ),
            )
        )
    );

    return array_merge( $sections, $footer_sections );
}

add_filter( 'zoom_customizer_sections', 'capital_customizer_define_footer_sections' );
