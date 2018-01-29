<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 */

$widgets_areas = (int) get_theme_mod( 'footer-widget-areas', capital_get_default( 'footer-widget-areas' ) );

$has_active_sidebar = false;
if ( $widgets_areas > 0 ) {
    $i = 1;

    while ( $i <= $widgets_areas ) {
        if ( is_active_sidebar( 'footer_' . $i ) ) {
            $has_active_sidebar = true;
            break;
        }

        $i++;
    }
}

?>

    <div class="clear"></div>
    <footer id="colophon" class="site-footer" role="contentinfo">

        <?php if ( $has_active_sidebar ) : ?>
            <div class="footer-widgets widgets widget-columns-<?php echo esc_attr( $widgets_areas ); ?>">

                <div class="inner-wrap">

                    <?php for ( $i = 1; $i <= $widgets_areas; $i ++ ) : ?>

                        <div class="column">
                            <?php dynamic_sidebar( 'footer_' . $i ); ?>
                        </div><!-- .column -->

                    <?php endfor; ?>

                </div>
                <div class="clear"></div>
            </div><!-- .footer-widgets -->

        <?php endif; ?>

        <div class="site-info">
            <div class="inner-wrap">
                <p class="copyright">
                    <?php echo get_theme_mod( 'footer-text', capital_get_default( 'footer-text' ) ); ?>
                </p>
                <p class="designed-by">
                    <?php printf( __( 'Designed by %s', 'wpzoom' ), '<a href="http://www.wpzoom.com/" target="_blank" rel="designer">WPZOOM</a>' ); ?>
                </p>
            </div>
            <div class="clear"></div>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->

</div><!-- /.main-wrap -->
<?php wp_footer(); ?>

</body>
</html>