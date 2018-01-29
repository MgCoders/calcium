<?php
/**
 * Template Name: Full-width
 */

get_header(); ?>
<div class="inner-wrap">

    <main id="main" class="site-main full-width" role="main">

        <h2 class="section-title">
            <span class="cat-links"><a class="section-home-link" href="<?php echo esc_url( home_url( '/' ) );?>"><?php _e('Home', 'wpzoom'); ?></a> <span class="separator">&raquo;</span> <span class="cat-links"> <?php the_title(); ?></span>
        </h2>

        <section class="post-wrap">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', 'page' ); ?>

                <?php if (option::get('comments_page') == 'on') { ?>
                    <?php comments_template(); ?>
                <?php } ?>

            <?php endwhile; // end of the loop. ?>

        </section><!-- .single-post -->

    </main><!-- #main -->

</div>

<?php get_footer(); ?>