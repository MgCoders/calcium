<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<div class="inner-wrap">

    <main id="main" class="site-main container-fluid" role="main">

        <div class="section-title">
            <?php if ( option::is_on( 'post_category' ) ) { ?><span class="cat-links"><a class="section-home-link" href="<?php echo esc_url( home_url( '/' ) );?>"><?php _e('Home', 'wpzoom'); ?></a> <span class="separator">&raquo;</span> <span class="cat-links"> <?php echo get_the_category_list( ', ' ); ?></span><?php } ?>
        </div>

        <section class="post-wrap">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', 'single' ); ?>


                <?php if (option::get('post_comments') == 'on') : ?>

                    <?php comments_template(); ?>

                <?php endif; ?>

            <?php endwhile; // end of the loop. ?>

        </section><!-- .single-post -->

        <?php get_sidebar(); ?>

    </main><!-- #main -->

</div>

<?php get_footer(); ?>