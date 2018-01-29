<?php
/**
 * The main template file.
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // gets current page number

get_header(); ?>

<?php if ( option::is_on( 'featured_posts_show' ) && is_front_page() && $paged < 2) : ?>

    <?php get_template_part( 'wpzoom-slider' ); ?>

<?php endif; ?>

<div class="inner-wrap">

    <main id="main" class="site-main" role="main">

        <h2 class="section-title">
            <?php if ( is_front_page() ) : ?>

                <?php _e( 'Our Blog', 'wpzoom' ); ?>

            <?php else: ?>

                <?php echo get_the_title( get_option( 'page_for_posts' ) ); ?>

            <?php endif; ?>
        </h2>

        <section class="recent-posts">

            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php

                    get_template_part( 'content', get_post_format() );
                    ?>

                <?php endwhile; ?>

                <?php get_template_part( 'pagination' ); ?>

            <?php else: ?>

                <?php get_template_part( 'content', 'none' ); ?>

            <?php endif; ?>

        </section><!-- .recent-posts -->

        <?php get_sidebar(); ?>

    </main><!-- .site-main -->

</div>

<?php
get_footer();