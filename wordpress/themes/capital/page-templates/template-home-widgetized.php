<?php
/**
 * Template Name: Homepage (Widgetized)
 */

get_header(); ?>

<?php if ( option::is_on( 'featured_posts_show' ) ) : ?>

    <?php get_template_part( 'wpzoom-slider' ); ?>

<?php endif; ?>

<?php if ( is_active_sidebar( 'home-1' ) || is_active_sidebar( 'home-2' ) || is_active_sidebar( 'home-3' ) ) : ?>

    <div class="inner-wrap">

        <div class="home_widgets">

            <div class="home_column_my">
                <?php dynamic_sidebar( 'home-1' ) ?>
            </div>

            <!--div class="home_column">
                <?php /*dynamic_sidebar( 'home-2' ) */?>
            </div-->

            <div class="home_column last">
                <?php dynamic_sidebar( 'home-3' ) ?>
            </div>

            <div class="clear"></div>

        </div>

    </div><!--/.inner-wrap-->

    <div class="clear"></div>
<?php endif; ?>



<?php

$widgets_areas = (int) get_theme_mod( 'home-dark-widget-columns', capital_get_default( 'home-dark-widget-columns' ) );

$has_active_sidebar = false;
if ( $widgets_areas > 0 ) {
    $i = 1;

    while ( $i <= $widgets_areas ) {
        if ( is_active_sidebar( 'home-full-dark-' . $i ) ) {
            $has_active_sidebar = true;
            break;
        }

        $i ++;
    }
}

?>

<?php if ( $has_active_sidebar ) : ?>
    <div class="home_widgets_dark">
        <div class="inner-wrap">

            <div class="dark_column-<?php echo $widgets_areas; ?>">

                <?php
                for ( $i = 1; $i <= $widgets_areas; $i ++ ) :

                    dynamic_sidebar( 'home-full-dark-' . $i );

                endfor;
                ?>

            </div>

            <div class="clear"></div>

        </div>
    </div>

    <div class="clear"></div>

<?php endif; ?>



<?php

$widgets_areas = (int) get_theme_mod( 'home-footer-widget-columns', capital_get_default( 'home-footer-widget-columns' ) );

$has_active_sidebar = false;
if ( $widgets_areas > 0 ) {
    $i = 1;

    while ( $i <= $widgets_areas ) {
        if ( is_active_sidebar( 'home-footer-' . $i ) ) {
            $has_active_sidebar = true;
            break;
        }

        $i ++;
    }
}

?>

<?php if ( $has_active_sidebar ) : ?>
    <div class="home_footer_widgets">
        <div class="inner-wrap">

            <div class="footer_column-<?php echo $widgets_areas; ?>">

                <?php
                for ( $i = 1; $i <= $widgets_areas; $i ++ ) :

                    dynamic_sidebar( 'home-footer-' . $i );

                endfor;
                ?>

            </div>


            <div class="clear"></div>

        </div>
    </div>

    <div class="clear"></div>

<?php endif; ?>

<?php get_footer(); ?>