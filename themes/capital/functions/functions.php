<?php
/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

if ( ! function_exists( 'capital_setup' ) ) :
/**
 * Theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function capital_setup() {
    // This theme styles the visual editor to resemble the theme style.
    add_editor_style( array( 'css/editor-style.css' ) );

    /* Homepage Slider */
    add_image_size( 'featured', 1600 );
    add_image_size( 'featured-small', 800 );
    add_image_size( 'carousel', 270, 152, true );
    add_image_size( 'featured-page', 580 );

    add_image_size( 'loop', option::get( 'thumb_width' ), option::get( 'thumb_height' ), true );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
    add_theme_support( 'title-tag' );


    // Register nav menus
    register_nav_menus( array(
        'secondary' => __( 'Top Menu', 'wpzoom' ),
        'primary' => __( 'Main Menu', 'wpzoom' )
    ) );
}
endif;
add_action( 'after_setup_theme', 'capital_setup' );



function is_blog() {
    global $post;
    $posttype = get_post_type( $post );
    return ( ( $posttype == 'post' ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() || is_author() ) ) ? true : false;
}

function fix_blog_link_on_cpt( $classes, $item, $args ) {
    if( !is_blog() ) {
        $blog_page_id = intval( get_option('page_for_posts') );
        if( $blog_page_id != 0 && $item->object_id == $blog_page_id )
            unset($classes[array_search('current_page_parent', $classes)]);
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'fix_blog_link_on_cpt', 10, 3 );



/*  Add support for Custom Background
==================================== */

add_theme_support( 'custom-background' );



/* Register Video Post Format
==================================== */

add_theme_support( 'post-formats', array( 'video' ) );


/* Video auto-thumbnail
==================================== */

if (is_admin()) {
    WPZOOM_Video_Thumb::init();
}


/*  Add Support for Shortcodes in Excerpt
========================================== */

add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );

add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );


/*  Custom Excerpt Length
==================================== */

function new_excerpt_length( $length ) {
    return (int) option::get( "excerpt_length" ) ? (int)option::get( "excerpt_length" ) : 50;
}

add_filter( 'excerpt_length', 'new_excerpt_length' );



/* Replaces the excerpt "more" text by a link
=========================================== */

function new_excerpt_more( $more ) {
    global $post;

    return ' […] <div class="clear"></div><a class="more_link clearfix" href="' . get_permalink( $post->ID ) . '" rel="nofollow">' . __( 'Read More', 'wpzoom' ) . '</a>';
}

add_filter( 'excerpt_more', 'new_excerpt_more' );



/* Enable Excerpts for Pages
==================================== */

add_action( 'init', 'wpzoom_excerpts_to_pages' );
function wpzoom_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}



/*  Maximum width for images in posts
=========================================== */

if ( ! isset( $content_width ) ) $content_width = 740;



/* Enqueue scripts and styles for the front end.
=========================================== */

function capital_scripts() {
    if ( '' !== $google_request = capital_get_google_font_uri() ) {
        wp_enqueue_style( 'capital-google-fonts', $google_request, WPZOOM::$themeVersion );
    }

    // Load our main stylesheet.
    wp_enqueue_style( 'capital-style', get_stylesheet_uri() );

    wp_enqueue_style( 'media-queries', get_template_directory_uri() . '/css/media-queries.css', array(), WPZOOM::$themeVersion );

    wp_enqueue_style( 'dashicons' );

    wp_enqueue_script( 'mmenu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'caroufredsel', get_template_directory_uri() . '/js/caroufredsel.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    $themeJsOptions = option::getJsOptions();

    wp_enqueue_script( 'capital-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), WPZOOM::$themeVersion, true );
    wp_localize_script( 'capital-script', 'zoomOptions', $themeJsOptions );
}

add_action( 'wp_enqueue_scripts', 'capital_scripts' );
